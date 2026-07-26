# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R2 SANS TOOLS

Date : 2026-07-26  
État : livrable actif à appliquer

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial appliqué et migré
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement des échanges REST sécurisés entre les deux applications. Ne créer aucune racine partagée et ne partager aucun système de fichiers.

## Livrable actif

```text
ZIP : opus_p117w_r2_owasys_no_tools_two_applications_rest_only.zip
SHA-256 : e956043cbb799497fa51fa4ca40217f7fa9944063de297e0baa32d47a3d69ad4
Fichiers : 14
Octets : 22184
```

Rejeter P117W R1 parce qu’il place des scripts dans `sites/owasys-front/tools` et `sites/owasys-back/tools`.

## Scripts autorisés

Utiliser uniquement :

```text
scripts/audit_opus_component_interfaces.php
scripts/owasys/p117w-r2/*
```

Ne conserver aucun chemin `tools` dans le ZIP, les applications ou les commandes P117W R2.

## Appliquer

```text
scripts/owasys/p117w-r2/MIGRATE_OWASYS_FRONT_P117W_R2.cmd
scripts/owasys/p117w-r2/MIGRATE_OWASYS_BACK_P117W_R2.cmd
scripts/owasys/p117w-r2/smoke_p117w_r2_front.php
scripts/owasys/p117w-r2/smoke_p117w_r2_back.php
scripts/owasys/p117w-r2/CLEANUP_REJECTED_OWASYS_SHARED_P117W_R2.cmd
scripts/audit_opus_component_interfaces.php
```

## Provisionner

```text
scripts/owasys/p117w-r2/PROVISION_OWASYS_DEVELOPMENT_EXCHANGE_P117W_R2.cmd
```

Écrire séparément :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne faire lire à aucune application le fichier de l’autre.

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

## Contrôler

Valider les deux smokes, supprimer `sites/owasys-shared`, reconstruire l’autoload, exécuter l’audit des interfaces, lancer le back, lancer le front, tester REST vers Composer, puis contrôler Logger, Profiler et `trace_id`.
