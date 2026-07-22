# OPUS — Spécification façade ODBC et frontière ODBCExplorer P117J

## 1. Objet

Définir l’unique frontière ODBC du framework OPUS et supprimer la confusion entre capacité technique et produit d’administration.

```text
Framework : Opus\Database\Odbc
Application : sites/odbcexplorer
```

`Manager` et `Explorer` ne sont pas des noms de façade framework.

## 2. Frontière publique

Le point d’entrée public est :

```php
Opus\Database\Odbc
```

Fichier PSR-4 :

```text
Opus/Database/Odbc.php
```

PHP autorise la coexistence de cette classe et du namespace spécialisé :

```text
Opus/Database/Odbc/
```

## 3. Responsabilité de la façade

La façade :

- construit la connexion depuis une configuration ;
- accepte une connexion injectée ;
- expose la source active ;
- teste la connexion ;
- fournit l’adaptateur Model ;
- construit un `TableModel` ;
- prévisualise des `ModelRecord` avec limite obligatoire ;
- écrit des records validés par Model ;
- prépare un draft LSTSAR model-driven ;
- construit un service de mutations préparées.

La façade ne doit pas :

- contenir de route ;
- contenir de contrôleur ;
- rendre du HTML ;
- charger un template ;
- contenir des libellés ;
- implémenter une parité Adminer/phpMyAdmin ;
- gérer un menu applicatif ;
- décider une ACL ;
- porter le nom Manager ou Explorer.

## 4. Composants techniques

Les composants spécialisés appartiennent à :

```text
Opus/Database/Odbc/
```

Répartition cible :

```text
OdbcDataSourceConfig
OdbcDataSourceRegistry
OdbcConnectionInterface
OdbcPreparedConnectionInterface
NativeOdbcConnection
OdbcColumn
OdbcTableInspector
OdbcReadOnlyConnectionInterface
OdbcReadOnlySqlGuard
OdbcQueryResult
OdbcTable
Mutation/*
```

## 5. Sources de données

Une source est déclarée par `OdbcDataSourceConfig`.

Règles :

- `driver` vaut exclusivement `odbc` ;
- un DSN ou une chaîne `connection_string` est obligatoire ;
- l’identifiant de source est unique dans un registre ;
- le registre accepte un fichier PHP ou JSON ;
- un registre vide est refusé ;
- une source inconnue est refusée ;
- `toArray()` et `describe()` n’exposent jamais le mot de passe.

Formats de registre :

```php
return [
    'sources' => [
        [
            'id' => 'main',
            'driver' => 'odbc',
            'dsn' => 'OPUS_MAIN',
            'username' => '...',
            'password' => '...',
        ],
    ],
];
```

ou JSON équivalent.

## 6. Model

Pipeline officiel :

```text
ODBC
  -> OdbcConnectionInterface
  -> OdbcModelAdapter
  -> TableModel / ModelRecord
```

La façade ne remplace pas `OdbcModelAdapter`. Elle le rend accessible comme composant canonique.

## 7. LSTSAR

Pipeline officiel :

```text
ODBC source
  -> TableModel source
  -> mapping de champs
  -> TableModel cible
  -> draft LSTSAR
  -> dry-run
  -> Store ODBC
```

LSTSAR ne doit pas appeler directement les fonctions PHP `odbc_*` et ne doit pas devenir une seconde couche de connexion.

Le draft expose obligatoirement :

- source ;
- cible ;
- modèles ;
- mapping ;
- garde ACL ;
- dry-run avant Store ;
- règle ODBC-only.

## 8. Mutations

Namespace :

```text
Opus\Database\Odbc\Mutation
```

Actions autorisées :

```text
insert
update
delete
```

Le service n’accepte pas une chaîne SQL brute en entrée. Il reçoit une commande structurée contenant :

- action ;
- table ;
- valeurs ;
- prédicat ;
- acteur ;
- jeton de confirmation.

## 9. Validation des identifiants

Les colonnes utilisent :

```text
^[A-Za-z_][A-Za-z0-9_]*$
```

Une table peut être qualifiée par un maximum de trois segments validés séparément :

```text
table
schema.table
catalog.schema.table
```

