# P117W R45B2A4AB — Handoff

State: OWNER FUNCTIONAL VALIDATION PASSED — CONTINUE WITH A4AC

## Baseline

Accepted OPUS baseline:

`0ce2dfa9a1c7175ac39f93b2ee017ed6e40643ac` — A4Z.

Owner working tree additionally contains A4AA CSS and A4AB `FsmDiagramBuilder.php` changes.

## Root correction

The fixed graph intentionally displays representative edges. Runtime interaction must not be keyed to the representative edge's source state.

A4AB derives currently executable actions exclusively from the current Menu=FSM state, then maps each actionable semantic `signal + target` to one fixed displayed representative.

Selection rule:

- exact displayed source == current state: prefer it;
- otherwise: use the first fixed representative of the same `signal + target`;
- action URL always comes from the current state's `NavigationBuilder` projection;
- passive current-state signals never receive a link.

## Owner runtime validation — 2026-08-16

Validated:

- `change_app` works;
- `logout` works from Applications/registry;
- fixed A4Z topology remains stable.

Remaining visual defects reported by owner:

- cyan is ambiguous because passive return edges also use the accent cyan token;
- transition labels/paths still overlap in the classic non-compact renderer.

These defects are now the A4AC target. Do not regress A4AB semantic action mapping.

## Continuation

Apply A4AC as the next direct differential. A4AC incorporates the complete A4AB builder plus the A4AA CSS behavior, then updates the generic OPUS renderer/theme to reserve cyan for actionable transitions and remove label/node overlaps.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.