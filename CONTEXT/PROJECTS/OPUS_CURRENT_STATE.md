# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-07.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 2376a4de07e4f504aeac1be1d8a183d43c34df80
Dernier acquis : R45B4 Profiler configurable par environnement
Livrable actif : R45B5A correction identifiant opération REST Stage all
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module Profiler historique du scaffold, remplacé par R45B4.
- R45B2A4 : alignement historique `profiler:view`, remplacé par R45B4.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e`.
- E3A : workspace Git générique/backend, publié à `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.
- E3B : interface Git frontend, publiée à `7b390b662573b1e71bd8d770bbcad3d3b386325b`.
- R45B3 : contrat client REST/catalogues croisés, publié à `6be07a76e20dfeea09b51c7c016083da626bf974`.
- R45B4 : Profiler configurable par environnement, publié à `2376a4de07e4f504aeac1be1d8a183d43c34df80`.

R45B4 reste la dernière base acquise.

R46 `dev-server --site=` reste abandonné.

## Contrat dev-server

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## R45B5 — état NON acquis

R45B5 a été appliqué localement pour :

- corriger le statut Profiler invalide `failed` du chemin d'erreur `GeneratedSiteRuntime` en `error` ;
- ajouter le Stage all générique borné au site courant.

Mais R45B5 contient une régression bloquante REST et ne doit pas être committé seul.

Symptôme réel après application :

```text
OPUS_REST_API_RESOURCE_DEFINITION_INVALID
```

au bootstrap OWASYS-front.

## Cause racine R45B5

R45B5 a déclaré l'identifiant REST :

```text
git.stage_all
```

`RestResourceCatalog` impose :

```text
^[a-z][a-z0-9]*(?:[.-][a-z0-9]+)*$
```

Le `_` est interdit. Le bon identifiant est :

```text
git.stage-all
```

La grammaire REST ne doit pas être élargie pour accepter le mauvais identifiant.

## Livrable actif — R45B5A

```text
ZIP     : opus_p117w_r45b5a_rest_operation_identifier_fix.zip
SHA-256 : 9612f091296cbbcd9f5295f0d77113f40222924531c6787c1d4eda68e6920dfd
SCRIPT  : apply_opus_p117w_r45b5a.php
SHA-256 : 36b7e8715b0c72934007e1bf3cdf3d2f303eef904bb075c9c63f0f425881b71c
OUTPUT  : OPUS_P117W_R45B5A_APPLIED
FILES   : 4
```

Smoke owner séparé :

```text
smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php
SHA-256 : 059755a7267b7379aceccc4bd3987e397a827fd9c7a3f7a1c87925ea757e0a19
OUTPUT  : OPUS_P117W_R45B5A_SMOKE_OK
```

R45B5A répare uniquement les quatre catalogues/configurations qui portent l'identifiant d'opération REST :

```text
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-front/config/rest.resources.json
```

Le script valide réellement `RestResourceCatalog` avant écriture et contrôle :

- la route collectionnelle `PUT /api/v1/applications/{site_id}/git/index` -> `git.stage-all` ;
- la route individuelle `PUT /api/v1/applications/{site_id}/git/index/{*path}` -> `git.stage` ;
- l'identité des catalogues front, backend externe et backend inline.

## Point de contrôle sur l'ancien smoke R45B5

L'ancien smoke R45B5 instancie `RestResourceCatalog` mais attend ensuite explicitement `git.stage_all`. Après R45B5A il devient obsolète et ne doit plus être exécuté. R45B5A fournit son propre smoke avec l'identifiant contractuel corrigé.

## Validation owner attendue

1. HEAD Git toujours `2376a4de07e4f504aeac1be1d8a183d43c34df80` ;
2. modifications locales R45B5 présentes et non committées ;
3. appliquer R45B5A ;
4. `OPUS_P117W_R45B5A_APPLIED` + `FILES=4` ;
5. `composer validate` ;
6. smoke R45B5A -> `OPUS_P117W_R45B5A_SMOKE_OK` ;
7. relancer `owasys-back`, puis `owasys-front` ;
8. confirmer retour de l'interface OWASYS ;
9. tester Stage all réel ;
10. tester `try` sur `/fr-FR/` ;
11. tester une route absente et confirmer une erreur OPUS propre, pas un crash PHP ;
12. commit/push owner du lot R45B5 + R45B5A seulement après succès.

## Suite gouvernée

Après acquisition R45B5 + R45B5A :

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO LOCAL TRY FIX.
NO REST REGEX WIDENING.
NO CROSS-SITE STAGE.
NO FREE GIT PATH OR COMMAND.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO REST CATALOG DRIFT.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
