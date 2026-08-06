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
9. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_2026-08-06.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `fac5f8d94f29f8529ad9b99f72a0b83f9a74240f`.

E2B est acquis au commit `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé par une édition réelle depuis OWASYS Sources.

Le HEAD courant inclut ensuite les opérations owner sur le site témoin. Aucun fichier de site témoin ne doit entrer dans E3A.

R46 `dev-server --site=` reste abandonné. Le contrat positionnel reste :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_e3a_git_workspace_backend.zip
SHA-256 : 18bfeca293b10d911c717e266823b10771d1899b81dd5ae3edd281ca242bfcdc
FILES   : 11
BASE    : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
STATUS  : livré, application, validation et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e3a_git_workspace_backend_owner.php
SHA-256 : bb37d9e0fe75a4f516593968e79fc1d134ffdeab1c7c9ea6e7944f67c9634db7
OUTPUT  : OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_OK
```

## Cible E3A

- service Git générique OPUS borné au site sélectionné ;
- statut, diff, historique, stage, unstage, commit et restauration ;
- aucun push, aucune commande Git libre ;
- refus du commit si l'index contient un chemin extérieur au site ;
- restauration avec hash optimiste et confirmation renforcée ;
- REST sécurisé puis Composer allow-listé dans OWASYS-back ;
- ACL viewer lecture, developer/admin mutation ;
- Logger et Profiler corrélés sans contenu Git sensible ;
- correction du rôle principal affiché par priorité `admin > developer > viewer`.

E3A ne contient aucune page Git frontend, aucun JavaScript backend et aucun fichier de site généré.

## Suite après acquisition

E3B : intégration Git dans OWASYS-front via SCORE, FSM, I18n, ACL, CSRF et fallback sans JavaScript. L'enregistrement Source, le stage et le commit restent trois actions explicites et séparées.

NO ACL BYPASS.
NO CONTENT OR COMMIT MESSAGE IN ARGV.
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
