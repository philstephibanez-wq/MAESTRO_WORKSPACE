# P117W R45B2A4BZ2R8B6R — EFSM renderer palette parity handoff

Date: 2026-09-05
Status: READY FOR OWNER APPLICATION

## Scope

Owner clarification is authoritative: the red NMI presentation is correct and is preserved. The defect is the mismatch between OWASYS ordinary state/transition colors and the generic OPUS renderer presentation visible in `sites/essai`.

## Root cause

`sites/essai` consumes the generic FSM diagram palette. OWASYS overrides that palette in `sites/owasys-front/www/asset/css/fsm-native.css`, including state/current-state/edge/label tokens and explicit user/automatic transition recoloring. This local adapter causes the observed divergence.

## Delivery intent

The owner receives a native differential ZIP containing an applicator for the single CSS correction. The applicator performs exact-source anchors and aborts if the expected OWASYS CSS baseline is not found.

Before application, restore the rejected experimental local model change:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

Do not modify the owner's existing layout edits:

- `sites/owasys-back/config/fsm.layout.json`
- `sites/owasys-front/config/data.fsm.layout.json`

## Acceptance evidence required

1. applicator reports success;
2. `git diff --check` succeeds;
3. diff for `fsm-native.css` contains palette-remapping removal only;
4. front runtime screenshot shows generic `essai` state/transition palette;
5. NMI remains red;
6. no commit/push until owner visually accepts the runtime.

## Rejected attempts

`R8NMI.zip` targeted NMI presentation rather than the actual owner-requested state/transition palette and is rejected. `R8NMI2.zip` must not be applied. Neither is an accepted OPUS/OWASYS state.

Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6R_EFSM_RENDERER_PALETTE_PARITY_SPEC.md`.
