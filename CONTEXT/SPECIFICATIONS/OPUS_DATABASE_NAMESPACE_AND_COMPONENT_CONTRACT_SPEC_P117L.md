# OPUS — Spécification namespace Database et contrats de composants P117L

## 1. Objet

Définir le domaine de base de données canonique d’OPUS et rendre toutes les classes concrètes ODBC concernées conformes au contrat documentaire standard du framework.

## 2. Domaine canonique

Le domaine unique est :

```text
Path      : Opus/Database
Namespace : Opus\Database
```

Le chemin et le vocabulaire suivants sont interdits dans le runtime cible :

```text
Opus/Db
Opus\Db
OPUS_BDD_*
OPUS_adodb5
```

## 3. Justification

`Database` est le terme anglais explicite déjà retenu par la normalisation ASAP.

`Db` est :

- une abréviation concurrente ;
- un ancien domaine global non PSR-4 ;
- associé à des classes `OPUS_BDD_*` ;
- associé à une pile MySQLi directe ;
- incompatible avec la frontière ODBC officielle.

La coexistence `Database` + `Db` crée deux domaines officiels supposés pour une même responsabilité. Elle est interdite.

## 4. Suppression, pas migration

Le contenu historique de `Opus/Db` ne doit pas être renommé vers `Opus/Database`.

Il doit être supprimé parce qu’il contient notamment :

- une fabrique globale dépendante d’un paramètre `adapter` ;
- un adaptateur MySQLi direct ;
- de l’assemblage SQL historique ;
- un rendu HTML d’erreur dans la couche base ;
- un ancien composant ADOdb.

La couche moderne `Opus\Database\Odbc` remplace la responsabilité, pas le code legacy.

## 5. Frontière de base officielle

La façade publique reste :

```php
Opus\Database\Odbc
```

Les composants spécialisés restent sous :

```text
Opus/Database/Odbc/
namespace Opus\Database\Odbc
```

Pipeline officiel :

```text
ODBC driver / DSN
  -> Opus\Database\Odbc
  -> OdbcConnectionInterface
  -> OdbcModelAdapter
  -> TableModel / ModelRecord
  -> LSTSAR
```

Aucune nouvelle classe ne doit dépendre de MySQLi, PDO MySQL, PostgreSQL natif ou SQLite natif comme frontière OPUS.

## 6. Contrat par classe concrète

Toute classe concrète OPUS doit posséder une interface contractuelle homonyme dans le même namespace et le même répertoire logique.

Exemple :

```text
Opus/Database/Odbc.php
Opus/Database/OdbcInterface.php
```

```php
final class Odbc implements OdbcInterface
```

La règle s’applique aussi aux composants internes publics du framework et aux adaptateurs Model.

## 7. Interface standard

Toute interface contractuelle homonyme étend obligatoirement :

```php
Opus\Framework\OpusFrameworkComponentInterface
Opus\Framework\OpusExceptionAwareInterface
Opus\Framework\OpusProfilerAwareInterface
Opus\Framework\OpusSelfDocumentingInterface
```

Modèle :

```php
interface ComponentInterface extends
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

Le contrat reste marker-level conformément au standard P7A1C. Il n’impose pas une duplication mécanique de toutes les signatures publiques dans l’interface.

## 8. Interfaces fonctionnelles

Les interfaces fonctionnelles ne sont pas supprimées :

```text
OdbcConnectionInterface
OdbcPreparedConnectionInterface
OdbcMutationExecutorInterface
```

Lorsqu’une classe concrète implémente une frontière fonctionnelle, son interface homonyme étend cette frontière en plus des quatre marqueurs OPUS.

### Connexion native

```php
interface NativeOdbcConnectionInterface extends
    OdbcConnectionInterface,
    OdbcPreparedConnectionInterface,
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

```php
final class NativeOdbcConnection
    implements NativeOdbcConnectionInterface
```

### Exécuteur de mutation

