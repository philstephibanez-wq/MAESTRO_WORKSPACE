# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R2_NO_TOOLS_TWO_APPLICATIONS_REST_ONLY_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R2_NO_TOOLS_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial extrait et migré
```

## Conserver deux applications

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute racine `owasys-shared` et tout partage de fichiers entre les deux bastions.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Interdire tools

Ne créer, livrer ou conserver aucun répertoire nommé `tools` dans OPUS, OWASYS ou le différentiel P117W.

Utiliser la racine canonique :

```text
scripts/
```

## Statut

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r2_owasys_no_tools_two_applications_rest_only.zip
SHA-256 : 10c209e06fad85c83e7081276f36454ebddf8b53f098288974d53b93e35a8b9c
Fichiers : 14
Octets : 22213
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Ne contenir aucun chemin ou référence `tools` et aucune entrée `sites/owasys-shared`.

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

Créer deux environnements locaux distincts, sans lecture croisée :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

## Lancer

Backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver la commande au développement.

## Contrats

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier côté front ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
