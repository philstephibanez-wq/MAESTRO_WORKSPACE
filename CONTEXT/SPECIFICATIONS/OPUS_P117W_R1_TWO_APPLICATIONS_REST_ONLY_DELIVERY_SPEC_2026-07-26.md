# OPUS P117W R1 — DEUX APPLICATIONS AUTONOMES, ÉCHANGES REST UNIQUEMENT

Date : 2026-07-26  
État : ZIP différentiel produit ; application et validation owner requises

## 1. Lecture obligatoire

Lire et appliquer `README-FIRST.md` avant toute intervention.

Appliquer notamment :

- relire les dépôts et contrats ;
- maintenir deux Singletons OPUS autonomes ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler ;
- livrer un ZIP différentiel direct ;
- lire les configurations via `File` et `StructuredFileLoader`.

## 2. Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
État local owner : P117W initial extrait et migration exécutée
Racine : H:\OPUS
```

Appliquer P117W R1 au-dessus de cet état local. Ne pas appliquer P117W R1 à un dépôt n'ayant pas reçu le différentiel P117W initial.

## 3. Architecture finale

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer :

```text
sites/owasys-shared
```

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact entre les deux applications.

Réaliser uniquement les échanges suivants :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## 4. Applications autonomes

### Front

Maintenir :

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, Logger, Profiler et client REST sécurisé.

Interdire toute mutation métier et toute exécution Composer locale.

### Back

Maintenir :

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Appliquer Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, Logger, Profiler, API REST sécurisée et Composer allow-listé.

Interdire tout rendu UI.

## 5. Développement local sans racine commune

Conserver la commande générique :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Remplacer le registre commun `runtime/development` par deux fichiers locaux indépendants :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Utiliser un outil de provisionnement de développement afin d'écrire séparément les paramètres correspondant au canal REST dans chaque application. Ne faire lire à aucune application le fichier local de l'autre application.

Réserver ce mécanisme au développement. Injecter séparément en production les endpoints, certificats, identités et secrets sur chaque bastion.

## 6. Configurations

Retirer de `site.json` et des manifestes :

```text
shared_contract
shared_contract_version
source = sites/owasys-shared/...
```

Déclarer localement dans chaque application :

```text
exchange.contract = OWASYS_REST_EXCHANGE_V1
exchange.transport = rest
exchange.peer_application_id
a cross_application_filesystem_access = false
```

Lire les environnements de développement locaux via `File` et `StructuredFileLoader` sous le contrat :

```text
OPUS_DEVELOPMENT_ENVIRONMENT_V1
```

## 7. Observabilité distribuée

Conserver la propagation RCP V2 :

```text
trace_id
execution_id
actor
operation
```

Faire transmettre `X-Opus-Trace-Id` par le client REST. Faire vérifier le même identifiant par le serveur REST. Faire transmettre le `trace_id` à la requête Composer.

Conserver les diagnostics localement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler
```

## 8. Migrations et validations autonomes

Fournir :

```text
sites/owasys-front/tools/cmd/MIGRATE_OWASYS_FRONT_P117W_R1.cmd
sites/owasys-back/tools/cmd/MIGRATE_OWASYS_BACK_P117W_R1.cmd
sites/owasys-front/tools/smoke/smoke_p117w_r1_front.php
sites/owasys-back/tools/smoke/smoke_p117w_r1_back.php
```

Faire vérifier par les smokes :

- les deux Singletons ;
- les contrats FSM, ACL et SSO ;
- SCORE uniquement côté front ;
- aucune API ou commande Composer côté front ;
- aucun renderer ou template UI côté back ;
- aucun `echo` UI ;
- aucun mélange HTML/PHP ;
- aucune référence à `owasys-shared` ;
- aucun accès de système de fichiers entre les deux applications.

## 9. Audit framework

Remplacer la commande invalide vers `tools/maintenance/opus_contractualize_all.php` par :

```text
php scripts/audit_opus_component_interfaces.php
```

Faire vérifier pour chaque classe concrète sous `Opus/**/*.php` :

- l'existence de l'interface homonyme ;
- l'implémentation directe de cette interface ;
- l'extension directe des quatre marqueurs standards par cette interface.

## 10. Nettoyage

Fournir :

```text
sites/owasys-front/tools/cmd/CLEANUP_REJECTED_OWASYS_SHARED_P117W_R1.cmd
```

Faire exécuter les deux smokes avant toute suppression.

Supprimer ensuite :

```text
sites/owasys-shared
runtime/development
Opus/Console/Development/DevelopmentServerRegistry.php
Opus/Console/Development/DevelopmentServerRegistryInterface.php
```

Ne supprimer aucun chemin historique `sites/owasys` ou `sites/owasys_old` dans cette livraison.

## 11. Livrable

```text
ZIP : opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip
SHA-256 : 922009ecc3632cf70e0dca6d4f79d81916391aebdf8f7409f8a6103ed6cd9e5e
Fichiers : 14
Octets : 23211
```

Livrer directement à la racine `H:\OPUS`, sans répertoire enveloppe, installateur, payload, patch, staging, rapport, journal ou copie complète du dépôt.

Ne contenir aucune entrée `sites/owasys-shared` dans le ZIP.

## 12. Validations exécutées

```text
Lire et appliquer README-FIRST.md                         : OK
Analyser la syntaxe PHP des fichiers livrés               : OK
Analyser les configurations JSON livrées                  : OK
Réouvrir et contrôler le ZIP                              : OK
Compter les fichiers complets                             : 14
Détecter une entrée sites/owasys-shared                   : 0
Détecter payload/patch/staging/report/log                  : 0
Exécuter le smoke front en environnement simulé           : OK
Exécuter le smoke back en environnement simulé            : OK
Provisionner deux environnements locaux distincts         : OK
Vérifier la correspondance endpoint/token/HMAC            : OK
Tester le script d'audit sur un composant synthétique      : OK
```

## 13. Séquence owner

1. vérifier l'empreinte du ZIP ;
2. extraire P117W R1 dans `H:\OPUS` ;
3. exécuter les deux migrations ;
4. reconstruire l'autoload ;
5. exécuter les deux smokes ;
6. supprimer la racine rejetée avec le CMD fourni ;
7. reconstruire l'autoload après suppression ;
8. exécuter l'audit des interfaces OPUS ;
9. provisionner le canal REST de développement ;
10. lancer le backend ;
11. lancer le frontend ;
12. tester REST vers Composer ;
13. contrôler Logger, Profiler et `trace_id` ;
14. exécuter le gate P117M ;
15. committer et pousser après acceptation owner.
