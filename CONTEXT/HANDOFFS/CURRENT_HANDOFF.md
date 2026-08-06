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
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_2026-08-06.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.

E2A est acquis et publié à cette base.

R46 `dev-server --site=` est abandonné par décision owner et ne doit jamais être appliqué. Le contrat positionnel est conservé :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_e2b_source_editor_front.zip
SHA-256 : da9df8d1e17a16797fdf09a78413fde32db5d9307d30f577addc292ecc21254b
FILES   : 34
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e2b_source_editor_front_owner.php
SHA-256 : 97055a9b832e84bf9bbcdefbb2f764f25ef341c3b124c17f7bd26b703dc0ace4
OUTPUT  : OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_OK
```

## Cible E2B

- éditeur Sources dans `owasys-front` ;
- fallback SCORE/POST sans JavaScript obligatoire ;
- CodeMirror 6, arbre, onglets, ouverture GET JSON et indicateur dirty en amélioration progressive ;
- preview REST POST distincte de write REST PUT ;
- verrou optimiste SHA-256 ;
- conflit HTTP 409 sans écrasement ;
- POST/Redirect/GET après écriture ;
- ACL viewer lecture seule, developer/admin édition ;
- service CSRF OPUS générique, scopé et à usage unique ;
- 25 catalogues de langue de base UE + ukrainien.

Aucun fichier `owasys-back`, aucun site généré et aucune opération Git ne sont ciblés.

## Suite après acquisition

E3 : Git contrôlé, séparé de l'enregistrement Source : statut, diff, historique, stage, unstage, commit et restauration bornée. Aucun push implicite, aucun argument Git libre, aucun reset/rebase destructif.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO DIRECT FRONTEND FILESYSTEM ACCESS.
NO IMPLICIT GIT OPERATION.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
