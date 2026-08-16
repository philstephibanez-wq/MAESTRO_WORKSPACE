# P117W R45B2A4U — Handoff

State: SUPERSEDED — OWNER APPLY BLOCKED BY INVALID BASELINE GATE

## Proven baseline

A4T is owner-validated and committed in OPUS as:

`0313e5892abcf9788c5b2e083b98cdb224a1e453`

The retained functional model is:

- Menu = FSM;
- state = menu/context;
- outgoing signals = submenu commands;
- no direct state-command navigation;
- native diagram = second functional projection of the same FSM.

## A4U owner result

The owner executed the A4U runner and obtained:

`OPUS_P117W_R45B2A4U_FSM_BASE_MISMATCH:7ee711751848123c3038eb720412ace391848daa`

This happened after A4U had already accepted the exact required HEAD and the tracked-worktree cleanliness gate, but before any tracked file write.

## Delivery defect

A4U compared a GitHub/Git blob SHA with a SHA recomputed from raw Windows working-tree bytes. That gate duplicates Git's own repository-equivalence logic incorrectly and can reject a clean checkout because checkout representation is not the same contract as normalized Git content.

A4U therefore must not be retried.

No A4U tracked modification was applied.

## Continuation

Continue with **P117W R45B2A4V**.

A4V carries the same functional correction:

- generic `OPUS_FSM_Diagram` compact fan-out grid;
- source and target edge lanes;
- bounded signal-label hitboxes;
- all ten canonical `change_app` transitions gain existing FSM action `clear_current_app`.

A4V replaces only the faulty baseline-attestation method:

- exact HEAD;
- clean tracked worktree;
- normalized HEAD text comparison for `Diagram.class.php`;
- semantic HEAD comparison for `fsm.json` via `StructuredFileLoader`.

The assistant does not commit or push OPUS/OWASYS.