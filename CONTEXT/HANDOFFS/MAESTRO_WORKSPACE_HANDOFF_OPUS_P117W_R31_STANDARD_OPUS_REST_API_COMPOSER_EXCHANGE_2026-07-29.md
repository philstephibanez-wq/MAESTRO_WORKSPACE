# HANDOFF — OPUS P117W R31

Date : 2026-07-29

R30 est invalidé et ne doit pas être appliquer. R31 fournir une API REST OPUS standard, puis faire traduire les ressources en commandes Composer métier dans OWASYS back.

## Source

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
Base : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
État : R29
```

## Flux

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer -> métier
owasys-front <- réponse HTTP <- owasys-back <- résultat Composer
```

Supprimer `/api/v1/executions`. Utiliser les ressources `applications`, `sources`, `session/application` et `security/admin-password` avec GET, POST, PUT, PATCH et DELETE selon leur sémantique.

Conserver `405 + Allow`, `201 + Location`, ETag, HMAC, acteur délégué signé, nonce, anti-rejeu, FSM, ACL, Logger et Profiler.

## Livrable

```text
opus_p117w_r31_standard_opus_rest_api_composer_exchange.zip
946dc23df594080eeddce1e175bebb0b3c8b7da564f2d28ab745ff010f467d90
32 fichiers
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```
