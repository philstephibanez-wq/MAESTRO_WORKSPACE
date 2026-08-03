# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B11_FSM_SIGNAL_CONTRACT_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `bf190ab7afecc09493d2d5c98513420613f45fbc`.
- R46B9 est poussé et acquis.
- R46B10 est annulé et ne doit pas être appliqué.
- R46B11 est le cadrage actif et repart exclusivement de R46B9.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Contrat FSM actif

```text
table_fsm + current_state + signal -> next_state
```

Le nom de table est toujours visible. `event`, `from_state` et `to_state`
doivent être migrés atomiquement dans les contrats, configurations, résultats,
consommateurs et smokes FSM. Aucun alias ancien silencieux.

Une garde refusée conserve la transition candidate et son `next_state`.
Un signal inconnu produit `transition_not_found` sans cible inventée.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
