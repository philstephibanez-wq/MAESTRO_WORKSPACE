#!/usr/bin/env python3
# -*- coding: utf-8 -*-
r"""
P111 policy update V2 FIXED for H:\MAESTRO_WORKSPACE.

Correction:
- UwAmp is runtime/link only, not the front source.
- H:\MO_KB_FRONT is the front source candidate.
- Python booleans are valid Python booleans, not JSON booleans.

Non destructive:
- writes only P111 context documents
- writes the proposed VS Code workspace
- does not modify source code
- does not touch Git repositories
- deletes nothing
"""

from __future__ import annotations

import json
from pathlib import Path


WORKSPACE = Path(r"H:\MAESTRO_WORKSPACE")

POLICY_MD = '# P111_DISTRIBUTION_POLICY.md\n\n## Décision active\n\n`MO_KB` et toutes ses applications associées sont une infrastructure privée **at home**.\n\n`MAESTRO` et les futurs `VSTi` sont des produits **distribuables**.\n\n## Conséquence directe\n\nLes dépendances embarquées type Python runtime, SQLite runtime, modèles ou runtimes IA ne sont obligatoires comme packaging distribuable que pour les applications distribuables, quand elles en ont réellement besoin.\n\n## Secteurs\n\n| Secteur | Statut | Règle |\n|---|---|---|\n| `MAESTRO_V5` | distribuable | packaging propre, dépendances maîtrisées, source Git propre |\n| `VSTi_*` futurs | distribuables | packaging public/privé propre, licences et dépendances cadrées |\n| `MO_KB_DAEMON` | at home | dépendances locales maîtrisées acceptées, pas besoin de bundle public |\n| `MO_KB_FRONT` | at home | vraie source applicative front/backoffice |\n| `UwAmp` | runtime local | héberge le front via lien/junction ; pas source applicative |\n| `MO_KB_STORE` | données privées durables | pas un dépôt code |\n| `MO_KB_VENDOR` | dépendances/cache contrôlé at home | pas un dépôt source |\n\n## Règle corrigée UwAmp / Front\n\n```text\nH:\\MO_KB_FRONT\n    = source réelle du front.\n\nH:\\UwAmp\\www\\...\n    = hôte web local / lien / junction vers le front.\n    = ne doit pas être traité comme source de vérité applicative.\n```\n\n## Interdits maintenus\n\n- Aucun fallback silencieux.\n- Aucun JSON brut dans l’UI normale.\n- Aucun fichier temporaire/scorie dans les vues normales.\n- Aucun patch sans source de vérité.\n- Aucun patch depuis ZIP partiel.\n- Aucun mélange entre données privées `MO_KB_STORE` et code distribuable.\n- Aucun vendoring public inutile pour MO_KB at home.\n- Ne pas transformer `H:\\UwAmp\\www` en dépôt source du front.\n\n## Règle de packaging\n\n```text\nMO_KB at home:\n    dépendances locales documentées et contrôlées OK.\n\nMAESTRO / VSTi distribuables:\n    dépendances embarquées ou installateur propre uniquement si nécessaire.\n```\n'

SECTORS_MD = '# P111_SOURCE_OF_TRUTH_SECTORS.md\n\n## État corrigé\n\nCorrection importante : `UwAmp` n’est pas le front.\n\n`UwAmp` contient seulement un lien/junction vers le vrai front et sert de runtime web local.\n\n## Sources de vérité candidates\n\n| Secteur | Chemin officiel candidat | Rôle |\n|---|---|---|\n| `MAESTRO_WORKSPACE` | `H:\\MAESTRO_WORKSPACE` | contexte, rapports, décisions P111 |\n| `MAESTRO_V5` | `D:\\REAPER_Roaming\\REAPER\\Scripts\\MAESTRO_v5` | produit distribuable REAPER/Lua |\n| `MO_KB_DAEMON` | `H:\\MO_KB_DAEMON` | backend privé at home |\n| `MO_KB_FRONT` | `H:\\MO_KB_FRONT` | vraie source front/backoffice privé at home |\n\n## Hors source de vérité code\n\n| Chemin | Rôle | Règle |\n|---|---|---|\n| `H:\\UwAmp\\www` | hôte web local | ne pas traiter comme dépôt source |\n| `H:\\MO_KB_STORE` | données privées, KB, logs, jobs, DB, audio | pas un dépôt code |\n| `H:\\MO_KB_VENDOR` | dépendances, Python local, modèles, caches contrôlés | pas un dépôt code |\n| `H:\\MO_KB_BACKUPS` | backups | hors repo |\n| `H:\\MO_KB_SNAPSHOTS` | snapshots | hors repo sauf décision explicite |\n\n## Résumé Git observé précédemment\n\n| Secteur | Git | État |\n|---|---|---|\n| `MAESTRO_V5` | oui | clean, remote à définir |\n| `MO_KB_DAEMON` | oui | modifications locales à comprendre avant GitHub |\n| `MO_KB_FRONT` | à confirmer sur disque | doit être audité directement depuis `H:\\MO_KB_FRONT` |\n\n## Alerte importante\n\nNe pas confondre :\n\n```text\nH:\\UwAmp\\www\\MO_KB_FRONT\n```\n\navec la vraie source :\n\n```text\nH:\\MO_KB_FRONT\n```\n\nSi `H:\\UwAmp\\www\\MO_KB_FRONT` existe, il doit être vérifié comme lien/junction uniquement.\n\n## Prochaine étape avant patch\n\n1. Confirmer que `H:\\MO_KB_FRONT` existe et contient le front actif.\n2. Vérifier que `H:\\UwAmp\\www\\MO_KB_FRONT` est bien un lien/junction vers `H:\\MO_KB_FRONT`.\n3. Auditer `git status` sur `H:\\MO_KB_FRONT`.\n4. Lire le diff réel de `H:\\MO_KB_DAEMON`.\n5. Décider commit / rollback / palier propre.\n'

