# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et LOGANDPLAY.

Ce dépôt garde les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

Correction importante : OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. README.md
2. CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
3. CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md
4. CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md
5. CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
6. CONTEXT/PROJECTS/PROJECT_INDEX.md

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| LOGANDPLAY | Identité publique et carte d'entrée logandplay.org | À aligner contractuellement |
| OPUS | Framework PHP OPUS 8.1.0 Lysenko | ODBC-only + Model core validés ; ODBC Explorer contract validé ; prochaine étape P7_ODBC_EXPLORER_READONLY_CORE |
| OPUS RefBook | Site officiel de documentation OPUS | Intégré sous OPUS comme site optionnel ; rendu .score OPUS |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif, non exposé publiquement |
| MO_KB_DAEMON | Backend KB musicale | Actif privé, non exposé publiquement |
| MO_KB_FRONT | Front/backoffice KB historique | À réévaluer |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte, handoffs et TODOs |

## OPUS état immédiat

- OPUS root : H:/OPUS
- OPUS GitHub : philstephibanez-wq/OPUS
- Workspace root : H:/MAESTRO_WORKSPACE
- Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
- OPUS branch : master
- OPUS latest functional code commit : e12b1dd
- OPUS latest workspace-status-only commit in OPUS repo : 506280f
- OPUS latest validated tag : OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE

OPUS database-facing architecture is ODBC-only. OPUS Model is the official representation layer for ODBC tables, rows, fields, types, sizes, nullability and metadata.

LSTSAR final target must be Model-driven + ODBC-driven for heterogeneous database ingestion and storage.

OPUS ODBC Explorer must become a true OPUS site/application with routes, controllers, ScoreTemplate views, I18N, SSO/ACL, diagnostics, profiler and logs.

## Handoff obligatoire à chaque livraison

À chaque livraison qui change l'état projet, mettre à jour le workspace, notamment CURRENT_HANDOFF.md, PROJECT_INDEX.md, OPUS_CURRENT_STATE.md, les décisions si nécessaire, et README.md si la vue 10 secondes change.

## Raccourcis

- Décision ODBC-only / Model / ODBC Explorer site : CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md
- Handoff courant : CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- Handoff OPUS ODBC Model Explorer : CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md
- OPUS current state : CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md

## Règles immédiates

- OPUS est un sous-projet du MAESTRO_WORKSPACE ; OPUS n'est pas le workspace.
- ScoreTemplate et .score : OPUS uniquement, pas ASAP.
- OPUS REST : générique, data-driven, contractuel, sans hardcode LSTSAR.
- OPUS database : ODBC-only, via Opus\Database\Odbc.
- OPUS Model : représentation officielle des tables/lignes/champs ODBC.
- OPUS ODBC Explorer : futur vrai site OPUS.
- OPUS LSTSAR final : Model-driven + ODBC-driven.
- Opus/Legacy ne doit pas réapparaître.
- Pas de fallback silencieux.
- Les caches vont dans OPUS/var/cache.
- Les logs vont dans OPUS/var/logs.
