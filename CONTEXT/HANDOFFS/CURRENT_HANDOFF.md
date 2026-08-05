# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-05

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `2c268e998c7f714c17476050e652d7afb88db9f4`.

R45B2A3 est publié à `a1afd6415c9ddbd80b7944756210f33c36f7253b` et a permis la génération de `test7`.
R45B2A4 est publié à la base courante et corrige la visibilité ACL générique du Profiler.

## Livrable actif

```text
ZIP     : opus_p117w_e1_source_workspace.zip
SHA-256 : b4b4b681ea9e7ca19c06529f9bf59ba8125e31a2aadd7d89927f3c6be71bb657
FILES   : 3
BASE    : 2c268e998c7f714c17476050e652d7afb88db9f4
STATUS  : livré, application, validation et push owner requis
```

Cible : service générique OPUS Sources E1.

Aucun site généré, aucun fichier OWASYS et aucune opération Git ne sont ciblés.
Le smoke owner est fourni séparément du ZIP.

## Suite après acquisition

E2 : intégration OWASYS Sources via REST sécurisé, Composer allow-listé, ACL deny-by-default, ViewModel et SCORE.

E3 : Git contrôlé, séparé de l’enregistrement Source et sans push implicite.

NO ACL BYPASS.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L’ASSISTANT.
