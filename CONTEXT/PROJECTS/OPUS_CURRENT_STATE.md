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

## Livrable owner actif — R46B15

- Base : `f5809c58c847a9137aa81f716d368d6f0da74832`.
- ZIP : `opus_p117w_r46b15_remote_record_replay_idempotency.zip`.
- SHA-256 : `0bde7455e12082f5a0905294955418263b7db7eb129ef377900dcc5e77aacf85`.
- Fichiers complets : 4.
- Statut : livré, validation et push owner requis.
- Handoff : `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B15_REMOTE_RECORD_REPLAY_IDEMPOTENCY_2026-08-03.md`.

R46B14 est appliqué localement mais non acquis. R46B15 le remplace intégralement, conserve l'idempotence de `registry.clear` et rend idempotent le rejeu du même enregistrement Profiler distant sans masquer une collision réelle de spans.

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
