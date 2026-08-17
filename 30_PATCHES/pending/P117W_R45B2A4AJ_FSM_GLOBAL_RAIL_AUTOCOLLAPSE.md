# P117W R45B2A4AJ — FSM global rail autocollapse

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Owner evidence

Owner applied and pushed A4AI as OPUS commit `1c86e851fa989473468edf86962b3648e19a0911`.

Browser evidence on `/fr-FR/sources-de-données` shows the canonical FSM menu working, but the global navigation rail occupies roughly half the viewport height and does not collapse.

Current front logs show the request itself completes normally after the A4AI application-selection POST. This is therefore a SCORE/menu projection defect, not a REST/back/FSM transition failure.

## Root cause

A4AI `navigation.score` renders `item.global_signals` before the per-state `<details>` block in a permanent `<div class="ow-fsm-menu-globals">`.

Each global signal uses `.ow-fsm-menu-signal`, whose display is block/flex-width based. The signals are therefore stacked in normal document flow.

The native exclusive autocollapse contract only applies to the state `<details name="owasys-fsm-navigation">` elements. It cannot collapse the separate global `<div>`.

The defect must not be repaired by hiding signals, clipping height, absolute-positioning an always-open rail, or changing FSM semantics.

## A4AJ implementation

Move the one canonical global-signal projection inside the existing dropdown of its canonical `global_host` state (Applications / registry).

Consequences:

- global transitions remain projected exactly once;
- `NavigationBuilder` and `fsm.json` remain unchanged;
- no transition, ACL, route, REST or FSM semantics change;
- the global list consumes zero page-flow height while the Applications state is collapsed;
- when Applications is opened, global signals and registry-local signals appear in the same existing dropdown surface;
- the dropdown already has bounded height and scrolling through `fsm-native.css`;
- native same-name `<details>` exclusive autocollapse remains authoritative;
- no JavaScript is introduced.

The SCORE menu contract revision becomes `OWASYS_FSM_MENU_V4` with behavior `canonical-state-signals-global-host-exclusive-autocollapse`.

## Direct differential ZIP

Artifact:

`opus_p117w_r45b2a4aj_fsm_global_rail_autocollapse.zip`

SHA-256:

`b0cdf450319f8b02691aac7befe98a54833bbde7026f6e8ccbe3131c730bbf85`

One complete replacement file only:

`sites/owasys-front/application/default/templates/partials/navigation.score`

No patcher. No delete operation. No OPUS framework change is required for this presentation defect.

## Pre-delivery static checks

- payload contains one final-path file only;
- old permanent `ow-fsm-menu-globals` block absent;
- `item.global_host` occurs inside `.ow-fsm-menu-signals` and therefore inside the state `<details>`;
- `name="owasys-fsm-navigation"` retained;
- global transition data attributes retained;
- no trailing whitespace.

## Owner validation

After extraction, owner validates that the menu returns to one-row page-flow height, Applications opens the global/local signal dropdown, opening another state closes the previous state, and all previously actionable global signals remain available.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
