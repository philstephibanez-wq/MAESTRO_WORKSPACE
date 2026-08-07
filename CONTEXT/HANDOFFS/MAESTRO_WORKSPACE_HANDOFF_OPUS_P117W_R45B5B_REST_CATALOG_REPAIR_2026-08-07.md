# HANDOFF — OPUS P117W R45B5B REST catalog repair

Date: 2026-08-07

## Base

OPUS master owner publié: `de705d2dbfde8b4da69c7af046acd78453ecde31`.

R45B5 est déjà committé/poussé mais reste non acquis fonctionnellement.

## Incident bloquant

OWASYS échoue au bootstrap avec `OPUS_REST_API_RESOURCE_DEFINITION_INVALID`.

Cause prouvée dans le HEAD publié: `git.stage_all` est présent dans les catalogues REST et opérations Composer. `RestResourceCatalog` interdit `_` dans l'identifiant d'opération.

Correction: `git.stage-all`.

R45B5A est abandonné: il exigeait à tort le HEAD pré-R45B5 `2376a4de...` et n'a rien écrit sur le dépôt owner au HEAD `de705...`.

## Livrable actif

ZIP: `opus_p117w_r45b5b_rest_catalog_repair.zip`
SHA-256: `dbc98775a7ed11c50b0b41df17d020eb6de3df8373bd1890ea956bed43a4695d`

Script: `apply_opus_p117w_r45b5b.php`
SHA-256: `9b0fd9e779f8d91c76432995ebdd93fbe9a30e4f128d00cfa1075571cf99099a`

Smoke séparé: `smoke_opus_p117w_r45b5b_rest_catalog_repair_owner.php`
SHA-256: `de3d4fcb95f8bc658f4e7f601bdacf3e17e6fbad31debbdc47a31524906aa8c9`

## Fichiers corrigés

- `sites/owasys-front/config/rest.resources.json`
- `sites/owasys-back/config/backend.resources.json`
- `sites/owasys-back/config/backend.rest.json`
- `sites/owasys-back/config/backend.operations.json`

## Validation

Attendus après application: `OPUS_P117W_R45B5B_APPLIED` puis `FILES=4`.

Le smoke doit ensuite produire `OPUS_P117W_R45B5B_SMOKE_OK`.

Puis relancer owasys-back et owasys-front. Le premier gate fonctionnel est le retour de l'interface OWASYS sans `OPUS_REST_API_RESOURCE_DEFINITION_INVALID`. Ensuite seulement tester Stage all et `try`.

Après application, `git status --short` doit montrer les quatre JSON ci-dessus modifiés; ils deviennent le correctif owner à committer/pusher si tous les gates passent.

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO PUSH OPUS PAR L'ASSISTANT.
