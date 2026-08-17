# P117W R45B2A4AI — Full FSM workflow reconstruction

State: MERGED INTO CANONICAL A4AI DELIVERY — OWNER VALIDATION REQUIRED

This design-lock document is retained as the broader A4AI rationale, but the authoritative implementation specification and artifact record are now:

`30_PATCHES/pending/P117W_R45B2A4AI_CANONICAL_WORKFLOW_FSM_REBUILD.md`

The produced direct differential artifact is:

`opus_p117w_r45b2a4ai_canonical_workflow_fsm_menu.zip`

SHA-256:

`38ad0d87a8e7a33a09fb413aad01d4df4d04dfd38290a7b7f831db638f311632`

The delivery implements the locked requirements from this document:

- generic finite ordinary global transitions distinct from NMI;
- exact local transition precedence over global transition;
- one canonical OWASYS FSM instead of a hidden creation wizard FSM plus principal FSM;
- explicit creation workflow/result states including `application_creating`, `application_created`, `application_creation_failed`;
- branch-local signal submenus plus one global navigation rail;
- fixed canonical diagram with current-state highlight only;
- `logout -> login` visibly connected from every finite state in projection;
- typed signal colors/actionability preserved;
- Source/Git/build lifecycle audited without inventing persistent states for synchronous external-state operations.

The separate file `sites/owasys-front/config/creation.wizard.fsm.json` is obsolete and must be deleted when applying A4AI.

Owner validation on `H:\OPUS` remains mandatory. Owner alone commits/pushes OPUS/OWASYS; assistant writes MAESTRO_WORKSPACE only.
