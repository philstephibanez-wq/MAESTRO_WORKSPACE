# P117W R45B2A4AI — Full FSM workflow reconstruction

State: DESIGN LOCK / IMPLEMENTATION NEXT

## Baseline

Keep the validated visual/runtime improvements through A4AG:

- fixed readable classic FSM diagram;
- typed signal colors;
- actionable signal focus/click behavior;
- Account / Password semantic split;
- diagram/menu projection separation.

A4AH is rejected and is not an accepted baseline.

## Owner clarification — 2026-08-17

The owner states that the FSM still omits many states and gives the required semantic example:

`Applications -> create_app -> Application created`

The owner also requires `logout` to be connected to all states and requires submenus to remain part of the OWASYS workflow UI.

## Root diagnosis

Current `fsm.json` models a small set of page/module states and encodes many observable workflow conditions only as signals or self-loops.

It also expands every global navigation signal into one transition per concrete state. This creates:

- a dense near-complete graph;
- repeated submenu entries;
- artificial duplication of `open_*`, `change_app` and `logout`;
- loss of distinction between global navigation and local workflow;
- missing business result/intermediate states.

## A4AI canonical model

### 1. State categories

The canonical FSM must distinguish state categories explicitly:

- `screen`: stable routable UI state;
- `workflow`: business workflow/intermediate state;
- `result`: observable result state;
- `system`: authentication/session/system state.

A state may be non-menu and may be non-routable. NavigationBuilder must not require every state to have a direct route.

### 2. Signal categories

Keep explicit signal categories:

- `navigation`;
- `command`;
- `outcome`;
- `system`.

Signal color remains independent from menu visibility/actionability.

### 3. Global transitions

Evolve the generic OPUS FSM contract to support global transitions without duplicating them once per state.

Required semantics:

- a global transition applies from every allowed concrete state;
- exact state-local transition has precedence over global transition when both exist;
- global transitions are validated explicitly and cannot silently overlap ambiguously;
- global transitions are not NMI unless explicitly marked NMI;
- profiler records the concrete runtime source state even when the canonical transition source is global.

At minimum OWASYS uses global transitions for:

- `logout -> login`;
- `change_app -> registry`;
- section navigation signals whose semantics are genuinely universal.

### 4. Local workflow transitions

State-specific submenus are restored from local workflow transitions only.

Global navigation is not repeated inside every submenu.

Example required application workflow:

- state `registry` (Applications);
- command `create_app` / canonical creation command;
- explicit workflow/result state `application_created` where the business result is observable;
- failure path to explicit `application_creation_failed` where appropriate;
- subsequent navigation/continuation to application data/configuration states.

The implementation must audit every existing outcome/self-loop and decide whether it is:

- a true signal only;
- or an observable state that must become explicit.

This audit includes at least:

- application create/delete/select lifecycle;
- registry failures;
- login/password outcomes;
- source preview/write/conflict/stage/unstage/commit/restore outcomes;
- Git failures;
- build/runtime outcomes if present in current code.

### 5. Menu contract

The OWASYS menu has two layers derived from one FSM:

- top-level global navigation states;
- state-specific submenu exposing local user-triggerable workflow transitions.

No second menu registry is permitted.

Technical outcomes/system transitions remain visible in diagram/profiler but are not user menu controls unless explicitly declared user-triggerable.

### 6. Diagram contract

The diagram renders the complete canonical FSM, including explicit workflow/result states.

Global transitions use a readable shared bus/hub representation so `logout` is visibly connected to all applicable states without drawing a spaghetti bundle of duplicate curves.

Current state remains highlight-only; geometry remains fixed.

### 7. Runtime contract

`FsmProcessor` must resolve transitions in this order:

1. exact current-state transition;
2. matching global transition;
3. current-state wildcard/default fallback as currently supported;
4. NMI remains preemptive and separate from ordinary global transitions.

No route or UI layer may bypass transition resolution.

## Implementation gate

Do not deliver another presentation-only menu patch.

The next OPUS/OWASYS ZIP must implement the generic global-transition contract and the first complete audited OWASYS workflow model together, with tests proving:

- no duplicated universal transition families;
- `logout` applies from every concrete state;
- submenu entries differ by local state workflow;
- explicit application lifecycle states exist;
- diagram and menu remain projections of the same canonical FSM;
- no regression to Account/Password, ACL, I18n, SCORE, profiler or typed colors.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.