#!/usr/bin/env python3
# -*- coding: utf-8 -*-
r"""
OPENAI_ASSISTANT_READONLY / ask_maestro.py

Assistant API local pour MAESTRO_WORKSPACE.

Contrat P111:
- READ ONLY par défaut.
- Ne modifie aucun fichier.
- Ne crée aucun patch appliqué.
- Ne lance aucun git add / commit / push / checkout / reset / clean.
- Ne supprime rien.
- Ne stocke jamais la clé API dans un fichier.
- Écrit uniquement un rapport de réponse dans:
    H:\MAESTRO_WORKSPACE\OUTBOX\OPENAI_ASSISTANT

Dépendances:
- Python standard library uniquement.
- Utilise l'API REST OpenAI /v1/responses via urllib.
- Nécessite OPENAI_API_KEY dans l'environnement Windows.

Exemples:
    python ask_maestro.py --dry-run --repo H:\MO_KB_DAEMON --status --question "Résumé lecture seule"

    python ask_maestro.py --repo H:\MO_KB_DAEMON --status --diff --question "Analyse ce diff sans patcher"

    python ask_maestro.py --file H:\MO_KB_DAEMON\app\core\paths.py --question "Explique ce fichier"
"""

from __future__ import annotations

import argparse
import datetime as dt
import json
import os
import subprocess
import sys
import textwrap
import urllib.error
import urllib.request
from pathlib import Path
from typing import Iterable


WORKSPACE = Path(r"H:\MAESTRO_WORKSPACE")
OUTBOX = WORKSPACE / "OUTBOX" / "OPENAI_ASSISTANT"

DEFAULT_MODEL = os.environ.get("OPENAI_MODEL", "gpt-5.5")
API_URL = os.environ.get("OPENAI_RESPONSES_URL", "https://api.openai.com/v1/responses")

MAX_CAPTURE_BYTES_DEFAULT = 120_000
MAX_FILE_BYTES_DEFAULT = 80_000


P111_INSTRUCTIONS = r"""
You are assisting the MAESTRO_WORKSPACE project.

P111 strict rules:
- Read-only inspection unless the user explicitly approves a patch in a later step.
- Do not ask to run destructive commands.
- Do not propose git add, git commit, git push, git checkout, git reset, or git clean as an automatic action.
- Do not create temporary/debug/scorie files.
- Do not create fallbacks.
- No source of truth, no patch.
- No context, no patch.
- No zip partiel as source of truth.
- GitHub is the source of truth for code repositories already configured in this workspace.
- MO_KB and its apps are private at-home infrastructure, not public distributable products.
- MAESTRO and future VSTi are distributable products.
- UwAmp is only a local web host/junction; the real MO_KB front source is H:\MO_KB_FRONT.
- MO_KB_STORE, MO_KB_VENDOR and UwAmp are not code repositories.

Output contract:
- Answer in French.
- Start with a clear conclusion.
- Separate observations, risks, and next safe actions.
- If a patch is needed, propose a patch plan only, do not output a full patch unless explicitly asked.
- Use visible markers for critical points: 🔴 IMPORTANT or ⚠️ À NE PAS OUBLIER.
"""


def now_stamp() -> str:
    return dt.datetime.now().strftime("%Y%m%d_%H%M%S")


def safe_write(path: Path, text: str) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(text, encoding="utf-8")


def run_readonly_command(args: list[str], cwd: Path | None = None, timeout: int = 60) -> tuple[int, str]:
    forbidden = {
        "add", "commit", "push", "checkout", "reset", "clean", "merge", "rebase",
        "rm", "mv", "restore", "switch", "stash", "pull",
    }

    if args and args[0].lower() == "git":
        for token in args[1:]:
            if token.lower() in forbidden:
                return 99, f"BLOCKED_BY_P111_READONLY: git {token}"

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
        return proc.returncode, proc.stdout
    except FileNotFoundError as exc:
        return 127, f"{type(exc).__name__}: {exc}"
    except subprocess.TimeoutExpired as exc:
        return 124, f"TimeoutExpired after {timeout}s: {exc}"
    except Exception as exc:
        return 1, f"{type(exc).__name__}: {exc}"


def truncate_text(text: str, max_bytes: int, label: str) -> str:
    data = text.encode("utf-8", errors="replace")
    if len(data) <= max_bytes:
        return text
    clipped = data[:max_bytes].decode("utf-8", errors="replace")
    return clipped + f"\n\n[TRUNCATED: {label} exceeded {max_bytes} bytes]\n"


def read_text_file(path: Path, max_bytes: int) -> str:
    try:
        data = path.read_bytes()
    except Exception as exc:
        return f"[ERROR reading {path}: {type(exc).__name__}: {exc}]"

    if len(data) > max_bytes:
        data = data[:max_bytes]
        suffix = f"\n\n[TRUNCATED: file exceeded {max_bytes} bytes]\n".encode("utf-8")
    else:
        suffix = b""

    try:
        return data.decode("utf-8", errors="replace") + suffix.decode("utf-8")
    except Exception as exc:
        return f"[ERROR decoding {path}: {type(exc).__name__}: {exc}]"


