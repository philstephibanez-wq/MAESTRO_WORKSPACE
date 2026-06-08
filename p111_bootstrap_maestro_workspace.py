#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
MAESTRO_WORKSPACE P111 BOOTSTRAP

Cible officielle :
    H:\MAESTRO_WORKSPACE

Contrat :
- Python uniquement
- Non destructif
- Ne supprime rien
- Ne déplace rien
- Ne patche aucun code
- Ne modifie aucun dépôt Git
- Crée uniquement le workspace P111 et des rapports Markdown
- Génère les rapports préalables avant toute future correction :
    PROJECT_MAP.md
    SCORIES_REPORT.md
    GIT_READINESS.md
    CLEAN_GITHUB_REPO_PLAN.md

Usage Windows :
    python p111_bootstrap_maestro_workspace.py

Option :
    python p111_bootstrap_maestro_workspace.py --workspace H:\MAESTRO_WORKSPACE
"""

from __future__ import annotations

import argparse
import datetime as dt
import os
import shutil
import subprocess
from pathlib import Path
from typing import Iterable


OFFICIAL_WORKSPACE = Path(r"H:\MAESTRO_WORKSPACE")

CANDIDATE_SOURCES = [
    Path(r"D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5"),
    Path(r"C:\Users\steph\AppData\Roaming\REAPER\Scripts\MAESTRO_v5"),
    Path(r"H:\MO_KB_DAEMON"),
    Path(r"H:\MO_KB_FRONT_ASAP"),
    Path(r"H:\MO_KB_STORE"),
    Path(r"H:\MO_KB_VENDOR"),
    Path(r"H:\UwAmp\www"),
]

WORKSPACE_DIRS = [
    "CONTEXT",
    "CONTEXT\\REPORTS",
    "CONTEXT\\HANDOFFS",
    "CONTEXT\\DECISIONS",
    "CONTEXT\\STARTER",
    "SECTORS",
    "SECTORS\\MAESTRO_V5",
    "SECTORS\\MO_KB_DAEMON",
    "SECTORS\\MO_KB_FRONT_ASAP",
    "SECTORS\\MO_KB_STORE",
    "SECTORS\\MO_KB_VENDOR",
    "SECTORS\\UWAMP_FRONT",
    "TOOLS",
    "TOOLS\\P111",
    "TOOLS\\AUDIT",
    "INBOX",
    "OUTBOX",
]

SCORIE_DIR_NAMES = {
    "__pycache__",
    ".pytest_cache",
    ".mypy_cache",
    ".ruff_cache",
    ".idea",
    ".vscode",
    "node_modules",
    "dist",
    "build",
    "tmp",
    "temp",
    "cache",
    "caches",
}

SCORIE_SUFFIXES = {
    ".pyc",
    ".pyo",
    ".tmp",
    ".temp",
    ".bak",
    ".old",
    ".orig",
    ".rej",
    ".log",
}

MAX_TREE_DEPTH = 4
MAX_LISTED_ITEMS_PER_SOURCE = 800
MAX_SCORIE_ITEMS_PER_SOURCE = 500


def timestamp() -> str:
    return dt.datetime.now().strftime("%Y-%m-%d %H:%M:%S")


def safe_rel(path: Path, root: Path) -> str:
    try:
        return str(path.relative_to(root))
    except ValueError:
        return str(path)


def ensure_workspace(workspace: Path) -> None:
    workspace.mkdir(parents=True, exist_ok=True)
    for rel in WORKSPACE_DIRS:
        (workspace / rel).mkdir(parents=True, exist_ok=True)


def existing_sources(extra_sources: list[str]) -> list[Path]:
    candidates = list(CANDIDATE_SOURCES)
    for raw in extra_sources:
        candidates.append(Path(raw))

    out: list[Path] = []
    seen: set[str] = set()

    for p in candidates:
        if not p.exists():
            continue
        try:
            key = str(p.resolve()).lower()
        except Exception:
            key = str(p).lower()
        if key in seen:
            continue
        seen.add(key)
        out.append(p)

    return out


def walk_limited(root: Path, max_depth: int) -> Iterable[Path]:
    try:
        resolved_root = root.resolve()
    except Exception:
        resolved_root = root

    for current, dirs, files in os.walk(root):
        current_path = Path(current)
        try:
            depth = len(current_path.resolve().relative_to(resolved_root).parts)
        except Exception:
            depth = 0

        dirs[:] = sorted(dirs)
        files = sorted(files)

        if depth >= max_depth:
            dirs[:] = []

        for d in dirs:
            yield current_path / d
        for f in files:
            yield current_path / f


def classify_source(path: Path) -> str:
    s = str(path).lower()
    if "maestro_v5" in s:
        return "MAESTRO_V5"
    if "mo_kb_daemon" in s:
        return "MO_KB_DAEMON"
    if "mo_kb_front" in s:
        return "MO_KB_FRONT_ASAP"
    if "mo_kb_store" in s:
        return "MO_KB_STORE"
    if "mo_kb_vendor" in s:
        return "MO_KB_VENDOR"
    if "uwamp" in s:
        return "UWAMP_FRONT"
    return "UNKNOWN"


def run_git(args: list[str], cwd: Path) -> tuple[int, str]:
    if shutil.which("git") is None:
        return 127, "git introuvable dans PATH"

    try:
        proc = subprocess.run(
            ["git"] + args,
            cwd=str(cwd),
            text=True,
            encoding="utf-8",
            errors="replace",
            stdout=subprocess.PIPE,
            stderr=subprocess.STDOUT,
            timeout=30,
        )
        return proc.returncode, proc.stdout.strip()
    except Exception as exc:
        return 1, f"{type(exc).__name__}: {exc}"


def git_info(source: Path) -> dict[str, str]:
    code, top = run_git(["rev-parse", "--show-toplevel"], source)
    if code != 0:
        return {
            "is_git": "NO",
            "top": "",
            "branch": "",
            "status": top,
            "remote": "",
        }

    top_path = Path(top)
    _, branch = run_git(["branch", "--show-current"], top_path)
    _, status = run_git(["status", "--short"], top_path)
    _, remote = run_git(["remote", "-v"], top_path)

    return {
        "is_git": "YES",
        "top": str(top_path),
        "branch": branch or "(detached/unknown)",
        "status": status or "clean",
        "remote": remote or "(aucun remote)",
    }


def detect_scories(source: Path) -> list[Path]:
    found: list[Path] = []

    for p in walk_limited(source, max_depth=8):
        name = p.name.lower()
        if p.is_dir() and name in SCORIE_DIR_NAMES:
            found.append(p)
        elif p.is_file() and any(name.endswith(suffix) for suffix in SCORIE_SUFFIXES):
            found.append(p)

        if len(found) >= MAX_SCORIE_ITEMS_PER_SOURCE:
            break

    return found


def write_project_map(report_dir: Path, workspace: Path, sources: list[Path]) -> None:
    lines: list[str] = []
    lines.append("# PROJECT_MAP.md")
    lines.append("")
    lines.append(f"Generated: `{timestamp()}`")
    lines.append(f"Workspace officiel: `{workspace}`")
    lines.append("")
    lines.append("## Sources détectées")
    lines.append("")

    if not sources:
        lines.append("Aucune source détectée parmi les chemins candidats.")
    else:
        lines.append("| Secteur | Chemin | Git |")
        lines.append("|---|---|---|")
        for src in sources:
            info = git_info(src)
            lines.append(f"| `{classify_source(src)}` | `{src}` | `{info['is_git']}` |")

    lines.append("")
    lines.append("## Arborescence limitée")
    lines.append("")

    for src in sources:
        lines.append(f"### {classify_source(src)}")
        lines.append("")
        lines.append(f"`{src}`")
        lines.append("")

        count = 0
        for p in walk_limited(src, MAX_TREE_DEPTH):
            rel = safe_rel(p, src)
            kind = "DIR " if p.is_dir() else "FILE"
            lines.append(f"- `{kind}` `{rel}`")
            count += 1
            if count >= MAX_LISTED_ITEMS_PER_SOURCE:
                lines.append(f"- `...` liste tronquée à {MAX_LISTED_ITEMS_PER_SOURCE} éléments")
                break

        if count == 0:
            lines.append("- `(vide ou inaccessible)`")

        lines.append("")

    (report_dir / "PROJECT_MAP.md").write_text("\n".join(lines), encoding="utf-8")


def write_scories_report(report_dir: Path, sources: list[Path]) -> None:
    lines: list[str] = []
    lines.append("# SCORIES_REPORT.md")
    lines.append("")
    lines.append(f"Generated: `{timestamp()}`")
    lines.append("")
    lines.append("Rapport non destructif. Aucun fichier n'a été supprimé.")
    lines.append("")

    if not sources:
        lines.append("Aucune source à auditer.")
    else:
        for src in sources:
            lines.append(f"## {classify_source(src)}")
            lines.append("")
            lines.append(f"Source: `{src}`")
            lines.append("")

            scories = detect_scories(src)
            if not scories:
                lines.append("Aucune scorie évidente détectée dans la profondeur auditée.")
            else:
                lines.append("| Type | Chemin |")
                lines.append("|---|---|")
                for item in scories:
                    kind = "DIR" if item.is_dir() else "FILE"
                    lines.append(f"| `{kind}` | `{item}` |")

            lines.append("")

    (report_dir / "SCORIES_REPORT.md").write_text("\n".join(lines), encoding="utf-8")


def write_git_readiness(report_dir: Path, sources: list[Path]) -> None:
    lines: list[str] = []
    lines.append("# GIT_READINESS.md")
    lines.append("")
    lines.append(f"Generated: `{timestamp()}`")
    lines.append("")
    lines.append("Objectif : déterminer ce qui peut devenir source de vérité GitHub.")
    lines.append("")

    if not sources:
        lines.append("Aucune source détectée.")
    else:
        for src in sources:
            info = git_info(src)
            lines.append(f"## {classify_source(src)}")
            lines.append("")
            lines.append(f"- Chemin : `{src}`")
            lines.append(f"- Dépôt Git : `{info['is_git']}`")
            if info["is_git"] == "YES":
                lines.append(f"- Racine Git : `{info['top']}`")
                lines.append(f"- Branche : `{info['branch']}`")
                lines.append("- Statut :")
                lines.append("")
                lines.append("```text")
                lines.append(info["status"])
                lines.append("```")
                lines.append("")
                lines.append("- Remotes :")
                lines.append("")
                lines.append("```text")
                lines.append(info["remote"])
                lines.append("```")
            else:
                lines.append("- État : non versionné ou Git indisponible.")
                lines.append("- Action future : décider explicitement si ce secteur devient dépôt Git séparé ou sous-dossier d'un mono-repo.")
            lines.append("")

    (report_dir / "GIT_READINESS.md").write_text("\n".join(lines), encoding="utf-8")


def write_clean_repo_plan(report_dir: Path, workspace: Path, sources: list[Path]) -> None:
    lines: list[str] = []
    lines.append("# CLEAN_GITHUB_REPO_PLAN.md")
    lines.append("")
    lines.append(f"Generated: `{timestamp()}`")
    lines.append(f"Workspace officiel : `{workspace}`")
    lines.append("")
    lines.append("## Contrat")
    lines.append("")
    lines.append("Aucun dépôt GitHub ne doit être initialisé ou nettoyé automatiquement par ce bootstrap.")
    lines.append("Ce fichier prépare seulement la décision.")
    lines.append("")
    lines.append("## Plan recommandé")
    lines.append("")
    lines.append("1. Valider manuellement `PROJECT_MAP.md`.")
    lines.append("2. Valider manuellement `SCORIES_REPORT.md`.")
    lines.append("3. Valider manuellement `GIT_READINESS.md`.")
    lines.append("4. Décider de la stratégie Git : mono-repo ou repos séparés.")
    lines.append("5. Créer un `.gitignore` propre par secteur.")
    lines.append("6. Faire un premier commit propre uniquement après validation.")
    lines.append("7. Déclarer GitHub comme source de vérité seulement après push vérifié.")
    lines.append("")
    lines.append("## Sources candidates")
    lines.append("")

    if not sources:
        lines.append("Aucune source détectée.")
    else:
        for src in sources:
            lines.append(f"- `{classify_source(src)}` : `{src}`")

    lines.append("")
    lines.append("## Interdits P111")
    lines.append("")
    lines.append("- Pas de patch depuis un ZIP partiel.")
    lines.append("- Pas de patch sans source de vérité.")
    lines.append("- Pas de patch sans cible live identifiée.")
    lines.append("- Pas de fallback silencieux.")
    lines.append("- Pas de scories, caches ou fichiers temporaires dans l'UI normale.")
    lines.append("- Pas de suppression automatique par ce bootstrap.")

    (report_dir / "CLEAN_GITHUB_REPO_PLAN.md").write_text("\n".join(lines), encoding="utf-8")


def write_readme(workspace: Path, report_dir: Path, sources: list[Path]) -> None:
    lines: list[str] = []
    lines.append("# MAESTRO_WORKSPACE")
    lines.append("")
    lines.append(f"Bootstrap P111 exécuté le `{timestamp()}`.")
    lines.append("")
    lines.append(f"Workspace officiel : `{workspace}`")
    lines.append("")
    lines.append("## Rapports générés")
    lines.append("")
    lines.append(f"- `{report_dir / 'PROJECT_MAP.md'}`")
    lines.append(f"- `{report_dir / 'SCORIES_REPORT.md'}`")
    lines.append(f"- `{report_dir / 'GIT_READINESS.md'}`")
    lines.append(f"- `{report_dir / 'CLEAN_GITHUB_REPO_PLAN.md'}`")
    lines.append("")
    lines.append("## Sources détectées")
    lines.append("")
    if not sources:
        lines.append("Aucune source détectée.")
    else:
        for src in sources:
            lines.append(f"- `{classify_source(src)}` : `{src}`")
    lines.append("")
    lines.append("## Prochaine étape")
    lines.append("")
    lines.append("Lire les rapports avant toute correction ou création de dépôt GitHub.")
    lines.append("")
    lines.append("🔴 IMPORTANT : ce bootstrap ne rend pas GitHub source de vérité. Il prépare seulement le terrain.")
    (workspace / "README_P111.md").write_text("\n".join(lines), encoding="utf-8")


def main() -> int:
    parser = argparse.ArgumentParser(description="Bootstrap non destructif du workspace P111 MAESTRO_WORKSPACE.")
    parser.add_argument(
        "--workspace",
        default=str(OFFICIAL_WORKSPACE),
        help=r"Chemin du workspace. Défaut : H:\MAESTRO_WORKSPACE",
    )
    parser.add_argument(
        "--source",
        action="append",
        default=[],
        help="Chemin source supplémentaire à auditer. Option répétable.",
    )
    args = parser.parse_args()

    workspace = Path(args.workspace)
    report_dir = workspace / "CONTEXT" / "REPORTS"

    print("MAESTRO_WORKSPACE P111 BOOTSTRAP")
    print(f"Workspace cible : {workspace}")
    print("Mode : non destructif")

    ensure_workspace(workspace)

    sources = existing_sources(args.source)

    write_project_map(report_dir, workspace, sources)
    write_scories_report(report_dir, sources)
    write_git_readiness(report_dir, sources)
    write_clean_repo_plan(report_dir, workspace, sources)
    write_readme(workspace, report_dir, sources)

    print("")
    print("OK - workspace préparé.")
    print(f"Rapports : {report_dir}")
    print("")
    print("Rapports générés :")
    print(f"- {report_dir / 'PROJECT_MAP.md'}")
    print(f"- {report_dir / 'SCORIES_REPORT.md'}")
    print(f"- {report_dir / 'GIT_READINESS.md'}")
    print(f"- {report_dir / 'CLEAN_GITHUB_REPO_PLAN.md'}")
    print("")
    print("Aucun fichier source modifié.")
    print("Aucune suppression effectuée.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
