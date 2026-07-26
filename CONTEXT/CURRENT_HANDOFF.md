# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R6_LAZY_APPLICATION_PROVIDER_BOOTSTRAP_ROOT_CAUSE_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R6_ROOT_CAUSE_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial, R3, R4 et R5 appliqués
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

Ne partager aucun fichier entre les deux applications. Ne livrer aucun `tools`, aucun `scripts/owasys` et aucune racine `owasys-shared`.

## Cause

`OpusConsoleApplication::fromRoot()` construit le dispatcher applicatif pour toutes les commandes.

Le dispatcher exécute tous les bootstraps de tous les sites. Une commande framework charge donc simultanément l’ancien `sites/owasys` et `sites/owasys-back`, puis provoque la redéclaration de `OwasysApplicationSingletonInspector`.

## Corriger

- Ne pas construire le dispatcher pour une commande framework.
- Lire seulement les métadonnées des registres applicatifs.
- Charger uniquement le bootstrap de l’unique provider qui déclare la commande applicative demandée.
- Refuser une commande inconnue ou ambiguë avant charger un bootstrap.

## Statut

```text
P117W R3 : appliqué
P117W R4 : appliqué
P117W R5 : appliqué, effet corrigé mais cause restante
P117W R6 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip
SHA-256 : b9e6fade25160bd5e6fe3fbb3810267b4544cac67b4deff7c6d0a8a1d75c3896
Fichiers : 2
Octets : 5558
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial, R3, R4 et R5 appliqués
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Application/ApplicationCommandDispatcher.php
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r6_lazy_application_provider_bootstrap_root_cause.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\OpusConsoleApplication.php
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

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
