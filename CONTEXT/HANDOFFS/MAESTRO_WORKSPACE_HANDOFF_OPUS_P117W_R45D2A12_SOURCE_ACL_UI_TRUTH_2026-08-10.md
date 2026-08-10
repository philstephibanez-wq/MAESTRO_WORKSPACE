# HANDOFF — OPUS P117W R45D2A12 SOURCE ACL UI TRUTH

Date : 2026-08-10

## Base canonique

`philstephibanez-wq/OPUS` master : `76b25c1b2bace4598f3535101a46283fa52684f5` (`test`).

Ce commit ne modifie que `sites/essai2/config/site.json` (`site_name`), après R45D2A11 publié sous `509904785c8d9d4b2e6deed7314e1e690c0ee211`.

## États acquis owner

- `essai2/steve` : connexion réussie après reset local-password R45D2A11.
- Profiler intégré/repliable : acquis.
- message login I18n : acquis.
- reset credential administrateur : acquis.

## Défaut courant

OWASYS Sources/Git affiche un bandeau « lecture seule » alors que l'identité admin + développeur possède `source/write` et peut effectivement enregistrer.

## Cause exacte

`SourceController` construit :

```text
roleCanWrite = ACL(source/write)
editable = selectedPresent && roleCanWrite
read_only = !editable
```

L'état `read_only` mélange donc l'absence de sélection et le refus ACL. Au premier rendu sans sélection, le bandeau est produit ; le navigateur charge ensuite le fichier via AJAX et active l'éditeur depuis la capacité ACL, sans retirer le bandeau statique.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a12_source_acl_ui_truth.zip
SHA-256 : 98dc1db93358d5d3b6e6d9c2fda564898a9bb8979109dc4d3d1a9e9298b04be3
BASE    : 76b25c1b2bace4598f3535101a46283fa52684f5
FILES   : 2
```

Correction : `read_only` dépend uniquement de `!$roleCanWrite`.

## Gate immédiat

```text
php tools/r45d2a12_apply_source_acl_ui_truth.php
php tools/smoke_r45d2a12_source_acl_ui_truth.php
php -l sites/owasys-front/application/source/controllers/SourceController.php
composer dump-autoload -o
composer opus:dev-server -- owasys-front
```

Validation UI : compte admin + développeur => aucun faux bandeau lecture seule, édition/enregistrement toujours autorisés. Une identité sans `source/write` doit rester réellement lecture seule et le backend doit refuser toute écriture.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO ROLE MERGE.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
