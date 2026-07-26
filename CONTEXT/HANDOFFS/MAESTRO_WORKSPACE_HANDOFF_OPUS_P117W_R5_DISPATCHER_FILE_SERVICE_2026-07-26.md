# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R5

Date : 2026-07-26  
État : livrable actif à appliquer et valider côté owner

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial, R3 et R4 appliqués
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne créer aucun partage de fichiers, aucune racine `owasys-shared`, aucun `tools` et aucun répertoire opérationnel `scripts/owasys`.

## Erreur owner après R4

```text
Call to a member function exists() on string
Opus/Console/Application/ApplicationCommandDispatcher.php:60
```

Le registre frontend est maintenant correct. Le dispatcher échoue avant exécuter `opus:validate-site` ou `opus:dev-server`.

## Correction framework générique

Remplacer le handle local `$file` et le handle local du loader par des propriétés typées :

```text
FileInterface $fileService
StructuredFileLoaderInterface $structuredFileLoader
```

Utiliser ces propriétés pour rechercher, lire et valider les registres Composer applicatifs.

Conserver l’interface homonyme `ApplicationCommandDispatcherInterface` et ses quatre marqueurs standards.

## Livrable actif

```text
ZIP : opus_p117w_r5_fix_application_command_dispatcher_file_service.zip
SHA-256 : d3c5783314f8b3f48eb54bbd02f2a6e5cb534e4d64fcac0525dc0e34996cbdf7
Fichiers : 2
Octets : 1907
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
sites/owasys-front/config/composer.commands.json
```

Ne livrer aucun répertoire opérationnel, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune troisième racine.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r5_fix_application_command_dispatcher_file_service.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r5_fix_application_command_dispatcher_file_service.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver la commande au développement.

## Valider avant livraison

```text
PHP lint                                         : OK
JSON frontend                                    : OK
Dispatcher sur deux registres isolés             : OK
Chemins tools/scripts/owasys/owasys-shared       : 0
ZIP direct                                       : OK
```

Ne pas confondre la simulation isolée avec la validation runtime Windows owner.

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

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