def collect_context_docs() -> str:
    candidates = [
        WORKSPACE / "CONTEXT" / "DECISIONS" / "P111_DISTRIBUTION_POLICY.md",
        WORKSPACE / "CONTEXT" / "DECISIONS" / "P111_SOURCE_OF_TRUTH_SECTORS.md",
        WORKSPACE / "CONTEXT" / "REPORTS" / "P111_LIVE_GIT_AUDIT.md",
        WORKSPACE / "README_P111.md",
    ]

    chunks: list[str] = []
    for p in candidates:
        if p.exists():
            chunks.append(f"\n\n===== CONTEXT DOC: {p} =====\n")
            chunks.append(read_text_file(p, max_bytes=40_000))
    return "".join(chunks) if chunks else "[No P111 context docs found]"


def collect_repo_status(repo: Path) -> str:
    chunks = [f"\n\n===== REPO STATUS: {repo} =====\n"]

    commands = [
        ["git", "rev-parse", "--show-toplevel"],
        ["git", "status", "--short", "--branch"],
        ["git", "remote", "-v"],
        ["git", "log", "-1", "--oneline", "--decorate"],
    ]

    for cmd in commands:
        code, out = run_readonly_command(cmd, cwd=repo)
        chunks.append(f"\n$ {' '.join(cmd)}\nExitCode={code}\n")
        chunks.append(out if out else "(empty)\n")

    return "".join(chunks)


def collect_repo_diff(repo: Path, max_bytes: int) -> str:
    chunks = [f"\n\n===== REPO DIFF: {repo} =====\n"]

    commands = [
        ["git", "diff", "--stat"],
        ["git", "diff", "--name-status"],
        ["git", "diff", "--no-ext-diff", "--"],
        ["git", "diff", "--cached", "--stat"],
        ["git", "diff", "--cached", "--no-ext-diff", "--"],
    ]

    for cmd in commands:
        code, out = run_readonly_command(cmd, cwd=repo, timeout=120)
        chunks.append(f"\n$ {' '.join(cmd)}\nExitCode={code}\n")
        chunks.append(truncate_text(out if out else "(empty)\n", max_bytes=max_bytes, label="git diff capture"))

    return "".join(chunks)


def collect_files(files: Iterable[str], max_bytes: int) -> str:
    chunks: list[str] = []
    for raw in files:
        p = Path(raw)
        chunks.append(f"\n\n===== FILE: {p} =====\n")
        if not p.exists():
            chunks.append("[MISSING]\n")
            continue
        if p.is_dir():
            chunks.append("[SKIPPED: is a directory]\n")
            continue
        chunks.append(read_text_file(p, max_bytes=max_bytes))
    return "".join(chunks)


def build_user_input(args: argparse.Namespace) -> str:
    parts: list[str] = []
    parts.append("QUESTION UTILISATEUR:\n")
    parts.append(args.question.strip())
    parts.append("\n\n")

    if args.context:
        parts.append("===== P111 CONTEXT =====\n")
        parts.append(collect_context_docs())

    if args.repo:
        repo = Path(args.repo)
        if args.status:
            parts.append(collect_repo_status(repo))
        if args.diff:
            parts.append(collect_repo_diff(repo, max_bytes=args.max_capture_bytes))

    if args.file:
        parts.append(collect_files(args.file, max_bytes=args.max_file_bytes))

    if args.extra:
        parts.append("\n\n===== EXTRA USER CONTEXT =====\n")
        parts.append(args.extra)

    full = "".join(parts)
    return truncate_text(full, max_bytes=args.max_capture_bytes * 3, label="full prompt capture")


def call_openai_responses(model: str, instructions: str, input_text: str, max_output_tokens: int) -> dict:
    api_key = os.environ.get("OPENAI_API_KEY", "").strip()
    if not api_key:
        raise RuntimeError("OPENAI_API_KEY is missing. Set it as a Windows user environment variable.")

    body = {
        "model": model,
        "instructions": instructions,
        "input": input_text,
        "max_output_tokens": max_output_tokens,
        "store": False,
    }

    request = urllib.request.Request(
        API_URL,
        data=json.dumps(body).encode("utf-8"),
        headers={
            "Authorization": f"Bearer {api_key}",
            "Content-Type": "application/json",
        },
        method="POST",
    )

    try:
        with urllib.request.urlopen(request, timeout=180) as response:
            raw = response.read().decode("utf-8", errors="replace")
            return json.loads(raw)
    except urllib.error.HTTPError as exc:
        error_body = exc.read().decode("utf-8", errors="replace")
        raise RuntimeError(f"OpenAI API HTTP {exc.code}: {error_body}") from exc
    except urllib.error.URLError as exc:
        raise RuntimeError(f"OpenAI API URL error: {exc}") from exc


