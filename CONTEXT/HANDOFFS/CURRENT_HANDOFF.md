# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B11_FSM_SIGNAL_CONTRACT_DELIVERY_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `bf190ab7afecc09493d2d5c98513420613f45fbc`.
- R46B9 est poussé et acquis.
- R46B10 est annulé et interdit.
- R46B11 est livré sur cette base et attend validation/push owner.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Livrable actif

```text
ZIP     : opus_p117w_r46b11_fsm_signal_contract.zip
SHA-256 : 7c78b527357f5adc37d87109b94c06eec2a1be454eee5a3744e4732dc5a3fcd0
FILES   : 17
BASE    : bf190ab7afecc09493d2d5c98513420613f45fbc
```

## Contrat FSM actif

```text
table_fsm + current_state + signal -> next_state
```

Le nom de table est toujours visible. Aucun alias `event/from_state/to_state`.
Une garde refusée conserve le `next_state` candidat. Un signal inconnu produit
`transition_not_found` sans cible inventée. `fsm_contract` est réservé au
snapshot runtime et n'apparaît pas dans le Profiler.

## Prochaine action

L'owner applique le ZIP sur une arborescence OPUS propre au HEAD de base,
exécute les contrôles PHP et smokes, vérifie le panneau FSM, puis committe et
pousse. Ne pas poursuivre un nouvel incrément avant le retour owner.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
