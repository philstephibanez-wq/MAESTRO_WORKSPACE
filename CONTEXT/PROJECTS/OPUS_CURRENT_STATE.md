# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-26.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
```

Considérer HF10A et HF10B comme rejetés. Considérer P117W comme le différentiel actif à installer et valider.

## Architecture OWASYS canonique

```text
sites/owasys-front
sites/owasys-back
sites/owasys-shared
```

### Frontend

```text
Singleton : OwasysFrontApplication
Interface : OwasysFrontApplicationInterface
Racine : sites/owasys-front
```

Appliquer :

- Singleton autonome ;
- FSM frontend ;
- I18n avec locale initiale depuis le navigateur ;
- ACL deny-by-default ;
- SSO/Auth0-proxy/bastion ;
- rendu SCORE uniquement ;
- client REST sécurisé ;
- Logger et Profiler ;
- aucune mutation métier locale ;
- aucune exécution Composer locale.

### Backend

```text
Singleton : OwasysBackApplication
Interface : OwasysBackApplicationInterface
Racine : sites/owasys-back
```

Appliquer :

- Singleton autonome ;
- FSM métier et FSM REST ;
- I18n API ;
- ACL deny-by-default ;
- SSO/identité de service/bastion ;
- API REST sécurisée ;
- Composer allow-listé ;
- Logger et Profiler ;
- aucun rendu UI.

### Shared

```text
Racine : sites/owasys-shared
```

Conserver uniquement les contrats, schémas, valeurs non secrètes, manifestes de compatibilité, migration et smoke. Ne placer aucun Singleton, bootstrap, serveur, secret ou état runtime dans cette racine.

## Bastions distincts

Permettre l'installation de `owasys-front` et `owasys-back` sur deux bastions distincts. Ne partager aucun fichier runtime entre les deux installations.

Propager :

```text
trace_id
request_id
actor_subject
execution_id
```

Ne journaliser aucun secret.

## Serveur de développement OPUS

Ajouter :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Exiger les trois arguments. Ne fournir aucune adresse ni aucun port fixe. Réserver la commande au développement local.

Lancer le backend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Lancer ensuite le frontend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Résoudre le backend au moyen de :

```text
runtime/development/servers.json
```

Conserver les secrets locaux dans :

```text
runtime/development/owasys-rcp-secrets.json
```

Ignorer `runtime/development` dans Git. Ne pas utiliser ce mécanisme en production.

## Classes framework

Ajouter :

```text
Opus\Console\Development\DevelopmentServerRegistry
Opus\Console\Development\DevelopmentServerRegistryInterface
```

Faire implémenter directement l'interface homonyme par la classe. Faire étendre directement l'interface par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Conserver ce contrat pour toutes les classes framework modifiées.

## Configuration

Lire toute configuration via `File` et `StructuredFileLoader`, puis sélectionner `Json`, `Xml` ou `Yaml`.

Faire utiliser au frontend :

```text
OPUS_RCP_REST_CLIENT_CONFIG_V2
endpoint_env = OPUS_OWASYS_BACKEND_ENDPOINT
```

Ne coder aucune adresse backend dans `rcp.json`.

## Livrable actif

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Fichiers : 60
Octets : 69297
```

Livrer le ZIP comme différentiel direct superposable à `H:/OPUS`, sans répertoire enveloppe, installateur, payload, patch, staging, rapport, journal ou copie complète du dépôt.

## Validations exécutées

```text
Relire tous les fichiers PHP                         : OK
Analyser les 36 fichiers JSON                        : OK
Réouvrir et contrôler le ZIP                         : OK
Valider les deux Singletons                          : OK
Valider les interfaces et quatre marqueurs           : OK
Valider le registre de développement                 : OK
Valider le client RCP V2 par endpoint_env            : OK
Exécuter le smoke P117W                              : OK
Détecter les entrées interdites dans le ZIP           : 0
```

Marqueur :

```text
P117W_OWASYS_DUAL_APPLICATIONS_SMOKE_OK
```

## Installer et valider

1. vérifier le HEAD et l'état Git ;
2. vérifier le SHA-256 ;
3. extraire le ZIP ;
4. exécuter `MIGRATE_OWASYS_P117W.cmd` ;
5. reconstruire l'autoload Composer ;
6. exécuter le smoke et l'audit contractuel ;
7. lancer le backend ;
8. lancer le frontend ;
9. tester REST vers Composer ;
10. contrôler Logger, Profiler et `trace_id` ;
11. exécuter le gate P117M avant commit owner ;
12. ne nettoyer les anciens chemins qu'après acceptation complète.

## Préserver

```text
sites/owasys
sites/owasys_old
sites/owasys/var
sites/owasys/application/shared
sites/owasys/application/front
sites/owasys/application/back
```
