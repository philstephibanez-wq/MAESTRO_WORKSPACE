# OPUS P117W R45D2A12 — SOURCE ACL UI TRUTH

Date : 2026-08-10
Statut : livrable owner à valider
Base OPUS : `76b25c1b2bace4598f3535101a46283fa52684f5`

## Constat owner

Dans OWASYS Sources et Git, un compte disposant des droits admin + développeur peut effectivement modifier et enregistrer une source, tandis que l'interface affiche simultanément le message I18n :

`Votre rôle dispose d’un accès en lecture seule à cette source.`

La mutation backend réussie confirme que l'ACL `source/write` autorise l'identité. Le message UI est donc faux.

## Cause

Dans `sites/owasys-front/application/source/controllers/SourceController.php` :

- `$roleCanWrite` est la décision ACL réelle `isAllowed(identity, 'source', 'write')` ;
- `$editable = $selectedPresent && $roleCanWrite` mélange capacité ACL et présence d'une sélection ;
- le ViewModel exporte actuellement `read_only => !$editable`.

Ainsi, au chargement initial sans fichier sélectionné, `read_only=true` même pour une identité autorisée en écriture. Le bandeau SCORE est rendu. Ensuite `source-browser.js` charge la sélection en AJAX et active correctement l'éditeur depuis `data-source-editable`, mais ne supprime pas ce bandeau statique.

## Correction contractuelle

`source.read_only` doit représenter exclusivement la décision ACL d'écriture :

```php
'read_only' => !$roleCanWrite,
```

La présence ou l'absence d'une sélection reste portée par les états `source.selected` / `source.empty` / `$editable`, mais ne doit jamais être présentée comme une restriction de rôle.

## Invariants

- backend POST write reste protégé par `assertAllowed(identity, 'source', 'write')` ;
- textarea/éditeur reste piloté par `$roleCanWrite` ;
- ACL deny-by-default inchangée ;
- aucune fusion de rôles ;
- aucun bypass ACL ;
- aucun correctif spécifique à `essai2` ;
- SCORE/I18n inchangés ;
- aucune modification owasys-back ;
- aucun secret.

## Livrable

```text
ZIP     : opus_p117w_r45d2a12_source_acl_ui_truth.zip
SHA-256 : 98dc1db93358d5d3b6e6d9c2fda564898a9bb8979109dc4d3d1a9e9298b04be3
BASE    : 76b25c1b2bace4598f3535101a46283fa52684f5
FILES   : 2
```

Le ZIP contient un applicateur fail-fast et un smoke de cohérence ACL/UI.

## Gate owner

1. appliquer le ZIP ;
2. exécuter l'applicateur ;
3. exécuter le smoke ;
4. lint de `SourceController.php` ;
5. relancer `owasys-front` ;
6. avec l'identité admin + développeur, ouvrir une source : aucun bandeau lecture seule ;
7. modifier puis enregistrer : succès attendu ;
8. tester ensuite une identité réellement sans `source/write` : bandeau lecture seule + écriture refusée.
