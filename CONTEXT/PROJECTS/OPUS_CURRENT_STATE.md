# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-26.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
```

## Architecture OWASYS canonique

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute racine `owasys-shared` de l'architecture finale.

Considérer `owasys-front` et `owasys-back` comme deux applications OPUS autonomes, installables sur deux bastions distincts.

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

## Échanges uniquement

Ne partager aucun :

- fichier ;
- dossier ;
- volume ;
- secret ;
- configuration ;
- état runtime ;
- catalogue ;
- manifeste ;
- artefact applicatif.

Réaliser exclusivement des échanges REST sécurisés entre les deux applications.

Définir les contrats génériques de transport dans OPUS RCP. Conserver les configurations et validateurs localement dans chaque application.

Propager par REST :

```text
api_contract_version
trace_id
request_id
actor_subject
execution_id
```

Refuser toute version incompatible.

## Bastions distincts

Déployer indépendamment :

```text
Bastion FRONT -> owasys-front
Bastion BACK  -> owasys-back
```

Injecter séparément les endpoints, secrets, certificats et politiques réseau.

Interdire tout système de fichiers commun entre les bastions.

## Serveur de développement OPUS

Utiliser :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Lancer le backend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Lancer le frontend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Réserver cette commande au développement local.

## Classes framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Configuration

Lire toute configuration via `File` et `StructuredFileLoader`, puis utiliser `Json`, `Xml` ou `Yaml` selon le format.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, migration OK, smoke OK, architecture rejetée
P117W R1 : correctif requis
```

Rejeter le ZIP initial :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

Motifs :

- créer `sites/owasys-shared` ;
- placer migration et smoke dans cette troisième racine ;
- conserver une notion de partage interdite ;
- référencer `tools/maintenance/opus_contractualize_all.php`, absent du dépôt.

## P117W R1

Produire un ZIP différentiel direct afin de :

1. supprimer toute dépendance à `owasys-shared` ;
2. conserver uniquement les deux applications ;
3. déplacer les composants selon leur responsabilité ;
4. fournir un smoke autonome dans chaque application ;
5. fournir un CMD de migration sans troisième racine ;
6. valider REST sécurisé vers Composer ;
7. valider Logger, Profiler et propagation du `trace_id` ;
8. fournir un CMD de suppression de `sites/owasys-shared` après validation ;
9. exécuter le gate P117M avant commit owner.

## Nettoyage

Ne pas supprimer immédiatement `sites/owasys-shared` avant appliquer P117W R1, car le ZIP initial y a placé des outils encore nécessaires à la migration et au smoke.

Supprimer cette racine après déplacer ces fonctions et valider les deux applications.
