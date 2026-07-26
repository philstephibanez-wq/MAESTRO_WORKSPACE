# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R4

Date : 2026-07-26  
État : livrable actif à appliquer

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial et P117W R3 appliqués
```

## Conserver deux applications propres

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne créer aucune racine partagée et ne partager aucun système de fichiers.

## Corriger le blocage Composer

Cause observée :

```text
OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID:sites/owasys-front/config/composer.commands.json
```

La migration initiale a copié le registre de l'ancien site `owasys` dans la nouvelle racine `owasys-front`.

Remplacer ce registre par un contrat frontend autonome :

```text
contract  = OPUS_APPLICATION_COMMAND_PROVIDER_REGISTRY_V1
site_id   = owasys-front
providers = []
aliases   = []
```

Interdire ainsi toute commande Composer applicative locale côté frontend.

## Livrable actif

```text
ZIP : opus_p117w_r4_fix_front_composer_registry_clean_site.zip
SHA-256 : 421fbd6d39e01e166b798d5bdee313cb24c39ef8761d62b4fc2ae7edb1dcc7d0
Fichiers : 1
Octets : 309
```

Inclure uniquement :

```text
sites/owasys-front/config/composer.commands.json
```

Ne livrer aucun `tools`, aucun répertoire opérationnel `scripts/owasys`, aucune migration, aucun smoke, aucun audit et aucune racine `owasys-shared`.

## Appliquer

Extraire le ZIP directement dans `H:\OPUS`, reconstruire l'autoload, valider les deux sites et lancer les deux serveurs de développement.

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables. Réserver la commande au développement.

## Contrats permanents

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier et toute exécution Composer locale côté front ;
- faire passer toute mutation par REST sécurisé puis Composer côté back ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.