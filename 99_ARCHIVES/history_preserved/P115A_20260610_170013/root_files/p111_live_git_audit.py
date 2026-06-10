#!/usr/bin/env python3
# -*- coding: utf-8 -*-
r"""
MAESTRO_WORKSPACE P111 LIVE AUDIT

Objectif:
- figer l'état live des sources candidates avant toute action GitHub / nettoyage / patch
- auditer MAESTRO_V5, MO_KB_DAEMON, MO_KB_FRONT
- vérifier que UwAmp est seulement un hôte/lien vers le front
- exporter un ZIP lisible à uploader dans ChatGPT

Contrat:
- non destructif
- aucune suppression
- aucun déplacement
- aucun patch
- aucun commit
- aucun git add
- aucun git checkout
"""

from __future__ import annotations

import datetime as dt
import os
import subprocess
import zipfile
from pathlib import Path


WORKSPACE = Path(r"H:\MAESTRO_WORKSPACE")
REPORTS_DIR = WORKSPACE / "CONTEXT" / "REPORTS"
DIFFS_DIR = REPORTS_DIR / "GIT_DIFFS"
OUTBOX_DIR = WORKSPACE / "OUTBOX"

SOURCES = [
    ("MAESTRO_V5", Path(r"D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5"), "distribuable"),
    ("MO_KB_DAEMON", Path(r"H:\MO_KB_DAEMON"), "at home"),
    ("MO_KB_FRONT", Path(r"H:\MO_KB_FRONT"), "at home"),
]

UWAMP_WWW = Path(r"H:\UwAmp\www")
UWAMP_FRONT_LINK = UWAMP_WWW / "MO_KB_FRONT"


def stamp() -> str:
    return dt.datetime.now().strftime("%Y%m%d_%H%M%S")


def now_human() -> str:
    return dt.datetime.now().isoformat(timespec="seconds")


def run_cmd(args: list[str], cwd: Path | None = None, timeout: int = 60) -> tuple[int, str]:
    try:
        proc = subprocess.run(
            args,
            cwd=str(cwd) if cwd else None,
            text=True,
            encoding="utf-8",
            errors="replace",
            stdout=subprocess.PIPE,
            stderr=subprocess.STDOUT,
            timeout=timeout,
        )
        return proc.returncode, proc.stdout.strip()
    except FileNotFoundError as exc:
        return 127, f"{type(exc).__name__}: {exc}"
    except subprocess.TimeoutExpired as exc:
        return 124, f"TimeoutExpired after {timeout}s: {exc}"
    except Exception as exc:
        return 1, f"{type(exc).__name__}: {exc}"


def git(args: list[str], cwd: Path, timeout: int = 60) -> tuple[int, str]:
    return run_cmd(["git"] + args, cwd=cwd, timeout=timeout)


def safe_write(path: Path, text: str) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(text + "\n", encoding="utf-8")


def is_git_repo(path: Path) -> tuple[bool, str]:
    code, out = git(["rev-parse", "--show-toplevel"], path)
    return code == 0, out


def collect_git_report(name: str, path: Path) -> list[str]:
    lines: list[str] = []
    lines.append(f"## {name}")
    lines.append("")
    lines.append(f"- Chemin: `{path}`")
    lines.append(f"- Existe: `{'YES' if path.exists() else 'NO'}`")

    if not path.exists():
        lines.append("- Git: `NO_PATH`")
        lines.append("")
        return lines

    ok, top = is_git_repo(path)
    lines.append(f"- Git: `{'YES' if ok else 'NO'}`")

    if not ok:
        lines.append("")
        lines.append("```text")
        lines.append(top)
        lines.append("```")
        lines.append("")
        return lines

    top_path = Path(top)
    lines.append(f"- Racine Git: `{top_path}`")

    commands = [
        ("branch", ["branch", "--show-current"]),
        ("status_short_branch", ["status", "--short", "--branch"]),
        ("remote_v", ["remote", "-v"]),
        ("log_head", ["log", "-1", "--oneline", "--decorate"]),
        ("diff_stat", ["diff", "--stat"]),
        ("diff_name_status", ["diff", "--name-status"]),
        ("diff_cached_stat", ["diff", "--cached", "--stat"]),
        ("untracked", ["ls-files", "--others", "--exclude-standard"]),
    ]

    for key, args in commands:
        code, out = git(args, top_path)
        lines.append("")
        lines.append(f"### git {key}")
        lines.append("")
        lines.append(f"ExitCode: `{code}`")
        lines.append("")
        lines.append("```text")
        lines.append(out if out else "(empty)")
        lines.append("```")

    # Full diffs in separate files, not inline in main report.
    diff_code, diff_out = git(["diff", "--no-ext-diff", "--"], top_path, timeout=120)
    cached_code, cached_out = git(["diff", "--cached", "--no-ext-diff", "--"], top_path, timeout=120)

    safe_write(DIFFS_DIR / f"{name}_working_tree.diff", diff_out if diff_out else "")
    safe_write(DIFFS_DIR / f"{name}_staged.diff", cached_out if cached_out else "")

    lines.append("")
    lines.append("### Diff files")
    lines.append("")
    lines.append(f"- Working tree diff: `{DIFFS_DIR / f'{name}_working_tree.diff'}` exit `{diff_code}`")
    lines.append(f"- Staged diff: `{DIFFS_DIR / f'{name}_staged.diff'}` exit `{cached_code}`")
    lines.append("")

    return lines


