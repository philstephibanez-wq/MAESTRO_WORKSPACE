# OPUS P117W — LIVRAISON DES DEUX APPLICATIONS AUTONOMES ET DU SERVEUR DE DÉVELOPPEMENT

Date : 2026-07-26  
État : installer et valider côté owner

## 1. Source de vérité

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
```

## 2. Architecture

Considérer OWASYS comme un système distribué composé de deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
sites/owasys-shared
```

### `owasys-front`

- posséder son propre Singleton `OwasysFrontApplication` ;
- appliquer FSM, I18n, ACL deny-by-default et SSO/Auth0-proxy/bastion ;
- détecter la locale initiale depuis le navigateur ;
- produire l'interface exclusivement via SCORE ;
- interdire toute mutation métier locale ;
- transmettre toute opération métier à `owasys-back` par REST sécurisé ;
- journaliser et profiler localement.

### `owasys-back`

- posséder son propre Singleton `OwasysBackApplication` ;
- appliquer FSM, I18n, ACL deny-by-default et SSO/identité de service/bastion ;
- exposer uniquement l'API REST sécurisée ;
- exécuter les opérations Composer allow-listées ;
- interdire tout rendu UI ;
- journaliser et profiler localement.

### `owasys-shared`

Ne contenir aucun Singleton, bootstrap, serveur, secret, journal, Profiler ou état runtime. Contenir uniquement les contrats, schémas, valeurs communes non secrètes, manifestes de compatibilité et outils de migration/validation.

## 3. Commande générique de développement

Ajouter au framework OPUS :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Exiger les trois arguments suivants :

```text
application-id
--host
--port
```

Ne fournir aucune valeur réseau fixe. Réserver cette commande au développement local. Conserver `opus:serve-site` uniquement pour compatibilité historique.

### OWASYS local

Lancer d'abord le backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Lancer ensuite le frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Résoudre dynamiquement l'endpoint backend depuis le registre runtime de développement :

```text
runtime/development/servers.json
```

Créer ou réutiliser les secrets de développement sous :

```text
runtime/development/owasys-rcp-secrets.json
```

Ignorer intégralement `runtime/development` dans Git.

Ne jamais utiliser cette commande ni ce registre en production. Définir les listeners, endpoints, certificats et reverse proxies de production par l'infrastructure de chaque bastion.

## 4. Corrélation distribuée

Propager le même `trace_id` du frontend vers le backend, puis vers la FSM REST et Composer.

Séparer les diagnostics :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/runtime
sites/owasys-front/var/profiler/dev-server

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/runtime
sites/owasys-back/var/profiler/rcp
sites/owasys-back/var/profiler/dev-server
```

Ne journaliser ni token, ni secret HMAC, ni mot de passe, ni ligne de commande sensible.

## 5. Contrat des classes framework

Ajouter la classe framework :

```text
Opus\Console\Development\DevelopmentServerRegistry
```

Implémenter directement :

```text
DevelopmentServerRegistryInterface
```

Faire étendre directement cette interface par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Conserver les mêmes quatre marqueurs sur toutes les interfaces homonymes des classes framework modifiées.

## 6. Configuration

Lire tous les fichiers de configuration via `File` et `StructuredFileLoader`, puis sélectionner `Json`, `Xml` ou `Yaml` selon le format.

Utiliser pour le client REST frontend :

```text
OPUS_RCP_REST_CLIENT_CONFIG_V2
endpoint_env = OPUS_OWASYS_BACKEND_ENDPOINT
```

Ne coder aucune adresse ni aucun port backend dans la configuration frontend.

## 7. Migration

Fournir :

```text
sites/owasys-shared/tools/cmd/MIGRATE_OWASYS_P117W.cmd
```

Exécuter les actions suivantes :

1. copier les composants UI historiques dans `sites/owasys-front` ;
2. retirer de la nouvelle cible frontend les composants backend ;
3. copier les providers, repositories et composants métier dans `sites/owasys-back` ;
4. préserver les données runtime utiles ;
5. valider les chemins indispensables ;
6. ne supprimer aucun chemin historique.

Préserver jusqu'à acceptation runtime :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```

## 8. Livrable

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
BASE : 4fb3a92605f14d84b8060ff36fde78828da49273
FICHIERS : 60
OCTETS : 69297
```

Livrer un ZIP différentiel direct superposable à `H:\OPUS`, sans répertoire enveloppe, installateur, payload, patch, staging, rapport, journal ou copie complète du dépôt.

## 9. Validations exécutées

```text
Relire le ZIP après création                         : OK
Analyser la syntaxe de tous les fichiers PHP         : OK
Analyser les 36 fichiers JSON                        : OK
Valider les deux racines application/default         : OK
Valider les deux Singletons et leurs interfaces      : OK
Valider les quatre marqueurs de chaque interface     : OK
Valider le registre générique de développement       : OK
Valider la configuration RCP V2 par endpoint_env     : OK
Exécuter le smoke P117W                              : OK
Détecter les entrées interdites dans le ZIP           : 0
```

Marqueur smoke :

```text
P117W_OWASYS_DUAL_APPLICATIONS_SMOKE_OK
```

## 10. Séquence owner

1. vérifier le HEAD et l'état Git ;
2. vérifier l'empreinte du ZIP ;
3. extraire le ZIP directement dans `H:\OPUS` ;
4. exécuter le CMD de migration ;
5. reconstruire l'autoload Composer ;
6. analyser la syntaxe et les contrats ;
7. exécuter le smoke P117W ;
8. lancer `owasys-back` ;
9. lancer `owasys-front` ;
10. tester le frontend et le flux REST vers Composer ;
11. contrôler Logger et Profiler des deux applications ;
12. ne nettoyer les anciens chemins qu'après acceptation complète.
