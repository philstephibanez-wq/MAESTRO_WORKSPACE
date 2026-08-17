# P117W R45B2A4AI — Canonical workflow FSM rebuild

Status: SPECIFIED — CODE DELIVERY REQUIRED
Date: 2026-08-17

## Owner correction

A4AH is rejected. It removed submenus and exposed the deeper problem: the OWASYS canonical FSM is currently modeled mainly as a navigation router instead of the complete OWASYS workflow.

Owner examples / mandatory semantics:

- `Applications -> create_app -> Application created` must be represented as workflow state progression, not flattened into a single navigation jump;
- `logout` must be connected from every applicable authenticated state;
- state-specific submenus must exist;
- the fixed FSM diagram remains the preferred visual direction, but it must represent the real workflow completely enough to be useful.

## Audited current source

Audited OPUS master commit: `e166474b5ab5ae7628a3b96bb382e19ccc03357a` (`opus_p117w_r45b2a4ag_diagram_menu_projection_separation`) plus owner-applied A4AH local menu projection.

Current `sites/owasys-front/config/fsm.json` contains only 11 declared states but 45 signals and 165 transitions.

The current model collapses business workflow milestones into transition signals. Example:

- `application_created` is declared as an `outcome` signal;
- `t_creation_created` is `creation --application_created--> data`;
- therefore there is no canonical `application_created` state.

At the same time, real creation workflow states already exist in a separate FSM:

`sites/owasys-front/config/creation.wizard.fsm.json`

with states:

- `basics`
- `security`
- `review`

This split means the principal OWASYS FSM diagram can never show the complete application-creation workflow.

The source/Git controller similarly emits command/outcome pairs while remaining in state `source`, e.g. preview, write, stage, unstage, commit, restore and their outcomes. These are currently rendered as self-loops instead of workflow progression.

Current `logout` semantics are also misrepresented by the diagram: `fsm.json` already contains explicit `logout -> login` transitions from the current declared states, but `OwasysFsmDiagramBuilder::LOGICAL_EDGES` hardcodes only one representative `build --logout--> login` edge.

## Root cause

There are four coupled modeling defects:

1. **module/page state conflation** — top-level page/module identifiers are treated as if they were the complete finite-state domain;
2. **workflow fragmentation** — creation has its own hidden secondary FSM while the principal FSM owns navigation;
3. **workflow outcomes flattened into signals/self-loops** — observable business milestones such as application creation completion are absent from `states[]`;
4. **diagram curation overrides canonical topology** — `FsmDiagramBuilder` uses a fixed hand-selected edge list and therefore hides real canonical transitions such as most logout relations.

Menu problems are an effect of this model. Menu repair alone is forbidden.

## R45B2A4AI target contract

### 1. One canonical finite-state workflow surface

OWASYS front must have one canonical application FSM for principal navigation and business workflow state.

The application-creation wizard states must no longer be invisible to the principal workflow model. They must be represented in the canonical state domain, either directly or through a generic OPUS hierarchical/compound-state mechanism whose expanded runtime state relation remains finite and deterministic.

No duplicate state ownership is permitted.

### 2. Observable workflow milestones are states

A state is required when the milestone changes the set of valid next operations, is persisted/observable, or is needed for deterministic workflow/profiler inspection.

Minimum creation workflow expected:

`Applications -> creation/basics -> creation/security -> creation/review -> application creating -> application created | application creation failed`

`application created` must therefore be a real canonical state, not merely an outcome label on `creation -> data`.

The same audit rule must be applied to Source/Git and build/preview workflows. Do not blindly turn every signal into a state; use explicit lifecycle states for observable workflow phases and keep instantaneous events as signals.

### 3. Global transitions are modeled once, expanded deterministically

Universal transitions such as `logout` and `change_app` must not be manually duplicated in menu projection code.

OPUS must provide a generic finite-state way to define global transition applicability (for example state groups/tags or an equivalent schema mechanism) while preserving the A4F rule that runtime normal transitions resolve to concrete finite source states.

`logout` must resolve from every applicable authenticated state to `login` and the diagram must visibly attest this relation.

NMI remains separate from normal global navigation.

### 4. Menu = FSM, with coherent hierarchy

The menu must again have submenus, but they are **state/workflow hierarchy**, not repeated copies of every global `open_*` transition.

Required behavior:

- top-level entries = principal workflow/module states;
- submenu entries = local child workflow states/actions relevant to that branch;
- global actions such as logout/change application/account remain global controls and are not duplicated under every menu branch;
- menu link/actionability is derived from the exact canonical transition relation and ACL/availability;
- disabled/unavailable workflow entries remain visually distinct and non-actionable.

### 5. Diagram = canonical workflow, not a curated sample

Remove the semantic dependence on hardcoded `LOGICAL_EDGES`.

The renderer may retain fixed presentation hints, grouping and lanes, but every displayed state/edge must come from the canonical FSM definition. Layout metadata may reduce crossings but must never suppress canonical workflow semantics merely for readability.

Global transitions may use a dedicated visual rail/bus if required for readability, provided every applicable source state is visibly connected.

The current-state highlight remains presentation only.

### 6. Typed signals retained

Keep the existing visual distinction for navigation / command / outcome / system signals and the cyan focus/highlight for currently permitted actionable transitions.

## Required source audit before code

Before changing implementation, enumerate actual workflow transitions emitted by:

- `RuntimeController.php`
- `RegistryController.php`
- `CreationController.php`
- `SourceController.php`
- build/preview runtime path
- account/password/login runtime

The canonical FSM must be derived from those real execution paths. No invented transition may be added solely to make the diagram look complete.

## Acceptance

1. Application creation visibly contains real states beyond a single `creation` box.
2. `Application created` is a canonical state.
3. Creation basics/security/review are visible in the principal workflow model.
4. `logout` is visibly connected from every applicable authenticated state.
5. Submenus are restored and branch-specific; no repeated global transition table appears under every top-level menu.
6. Source/Git lifecycle is audited and represented with explicit workflow states where lifecycle phase changes are real.
7. Diagram geometry stays fixed/readable and current state only changes highlight.
8. Signal type colors and cyan actionable focus remain.
9. No UI routing bypasses the canonical FSM.
10. Owner alone applies/validates/commits/pushes OPUS/OWASYS.
