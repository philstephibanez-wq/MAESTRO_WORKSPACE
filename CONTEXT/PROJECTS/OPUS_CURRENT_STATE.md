# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : bf190ab7afecc09493d2d5c98513420613f45fbc
Dernier acquis : R46B9
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B9 est poussé et acquis.
- R46B10 est annulé et ne doit jamais être appliqué.
- Les détails structurés REST/BDD, le terme visible Étape et l'instrumentation réelle SCORE restent acquis.
- `fullstack-test` est un témoin, jamais une cible de correction locale.

## Livrable owner actif — R46B11

- Base : `bf190ab7afecc09493d2d5c98513420613f45fbc`.
- ZIP : `opus_p117w_r46b11_fsm_signal_contract.zip`.
- SHA-256 : `7c78b527357f5adc37d87109b94c06eec2a1be454eee5a3744e4732dc5a3fcd0`.
- Statut : livré, validation et push owner requis.
- Handoff : `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B11_FSM_SIGNAL_CONTRACT_DELIVERY_2026-08-03.md`.

## Contrat FSM R46B11

```text
table_fsm + current_state + signal -> next_state
```

- aucun alias silencieux `event/from_state/to_state` ;
- nom réel de la table systématiquement visible ;
- garde refusée : transition candidate complète et `guard_refused` ;
- signal inconnu : `transition_not_found` sans cible inventée ;
- `fsm_contract` interne au snapshot uniquement, absent de la vue.

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