def extract_output_text(data: dict) -> str:
    direct = data.get("output_text")
    if isinstance(direct, str) and direct.strip():
        return direct

    texts: list[str] = []
    for item in data.get("output", []) or []:
        for content in item.get("content", []) or []:
            if isinstance(content, dict):
                if isinstance(content.get("text"), str):
                    texts.append(content["text"])
                elif isinstance(content.get("output_text"), str):
                    texts.append(content["output_text"])

    if texts:
        return "\n".join(texts)

    return json.dumps(data, ensure_ascii=False, indent=2)


def make_report(args: argparse.Namespace, input_text: str, answer_text: str, response_data: dict | None) -> Path:
    OUTBOX.mkdir(parents=True, exist_ok=True)
    report_path = OUTBOX / f"OPENAI_ASSISTANT_RESPONSE_{now_stamp()}.md"

    response_id = ""
    if response_data:
        response_id = str(response_data.get("id", ""))

    body = []
    body.append("# OPENAI_ASSISTANT RESPONSE\n\n")
    body.append(f"- Generated: `{dt.datetime.now().isoformat(timespec='seconds')}`\n")
    body.append(f"- Model: `{args.model}`\n")
    body.append(f"- Repo: `{args.repo or ''}`\n")
    body.append(f"- Response ID: `{response_id}`\n")
    body.append(f"- Mode: `READ_ONLY`\n\n")
    body.append("## Question\n\n")
    body.append(args.question.strip() + "\n\n")
    body.append("## Réponse\n\n")
    body.append(answer_text.strip() + "\n\n")
    body.append("## Capture envoyée à l'API\n\n")
    body.append("```text\n")
    body.append(truncate_text(input_text, max_bytes=80_000, label="saved prompt capture"))
    body.append("\n```\n")

    safe_write(report_path, "".join(body))
    return report_path


def parse_args(argv: list[str]) -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Assistant API local read-only pour MAESTRO_WORKSPACE.",
        formatter_class=argparse.RawTextHelpFormatter,
    )
    parser.add_argument("--question", required=True, help="Question à envoyer à l'API.")
    parser.add_argument("--repo", help="Chemin repo à inspecter, ex: H:\\MO_KB_DAEMON.")
    parser.add_argument("--file", action="append", help="Fichier à inclure. Option répétable.")
    parser.add_argument("--extra", help="Contexte texte additionnel.")
    parser.add_argument("--status", action="store_true", help="Inclure git status/remote/log lecture seule.")
    parser.add_argument("--diff", action="store_true", help="Inclure git diff lecture seule.")
    parser.add_argument("--no-context", dest="context", action="store_false", help="Ne pas inclure les docs P111.")
    parser.add_argument("--dry-run", action="store_true", help="Préparer la capture mais ne pas appeler l'API.")
    parser.add_argument("--model", default=DEFAULT_MODEL, help=f"Modèle OpenAI. Défaut: {DEFAULT_MODEL}")
    parser.add_argument("--max-output-tokens", type=int, default=2500, help="Limite de sortie API.")
    parser.add_argument("--max-capture-bytes", type=int, default=MAX_CAPTURE_BYTES_DEFAULT, help="Limite capture texte.")
    parser.add_argument("--max-file-bytes", type=int, default=MAX_FILE_BYTES_DEFAULT, help="Limite par fichier.")
    return parser.parse_args(argv)


def main(argv: list[str]) -> int:
    args = parse_args(argv)

    print("OPENAI_ASSISTANT_READONLY")
    print("Mode: READ_ONLY")
    print(f"Workspace: {WORKSPACE}")
    print(f"Model: {args.model}")
    print("")

    input_text = build_user_input(args)

    if args.dry_run:
        OUTBOX.mkdir(parents=True, exist_ok=True)
        dry_path = OUTBOX / f"OPENAI_ASSISTANT_DRY_RUN_{now_stamp()}.txt"
        safe_write(dry_path, input_text)
        print("OK - dry run genere.")
        print(f"Capture: {dry_path}")
        print("Aucun appel API effectue.")
        return 0

    try:
        data = call_openai_responses(
            model=args.model,
            instructions=P111_INSTRUCTIONS,
            input_text=input_text,
            max_output_tokens=args.max_output_tokens,
        )
    except Exception as exc:
        print("ERROR - appel API echoue.")
        print(f"{type(exc).__name__}: {exc}")
        return 2

    answer = extract_output_text(data)
    report_path = make_report(args, input_text, answer, data)

    print("")
    print("===== REPONSE =====")
    print(answer.strip())
    print("")
    print("===== RAPPORT =====")
    print(report_path)
    print("")
    print("Aucun fichier source modifie.")
    print("Aucun depot Git modifie.")
    print("Aucune suppression effectuee.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main(sys.argv[1:]))
