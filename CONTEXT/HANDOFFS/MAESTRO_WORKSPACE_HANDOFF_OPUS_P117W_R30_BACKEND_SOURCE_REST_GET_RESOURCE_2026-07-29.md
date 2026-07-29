# HANDOFF — OPUS P117W R30

Date : 2026-07-29

R30 complète R29 : le fichier source est maintenant une ressource GET sur les
deux frontières HTTP.

```text
OWASYS UI :
GET /<locale>/source/<chemin>

OWASYS backend :
GET /api/v1/applications/{site_id}/sources/{chemin>
```

Le GET backend est signé sans corps. L'identité déléguée est incluse dans la
signature HMAC. La ressource déclarative est résolue vers `source.read`, puis
traverse la FSM, l'ACL, Logger, Profiler et Composer allow-listé.

Les autres commandes conservent :

```text
POST /api/v1/executions
```

Base OPUS :

```text
8b186cbaa0938cd4c89666eac46bf9f4221ba71a
```

Livrable :

```text
opus_p117w_r30_backend_source_rest_get_resource.zip
47eec3cd2806f91a56230f0684ef5cdde8584d8b652921b0538eb85f16a14b24
6 fichiers
```

Commandes de lancement contractuelles :

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```
