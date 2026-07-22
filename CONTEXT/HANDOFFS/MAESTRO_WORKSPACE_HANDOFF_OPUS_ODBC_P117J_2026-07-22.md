# Handoff OPUS — façade ODBC P117J

**Date :** 2026-07-22  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Tête relue :** `24a6e7ff7abbce5e13559a0501ec000bc126871a` (`p117i`)

## Demande

Appliquer la décision d’architecture validée après l’étude d’ODBCManager/ODBCExplorer :

- OPUS expose ODBC, et non un produit nommé Manager ou Explorer ;
- `Opus\Database\Odbc` devient la façade publique canonique ;
- les briques techniques restent sous `Opus\Database\Odbc\*` ;
- les anciens domaines `Opus\OdbcExplorer` et `packages/opus-odbc-manager` sont obsolètes ;
- une future interface d’administration sera une application autonome sous `sites/odbcexplorer` ;
- OWASYS ne doit subir aucune régression.

## Diagnostic GitHub

La tête P117I possède déjà :

- `Opus\Database\Odbc\OdbcConnectionInterface` comme frontière d’accès ;
- `NativeOdbcConnection` comme implémentation PHP ODBC ;
- `OdbcDataSourceConfig` pour DSN et chaînes DSN-less ;
- `OdbcModelAdapter` pour la conversion ODBC vers `TableModel` et `ModelRecord`.

Les responsabilités historiques d’administration sont encore dispersées sous `Opus/OdbcExplorer`, avec contrats de produit, lecture, CRUD et parité Adminer/phpMyAdmin. Le package `packages/opus-odbc-manager` n’est plus présent dans la tête relue, mais le namespace framework historique subsiste.

## Correctif P117J préparé

Archive locale :

```text
opus_p117j_odbc_facade_boundary.zip
```

SHA-256 :

```text
7c82599ed3908bd10e7e5cf6a384113e1a6cc2bfc241755ed8ec275df1cd5e45
```

Le ZIP contient uniquement 14 fichiers PHP runtime :

- façade `Opus/Database/Odbc.php` ;
- registre `OdbcDataSourceRegistry` ;
- interface d’exécution préparée ;
- mise à niveau de `NativeOdbcConnection` ;
- couche `Opus\Database\Odbc\Mutation` structurée.

Aucun fichier n’est ajouté sous `Opus/OdbcExplorer`, `packages/opus-odbc-manager` ou `sites/owasys`.

## Façade

`Opus\Database\Odbc` expose :

- construction depuis un tableau, une configuration ou une connexion injectée ;
- test de connexion ;
- accès à la source sans exposer le mot de passe ;
- adaptation Model ;
- génération de `TableModel` ;
- aperçu de `ModelRecord` ;
- écriture de records validés ;
- préparation d’un draft LSTSAR ;
- accès à un service de mutations préparées.

La façade orchestre les composants ; elle ne contient pas toute l’implémentation ODBC.

## Mutations

La nouvelle couche impose :

- actions limitées à insert/update/delete ;
- noms de table et colonnes validés ;
- valeurs passées exclusivement comme paramètres préparés ;
- UPDATE et DELETE avec prédicat obligatoire et non vide ;
- traitement NULL par `IS NULL` ;
- décision ACL obligatoire ;
- capacité explicite du pilote ;
- confirmation obligatoire avant exécution ;
- acteur obligatoire avant exécution ;
- dry-run ne réalisant aucune connexion ni mutation.

Le SQL brut provenant d’une interface n’est jamais accepté par cette API.

## Nettoyage requis

Après extraction et validation du ZIP, supprimer localement :

```text
Opus/OdbcExplorer
packages/opus-odbc-manager
```

Le second chemin peut déjà être absent.

Les anciens documents et smokes P7 ODBC Explorer peuvent également être retirés du dépôt code afin qu’ils ne référencent plus un namespace supprimé. Ils ne sont pas remplacés dans le ZIP runtime.

## Future application

La future interface ne fait pas partie de P117J. Sa cible est :

```text
sites/odbcexplorer/
  application/default/
  application/<module>/
  config/
  var/
  www/index.php
```

Elle devra être pilotée par FSM, ACL et SSO, rendue avec SCORE, utiliser l’i18n canonique et consommer exclusivement `Opus\Database\Odbc`.

Créer une interface partielle avant d’avoir défini sa FSM et son ACL est interdit.

## Validation réalisée hors ZIP

- syntaxe PHP des 14 fichiers ;
- construction SQL INSERT/UPDATE/DELETE ;
- paramètres préparés ;
- prédicat NULL-safe ;
- dry-run sans exécution ;
- exécution avec confirmation ;
- refus ACL ;
- refus d’une confirmation invalide ;
- absence de Markdown, smoke, package Manager et namespace Explorer dans l’archive.

Résultat :

```text
OPUS_P117J_ODBC_FACADE_BOUNDARY_OK
```

## Non-régressions

P117J ne modifie pas :

- OWASYS ;
- FSM, ACL ou SSO ;
- Registry SQLite ;
- Mermaid ;
- SCORE ;
- moteur i18n P117I ;
- listes de locales ;
- assets publics.
