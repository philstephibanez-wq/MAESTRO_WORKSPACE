# OPUS P117W R45B5B — REST catalog repair

Date: 2026-08-07

## Base exacte

OPUS master owner publié: `de705d2dbfde8b4da69c7af046acd78453ecde31` (`opus_p117w_r45b5_generated_runtime_error_stage_all`).

## Incident

R45B5 est déjà committé/poussé mais non acquis fonctionnellement. OWASYS échoue au bootstrap avec `OPUS_REST_API_RESOURCE_DEFINITION_INVALID`.

Cause racine: les catalogues R45B5 utilisent l'identifiant d'opération invalide `git.stage_all`, alors que `RestResourceCatalog` impose `^[a-z][a-z0-9]*(?:[.-][a-z0-9]+)*$`.

Identifiant contractuel: `git.stage-all`.

Ne jamais élargir la grammaire REST pour accepter `_`.

## Périmètre R45B5B

Correction exclusive de:

- `sites/owasys-front/config/rest.resources.json`
- `sites/owasys-back/config/backend.resources.json`
- `sites/owasys-back/config/backend.rest.json`
- `sites/owasys-back/config/backend.operations.json`

Le runtime, `try`, SCORE, FSM, ACL et Profiler ne sont pas patchés.

## Gates obligatoires

Avant écriture, le correctif doit:

1. exiger le HEAD exact `de705d2dbfde8b4da69c7af046acd78453ecde31`;
2. refuser des cibles déjà modifiées;
3. remplacer uniquement `git.stage_all` par `git.stage-all` dans la route Stage all et l'opération Composer correspondante;
4. instancier réellement `RestResourceCatalog` pour les catalogues front, backend externe et backend inline;
5. résoudre `PUT /api/v1/applications/try/git/index` vers `git.stage-all`;
6. résoudre `PUT /api/v1/applications/try/git/index/config/site.json` vers `git.stage`;
7. vérifier identité des trois catalogues et de leurs fingerprints;
8. n'écrire qu'après succès de tous les contrôles.

## Livrable

ZIP: `opus_p117w_r45b5b_rest_catalog_repair.zip`
SHA-256: `dbc98775a7ed11c50b0b41df17d020eb6de3df8373bd1890ea956bed43a4695d`

Script: `apply_opus_p117w_r45b5b.php`
SHA-256: `9b0fd9e779f8d91c76432995ebdd93fbe9a30e4f128d00cfa1075571cf99099a`

Smoke owner séparé: `smoke_opus_p117w_r45b5b_rest_catalog_repair_owner.php`
SHA-256: `de3d4fcb95f8bc658f4e7f601bdacf3e17e6fbad31debbdc47a31524906aa8c9`

Attendus: `OPUS_P117W_R45B5B_APPLIED`, `FILES=4`, `OPUS_P117W_R45B5B_SMOKE_OK`.

R45B5B doit produire quatre fichiers modifiés à committer/pusher par l'owner après validation fonctionnelle OWASYS.
