# Spécification P117H — frontière OWASYS, Mermaid et ODBCExplorer

## 1. Objet

Cette spécification fixe :

- la frontière entre le framework OPUS et l’application OWASYS ;
- l’implantation du Registry OWASYS ;
- le contrat d’interaction Mermaid ;
- la séparation entre moteur ODBC générique et application ODBCExplorer.

## 2. Sens des dépendances

```text
sites/owasys -> Opus
sites/odbcexplorer -> Opus
```

Sont interdits :

```text
Opus/Owasys/
namespace Opus\Owasys
```

Une classe est framework uniquement si elle est réutilisable sans connaître un identifiant de site, une route applicative, un template applicatif, un libellé applicatif ou un stockage propre à une application.

## 3. Registry OWASYS

### 3.1 Implantation

```text
sites/owasys/application/registry/
  controllers/RegistryController.php
  models/RegistryModel.php
  repositories/RegistryRepository.php
  templates/index.score
```

### 3.2 Responsabilités

`OwasysRegistryRepository` assure exclusivement :

- synchronisation du seed contrôlé ;
- découverte des sites OPUS ;
- stockage SQLite du Registry ;
- stockage du contexte applicatif courant ;
- journalisation des événements de Registry.

### 3.3 Stockage runtime

```text
sites/owasys/var/registry/owasys.sqlite
```

Ce chemin n’est pas modifié par P117H. Aucune migration destructive n’est autorisée.

### 3.4 Contrats de sites découverts

Le Registry reconnaît explicitement :

```text
OPUS_SITE_APPLICATION_TREE_V2
OPUS_SITE_APPLICATION_TREE_V1_ETERNAL
```

Tout autre contrat est ignoré comme non compatible. Un JSON invalide produit une erreur explicite.

### 3.5 Chargement

Le front controller charge le Repository avant le Model :

```text
RegistryRepository.php
RegistryModel.php
RegistryController.php
```

Le Repository applicatif n’est pas ajouté à l’autoload PSR-4 `Opus\`.

## 4. FSM, ACL et SSO

Le Registry ne choisit jamais directement un état cible.

```text
POST select-app
  -> RegistryController
  -> événement select_app
  -> garde ACL
  -> transition FSM
  -> action set_current_app
  -> session + Registry SQLite
```

La sélection, l’effacement du contexte et le démarrage de création restent des actions déclarées dans la FSM.

Toute route privée reste soumise à SSO et à ACL `deny-by-default`.

## 5. Mermaid

### 5.1 Source

Le schéma est dérivé de la FSM canonique et de la navigation filtrée par ACL.

Aucune seconde liste de nœuds ou de routes n’est autorisée.

### 5.2 Arêtes

Les transitions affichées portent :

```json
"visual": true
```

Une transition générique peut utiliser `visual_from` uniquement pour sa projection.

Le builder produit des arêtes orientées Mermaid et impose un style de lien visible :

```text
linkStyle default stroke:#6ce3ff,stroke-width:2px
```

Le CSS impose également une couleur visible aux marqueurs SVG de pointe de flèche.

### 5.3 Navigation

Après rendu, chaque entrée de la table de routes ACL doit correspondre à un nœud SVG.

Chaque nœud :

- reçoit `role="link"` ;
- reçoit `tabindex="0"` ;
- expose son état et sa route en attributs de données ;
- navigue au clic ;
- navigue avec Entrée ;
- navigue avec Espace.

Si une route autorisée ne peut pas être liée, le panneau passe à l’état `error`. Il ne doit pas déclarer un rendu `ready` partiel.

### 5.4 Cache

Les assets d’intégration Mermaid utilisent un identifiant de version P117H pour forcer le rechargement après remplacement.

## 6. Assets framework

Le responder d’assets framework reste limité à deux bundles :

```text
mermaid/opus-mermaid.js
codemirror/opus-codemirror.js
```

Aucun accès générique à `Opus/Assets/dist` n’est autorisé.

## 7. ODBCExplorer

### 7.1 Moteur framework

Peuvent rester dans le framework :

- contrats de source ODBC ;
- inspection de schéma ;
- commandes CRUD structurées ;
- exécution préparée ;
- capacités drivers ;
- dry-run ;
- intégration Model/LSTSAR générique.

Ces classes peuvent vivre sous :

```text
Opus/Database/Odbc
Opus/OdbcExplorer
```

à condition de rester totalement indépendantes d’une interface applicative.

### 7.2 Application autonome

L’interface doit cibler :

```text
sites/odbcexplorer/
  application/default/
  application/<module>/
  config/site.json
  config/application.fsm.json
  config/acl.json
  config/sso.json
  var/
  www/index.php
```

Elle doit utiliser FSM, ACL, SSO et SCORE comme OWASYS.

### 7.3 Package historique

`packages/opus-odbc-manager` peut servir de source de migration. Il ne doit pas rester la frontière runtime de l’application ODBCExplorer.

## 8. Packaging

Le ZIP P117H contient uniquement sept fichiers runtime.

Sont exclus :

- documentation ;
- smokes ;
- manifestes ;
- scripts racine ;
- fichiers `Opus/Owasys` ;
- modification de la base SQLite runtime.

## 9. Critères d’acceptation

- aucune référence runtime à `Opus\Owasys` ;
- Registry opérationnel avec la base existante ;
- FSM, ACL et SSO inchangés ;
- pointes de flèches visibles ;
- tous les nœuds autorisés cliquables et accessibles au clavier ;
- aucun fichier `Opus/Owasys` recréé ;
- `Opus/OdbcExplorer` conservé uniquement pour le moteur générique ;
- application ODBCExplorer future située sous `sites/odbcexplorer`.
