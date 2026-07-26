# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R5_APPLICATION_COMMAND_DISPATCHER_TYPED_FILE_SERVICE_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R5_DISPATCHER_FILE_SERVICE_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial, R3 et R4 appliqués
```

## Conserver deux applications propres

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute notion de racine partagée et tout partage de fichiers entre les deux bastions.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Interdire la pollution du produit

Ne livrer aucun :

```text
tools
scripts/owasys
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Ne placer aucune migration, aucun smoke, aucun audit, aucun rapport et aucun provisionnement dans le produit livré.

## Erreur owner après P117W R4

```text
Call to a member function exists() on string
Opus/Console/Application/ApplicationCommandDispatcher.php:60
```

Le registre frontend R4 est correct. Le blocage concerne le handle local utilisé par `ApplicationCommandDispatcher` pour appeler `File::exists()`.

## Corriger génériquement OPUS

Remplacer les handles locaux par des propriétés typées :

```text
FileInterface $fileService
StructuredFileLoaderInterface $structuredFileLoader
```

Utiliser ces propriétés pour rechercher, lire et valider les registres Composer applicatifs.

## Statut

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : appliqué
P117W R4 : appliqué, registre frontend corrigé
P117W R5 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r5_fix_application_command_dispatcher_file_service.zip
SHA-256 : d3c5783314f8b3f48eb54bbd02f2a6e5cb534e4d64fcac0525dc0e34996cbdf7
Fichiers : 2
Octets : 1907
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial, R3 et R4 appliqués
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
sites/owasys-front/config/composer.commands.json
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r5_fix_application_command_dispatcher_file_service.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r5_fix_application_command_dispatcher_file_service.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer en développement

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

## Contrats permanents

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier et toute exécution Composer applicative locale côté front ;
- faire passer toute mutation par REST sécurisé puis Composer côté back ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
