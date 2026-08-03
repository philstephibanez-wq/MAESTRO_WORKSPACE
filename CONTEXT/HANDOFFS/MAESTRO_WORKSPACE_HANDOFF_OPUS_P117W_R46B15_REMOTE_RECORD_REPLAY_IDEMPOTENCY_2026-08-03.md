# MAESTRO WORKSPACE — Handoff OPUS P117W R46B15

Date : 2026-08-03

## Base owner

- Dépôt : `philstephibanez-wq/OPUS`
- Branche : `master`
- Base exacte : `f5809c58c847a9137aa81f716d368d6f0da74832`
- R46B13 est poussé et acquis.
- R46B14 est appliqué localement, non commité et non poussé ; R46B15 le remplace.
- Archive : `opus_p117w_r46b15_remote_record_replay_idempotency.zip`
- SHA-256 : `0bde7455e12082f5a0905294955418263b7db7eb129ef377900dcc5e77aacf85`
- Fichiers complets : 4.

## Cause

Plusieurs appels REST utilisent le même `trace_id`. Le backend renvoie à nouveau les enregistrements antérieurs de cette trace. Le front réimportait alors un `record_id` déjà acquis et interprétait le rejeu de ses spans comme une collision.

## Correctif

- reprise intégrale de l'idempotence `registry.clear` de R46B14 ;
- mémorisation des `record_id` distants déjà importés dans la trace active ;
- rejeu du même `trace_id + record_id` sans duplication ;
- maintien strict de `OPUS_PROFILER_REMOTE_SPAN_DUPLICATE` lorsque deux enregistrements distincts revendiquent le même `span_id` ;
- validation explicite du `record_id` distant.

## Portée

```text
Opus/Profiler/Trace.php
sites/owasys-back/application/registry/repositories/RegistryRepository.php
sites/owasys-back/application/registry/services/OwasysCommandProvider.php
sites/owasys-front/application/default/controllers/RuntimeController.php
```

## Contrôles assistant

- source relue au HEAD owner exact ;
- archive R46B14 conservée réutilisée sans reconstitution ;
- `git diff --check` propre pour `Trace.php` ;
- ZIP intègre avec exactement quatre fichiers complets ;
- PHP absent de l'environnement assistant : lint et runtime à valider côté owner.

## Validation owner

Remplacer le worktree R46B14 non commité par l'extraction de R46B15 sur le même HEAD. Vérifier lint, autoload et validation des deux sites, puis deux effacements successifs sans contexte. Le second appel doit réussir avec `already_empty=true` et aucun `OPUS_PROFILER_REMOTE_SPAN_DUPLICATE`.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
