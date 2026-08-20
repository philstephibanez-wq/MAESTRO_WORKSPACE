# P117W R45B2A4BP — Entry state navigation projection compatibility

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub committed baseline: `7ded8369167fa6d75df7f0cf6b33b67a45a5d626` — A4BN.
- A4BO was applied locally by the owner for runtime validation and introduced the canonical real `begin` FSM state with `type=entry`.
- Menu behavior remains frozen; A4BP is compatibility plumbing only.

## Runtime failure evidence

After A4BO application, OWASYS front fails on `GET /fr-FR/applications` with HTTP 500:

`OWASYS_NAVIGATION_STATE_TYPE_INVALID`

The exception is raised by `sites/owasys-front/application/default/services/NavigationBuilder.php` line 104.

At the same trace IDs, OWASYS back completes `GET /api/v1/applications` and Composer `owasys:registry-sync` successfully with HTTP 200. The failure is therefore front-side EFSM/menu projection validation, not REST/back/Composer.

## Root cause

A4BO extended the canonical OPUS FSM semantic state taxonomy with the real entry state:

`id=begin`, `type=entry`, `initial_state=begin`.

`FsmProcessor` accepts and validates that canonical entry-state contract, but `OwasysNavigationBuilder` still had the older closed presentation whitelist:

- `screen`
- `workflow`
- `result`
- `system`

Consequently, the menu projection rejects the valid canonical `entry` state before rendering even though `begin` is intentionally non-visible in navigation.

The defect is a taxonomy-integration mismatch introduced by the semantic A4BO evolution.

## A4BP correction

`OwasysNavigationBuilder` recognizes `entry` as a valid canonical state type in addition to the pre-existing four types.

No navigation/menu projection rule is otherwise changed:

- no menu item is added for `begin`;
- `begin` remains governed by its canonical state metadata (`navigation.visible=false`);
- no guard, ACL, signal, transition, route, label or ordering behavior is changed;
- the menu remains a projection of the canonical EFSM;
- A4BO `begin` semantics remain unchanged.

## Scope

Exactly one complete file changes:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`

No OPUS framework class is added or changed. No `owasys-back` file changes. No JavaScript is added.

## Artifact

`opus_p117w_r45b2a4bp_entry_state_navigation_projection_compatibility.zip`

SHA-256:

`0269905ef4ac8a68977dbafcf960ad001475ae3075f277282dc057bde12a7797`

## Validation performed

- PHP lint: OK;
- exact source baseline verified against OPUS committed `NavigationBuilder.php` blob `b887c80e178750ad42f1c8d1ba3279979ef939df`;
- state-type whitelist contains `entry`, `screen`, `workflow`, `result`, `system`;
- existing explicit `OWASYS_NAVIGATION_STATE_TYPE_INVALID` rejection remains for unsupported types;
- ZIP contains exactly one complete final-path file.

## Acceptance

1. Apply A4BP over the locally applied A4BO files.
2. Restart only `owasys-front` if already needed; `owasys-back` does not need code replacement.
3. Open `/fr-FR/applications` and confirm the `OWASYS_NAVIGATION_STATE_TYPE_INVALID` 500 is gone.
4. Confirm no `begin` item appears in the human menu.
5. Open FSM and confirm `begin` remains a real ordinary draggable state and the white pseudo marker remains absent.
6. Confirm `begin --open_login--> login` and existing global transitions remain functional.
7. Confirm ordinary menus, ACL projection and application selection remain unchanged.
