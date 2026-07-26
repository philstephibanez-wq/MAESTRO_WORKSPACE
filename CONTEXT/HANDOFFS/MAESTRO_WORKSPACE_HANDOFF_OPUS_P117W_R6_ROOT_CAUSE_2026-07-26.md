# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R6

Date : 2026-07-26  
État : livrable actif à appliquer et valider côté owner

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial, R3, R4 et R5 appliqués
```

## Cause

`OpusConsoleApplication::fromRoot()` construit le dispatcher applicatif pour toutes les commandes.

Le dispatcher exécute tous les bootstraps de tous les sites. Une commande framework charge donc simultanément `sites/owasys` et `sites/owasys-back`, puis provoque la redéclaration de `OwasysApplicationSingletonInspector`.

## Corriger

- Ne pas construire le dispatcher pour une commande framework.
- Lire seulement les métadonnées des registres applicatifs.
- Charger uniquement le bootstrap de l’unique provider qui déclare la commande applicative demandée.
- Refuser une commande inconnue ou ambiguë avant charger un bootstrap.

## Livrable

```text
ZIP : opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip
SHA-256 : b9e6fade25160bd5e6fe3fbb3810267b4544cac67b4deff7c6d0a8a1d75c3896
Fichiers : 2
Octets : 5558
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Valider

```text
php -l Opus\Console\OpusConsoleApplication.php
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

## Contrats

Conserver les interfaces homonymes et leurs quatre marqueurs standards. Lire les registres via `File` et `StructuredFileLoader`. Conserver Logger et Profiler contractuels dans les deux applications.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
