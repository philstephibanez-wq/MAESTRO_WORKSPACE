# P117W R45B2A4BZ2R7R2 — Owner validation repair handoff

State: OWNER APPLIED — VISUAL MENU/DIAGRAM ACCEPTANCE OBSERVED; PERSISTENCE ACCEPTANCE NOT EXPLICITLY RECORDED

## Exact OPUS baseline

`340d195907c7743154728578c255fe6ea46b7c14`

## Owner commit after application

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae` (`opus_p117w_r45b2a4bz2r7r2_owner_validation_repair`).

## Artifact

`opus_p117w_r45b2a4bz2r7r2_owner_validation_repair.zip`

ZIP SHA-256:

`78d89f77b2cec1006bb77b245364e5af6f8cfca2dd1b45482e6744c87e5a4004`

Applicator SHA-256:

`c33908c3012e5cf0ec755f7d1851a2a6301ad965df4618fef0c2eb7261c24744`

The ZIP contains exactly one differential applicator: `apply_a4bz2r7r2.php`.

The assistant does not commit/push OPUS/OWASYS.

## Why R7R2 exists

R7R1 owner validation failed. The resulting OPUS commit changed only `sites/owasys-front/config/fsm.layout.json` relative to R7, while the canonical EFSM/menu/routes source remained unchanged. Live logs then exposed additional generic OPUS defects in layout persistence and signal-origin normalization.

## Corrected causes

- structurally removes false user-facing FSM state/signals/transitions/routes;
- keeps `fsm:update` only as developer-tool authorization;
- keeps one canonical vertical `config/fsm.layout.json` and prunes only obsolete geometry;
- makes read-only selected-application FSM projection unable to persist host layout;
- makes signal-origin normalization idempotent for `unspecified`;
- sanitizes client-derived presentation coordinates and invalid SVG path numerics;
- validates layout payload before consuming the one-use CSRF token;
- resets only stale removed-state runtime snapshots and profiles `fsm/runtime.snapshot.reset`.

## Exact changed paths

Exactly nine:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/fsm.layout.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

## Pre-delivery verification performed

- applicator `php -l`: OK;
- transactional clean-Git fixture: full applicator execution OK;
- exactly nine changed paths produced;
- changed PHP sources linted;
- embedded layout JavaScript extracted and `node --check` passed;
- false `workflows` state and five false FSM menu signals removed;
- transition references to removed objects eliminated;
- canonical/localized `fsm` routes removed;
- layout remained vertical and obsolete geometry pruned;
- second application refused;
- forced post-write verification failure rolled all files back;
- `signalOrigin('unspecified')` accepted;
- invalid geometry leaves one-use CSRF token reusable until a successful persistence consumes it;
- stale removed-state snapshot reset path validated.

## Owner observation after application

The owner-provided 2026-08-22 screenshot shows the normal OWASYS navigation without the former top-level `FSM` item and shows the canonical vertical EFSM diagram without the deleted `workflows` state. This is recorded as visual acceptance of the menu/diagram correction only. A distinct explicit owner statement that drag/layout persistence survives refresh has not been recorded here, so persistence is not marked fully owner-accepted by this handoff.

## Expected applicator markers

`P117W_R45B2A4BZ2R7R2_APPLIED`

- `baseline=340d195907c7743154728578c255fe6ea46b7c14`
- `menu_fsm=removed_structurally`
- `false_fsm_route=removed`
- `graphics_authority=config/fsm.layout.json`
- `readonly_projection_layout_persistence=disabled`
- `signal_origin_unspecified=idempotent`
- `layout_coordinates=client_sanitized`
- `layout_csrf=consume_after_payload_validation`
- `stale_removed_state_session=profiled_reset`
- `changed_files=9`

## Next slice

R8A establishes the real developer-programmed GUARD/ACTION PHP source authority and secured write pipeline before enabling the graphical source editor in R8B.