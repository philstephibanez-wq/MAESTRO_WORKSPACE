# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R1

Date : 2026-07-26  
État : ZIP P117W initial rejeté ; correctif sans shared requis

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine locale : H:\OPUS
```

## Architecture canonique

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute notion de `owasys-shared`.

Faire de `owasys-front` et `owasys-back` deux applications OPUS autonomes, installables sur deux bastions distincts.

## Échanges uniquement

Ne partager aucun fichier, dossier, volume, état runtime, secret, configuration, catalogue, manifeste ou artefact entre les deux applications.

Réaliser exclusivement des échanges REST sécurisés :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Définir les contrats génériques de transport dans OPUS RCP. Conserver les configurations et validateurs localement dans chaque application.

## Front

```text
Singleton : OwasysFrontApplication
Interface : OwasysFrontApplicationInterface
Rôle : SCORE, FSM, I18n navigateur, ACL, SSO, client REST
Journal : sites/owasys-front/var/logs/owasys-front.log
Profiler : sites/owasys-front/var/profiler
```

Interdire toute mutation métier locale et toute exécution Composer locale.

## Back

```text
Singleton : OwasysBackApplication
Interface : OwasysBackApplicationInterface
Rôle : API REST, FSM métier, ACL, SSO/service identity, Composer allow-listé
Journal : sites/owasys-back/var/logs/owasys-back.log
Profiler : sites/owasys-back/var/profiler
```

Interdire tout rendu UI.

## Serveur de développement

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

## ZIP initial rejeté

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

Rejeter ce ZIP, car il crée `sites/owasys-shared` et référence une commande d'audit absente du dépôt.

## Correctif requis

Produire P117W R1 afin de :

1. supprimer toute dépendance à `owasys-shared` ;
2. conserver uniquement les deux applications ;
3. déplacer les composants selon leur responsabilité ;
4. fournir un smoke autonome dans chaque application ;
5. fournir un CMD de migration sans troisième racine ;
6. valider REST sécurisé vers Composer ;
7. valider Logger, Profiler et propagation du `trace_id` ;
8. fournir un CMD de suppression de `sites/owasys-shared` après validation.

## Nettoyage

Ne pas supprimer immédiatement `sites/owasys-shared` avant appliquer P117W R1, car le ZIP initial y a placé des outils encore nécessaires à la migration et au smoke.

Supprimer cette racine après déplacer ces fonctions et valider les deux applications.
