# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B13_ROUTING_CONTROLLER_EVIDENCE_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `d8eba2e5e0631a2e59edd5d509ba017edfbe2037`.
- R46B12 est poussé et acquis.
- R46B10 reste annulé et interdit.
- Contrat FSM V2 : `table_fsm + current_state + signal -> next_state`.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Livrable actif

```text
ZIP     : opus_p117w_r46b13_routing_controller_evidence.zip
SHA-256 : a6d2730b021d6806d8526aaa10567380443a93504f6b0543a37534bc2a1c13ae
FILES   : 2
BASE    : d8eba2e5e0631a2e59edd5d509ba017edfbe2037
```

## Correction

Le panneau « Routage et contrôleur » reçoit les événements contractuels exacts `http.route.resolved` et `http.controller.selected`, avec route normalisée, paramètres assainis, origine de la règle, classe et méthode du contrôleur. Le view-model générique les classe dans le panneau Routage et les résume sans inventer de décision.

## Prochaine action

L'owner applique R46B13 sur le HEAD exact, exécute lint, smokes et validation du site, puis vérifie le panneau Routage sur les chemins runtime, création et source avant commit et push.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
