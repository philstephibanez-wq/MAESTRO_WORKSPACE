# OPUS P117W R30 — SOURCE BACKEND EN RESSOURCE REST GET

Date : 2026-07-29  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
Racine owner : H:\OPUS
Pré-requis : R29 présent sur OPUS/master
```

## Cause traitée

R29 rend le fichier visible dans l'URL GET de `owasys-front`, mais
`OwasysSourceModel::read()` appelle encore l'opération RPC :

```text
POST /api/v1/executions
operation = source.read
```

La ressource n'est donc pas encore modélisée en GET sur la frontière REST
backend.

## Décision owner

OPUS fournit une capacité REST générique déclarative. OWASYS enregistre :

```text
GET /api/v1/applications/{site_id}/sources/{path+}
-> source.read
-> owasys:source-read
-> owasys:source:read
```

Exemple :

```text
GET /api/v1/applications/owasys-back/sources/application/default/bootstrap.php
```

## Contrats

- aucun corps n'est envoyé avec le GET ;
- le chemin complet est encodé segment par segment dans l'URL ;
- l'identité déléguée est transportée dans un en-tête borné et sa valeur est
  incluse dans la signature HMAC ;
- méthode, chemin, timestamp, nonce, corps vide et identité sont liés par la
  signature ;
- nonce, anti-rejeu, ACL deny-by-default, FSM, Logger, Profiler et trace
  restent obligatoires ;
- la route est déclarée dans `backend.rest.json` et résolue génériquement par
  `RcpRestServer` ;
- l'opération issue de la route reste présente dans le catalogue allow-listé ;
- la lecture physique reste exclusivement exécutée par Composer ;
- les POST `/api/v1/executions` existants restent compatibles ;
- aucune lecture filesystem n'est ajoutée au frontend.

Chaîne obligatoire :

```text
owasys-front -> GET REST signé -> owasys-back -> Composer allow-listé -> OPUS
```

## Livrable

```text
ZIP : opus_p117w_r30_backend_source_rest_get_resource.zip
SHA-256 : 47eec3cd2806f91a56230f0684ef5cdde8584d8b652921b0538eb85f16a14b24
Fichiers : 6
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
