# P117W R45B2A4BZ2R3 — EFSM state-semantic inspector — HANDOFF

State: DELIVERY PREPARED / APPLICATOR VERIFIED / OWNER VALIDATION REQUIRED

## Feedback resolved

The A4BZ2R2 state form exposed the raw OWASYS state schema as one flat editor. That is not an acceptable FSM designer abstraction.

R3 changes the mental model from **web-state record editor** to **FSM state editor**.

## Primary state view

Selecting a state now prioritizes:

- ID;
- FSM role: initial / final / normal;
- entry marker where applicable;
- incoming transition count;
- outgoing transition count;
- outgoing signals;
- self-loop count.

For `begin`, the first thing visible must be that it is the initial/entry state of the machine.

The inspector is rendered as a small graphical state card with incoming and outgoing sides instead of a raw flat property dump.

## Secondary application projection

The following fields remain editable but move to a collapsed `OWASYS` section:

- application nature/type;
- module;
- route;
- template;
- requires auth;
- requires current application;
- navigation visibility/order/label.

They are not presented as the definition of an FSM state.

## Presentation section

`diagram.rank` and `diagram.order` move under a separate collapsed `Layout` section.

## Entry protection

Ordinary state Edit does not permit the canonical `begin` entry type to be changed. Initial/final machine-role changes require a dedicated semantic machine command in a later slice.

## Delete UI defect fixed

The delete confirmation input is visible only in Delete mode. R3 adds explicit author-level hidden rules for state editor rows so generic grid/flex declarations cannot override the HTML `hidden` attribute.

## Validator parity

The A4BZ2 generic validator is strengthened with OPUS `FsmProcessor` structural validation so accepted drafts satisfy the same initial/entry/transition invariants as runtime execution.

No transition is executed and no guard is evaluated during this validation.

## Changed files

R3 modifies only:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`;
- `Opus/Fsm/Definition/FsmDefinitionValidator.php`.

No owasys-back JavaScript or package/runtime file is introduced.

## Applicator verification performed before delivery

Baseline contract: successfully applied A4BZ2R2.

Verification performed on exact A4BZ2R2 template/JS/validator outputs extracted from the delivered R2 applicator:

- applicator PHP lint: OK;
- application on LF fixture: OK;
- application on CRLF fixture: OK;
- generated `FsmDefinitionValidator.php` PHP lint: OK;
- generated `fsm-designer.js` syntax check: OK;
- second application is refused with `P117W_R45B2A4BZ2R3_ALREADY_APPLIED`;
- deliberately altered JS baseline is refused before writes;
- no-write assertion on failed preflight: OK.

Applicator marker:

`P117W_R45B2A4BZ2R3_APPLIED`

ZIP SHA-256:

`64e09d2832dce6bbf5f08d355610f81eb2917f40debc6c24ad99c5a036b7a0f5`

Applicator SHA-256:

`df6f50e5e4d087fb21c95a601b6f0e3769fa32a632348559b371a72ec1f8f854`

## Unchanged contracts

- state CRUD remains draft-only;
- no canonical FSM write;
- front -> REST -> back -> Composer remains mandatory for semantic commands;
- no JS in owasys-back;
- transition/condition CRUD still pending A4BZ3;
- Bézier editing still pending A4BZ3B.

## Owner acceptance

1. Apply R3 on top of the successfully applied A4BZ2R2 working tree.
2. Open Design mode as admin.
3. Select `begin`.
4. Confirm the primary inspector shows a graphical state card with `INITIAL · ENTRY` and transition connectivity.
5. Confirm module/route/navigation are not in the primary FSM block.
6. Enter Edit and expand `OWASYS` to verify application projection fields remain available.
7. Expand `Layout` and verify rank/order are separate.
8. Confirm ordinary Edit does not display delete confirmation.
9. Enter Delete and confirm typed confirmation appears only then.
10. Confirm the `begin` entry type is protected in ordinary Edit.
11. Validate both autonomous applications and inspect correlated Profiler events for a draft state command.

## Workspace spec

`40_SPECS/P117W_R45B2A4BZ2R3_EFSM_STATE_SEMANTIC_INSPECTOR_SPEC.md`

Specification commit: `decf669fe78d12df8a323398fbb44f99e318ff9a`
