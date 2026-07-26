# OPUS P117W R5 — CORRIGER LE DISPATCHER DES COMMANDES COMPOSER

Date : 2026-07-26  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser uniquement les échanges suivants :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne créer aucun partage de fichiers, aucune racine `owasys-shared`, aucun répertoire `tools` et aucun répertoire opérationnel `scripts/owasys`.

## Constater l’échec R4

Les commandes suivantes échouent avant leur exécution :

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Erreur owner :

```text
Call to a member function exists() on string
Opus/Console/Application/ApplicationCommandDispatcher.php:60
```

Le registre frontend R4 est désormais contractuellement correct. Le nouvel échec concerne le handle local `$file` utilisé par `ApplicationCommandDispatcher` pour appeler `exists()`.

## Corriger génériquement OPUS

Modifier uniquement le composant framework générique :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Remplacer les handles locaux non typés par :

```text
private readonly FileInterface $fileService
private readonly StructuredFileLoaderInterface $structuredFileLoader
```

Initialiser ces propriétés avec :

```text
File::instance()
StructuredFileLoader::instance()
```

Utiliser exclusivement ces propriétés pour :

- rechercher les registres `composer.commands.json` ;
- lire les registres via `StructuredFileLoader` ;
- vérifier les bootstraps via `FileInterface::exists()`.

Conserver l’implémentation directe de `ApplicationCommandDispatcherInterface`, laquelle étend les quatre marqueurs OPUS standards.

## Maintenir le registre frontend

Réappliquer :

```text
sites/owasys-front/config/composer.commands.json
```

Déclarer :

```text
contract  = OPUS_APPLICATION_COMMAND_PROVIDER_REGISTRY_V1
site_id   = owasys-front
providers = []
aliases   = []
```

Interdire ainsi toute commande Composer applicative locale dans le frontend.

## Livrer

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider avant livraison

```text
Analyser la syntaxe PHP                              : OK
Analyser le JSON frontend                            : OK
Instancier le dispatcher sur deux registres isolés   : OK
Détecter tools/scripts/owasys/owasys-shared          : 0
Réouvrir et contrôler le ZIP                         : OK
```

Marqueurs de simulation :

```text
P117W_R5_DISPATCHER_BOOT_OK
P117W_R5_ZIP_CLEAN_OK
```

Ne pas présenter cette simulation isolée comme une validation runtime Windows owner.

## Valider côté owner

Exécuter :

```text
composer dump-autoload -o
php -l Opus/Console/Application/ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
