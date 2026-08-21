# P117W R45B2A4BZ2R3 — EFSM state-semantic inspector — HANDOFF

State: DELIVERY TO PREPARE / OWNER VALIDATION REQUIRED

## Feedback resolved

The A4BZ2R2 state form exposed the raw OWASYS state schema as one flat editor. That is not an acceptable FSM designer abstraction.

R3 changes the mental model from **web-state record editor** to **FSM state editor**.

## Primary state view

Selecting a state must immediately show:

- ID;
- FSM role: initial / final / normal;
- entry marker where applicable;
- incoming transition count;
- outgoing transition count;
- outgoing signals;
- self-loop count.

For `begin`, the first thing visible must be that it is the initial/entry state of the machine.

## Secondary application projection

The following fields remain editable but move to a collapsed `Projection OWASYS` section:

- application nature/type;
- module;
- route;
- template;
- requires auth;
- requires current application;
- navigation visibility/order/label.

They are not presented as the definition of an FSM state.

## Presentation section

`diagram.rank` and `diagram.order` move under a separate `Disposition` section.

## Entry protection

Ordinary state Edit does not permit the canonical `begin` entry role to be broken. Initial/final machine-role changes require a dedicated semantic machine command in a later slice.

## Delete UI defect

The delete confirmation input is visible only in Delete mode. Add an explicit author-level `[hidden] { display:none }` rule for state editor rows so generic grid/flex declarations cannot override the hidden attribute.

## Validator parity

The A4BZ2 generic validator is strengthened with OPUS `FsmProcessor` structural validation so accepted drafts satisfy the same initial/entry/transition invariants as runtime execution.

No transition is executed and no guard is evaluated during this validation.

## Unchanged contracts

- state CRUD remains draft-only;
- no canonical FSM write;
- front -> REST -> back -> Composer remains mandatory;
- no JS in owasys-back;
- transition/condition CRUD still pending A4BZ3;
- Bézier editing still pending A4BZ3B.

## Owner acceptance

1. Open Design mode as admin.
2. Select `begin`.
3. Confirm primary inspector says it is initial/entry and shows transition connectivity.
4. Confirm module/route/navigation are not in the primary FSM block.
5. Expand `Projection OWASYS` and verify those fields remain available.
6. Expand `Disposition` and verify rank/order are separate.
7. Enter ordinary Edit mode and confirm delete confirmation is absent.
8. Enter Delete mode and confirm typed confirmation appears.
9. Confirm `begin` entry semantics cannot be changed through ordinary Edit.
10. Validate both autonomous applications and inspect correlated Profiler events for a draft state command.

## Workspace spec

`40_SPECS/P117W_R45B2A4BZ2R3_EFSM_STATE_SEMANTIC_INSPECTOR_SPEC.md`

Specification commit: `decf669fe78d12df8a323398fbb44f99e318ff9a`
