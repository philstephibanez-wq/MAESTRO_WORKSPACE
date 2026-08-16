# P117W R45B2A4U — FSM fan-out readability + functional change_app

State: SUPERSEDED — BASELINE GATE INVALID

## Baseline

OPUS owner baseline:

`0313e5892abcf9788c5b2e083b98cdb224a1e453` — `opus_p117w_r45b2a4t_direct_fsm_menu_i18n`

A4T is owner-validated and establishes the retained contract:

- Menu = FSM;
- one state = one menu state/context;
- outgoing signals = submenu commands for the source state;
- state entries do not directly perform transitions;
- diagram = another functional projection of the same FSM;
- cross-module FSM/menu I18n is state-module/target-module owned.

## Intended correction

A4U targeted two validated defects:

1. generic compact SVG fan-out readability in `Opus/Fsm/Diagram.class.php`;
2. missing observable effect for the canonical `change_app` signal, by adding the existing FSM action `clear_current_app` to all ten `change_app` transitions in `sites/owasys-front/config/fsm.json`.

The functional correction remains valid and is carried forward unchanged by A4V.

## Owner validation failure

The owner ran:

`php tools\apply_p117w_r45b2a4u_fsm_fanout_change_app.php`

The runner stopped before any tracked write with:

`OPUS_P117W_R45B2A4U_FSM_BASE_MISMATCH:7ee711751848123c3038eb720412ace391848daa`

The exact HEAD gate had already passed, and the runner's tracked-worktree cleanliness gate had already passed. The failure therefore came only from A4U's additional raw-byte Git blob comparison.

That comparison is not an acceptable repository-equivalence gate for a Windows checkout: Git owns text normalization and repository equivalence, while A4U recomputed a Git blob SHA directly from raw working-tree bytes. A clean HEAD checkout can therefore be refused despite Git considering it unchanged.

No A4U tracked source was written because the failure occurs before candidate construction/write.

## Supersession

A4U is superseded by **P117W R45B2A4V**.

A4V retains the exact same intended functional changes but replaces raw-byte blob validation with:

- exact required HEAD SHA;
- Git tracked-worktree cleanliness;
- `Diagram.class.php` comparison against `git show HEAD:<path>` after EOL normalization;
- `fsm.json` comparison against `git show HEAD:<path>` as parsed structured data through `StructuredFileLoader`, recursively canonicalized before comparison.

This preserves fail-closed baseline validation without confusing checkout representation with repository semantics.

Historical artifact retained for traceability only:

`opus_p117w_r45b2a4u_fsm_fanout_change_app.zip`

Historical SHA-256:

`008e85898eb3d2e5df3497205ff1bc137ce2256c750cd0a8773ecfc0cfe0fa93`

Do not apply A4U again.

The assistant does not commit or push OPUS/OWASYS.