def collect_uwamp_report() -> list[str]:
    lines: list[str] = []
    lines.append("## UwAmp / Front link check")
    lines.append("")
    lines.append(f"- UwAmp www: `{UWAMP_WWW}`")
    lines.append(f"- Existe: `{'YES' if UWAMP_WWW.exists() else 'NO'}`")
    lines.append(f"- Front link attendu: `{UWAMP_FRONT_LINK}`")
    lines.append(f"- Existe: `{'YES' if UWAMP_FRONT_LINK.exists() else 'NO'}`")

    try:
        resolved = UWAMP_FRONT_LINK.resolve()
    except Exception as exc:
        resolved = f"{type(exc).__name__}: {exc}"

    lines.append(f"- Résolution Python: `{resolved}`")
    lines.append("")

    code, out = run_cmd(["cmd", "/c", "dir", "/AL", str(UWAMP_WWW)])
    lines.append("### cmd /c dir /AL H:\\UwAmp\\www")
    lines.append("")
    lines.append(f"ExitCode: `{code}`")
    lines.append("")
    lines.append("```text")
    lines.append(out if out else "(empty)")
    lines.append("```")
    lines.append("")

    # fsutil can fail depending on permissions/path type; report only.
    if UWAMP_FRONT_LINK.exists():
        code2, out2 = run_cmd(["cmd", "/c", "fsutil", "reparsepoint", "query", str(UWAMP_FRONT_LINK)])
        lines.append("### fsutil reparsepoint query H:\\UwAmp\\www\\MO_KB_FRONT")
        lines.append("")
        lines.append(f"ExitCode: `{code2}`")
        lines.append("")
        lines.append("```text")
        lines.append(out2 if out2 else "(empty)")
        lines.append("```")
        lines.append("")

    return lines


def write_main_report() -> Path:
    REPORTS_DIR.mkdir(parents=True, exist_ok=True)
    DIFFS_DIR.mkdir(parents=True, exist_ok=True)

    lines: list[str] = []
    lines.append("# P111_LIVE_GIT_AUDIT.md")
    lines.append("")
    lines.append(f"Generated: `{now_human()}`")
    lines.append(f"Workspace: `{WORKSPACE}`")
    lines.append("")
    lines.append("## Contrat")
    lines.append("")
    lines.append("- Audit non destructif.")
    lines.append("- Aucun fichier source modifié.")
    lines.append("- Aucun dépôt Git modifié.")
    lines.append("- Aucun commit, add, checkout, reset ou clean.")
    lines.append("")
    lines.append("## Politique active")
    lines.append("")
    lines.append("- `MO_KB` et ses applications: **at home**, privé, non distribuable public.")
    lines.append("- `MAESTRO` et futurs `VSTi`: **distribuables**.")
    lines.append("- `UwAmp`: hôte web/runtime local, pas source front.")
    lines.append("- `H:\\MO_KB_FRONT`: source front candidate.")
    lines.append("")

    for name, path, status in SOURCES:
        lines.extend(collect_git_report(name, path))
        lines.append("")

    lines.extend(collect_uwamp_report())

    lines.append("## Décision attendue après lecture")
    lines.append("")
    lines.append("Pour chaque secteur Git non clean, choisir explicitement :")
    lines.append("")
    lines.append("1. commit propre,")
    lines.append("2. rollback,")
    lines.append("3. palier de stabilisation,")
    lines.append("4. ou exclusion de la source de vérité.")
    lines.append("")

    report_path = REPORTS_DIR / "P111_LIVE_GIT_AUDIT.md"
    safe_write(report_path, "\n".join(lines))
    return report_path


def make_export_zip(report_path: Path) -> Path:
    OUTBOX_DIR.mkdir(parents=True, exist_ok=True)
    zip_path = OUTBOX_DIR / f"P111_LIVE_AUDIT_EXPORT_{stamp()}.zip"

    files = [
        report_path,
        REPORTS_DIR / "PROJECT_MAP.md",
        REPORTS_DIR / "SCORIES_REPORT.md",
        REPORTS_DIR / "GIT_READINESS.md",
        REPORTS_DIR / "CLEAN_GITHUB_REPO_PLAN.md",
        WORKSPACE / "CONTEXT" / "DECISIONS" / "P111_DISTRIBUTION_POLICY.md",
        WORKSPACE / "CONTEXT" / "DECISIONS" / "P111_SOURCE_OF_TRUTH_SECTORS.md",
        WORKSPACE / "MAESTRO_WORKSPACE.code-workspace",
    ]

    with zipfile.ZipFile(zip_path, "w", zipfile.ZIP_DEFLATED) as z:
        for file_path in files:
            if file_path.exists():
                z.write(file_path, arcname=str(file_path.relative_to(WORKSPACE)))
        if DIFFS_DIR.exists():
            for diff_file in DIFFS_DIR.glob("*.diff"):
                z.write(diff_file, arcname=str(diff_file.relative_to(WORKSPACE)))

    return zip_path


def main() -> int:
    print("MAESTRO_WORKSPACE P111 LIVE AUDIT")
    print("Mode: non destructif")
    print(f"Workspace: {WORKSPACE}")
    print("")

    if not WORKSPACE.exists():
        print(f"ERROR: workspace introuvable: {WORKSPACE}")
        return 2

    report_path = write_main_report()
    zip_path = make_export_zip(report_path)

    print("OK - audit live genere.")
    print(f"- Rapport: {report_path}")
    print(f"- Export:  {zip_path}")
    print("")
    print("Aucun code source modifie.")
    print("Aucun depot Git modifie.")
    print("Aucune suppression effectuee.")
    print("")
    print("Upload ensuite le ZIP export pour analyse.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
