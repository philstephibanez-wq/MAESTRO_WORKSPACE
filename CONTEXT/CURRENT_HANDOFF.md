# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R31_STANDARD_OPUS_REST_API_COMPOSER_EXCHANGE_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R32_LOCALE_PRESERVATION_AND_FAST_COMPOSER_DISPATCH_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R32_LOCALE_PRESERVATION_AND_FAST_COMPOSER_DISPATCH_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base relue : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
R29 : présent sur master
R30 : invalidé, ne pas appliquer
R31 : API REST OPUS standard, à appliquer
R32 : correctif cumulatif après R31, livrable actif
```

## Contrat actif

```text
owasys-front
-> API REST OPUS sécurisée fondée sur des ressources
-> owasys-back
-> script Composer métier allow-listé
-> provider métier
-> résultat structuré
-> réponse HTTP
-> owasys-front
```

Interdire `/api/v1/executions` et les abstractions `Rcp*` dans la chaîne active. Appliquer GET, POST, PUT, PATCH et DELETE selon le CRUD.

R32 conserve la ressource Source pendant un changement de locale et supprime le redémarrage coûteux de `composer.phar` à chaque échange. Le script Composer reste résolu et exécuté par les composants OPUS contractuels dans le processus backend.

## Livrable actif

```text
ZIP : opus_p117w_r32_locale_preservation_and_fast_composer_dispatch.zip
Base : R31
SHA-256 : dba5139b5defcf3e03d8090c466eee27b7b1fbf4728441d7b3bf85d41fa0df15
Fichiers : 8
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
