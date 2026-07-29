# OPUS P117W R31 — API REST standard et échange Composer

Date : 2026-07-29  
Statut : prêt à appliquer après validation owner  
Base OPUS : `8b186cbaa0938cd4c89666eac46bf9f4221ba71a`

## Décision

Remplacer R30 invalidé. Exposer une API REST OPUS fondée sur des ressources HTTP. Faire déclencher par OWASYS back les commandes Composer métier allow-listées. Ne conserver aucune route publique `/executions` ni abstraction `Rcp*` dans la chaîne active.

```text
owasys-front -> API REST OPUS sécurisée -> owasys-back -> Composer -> métier
owasys-front <- représentation HTTP <- owasys-back <- résultat Composer
```

## Matrice des ressources

```text
GET    /api/v1/applications
POST   /api/v1/applications
DELETE /api/v1/applications/{site_id}
GET    /api/v1/applications/{site_id}/validation
GET    /api/v1/applications/{site_id}/routes
POST   /api/v1/applications/{site_id}/languages
POST   /api/v1/applications/{site_id}/pages
POST   /api/v1/applications/{site_id}/rubrics
POST   /api/v1/applications/{site_id}/exports
GET    /api/v1/applications/{site_id}/sources
GET    /api/v1/applications/{site_id}/sources/{path}
PUT    /api/v1/session/application/{application_id}
DELETE /api/v1/session/application
PATCH  /api/v1/security/admin-password
```

## Contrat HTTP

- Interdire tout corps sur GET.
- Identifier toute ressource dans l’URI.
- Retourner `201 Created` et `Location` pour créer une application.
- Retourner `405 Method Not Allowed` et `Allow` pour une ressource connue.
- Produire `ETag` et traiter `If-None-Match` sur les lectures.
- Conserver l’idempotence sémantique de GET, PUT et DELETE.
- Signer par HMAC la méthode, l’URI, l’acteur délégué et le corps.
- Conserver bearer, nonce, anti-rejeu, ACL deny-by-default, FSM, Logger et Profiler.

## Frontière Composer

Ne pas exposer les noms de commandes Composer dans l’API. Résoudre chaque ressource déclarative vers une opération allow-listée côté OWASYS back seulement. Lire les configurations via `StructuredFileLoader`.

## Suppressions requises

Après extraction de R31, supprimer l’ancien namespace `Opus/Rcp`, `sites/owasys-front/config/rcp.json` et les surfaces backend/shared historiques du frontend. Ne pas conserver deux transports concurrents.

## Livrable

```text
ZIP : opus_p117w_r31_standard_opus_rest_api_composer_exchange.zip
SHA-256 : 946dc23df594080eeddce1e175bebb0b3c8b7da564f2d28ab745ff010f467d90
Fichiers : 32
```
