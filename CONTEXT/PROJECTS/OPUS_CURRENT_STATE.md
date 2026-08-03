# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : f5809c58c847a9137aa81f716d368d6f0da74832
Dernier acquis : R46B13
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B13 est poussé et acquis ; les preuves de routage et contrôleur sont présentes.
- R46B10 est annulé et ne doit jamais être appliqué.
- Le contrat FSM V2 reste `table_fsm + current_state + signal -> next_state`.
- Les détails structurés REST/BDD, le terme visible Étape et l'instrumentation SCORE restent acquis.
- `fullstack-test` est un témoin, jamais une cible de correction locale.

## Livrable owner actif — R46B14

- Base : `f5809c58c847a9137aa81f716d368d6f0da74832`.
- ZIP : `opus_p117w_r46b14_registry_clear_idempotency.zip`.
- SHA-256 : `b6dfd73e87aaaf708ee44c3b0de9da9a5b9cd745dfc184fe7b1d7038357d6e73`.
- Fichiers complets : 3.
- Statut : livré, validation et push owner requis.
- Handoff : `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B14_REGISTRY_CLEAR_IDEMPOTENCY_2026-08-03.md`.

R46B14 rend `registry.clear` idempotent, retire le faux identifiant système `owasys`, rattache les événements techniques à `owasys-back` et empêche le front de reclasser une erreur non-FSM en refus FSM.

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
