from __future__ import annotations

import datetime as _dt
import re
import shutil
import subprocess
import sys
from pathlib import Path


CLEAN_GITIGNORE = """# ASAP repository ignore rules
#
# ASAP is a reusable PHP framework. The repository must not track generated
# dependencies, local secrets, runtime state, reports, caches, temporary files,
# or machine-specific artifacts.

# Dependencies
/vendor/
/composer.lock

# Local environment / secrets
/.env
/.env.*
!/.env.example
*.local.php
*.secret.php

# Documentation and tooling caches
/.phpdoc/
/.phpdoc-cache/
/.cache/
/tmp/

# Runtime state
/var/*
!/var/.gitkeep

# SQLite runtime sidecars
*.sqlite-wal
*.sqlite-shm
*.sqlite-journal

# Generic generated / temporary artifacts
*.tmp
*.temp
*.bak
*.backup
*.orig
*.rej
*.patch
*.diff
*.log

# OS / editor noise
.DS_Store
Thumbs.db
"""


def run(cmd: list[str], cwd: Path, *, check: bool = False) -> tuple[int, str]:
    proc = subprocess.run(
        cmd,
        cwd=str(cwd),
        text=True,
        stdout=subprocess.PIPE,
        stderr=subprocess.STDOUT,
        shell=False,
    )
    out = proc.stdout or ""
    if check and proc.returncode != 0:
        raise RuntimeError(f"COMMAND_FAILED rc={proc.returncode} cmd={' '.join(cmd)}\n{out}")
    return proc.returncode, out


def write_text(path: Path, content: str) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(content.replace("\r\n", "\n"), encoding="utf-8", newline="\n")


def read_text(path: Path) -> str:
    return path.read_text(encoding="utf-8-sig", errors="replace")


def ensure_asap_root(root: Path) -> None:
    if not root.exists():
        raise RuntimeError(f"ASAP_ROOT_NOT_FOUND path={root}")
    if not (root / "composer.json").is_file():
        raise RuntimeError(f"ASAP_COMPOSER_NOT_FOUND path={root / 'composer.json'}")
    if not (root / "framework" / "Asap").is_dir():
        raise RuntimeError(f"ASAP_FRAMEWORK_DIR_NOT_FOUND path={root / 'framework' / 'Asap'}")
    rc, out = run(["git", "rev-parse", "--show-toplevel"], root)
    if rc != 0:
        raise RuntimeError(f"ASAP_NOT_A_GIT_REPOSITORY\n{out}")
    git_root = Path(out.strip())
    if git_root.resolve().as_posix().lower() != root.resolve().as_posix().lower():
        raise RuntimeError(f"ASAP_GIT_ROOT_MISMATCH expected={root} actual={git_root}")


def require_clean_git(root: Path) -> None:
    rc, out = run(["git", "status", "--porcelain"], root)
    if rc != 0:
        raise RuntimeError(f"GIT_STATUS_FAILED\n{out}")
    if out.strip():
        raise RuntimeError("ASAP_WORKTREE_NOT_CLEAN_BEFORE_PATCH\n" + out)


def backup_targets(root: Path, workspace: Path) -> Path:
    stamp = _dt.datetime.now().strftime("%Y%m%d_%H%M%S")
    backup_dir = workspace / f"backup_{stamp}"
    backup_dir.mkdir(parents=True, exist_ok=True)
    for rel in [".gitignore", "var/.gitignore", "var/.gitkeep"]:
        src = root / rel
        if src.exists():
            dst = backup_dir / rel
            dst.parent.mkdir(parents=True, exist_ok=True)
            shutil.copy2(src, dst)
    return backup_dir


def apply_cleanup(root: Path) -> None:
    write_text(root / ".gitignore", CLEAN_GITIGNORE)
    var_dir = root / "var"
    var_dir.mkdir(exist_ok=True)
    gitkeep = var_dir / ".gitkeep"
    if not gitkeep.exists():
        write_text(gitkeep, "")
    var_gitignore = var_dir / ".gitignore"
    if var_gitignore.exists():
        var_gitignore.unlink()


def git_ls_files(root: Path) -> list[str]:
    _, out = run(["git", "ls-files"], root, check=True)
    return [line.strip().replace("\\", "/") for line in out.splitlines() if line.strip()]


def scan_tracked_scories(files: list[str]) -> list[str]:
    bad_ext = (".tmp", ".temp", ".bak", ".backup", ".orig", ".rej", ".patch", ".diff", ".log", ".zip", ".7z", ".rar")
    bad_fragments = ("/backup/", "/backups/", "/tmp/", "/temp/", "/patches/", "/handoff/", "handoff", "workspace_apply", "full_files")
    allowed = {".gitignore", "var/.gitkeep"}
    findings: list[str] = []
    for f in files:
        lf = f.lower()
        if f in allowed:
            continue
        if lf.endswith(bad_ext) or any(fragment in lf for fragment in bad_fragments):
            findings.append(f)
    return sorted(set(findings))