WORKSPACE_JSON = {'folders': [{'name': 'MAESTRO_WORKSPACE', 'path': 'H:\\MAESTRO_WORKSPACE'}, {'name': 'MAESTRO_V5', 'path': 'D:\\REAPER_Roaming\\REAPER\\Scripts\\MAESTRO_v5'}, {'name': 'MO_KB_DAEMON', 'path': 'H:\\MO_KB_DAEMON'}, {'name': 'MO_KB_FRONT', 'path': 'H:\\MO_KB_FRONT'}], 'settings': {'files.encoding': 'utf8', 'files.eol': 'auto', 'editor.formatOnSave': False, 'editor.formatOnPaste': False, 'git.autofetch': False, 'python.defaultInterpreterPath': 'H:\\MO_KB_VENDOR\\python\\python.exe', 'php.validate.executablePath': 'H:\\UwAmp\\bin\\php\\php-8.5.6\\php.exe', 'search.exclude': {'**/.git/**': True, '**/__pycache__/**': True, '**/.pytest_cache/**': True, '**/.mypy_cache/**': True, '**/.ruff_cache/**': True, '**/node_modules/**': True, '**/vendor/**': True, '**/MO_KB_STORE/**': True, '**/MO_KB_VENDOR/**': True, '**/MO_KB_BACKUPS/**': True, '**/MO_KB_SNAPSHOTS/**': True, '**/DEPENDENCIES/python_runtime/Lib/site-packages/**': True}, 'files.watcherExclude': {'**/.git/**': True, '**/__pycache__/**': True, '**/.pytest_cache/**': True, '**/.mypy_cache/**': True, '**/.ruff_cache/**': True, '**/node_modules/**': True, '**/vendor/**': True, '**/MO_KB_STORE/**': True, '**/MO_KB_VENDOR/**': True, '**/MO_KB_BACKUPS/**': True, '**/MO_KB_SNAPSHOTS/**': True, '**/DEPENDENCIES/python_runtime/Lib/site-packages/**': True}}, 'tasks': {'version': '2.0.0', 'tasks': [{'label': 'P111 · Git status MAESTRO_V5', 'type': 'shell', 'command': 'git -C D:\\REAPER_Roaming\\REAPER\\Scripts\\MAESTRO_v5 status --short --branch', 'problemMatcher': []}, {'label': 'P111 · Git status MO_KB_DAEMON', 'type': 'shell', 'command': 'git -C H:\\MO_KB_DAEMON status --short --branch', 'problemMatcher': []}, {'label': 'P111 · Git status MO_KB_FRONT', 'type': 'shell', 'command': 'git -C H:\\MO_KB_FRONT status --short --branch', 'problemMatcher': []}, {'label': 'P111 · Check UwAmp front junction', 'type': 'shell', 'command': 'cmd /c dir /AL H:\\UwAmp\\www', 'problemMatcher': []}, {'label': 'MO_KB · Python vendor version', 'type': 'shell', 'command': 'H:\\MO_KB_VENDOR\\python\\python.exe -c \\"import sys, sqlite3; print(sys.executable); print(sys.version); print(sqlite3.sqlite_version)\\"', 'problemMatcher': []}, {'label': 'MO_KB_FRONT · PHP version UwAmp', 'type': 'shell', 'command': 'H:\\UwAmp\\bin\\php\\php-8.5.6\\php.exe -v', 'problemMatcher': []}]}}


def main() -> int:
    decisions_dir = WORKSPACE / "CONTEXT" / "DECISIONS"
    decisions_dir.mkdir(parents=True, exist_ok=True)

    (decisions_dir / "P111_DISTRIBUTION_POLICY.md").write_text(POLICY_MD, encoding="utf-8")
    (decisions_dir / "P111_SOURCE_OF_TRUTH_SECTORS.md").write_text(SECTORS_MD, encoding="utf-8")

    workspace_file = WORKSPACE / "MAESTRO_WORKSPACE.code-workspace"
    workspace_file.write_text(
        json.dumps(WORKSPACE_JSON, ensure_ascii=False, indent=2) + "\n",
        encoding="utf-8",
    )

    print("OK - P111 context updated V2 FIXED.")
    print(f"- {decisions_dir / 'P111_DISTRIBUTION_POLICY.md'}")
    print(f"- {decisions_dir / 'P111_SOURCE_OF_TRUTH_SECTORS.md'}")
    print(f"- {workspace_file}")
    print("")
    print("Correction appliquee : UwAmp est runtime/lien, pas source front.")
    print("Aucun code source modifie.")
    print("Aucun depot Git modifie.")
    print("Aucune suppression effectuee.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
