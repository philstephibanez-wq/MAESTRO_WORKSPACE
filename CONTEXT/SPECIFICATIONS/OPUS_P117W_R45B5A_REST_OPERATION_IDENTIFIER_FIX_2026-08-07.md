# OPUS P117W R45B5A — REST operation identifier fix

Date : 2026-08-07

## Base

OPUS owner publié : `2376a4de07e4f504aeac1be1d8a183d43c34df80` (`opus_p117w_r45b4_profiler_environment_config`).

R45B5 a été appliqué localement sur cette base mais n'est pas acquis : le démarrage OWASYS échoue avec `OPUS_REST_API_RESOURCE_DEFINITION_INVALID`.

## Cause racine

R45B5 a ajouté l'identifiant d'opération REST `git.stage_all`.

`Opus\Api\Rest\RestResourceCatalog` impose le motif :

```text
^[a-z][a-z0-9]*(?:[.-][a-z0-9]+)*$
```

Le caractère `_` est donc interdit dans un identifiant d'opération REST. Le catalogue est rejeté au bootstrap avant toute requête.

L'identifiant canonique est :

```text
git.stage-all
```

Les noms internes UI/FSM `stage_all`, les clés I18n `git.stage_all` et le contrat `OPUS_SITE_GIT_STAGE_ALL_V1` ne sont pas des identifiants d'opération REST et restent inchangés.

## Cible du correctif

R45B5A modifie uniquement les quatre fichiers de configuration concernés :

```text
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-front/config/rest.resources.json
```

Transformations :

```text
operation key : git.stage_all -> git.stage-all
route operation : git.stage_all -> git.stage-all
```

La ressource reste :

```text
PUT /api/v1/applications/{site_id}/git/index
```

Le script Composer reste :

```text
owasys:git-stage-all
```

Le provider reste :

```text
owasys:git:stage-all
```

## Validation obligatoire

Le correctif ne se contente pas de comparer les tableaux JSON. Avant écriture, il instancie réellement `RestResourceCatalog` sur les trois catalogues REST, résout la route collectionnelle Stage all et contrôle que la route individuelle `git.stage` reste résolue.

Le smoke R45B5A répète ces contrôles sur le dépôt après application et exige le même fingerprint REST côté front, backend externe et backend inline.

## Livrable

```text
ZIP     : opus_p117w_r45b5a_rest_operation_identifier_fix.zip
SHA-256 : 9612f091296cbbcd9f5295f0d77113f40222924531c6787c1d4eda68e6920dfd
SCRIPT  : apply_opus_p117w_r45b5a.php
SHA-256 : 36b7e8715b0c72934007e1bf3cdf3d2f303eef904bb075c9c63f0f425881b71c
FILES   : 4 cibles
```

Smoke owner séparé :

```text
smoke_opus_p117w_r45b5a_rest_operation_identifier_fix_owner.php
SHA-256 : 059755a7267b7379aceccc4bd3987e397a827fd9c7a3f7a1c87925ea757e0a19
OUTPUT  : OPUS_P117W_R45B5A_SMOKE_OK
```

## Règles

- ne pas restaurer R45B5 fichier par fichier ;
- ne pas élargir la regex REST pour accepter `_` ;
- ne pas corriger `try` localement ;
- ne pas modifier SCORE/FSM/I18n pour cette réparation ;
- ne pas exécuter l'ancien smoke R45B5 après R45B5A, car il attend explicitement l'identifiant invalide `git.stage_all` ;
- ne pas commit/push OPUS tant que R45B5A et le test réel OWASYS ne passent pas.
