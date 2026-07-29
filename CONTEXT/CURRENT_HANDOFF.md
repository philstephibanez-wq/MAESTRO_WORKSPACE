# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R30_BACKEND_SOURCE_REST_GET_RESOURCE_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R30_BACKEND_SOURCE_REST_GET_RESOURCE_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
Racine owner : H:\OPUS
P117W R29 : présent sur master
```

## R30

La lecture Source traverse désormais une ressource REST GET complète :

```text
owasys-front
-> GET /api/v1/applications/{site_id}/sources/{path}
-> authentification bearer + signature HMAC
-> FSM + ACL + Logger + Profiler
-> source.read allow-listé
-> Composer
-> OPUS SiteSourceInspector
```

R29 reste responsable de l'URL GET visible côté interface :

```text
/<locale>/source/<chemin-relatif-encodé-par-segment>
```

## Livrable actif

```text
ZIP : opus_p117w_r30_backend_source_rest_get_resource.zip
Base : OPUS master 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
SHA-256 : 47eec3cd2806f91a56230f0684ef5cdde8584d8b652921b0538eb85f16a14b24
Fichiers : 6
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
