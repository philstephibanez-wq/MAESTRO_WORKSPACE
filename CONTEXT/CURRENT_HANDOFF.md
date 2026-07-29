# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R31_STANDARD_OPUS_REST_API_COMPOSER_EXCHANGE_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R31_STANDARD_OPUS_REST_API_COMPOSER_EXCHANGE_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
Racine owner : H:\OPUS
P117W R29 : présent sur master
R30 : invalidé, ne pas appliquer
R31 : livrable actif
```

## Contrat actif

```text
owasys-front
-> API REST OPUS sécurisée fondée sur des ressources
-> owasys-back
-> commande Composer métier allow-listée
-> résultat structuré
-> réponse HTTP
-> owasys-front
```

Interdire `/api/v1/executions` et les abstractions `Rcp*` dans la chaîne active. Appliquer les méthodes GET, POST, PUT, PATCH et DELETE selon le CRUD.

## Livrable actif

```text
ZIP : opus_p117w_r31_standard_opus_rest_api_composer_exchange.zip
Base : OPUS master 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
SHA-256 : 946dc23df594080eeddce1e175bebb0b3c8b7da564f2d28ab745ff010f467d90
Fichiers : 32
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
