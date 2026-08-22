# P117W R45B2A4BZ2R7R2 — Owner validation repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact OPUS baseline

`340d195907c7743154728578c255fe6ea46b7c14`

## Artifact

`opus_p117w_r45b2a4bz2r7r2_owner_validation_repair.zip`

ZIP SHA-256:

`78d89f77b2cec1006bb77b245364e5af6f8cfca2dd1b45482e6744c87e5a4004`

Applicator SHA-256:

`c33908c3012e5cf0ec755f7d1851a2a6301ad965df4618fef0c2eb7261c24744`

The ZIP contains exactly one differential applicator: `apply_a4bz2r7r2.php`.

The assistant does not commit/push OPUS/OWASYS.

## Why R7R2 exists

R7R1 owner validation failed. The resulting current OPUS commit changed only `sites/owasys-front/config/fsm.layout.json` relative to R7, while the canonical EFSM/menu/routes source remained unchanged. The live logs then exposed additional generic OPUS defects in layout persistence and signal-origin normalization.

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

Applicator:

- `php -l`: OK;
- ZIP extraction: exactly one applicator, lint OK.

Transactional synthetic clean-Git fixture:

- exact-baseline/hash variant of applicator applied end-to-end;
- exactly nine changed paths produced;
- all four changed PHP sources linted after transformation;
- embedded layout JavaScript extracted and `node --check` passed;
- `workflows` removed;
- five false FSM menu signals removed;
- all transition references to removed objects eliminated;
- canonical and localized `fsm` routes removed;
- layout remained vertical and `workflows` geometry removed;
- second application refused with exit code 20;
- forced post-write verification failure rolled all files back to a clean Git status.

Behavioral tests on transformed fixture:

- `signalOrigin('unspecified')` accepted;
- `persistLayout:false` prevented layout-store discovery while default `true` preserved canonical behavior;
- invalid state coordinate with a valid CSRF token failed on coordinate validation but left the token usable;
- retry of a valid payload with that same token succeeded;
- reuse after successful save failed `OPUS_CSRF_TOKEN_INVALID`;
- stale runtime snapshot error cleared/reset state and emitted `runtime.snapshot.reset`.

## Expected applicator markers

`P117W_R45B2A4BZ2R7R2_APPLIED`

Additional markers:

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

## Owner validation

After application:

1. lint changed PHP and JS-related sources;
2. regenerate Composer autoload;
3. validate both OWASYS applications;
4. verify the top menu has no `FSM` entry;
5. verify `/fr-FR/fsm` is no longer a public route;
6. open the developer EFSM designer through its developer control/query and verify the same persisted vertical diagram is used;
7. right-drag and persist several states/signals; refresh and verify geometry survives;
8. verify no `OPUS_FSM_DIAGRAM_LAYOUT_COORDINATE_INVALID` or CSRF cascade appears in fresh logs;
9. inspect `git status --short`: exactly nine changed paths before owner commit.

## Next slice

Only after owner validation succeeds: resume real PHP GUARD/ACTION authoring from the EFSM designer through the mandatory `owasys-front -> secured REST -> owasys-back -> Composer -> response -> owasys-front` flow.
