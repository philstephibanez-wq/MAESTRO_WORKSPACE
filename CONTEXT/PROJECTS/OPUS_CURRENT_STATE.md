# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-26.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD Git relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
État local : P117W initial extrait, migration et smoke réussis
```

Lire `README-FIRST.md` avant toute intervention.

## Architecture OWASYS canonique

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute racine `owasys-shared`.

Considérer `owasys-front` et `owasys-back` comme deux applications OPUS autonomes, installables sur deux bastions distincts.

## Échanges uniquement

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact entre les deux applications.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Définir les contrats de transport dans OPUS RCP. Conserver les configurations, validateurs, journaux, Profiler et secrets localement dans chaque application.

## Frontend

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
- Logger et Profiler locaux ;
- aucune mutation métier locale ;
- aucune exécution Composer locale.

## Backend

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
- Logger et Profiler locaux ;
- aucun rendu UI.

## Développement local

Utiliser :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables.

Remplacer le registre commun par :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Faire lire à chaque application uniquement son propre fichier local. Réserver ces fichiers et `opus:dev-server` au développement.

## Classes framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Utiliser :

```text
php scripts/audit_opus_component_interfaces.php
```

## Configuration

Lire toute configuration via `File` et `StructuredFileLoader`, puis utiliser `Json`, `Xml` ou `Yaml` selon le format.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, migration et smoke réussis, architecture rejetée
P117W R1 : livrable actif à appliquer et valider
```

Rejeter :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

## Livrable P117W R1

```text
ZIP : opus_p117w_r1_owasys_two_autonomous_applications_rest_only.zip
SHA-256 : 922009ecc3632cf70e0dca6d4f79d81916391aebdf8f7409f8a6103ed6cd9e5e
Fichiers : 14
Octets : 23211
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Ne contenir aucune entrée `sites/owasys-shared`.

## Contenu P117W R1

- remplacer `SiteCommandService` afin de lire un environnement de développement local à chaque application ;
- retirer `shared_contract` et `shared_contract_version` ;
- déclarer des échanges REST sans accès de système de fichiers croisé ;
- fournir deux migrations autonomes ;
- fournir deux smokes autonomes ;
- fournir un provisionnement local séparé du canal REST ;
- fournir un audit des interfaces OPUS ;
- fournir un CMD de suppression de la troisième racine rejetée ;
- supprimer le registre commun initial et ses classes devenues inutilisées.

## Validations exécutées

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

## Continuer

1. extraire P117W R1 ;
2. exécuter les deux migrations ;
3. reconstruire l'autoload ;
4. exécuter les deux smokes ;
5. supprimer `sites/owasys-shared` avec le CMD fourni ;
6. reconstruire l'autoload ;
7. exécuter l'audit des interfaces ;
8. provisionner le canal REST local ;
9. lancer le backend ;
10. lancer le frontend ;
11. tester REST vers Composer ;
12. contrôler Logger, Profiler et propagation du `trace_id` ;
13. exécuter le gate P117M ;
14. committer et pousser après acceptation owner.

## Préserver

Ne pas supprimer avant acceptation runtime complète :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
```