def scan_text_patterns(root: Path, files: list[str]) -> dict[str, list[str]]:
    checks: dict[str, list[str]] = {
        "windows_absolute_paths_in_framework": [],
        "shell_specific_tokens_in_framework": [],
        "maestro_workspace_markers": [],
        "fallback_mentions_review": [],
        "todo_fixme_review": [],
    }
    text_ext = {".php", ".md", ".json", ".xml", ".yml", ".yaml", ".twig", ".css", ".js", ".cmd", ".bat", ".sh"}
    scan_files = sorted(set(files + [".gitignore"]))
    for rel in scan_files:
        path = root / rel
        if not path.is_file():
            continue
        if path.suffix.lower() not in text_ext and path.name != ".gitignore":
            continue
        try:
            content = read_text(path)
        except Exception as exc:
            checks.setdefault("unreadable_files", []).append(f"{rel}: {exc}")
            continue
        lower = content.lower()
        if rel.startswith("framework/Asap/"):
            if re.search(r"\b[A-Za-z]:\\\\|\b[A-Za-z]:/", content):
                checks["windows_absolute_paths_in_framework"].append(rel)
            if any(token in lower for token in ["powershell", "cmd.exe", "cmd /c", ".bat", ".cmd", "windows\\"]):
                checks["shell_specific_tokens_in_framework"].append(rel)
            if "fallback" in lower:
                checks["fallback_mentions_review"].append(rel)
            if "todo" in lower or "fixme" in lower or "xxx" in lower:
                checks["todo_fixme_review"].append(rel)
        if "maestro_workspace" in lower:
            checks["maestro_workspace_markers"].append(rel)
    return {k: sorted(set(v)) for k, v in checks.items() if v}


def php_lint(root: Path, files: list[str]) -> tuple[str, list[str]]:
    php_files = [f for f in files if f.endswith(".php")]
    rc, _ = run(["where", "php"], root)
    if rc != 0:
        return "PHP_NOT_FOUND", ["where php failed; PHP lint not executed."]
    failures: list[str] = []
    for rel in php_files:
        rc, lint_out = run(["php", "-l", rel], root)
        if rc != 0:
            failures.append(f"{rel}\n{lint_out}")
    return ("OK" if not failures else "FAIL"), failures


def main() -> int:
    if len(sys.argv) != 3:
        print("USAGE: apply_p114q1q3.py <ASAP_ROOT> <WORKSPACE_PATCH_DIR>")
        return 2

    root = Path(sys.argv[1])
    workspace = Path(sys.argv[2])
    workspace.mkdir(parents=True, exist_ok=True)

    try:
        ensure_asap_root(root)
        require_clean_git(root)
        backup_dir = backup_targets(root, workspace)
        apply_cleanup(root)

        files = git_ls_files(root)
        scories = scan_tracked_scories(files)
        patterns = scan_text_patterns(root, files)
        php_status, php_failures = php_lint(root, files)

        _, status_after = run(["git", "status", "--short"], root)
        _, diff_stat = run(["git", "diff", "--stat"], root)
        _, diff_name = run(["git", "diff", "--name-only"], root)

        blockers: list[str] = []
        warnings: list[str] = []

        if scories:
            blockers.append("TRACKED_SCORIES_FOUND")
        if patterns.get("windows_absolute_paths_in_framework"):
            blockers.append("WINDOWS_ABSOLUTE_PATHS_IN_FRAMEWORK")
        if patterns.get("shell_specific_tokens_in_framework"):
            blockers.append("SHELL_SPECIFIC_TOKENS_IN_FRAMEWORK")
        if patterns.get("maestro_workspace_markers"):
            blockers.append("MAESTRO_WORKSPACE_MARKERS_FOUND")
        if php_status != "OK":
            blockers.append(f"PHP_LINT_{php_status}")

        if patterns.get("fallback_mentions_review"):
            warnings.append("FALLBACK_MENTIONS_REQUIRE_REVIEW")
        if patterns.get("todo_fixme_review"):
            warnings.append("TODO_FIXME_REQUIRE_REVIEW")
        if any(f.startswith("bin/") and f.lower().endswith(".cmd") for f in files):
            warnings.append("BIN_WINDOWS_CMD_WRAPPERS_DEFERRED_TO_P114Q2")

        report = []
        report.append("P114Q1Q3_ASAP_REPOSITORY_HYGIENE_REPORT")
        report.append(f"timestamp={_dt.datetime.now().isoformat(timespec='seconds')}")
        report.append(f"asap_root={root}")
        report.append(f"backup_dir={backup_dir}")
        report.append("")
        report.append("CHANGED_FILES")
        report.append(diff_name.strip() or "(none)")
        report.append("")
        report.append("DIFF_STAT")
        report.append(diff_stat.strip() or "(none)")
        report.append("")
        report.append("GIT_STATUS")
        report.append(status_after.strip() or "(clean)")
        report.append("")
        report.append("BLOCKERS")
        report.extend(blockers or ["0"])
        report.append("")
        report.append("WARNINGS")
        report.extend(warnings or ["0"])
        report.append("")
        report.append("TRACKED_SCORIES")
        report.extend(scories or ["0"])
        report.append("")
        report.append("PATTERN_AUDIT")
        if patterns:
            for key, values in patterns.items():
                report.append(f"{key}:")
                report.extend([f"  {value}" for value in values])
        else:
            report.append("0")
        report.append("")
        report.append("PHP_LINT")
        report.append(php_status)
        report.extend(php_failures or [])
        report.append("")

        report_path = workspace / "P114Q1Q3_ASAP_REPOSITORY_HYGIENE_REPORT.txt"
        write_text(report_path, "\n".join(report))

        print(f"REPORT={report_path}")
        if blockers:
            print("P114Q1Q3_ASAP_REPOSITORY_HYGIENE_REVIEW_REQUIRED")
            for blocker in blockers:
                print(f"BLOCKER={blocker}")
            return 1

        print("P114Q1Q3_ASAP_REPOSITORY_HYGIENE_APPLY_OK")
        return 0
    except Exception as exc:
        err_path = workspace / "P114Q1Q3_ASAP_REPOSITORY_HYGIENE_ERROR.txt"
        write_text(err_path, str(exc))
        print(f"ERROR={err_path}")
        print(str(exc))
        return 1


if __name__ == "__main__":
    raise SystemExit(main())
