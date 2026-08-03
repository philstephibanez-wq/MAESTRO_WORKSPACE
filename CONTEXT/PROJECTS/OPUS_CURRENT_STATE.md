# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : bd0c5d20f2e510b3666df8ed758b7a906c9f46ea
Dernier acquis : R46B11
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B11 est poussé et acquis.
- R46B10 est annulé et ne doit jamais être appliqué.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- Les détails structurés REST/BDD, le terme visible Étape et l'instrumentation SCORE restent acquis.
- `fullstack-test` est un témoin, jamais une cible de correction locale.

## Défaut confirmé de R46B11

`sites/owasys-front/application/default/controllers/RuntimeController.php` contient deux méthodes `resolveSignal()` de responsabilités différentes. PHP échoue au chargement avec `Cannot redeclare OwasysRuntimeController::resolveSignal()`; le front répond donc HTTP 500 avant instrumentation.

## Livrable owner actif — R46B12

- Base : `bd0c5d20f2e510b3666df8ed758b7a906c9f46ea`.
- ZIP : `opus_p117w_r46b12_runtime_signal_resolver_collision_fix.zip`.
- SHA-256 : `013f8347a4c52c4fcf15ef28eeddfd71e4acc484e15503660968f9252622f76e`.
- Fichiers complets : 1.
- Statut : livré, validation et push owner requis.
- Handoff : `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B12_RUNTIME_SIGNAL_RESOLVER_COLLISION_FIX_2026-08-03.md`.

R46B12 renomme la résolution multi-paramètres en `resolveRequestSignal(...)` et conserve `resolveSignal(string $routeKey)`.

## Invariants

- ZIP différentiel seulement pour OPUS/OWASYS ;
- validation et push par l'owner ;
- aucune correction locale du site témoin ;
- SCORE, Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- aucune donnée inventée dans le Profiler.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