```php
interface OdbcNativeMutationExecutorInterface extends
    OdbcMutationExecutorInterface,
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

## 9. Classes couvertes par P117L

### Façade

```text
Opus\Database\Odbc
```

### Domaine ODBC

```text
NativeOdbcConnection
OdbcColumn
OdbcDataSourceConfig
OdbcDataSourceRegistry
OdbcTableInspector
```

### Adaptateur Model

```text
Opus\Model\Adapter\OdbcModelAdapter
```

### Mutations

```text
OdbcMutationAction
OdbcMutationCapabilities
OdbcMutationCommand
OdbcMutationPredicate
OdbcMutationResult
OdbcMutationService
OdbcMutationSqlBuilder
OdbcMutationSqlPlan
OdbcNativeMutationExecutor
```

Total : 16 classes concrètes et 16 interfaces homonymes.

## 10. Nommage des interfaces

Le nom suit strictement :

```text
<ClassName>Interface
```

Sont interdits :

```text
DatabaseContract
OdbcContract
DocumentedOdbc
OdbcManagerInterface
LegacyDatabaseInterface
```

Une interface contractuelle par classe est exigée afin que le tokenizer et RefBook puissent construire une cartographie déterministe.

## 11. Documentation RefBook

`OpusSelfDocumentingInterface` marque la classe comme couverte par l’audit documentaire.

La documentation générée ou auditée doit décrire :

- rôle de la classe ;
- responsabilités ;
- méthodes publiques ;
- paramètres ;
- valeurs de retour ;
- propriétés importantes ;
- exceptions ;
- contrats de sécurité ;
- dépendances fonctionnelles.

La seule présence d’une constante `CONTRACT` ne remplace pas cette interface.

## 12. Exceptions et profiler

Les deux marqueurs suivants sont obligatoires même lorsque le composant ne possède pas encore une méthode explicite dédiée :

```text
OpusExceptionAwareInterface
OpusProfilerAwareInterface
```

Ils déclarent l’appartenance de la classe au contrat transverse OPUS et permettent à l’audit RefBook d’identifier les obligations futures sans injection mécanique dangereuse.

## 13. Règle de création future

Avant l’ajout d’une nouvelle classe concrète sous `Opus/Database` ou `Opus/Model/Adapter` :

1. définir son rôle ;
2. créer son interface homonyme ;
3. étendre les quatre marqueurs ;
4. étendre les interfaces fonctionnelles nécessaires ;
5. faire implémenter cette interface par la classe ;
6. documenter classe, méthodes et erreurs ;
7. valider la cartographie RefBook.

Une classe concrète sans interface homonyme ne doit pas être fusionnée.

## 14. Contrôle de `Opus/Db`

La suppression doit être précédée d’une recherche excluant le répertoire lui-même :

```text
OPUS_BDD_
OPUS_adodb5
Opus\Db
Opus/Db
```

Si une référence externe existe, la suppression est bloquée et cette référence doit être migrée vers la frontière ODBC moderne. Aucun alias temporaire ne doit être ajouté.

## 15. Composer

Le mapping reste :

```json
{
  "Opus\\": "Opus/"
}
```

Aucun mapping particulier pour `Opus\Db` ne doit exister.

Après suppression de `Opus/Db` :

```text
composer dump-autoload
```

est obligatoire afin d’éliminer les entrées classmap historiques.

## 16. Non-régressions ODBC

P117L ne change pas les comportements fonctionnels P117J :

- construction de la façade ;
- registre des sources ;
- connexion préparée ;
- adaptation Model ;
- preview bornée ;
- draft LSTSAR ;
- commandes de mutation structurées ;
- ACL obligatoire ;
- dry-run ;
- confirmation ;
- acteur ;
- paramètres préparés.

P117L ajoute le contrat de composant, sans créer une deuxième API.

## 17. OWASYS

Aucun fichier OWASYS n’est modifié par P117L.

Les contraintes restent :

```text
FSM + ACL + SSO
SCORE exclusivement
I18N global puis module
aucun echo de rendu applicatif
aucune vue PHP mélangeant HTML et PHP
```

## 18. Critères de validation

P117L est valide lorsque :

1. `Opus/Database` est le domaine canonique déclaré ;
2. le ZIP ne contient aucun chemin `Opus/Db` ;
3. les 16 classes concrètes possèdent leur interface homonyme ;
4. les 16 classes implémentent cette interface ;
5. chaque interface contient les quatre marqueurs OPUS ;
6. les interfaces fonctionnelles sont conservées ;
7. la connexion native expose encore les deux frontières fonctionnelles ;
8. l’exécuteur natif expose encore son interface fonctionnelle ;
9. tous les fichiers PHP passent `php -l` ;
10. les tests de mutation P117J restent valides ;
11. aucune référence externe legacy ne subsiste avant suppression de `Opus/Db` ;
12. Composer est régénéré ;
13. RefBook recense les 16 classes ;
14. aucune alias legacy n’est ajouté.

Résultat de validation attendu :

```text
OPUS_P117L_DATABASE_NAMESPACE_CONTRACT_OK
```