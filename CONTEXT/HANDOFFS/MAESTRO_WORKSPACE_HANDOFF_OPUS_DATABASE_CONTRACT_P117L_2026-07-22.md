# Handoff OPUS — namespace Database et contrats RefBook P117L

**Date :** 2026-07-22  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Tête relue :** `f64c57fb79ad196ee1ac04086e3c0b28c1d54e37` (`p117j`)

## Demande

Corriger deux défauts du jalon ODBC précédent :

1. OPUS contient simultanément `Opus/Database` et le domaine historique `Opus/Db` ;
2. les classes ODBC modernes ne respectent pas le contrat OPUS par classe requis pour la génération RefBook.

## Décision canonique

Le domaine conservé est exclusivement :

```text
Opus/Database
namespace Opus\Database
```

Le domaine suivant est legacy et doit être supprimé après contrôle des références :

```text
Opus/Db
OPUS_BDD_*
OPUS_adodb5
```

Aucun alias, `class_alias`, bridge PSR-4 ou autoload de compatibilité n’est admis.

Cette décision reprend la normalisation historique ASAP ayant remplacé l’abréviation française `BDD` par le domaine anglais `Database`, sans fallback ni namespace parallèle.

## Diagnostic du domaine legacy

`Opus/Db` contient encore une fabrique globale `OPUS_BDD_Database`, un adaptateur direct MySQLi et l’ancien composant ADOdb.

Cette couche est incompatible avec les règles actuelles :

- frontière officielle ODBC ;
- namespaces PSR-4 modernes ;
- absence de pile de base concurrente ;
- exceptions techniques sans rendu HTML ;
- documentation RefBook normalisée ;
- aucun maintien d’un vocabulaire `BDD` ou `Db` parallèle à `Database`.

Le code MySQL historique construit directement les requêtes et même une table HTML d’erreur. Il ne doit pas être déplacé sous `Database` : il doit disparaître après vérification qu’aucune référence runtime externe ne subsiste.

## Contrat OPUS obligatoire

Le standard OPUS P7A1C impose à chaque classe concrète du framework :

```text
<Class>.php
<Class>Interface.php
class <Class> implements <Class>Interface
```

L’interface homonyme doit étendre :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Ce dernier marqueur rend la classe éligible à l’audit et à la génération RefBook couvrant classe, méthodes, paramètres, retours, propriétés importantes et exceptions.

Les interfaces fonctionnelles spécialisées restent conservées. L’interface contractuelle de la classe les étend lorsque nécessaire.

Exemples P117L :

```text
NativeOdbcConnectionInterface
  extends OdbcConnectionInterface
  extends OdbcPreparedConnectionInterface
  extends les quatre marqueurs OPUS

OdbcNativeMutationExecutorInterface
  extends OdbcMutationExecutorInterface
  extends les quatre marqueurs OPUS
```

## Correctif préparé

Archive :

```text
opus_p117l_database_namespace_contract.zip
```

SHA-256 :

```text
54aab8447f20ff96b8c66006e4645a266044652281e11025844c0727440eb684
```

Le ZIP contient 34 fichiers PHP et couvre 16 classes concrètes :

```text
Opus\Database\Odbc
Opus\Database\Odbc\NativeOdbcConnection
Opus\Database\Odbc\OdbcColumn
Opus\Database\Odbc\OdbcDataSourceConfig
Opus\Database\Odbc\OdbcDataSourceRegistry
Opus\Database\Odbc\OdbcTableInspector
Opus\Model\Adapter\OdbcModelAdapter
Opus\Database\Odbc\Mutation\OdbcMutationAction
Opus\Database\Odbc\Mutation\OdbcMutationCapabilities
Opus\Database\Odbc\Mutation\OdbcMutationCommand
Opus\Database\Odbc\Mutation\OdbcMutationPredicate
Opus\Database\Odbc\Mutation\OdbcMutationResult
Opus\Database\Odbc\Mutation\OdbcMutationService
Opus\Database\Odbc\Mutation\OdbcMutationSqlBuilder
Opus\Database\Odbc\Mutation\OdbcMutationSqlPlan
Opus\Database\Odbc\Mutation\OdbcNativeMutationExecutor
```

Les interfaces fonctionnelles suivantes restent des frontières spécialisées et ne sont pas remplacées :

```text
OdbcConnectionInterface
OdbcPreparedConnectionInterface
OdbcMutationExecutorInterface
```

## Nettoyage local

Le nettoyage doit suivre cet ordre :

1. extraire P117L ;
2. régénérer Composer ;
3. vérifier les 16 couples classe/interface ;
4. rechercher les références externes à `Opus/Db`, `OPUS_BDD_*` et `OPUS_adodb5` ;
5. supprimer `Opus/Db` uniquement si la recherche est vide ;
6. régénérer Composer et relancer les validations.

Le nettoyage ne doit jamais recréer un adaptateur de compatibilité.

## Validation réalisée

- syntaxe PHP des 34 fichiers ;
- présence de l’interface homonyme pour chaque classe concrète couverte ;
- `implements <Class>Interface` sur chaque classe ;
- présence des quatre marqueurs OPUS dans chaque interface ;
- héritage des interfaces fonctionnelles pour la connexion native et l’exécuteur de mutation ;
- non-régression des mutations préparées, ACL, dry-run et confirmation ;
- absence de `Opus/Db`, Markdown et smoke dans le ZIP.

Résultat :

```text
OPUS_P117L_DATABASE_NAMESPACE_CONTRACT_OK
```

## OWASYS

P117L ne modifie aucun fichier OWASYS.

Les règles actives restent :

- FSM comme source de vérité ;
- ACL deny-by-default ;
- SSO obligatoire ;
- templates SCORE exclusivement ;
- i18n global puis module ;
- aucun HTML mélangé aux classes PHP ;
- Mermaid piloté par la navigation autorisée.

## Suite

Après application et suppression validée de `Opus/Db`, la génération RefBook doit être relancée afin de confirmer que les 16 classes P117L apparaissent dans la cartographie contractuelle et qu’aucune classe concrète moderne du domaine `Database` n’est orpheline d’interface.