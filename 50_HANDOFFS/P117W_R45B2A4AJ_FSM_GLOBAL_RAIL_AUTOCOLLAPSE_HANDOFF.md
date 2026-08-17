# P117W R45B2A4AJ — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

OPUS owner baseline is A4AI commit:

`1c86e851fa989473468edf86962b3648e19a0911`

A4AI canonical FSM semantics are preserved unchanged.

## Owner finding

The A4AI browser menu is not operationally usable because its global navigation rail is permanently expanded in document flow. It consumes roughly half the viewport height and does not participate in native `<details>` autocollapse.

Current front runtime evidence shows the selected application/source request completes; this delivery addresses menu projection only.

## Root cause

`navigation.score` renders `item.global_signals` in a standalone `<div>` before state `<details>` elements. Native exclusive autocollapse cannot affect that block.

## Delivered correction

The global-signal projection is moved inside the existing Applications/registry state dropdown selected by `NavigationBuilder::global_host`.

No global signal is removed and no transition is duplicated.

When collapsed, the global rail consumes no page height. When Applications is opened, global navigation and registry-local transitions use the existing bounded `.ow-fsm-menu-signals` dropdown.

The existing same-name `<details name="owasys-fsm-navigation">` contract remains responsible for autocollapse. No JavaScript is added.

## Artifact

`opus_p117w_r45b2a4aj_fsm_global_rail_autocollapse.zip`

SHA-256:

`b0cdf450319f8b02691aac7befe98a54833bbde7026f6e8ccbe3131c730bbf85`

Complete file:

`sites/owasys-front/application/default/templates/partials/navigation.score`

No deletion required.

## Validation requested

1. Extract over current A4AI checkout.
2. Verify only `navigation.score` changes.
3. Restart `owasys-front`.
4. Confirm the FSM menu occupies only its normal one-row height when closed.
5. Open Applications and verify the global signals are available in its dropdown.
6. Open another state and verify Applications closes automatically.
7. Verify `change_app`, section `open_*`, Account/Password navigation and `logout` remain actionable exactly where A4AI permits them.
8. Verify the FSM diagram is unchanged.

Do not mark A4AJ accepted before owner browser validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