Le quoting dépendant du dialecte sera ajouté dans une couche dédiée ultérieure. P117J refuse les identifiants hors contrat au lieu de tenter un quoting implicite.

## 10. Construction SQL

### INSERT

```sql
INSERT INTO table (column_a, column_b) VALUES (?, ?)
```

### UPDATE

```sql
UPDATE table SET column_a = ? WHERE id = ?
```

### DELETE

```sql
DELETE FROM table WHERE id = ?
```

Pour une valeur de prédicat `null` :

```sql
column IS NULL
```

Les valeurs ne sont jamais interpolées dans le SQL.

## 11. Gardes

Avant dry-run :

- ACL accordée ;
- action autorisée par les capacités ;
- commande structurellement valide.

Avant exécution :

- toutes les gardes du dry-run ;
- jeton de confirmation exact ;
- acteur non vide ;
- exécuteur préparé disponible.

UPDATE et DELETE sans prédicat sont refusés avant construction du plan.

## 12. Dry-run

Le dry-run :

- construit le même plan que l’exécution ;
- expose action, table, SQL et nombre de paramètres ;
- n’ouvre pas de connexion ;
- n’appelle pas l’exécuteur ;
- retourne `executed=false` et `affected_rows=0`.

## 13. Exécution préparée

Contrat :

```php
OdbcPreparedConnectionInterface::executePrepared(
    string $sql,
    array $parameters
): int
```

`NativeOdbcConnection` implémente ce contrat avec :

```text
odbc_prepare
odbc_execute
odbc_num_rows
```

Les paramètres acceptés sont `null`, scalaires ou `Stringable`.

## 14. Ancien namespace

Les chemins suivants ne font plus partie de l’architecture cible :

```text
Opus/OdbcExplorer/
packages/opus-odbc-manager/
```

Ils ne doivent pas recevoir de nouvelles classes ni de nouveaux appels.

Après application P117J et contrôle des références, ils sont supprimés localement. Aucun bridge permanent ou `class_alias` n’est admis : cela maintiendrait une seconde API officielle.

## 15. Application ODBCExplorer

La future application appartient à :

```text
sites/odbcexplorer/
```

Elle devra comporter :

```text
application/default
application/datasources
application/schema
application/data
application/query
application/import
application/export
config
var
www/index.php
```

Les modules définitifs seront dérivés de la FSM, et non d’une liste manuelle `site.json.modules`.

Contrats obligatoires :

- application autonome OPUS ;
- FSM source de vérité ;
- ACL deny-by-default ;
- SSO obligatoire ;
- SCORE exclusivement ;
- i18n global + module ;
- 24 langues UE plus ukrainien pour le sélecteur ;
- CodeMirror framework pour la future console SQL ;
- aucune copie de CodeMirror ou Mermaid dans l’application ;
- aucune fonction `odbc_*` appelée depuis l’application ;
- consommation exclusive de `Opus\Database\Odbc`.

P117J ne crée pas cette application : la créer sans FSM, ACL et spécification fonctionnelle complètes produirait un nouveau squelette non conforme.

## 16. OWASYS

P117J ne modifie aucun fichier OWASYS.

Les garanties P117I restent applicables :

- FSM + ACL + SSO ;
- Registry applicatif ;
- Mermaid cliquable ;
- i18n ASAP ;
- directive SCORE ;
- 25 locales ;
- aucun `Opus/Owasys`.

## 17. Critères de validation

1. `Opus\Database\Odbc` est autoloadable ;
2. construction depuis tableau et configuration ;
3. connexion injectée possible ;
4. source décrite sans mot de passe ;
5. accès à `OdbcModelAdapter` ;
6. aperçu limité entre 1 et 1000 ;
7. draft LSTSAR avec mapping non vide ;
8. registre refusant doublons et vide ;
9. SQL structuré avec marqueurs `?` ;
10. NULL transformé en `IS NULL` dans le prédicat ;
11. UPDATE/DELETE sans prédicat refusés ;
12. ACL refusée bloque dry-run et exécution ;
13. confirmation invalide bloque l’exécution ;
14. dry-run n’appelle pas l’exécuteur ;
15. ZIP sans Markdown, smoke, Manager, Explorer ni fichier applicatif OWASYS.
