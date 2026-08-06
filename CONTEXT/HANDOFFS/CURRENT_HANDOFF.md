# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-06

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R46_DEV_SERVER_SITE_OPTION_2026-08-06.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46_DEV_SERVER_SITE_OPTION_2026-08-06.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.

E2A est acquis et publié à cette base.

## Livrable actif

```text
ZIP     : opus_p117w_r46_dev_server_site_option.zip
SHA-256 : 4112fef6bff85d9dc8d064439eda7397793d06917ac5c9390949bdc8b1140f33
FILES   : 1
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

Cible : parseur générique OPUS de `opus:dev-server` et aide publique.

Nouveau contrat :

```text
composer opus:dev-server -- --site=<site> [--host=<local-address>] [--port=<local-port>]
```

La forme positionnelle et la forme `--site test7` sont interdites. Aucun site généré, aucun fichier OWASYS et aucune correction locale de `test7` ne sont ciblés.

Le smoke owner est fourni séparément du ZIP.

## Suite après acquisition

E2B : éditeur Sources dans `owasys-front`, POST backend, preview distincte de write, ViewModel, SCORE, conflit explicite, maintien du fichier et de la locale dans l'URL et fallback sans JavaScript obligatoire.

E3 : Git contrôlé, séparé de l'enregistrement Source et sans push implicite.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO POSITIONAL DEV-SERVER SITE.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
