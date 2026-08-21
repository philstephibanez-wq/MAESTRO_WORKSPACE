# P117W R45B2A4BZ1 — EFSM graphical designer design-mode shell — HANDOFF

State: DELIVERY PREPARED — OWNER APPLY/VALIDATE

## Purpose

Deliver the first safe slice of the graphical EFSM designer directly on the current native OPUS diagram.

A4BZ1 is intentionally read-only semantically.

## What becomes visible

For identities allowed `fsm:update`, the FSM panel gains a localized Design mode.

Design mode displays the target toolbar shell:

`Select | State Create Edit Rename Delete | Transition Create Edit Rename Delete | Condition Create Edit Rename Delete | Validate | Publish | View`

Only selection and return-to-View are enabled in this slice.

## Inspector

State selection shows canonical state data.

Transition selection shows canonical transition data plus referenced signal metadata, including:

- signal type;
- signal origin;
- `menu` membership;
- `menu_order`;
- `label_key`;
- `menu_state`;
- resource/operation;
- structural user-menu eligibility.

This confirms the requested future `Dans le menu utilisateur` property against the real canonical signal model before it becomes editable in A4BZ3.

## Safety

Design mode must not execute user-origin signals.

The slice blocks link, POST and keyboard activation in Design mode while preserving normal View mode behavior.

Existing right-button presentation drag remains untouched.

No `fsm.json` or semantic application configuration is written by the designer UI.

## Bézier preview

Simple current cubic transitions expose read-only P0/C1/C2/P3 control geometry and helper tangents when selected.

This proves the interaction vocabulary for A4BZ3B without changing layout persistence yet.

## Permission / profiler

- Design permission: ACL `fsm:update`.
- unauthorized `fsm_design=1`: deny-by-default.
- entering Design mode records real profiler event `fsm/designer.opened`.

## I18n

Designer command labels are added to all base-language default-module catalogs declared by the current site I18n policy. Regional overlays inherit them through the existing explicit base-language overlay contract.

## Differential contents

One one-shot applicator modifies only `owasys-front` files and base I18n catalogs and creates `www/asset/js/fsm-designer.js`.

There is no `owasys-back` change and no new backend JavaScript.

The applicator baseline-locks the five existing source/template/CSS files that it patches against the current OPUS master blobs.

## Validation commands

Run from `H:\OPUS` after extraction:

- applicator;
- PHP lint for `ScorePageRenderer.php` and `FsmDiagramBuilder.php`;
- `composer dump-autoload -o`;
- `composer opus:validate-site -- owasys-front`;
- `composer opus:dev-server -- owasys-front`.

## Browser checks

1. Login as developer/admin.
2. Confirm normal View-mode signal actions still work.
3. Enter Design mode.
4. Confirm toolbar/inspector appears.
5. Select several states and transitions.
6. Confirm transition inspector includes guards/actions/runtime operations and signal menu metadata.
7. Attempt to click an otherwise actionable signal: no runtime transition/request is allowed.
8. On a simple cubic transition, confirm P0/C1/C2/P3 preview.
9. Exit Design mode and confirm runtime actionability is restored.
10. Login as viewer and confirm `?fsm_design=1` is denied.

## Workspace spec

`40_SPECS/P117W_R45B2A4BZ1_EFSM_DESIGN_MODE_SHELL_SPEC.md`

Spec commit:

`4e121001d903510b40ee09eaf3c7ef5d029c322d`

## Next after owner validation

P117W R45B2A4BZ2 — state CRUD + rename/refactor on a validated draft.