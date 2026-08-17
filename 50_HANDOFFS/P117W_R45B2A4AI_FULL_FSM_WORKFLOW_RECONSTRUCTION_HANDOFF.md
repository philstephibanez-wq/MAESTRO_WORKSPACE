# P117W R45B2A4AI — Handoff

State: MERGED INTO CANONICAL A4AI CODE DELIVERY — OWNER VALIDATION REQUIRED

This earlier design handoff is superseded operationally by:

`50_HANDOFFS/P117W_R45B2A4AI_CANONICAL_WORKFLOW_FSM_REBUILD_HANDOFF.md`

Produced artifact:

`opus_p117w_r45b2a4ai_canonical_workflow_fsm_menu.zip`

SHA-256:

`38ad0d87a8e7a33a09fb413aad01d4df4d04dfd38290a7b7f831db638f311632`

A4AI now provides:

1. finite ordinary `scope: global` transitions with explicit `from_states`, distinct from NMI;
2. exact local transition precedence over a matching global transition;
3. collapsed global navigation/logout families instead of per-state duplication;
4. 16-state canonical OWASYS workflow including creation basics/security/review/creating/created/failed;
5. one principal FSM for creation; the old `creation.wizard.fsm.json` must be deleted;
6. state-specific local signal submenus with exclusive autocollapse;
7. one global navigation rail rather than repeated global controls;
8. canonical fixed diagram projection with initial root and highlight-only current state;
9. 16 visible `logout -> login` source relations in the projection smoke;
10. Source/Git/build lifecycle audit with synchronous external-state outcomes retained as signals rather than invented persistent states.

Owner validation on `H:\OPUS` remains the acceptance gate. Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.
