# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-06

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_2026-08-06.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_2026-08-06.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_2026-08-06.md`
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_2026-08-06.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.

E3A est acquis au commit `4b1f621051a306443ada7eb5fada2a8e9363b0aa` avec exactement les onze fichiers attendus du workspace Git générique et de sa frontière OWASYS-back.

R46 `dev-server --site=` reste abandonné. Le contrat positionnel reste :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_e3b_git_workspace_front.zip
SHA-256 : f6cdd8160f16586851b2983373eedba473e865db237db2c388b005bebcc49743
FILES   : 32
BASE    : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
STATUS  : livré, application, validation fonctionnelle, commit et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e3b_git_workspace_front_owner.php
SHA-256 : 4cc4c4cbe15d20d0f83f96d7a8431e420aea3ffcf2b4ecb9dc6a85b953bf5f6a
OUTPUT  : OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_OK
```

## Cible E3B

- intégration Git dans le module/state `source` existant ;
- status, diff, historique, stage, unstage, commit et restauration ;
- SCORE et formulaires POST sans JavaScript obligatoire ;
- CSRF Git distinct, FSM explicite et ACL deny-by-default ;
- viewer en lecture seule, developer/admin en mutation ;
- vingt-cinq catalogues I18n UE configurés plus ukrainien ;
- aucun Git, shell ou accès filesystem direct dans OWASYS-front ;
- enregistrement Source, stage et commit toujours séparés ;
- aucune opération Git implicite ;
- expurgation récursive des corps REST sensibles dans le Profiler OPUS.

E3B ne contient aucun fichier backend, aucun JavaScript, aucune configuration Composer et aucun fichier de site généré.

## Validation owner obligatoire

- lint PHP et parsing JSON ;
- `composer validate` et autoload optimisé ;
- smoke owner ;
- test OWASYS réel de status/diff/history/stage/unstage/commit/restore ;
- confirmation qu'un enregistrement Source ne stage ni ne commit ;
- confirmation viewer lecture seule et developer/admin mutation ;
- commit et push owner seulement après succès.

## Suite après acquisition

R45B3 : durcissement et validation croisée du client REST frontend générique.

Puis R45C wizard structuré et R45D administration Sécurité.

NO ACL BYPASS.
NO CONTENT, DIFF, COMMIT MESSAGE OR CONFIRMATION IN PROFILER.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO IMPLICIT GIT OPERATION.
NO FREE GIT COMMAND.
NO FOREIGN STAGED PATH.
NO BACKEND JAVASCRIPT.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
