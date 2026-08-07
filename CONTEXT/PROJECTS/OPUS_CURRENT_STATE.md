# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-07.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : de705d2dbfde8b4da69c7af046acd78453ecde31
Dernier acquis : R45B4 Profiler configurable par environnement
R45B5 : publié mais NON acquis fonctionnellement
Livrable actif : R45B5B réparation catalogues REST Stage all
```

## Incident courant

Le commit owner `de705d2dbfde8b4da69c7af046acd78453ecde31` (`opus_p117w_r45b5_generated_runtime_error_stage_all`) contient l'évolution R45B5 mais OWASYS échoue au bootstrap avec :

```text
OPUS_REST_API_RESOURCE_DEFINITION_INVALID
```

Cause prouvée sur GitHub : les catalogues utilisent l'identifiant REST invalide `git.stage_all`.

`RestResourceCatalog` impose `^[a-z][a-z0-9]*(?:[.-][a-z0-9]+)*$`; `_` est interdit. La correction est `git.stage-all`.

R45B5A n'a rien modifié sur le dépôt owner : il exigeait à tort le HEAD R45B4 `2376a4de...` et a arrêté avant écriture avec `R45B5A_BASE_HEAD_MISMATCH:de705...`.

## Livrable actif R45B5B

```text
ZIP     : opus_p117w_r45b5b_rest_catalog_repair.zip
SHA-256 : dbc98775a7ed11c50b0b41df17d020eb6de3df8373bd1890ea956bed43a4695d
SCRIPT  : apply_opus_p117w_r45b5b.php
SHA-256 : 9b0fd9e779f8d91c76432995ebdd93fbe9a30e4f128d00cfa1075571cf99099a
BASE    : de705d2dbfde8b4da69c7af046acd78453ecde31
FILES   : 4
```

Smoke séparé :

```text
smoke_opus_p117w_r45b5b_rest_catalog_repair_owner.php
SHA-256 : de3d4fcb95f8bc658f4e7f601bdacf3e17e6fbad31debbdc47a31524906aa8c9
OUTPUT  : OPUS_P117W_R45B5B_SMOKE_OK
```

Fichiers réparés :

```text
sites/owasys-front/config/rest.resources.json
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-back/config/backend.operations.json
```

Le script R45B5B valide les candidats avec le vrai `RestResourceCatalog` avant toute écriture et contrôle simultanément la route collectionnelle Stage all, la route Stage individuelle, la symétrie front/back et le fingerprint.

## Validation immédiate

1. HEAD `de705d2dbfde8b4da69c7af046acd78453ecde31`.
2. appliquer R45B5B.
3. attendu `OPUS_P117W_R45B5B_APPLIED` + `FILES=4`.
4. smoke -> `OPUS_P117W_R45B5B_SMOKE_OK`.
5. `git status --short` doit montrer quatre JSON modifiés.
6. relancer owasys-back puis owasys-front.
7. confirmer disparition de `OPUS_REST_API_RESOURCE_DEFINITION_INVALID`.
8. tester Stage all.
9. tester `try` seulement après retour d'OWASYS.
10. commit/push owner après tous les gates.

## Suite gouvernée

Après acquisition R45B5/R45B5B : R45C wizard OWASYS structuré, puis R45D administration Sécurité.

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS PAR L’ASSISTANT.
