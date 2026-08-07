# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-07

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B4_PROFILER_ENVIRONMENT_CONFIG_2026-08-07.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5_GENERATED_RUNTIME_ERROR_STAGE_ALL_2026-08-07.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B5B_REST_CATALOG_REPAIR_2026-08-07.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B5B_REST_CATALOG_REPAIR_2026-08-07.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` owner publié : `de705d2dbfde8b4da69c7af046acd78453ecde31` (`opus_p117w_r45b5_generated_runtime_error_stage_all`).

R45B5 est publié mais NON acquis fonctionnellement.

R45B5A est abandonné : son script exigeait le HEAD pré-R45B5 `2376a4de07e4f504aeac1be1d8a183d43c34df80`; sur le HEAD réel `de705...` il a retourné `R45B5A_BASE_HEAD_MISMATCH` avant toute écriture. Aucun fichier OPUS n'a donc été modifié par R45B5A.

## Incident bloquant

OWASYS affiche au bootstrap :

```text
OPUS_REST_API_RESOURCE_DEFINITION_INVALID
```

Cause prouvée au HEAD `de705...` :

```text
git.stage_all
```

est utilisé comme identifiant d'opération REST dans les catalogues. `RestResourceCatalog` interdit `_`; l'identifiant contractuel est :

```text
git.stage-all
```

Ne pas élargir la grammaire REST.

## Livrable actif — R45B5B

```text
ZIP     : opus_p117w_r45b5b_rest_catalog_repair.zip
SHA-256 : dbc98775a7ed11c50b0b41df17d020eb6de3df8373bd1890ea956bed43a4695d
SCRIPT  : apply_opus_p117w_r45b5b.php
SHA-256 : 9b0fd9e779f8d91c76432995ebdd93fbe9a30e4f128d00cfa1075571cf99099a
BASE    : de705d2dbfde8b4da69c7af046acd78453ecde31
FILES   : 4
OUTPUT  : OPUS_P117W_R45B5B_APPLIED
```

Smoke séparé :

```text
FILE    : smoke_opus_p117w_r45b5b_rest_catalog_repair_owner.php
SHA-256 : de3d4fcb95f8bc658f4e7f601bdacf3e17e6fbad31debbdc47a31524906aa8c9
OUTPUT  : OPUS_P117W_R45B5B_SMOKE_OK
```

R45B5B corrige uniquement :

```text
sites/owasys-front/config/rest.resources.json
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-back/config/backend.operations.json
```

Le script refuse un HEAD différent ou des cibles déjà modifiées, construit les candidats en mémoire, instancie réellement `RestResourceCatalog`, résout Stage all et Stage individuel, vérifie l'identité/fingerprint des catalogues, puis écrit seulement si tout est valide.

## Gate owner immédiat

Après application et smoke, `git status --short` doit montrer quatre JSON modifiés. Relancer d'abord owasys-back puis owasys-front. Si l'interface revient sans erreur REST, tester Stage all, puis `try`.

Commit/push OPUS uniquement par l'owner après succès.

## Suite après acquisition

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO CROSS-SITE STAGE.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS PAR L’ASSISTANT.
