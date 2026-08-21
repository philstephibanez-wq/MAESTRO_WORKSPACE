# P117W R45B2A4BZ2R3 — EFSM state-semantic inspector

State: CORRECTION REQUIRED AFTER A4BZ2R2 UX VALIDATION

## Problem confirmed

A4BZ2R2 made state draft CRUD operational, but its state editor projects the raw OWASYS state object as one flat form (`type`, `module`, `route`, auth/navigation/layout fields). This is technically editable but is not a comprehensible FSM-state designer.

The user feedback is correct: the primary state inspector must describe the state as an FSM node first. OWASYS web projection metadata is secondary.

A second defect is visible in the same surface: the delete confirmation row can be displayed outside delete mode because author CSS for `.ow-fsm-state-field { display:grid }` overrides the HTML `hidden` presentation rule.

## Generic FSM truth

The generic OPUS `FsmProcessor` treats state identity and machine position as the FSM semantics:

- each state has a unique non-wildcard `id`;
- `initial_state` references the initial state;
- optional `type=entry` is constrained to the canonical initial `begin` state when entry semantics are present;
- transitions provide source, signal, guards/actions and target semantics.

Fields such as `module`, `route`, `template`, authentication requirements and navigation are OWASYS/application projection metadata attached to the canonical state object. They are not the primary mental model of an FSM state.

## Correct designer projection

The state inspector is reorganized into three layers.

### 1. État EFSM — primary

Always visible:

- state ID;
- FSM role derived from the complete definition: `initial`, `final`, or `normal`;
- entry marker when canonical `type=entry` applies;
- incoming transition count;
- outgoing transition count;
- outgoing signal list;
- self-loop count.

This section answers the graph questions first: what state is this, where is it in the machine, and how is it connected?

### 2. Projection OWASYS — secondary/collapsible

Application-specific fields remain available but are visually subordinate:

- OWASYS nature/type (`screen`, `workflow`, `result`, `system`, `entry` where canonical);
- module;
- route;
- template;
- authentication requirement;
- current-application requirement;
- user-navigation visibility/order/label.

The initial `begin` entry type is protected from casual mutation. A later dedicated machine-role command will handle changes of initial/final role instead of pretending that a generic application `type` dropdown is the FSM role.

### 3. Disposition — secondary/collapsible

Diagram hints are separated from state semantics:

- rank;
- order.

They are presentation hints and must never be described as behavioral state semantics.

## Edit-mode rules

### Edit

The primary section identifies the selected state and FSM role. The OWASYS projection and layout sections can be expanded when needed.

### Rename

Only the state identifier is presented. Atomic reference refactor remains the A4BZ2 contract.

### Delete

Only the selected state identity, dependency context and explicit typed confirmation are presented. The confirmation input must never be visible in ordinary Edit/Create/Rename modes.

### Create

Creation starts from state identity and graph position. OWASYS projection is a secondary section. The new draft state remains non-authoritative until Publish.

## Validation parity

The generic draft validator must not be weaker than the runtime FSM engine for state-role invariants. A4BZ2R3 therefore adds runtime-structural parity by validating accepted drafts through the generic OPUS `FsmProcessor` constructor after the editor's own diagnostic pass.

This catches, among other things:

- invalid/duplicate states;
- invalid initial state;
- ambiguous entry states;
- `begin` not being the initial entry state;
- invalid local/global/NMI transition source/target semantics.

No guard is executed by this validation step.

## UX acceptance

1. Selecting `begin` primarily shows that it is the **initial/entry FSM state**.
2. Module/route/auth/navigation no longer dominate the primary state panel.
3. Incoming/outgoing transition information is visible immediately.
4. OWASYS metadata is available under a secondary expandable section.
5. Layout rank/order is under a separate presentation section.
6. The delete confirmation field is invisible unless Delete is explicitly selected.
7. `begin` cannot be changed away from canonical entry semantics by ordinary state Edit.
8. Existing state CRUD distributed flow remains unchanged.
9. No canonical `fsm.json` write is introduced.
10. Transition/condition CRUD remains the next semantic slice.

## Architecture invariants

- `fsm.json` remains semantic source of truth.
- design draft remains non-authoritative.
- UI stays SCORE + frontend JS only in owasys-front.
- no JavaScript is introduced in owasys-back.
- semantic draft commands still traverse `owasys-front -> secured REST -> owasys-back -> allow-listed Composer`.
- Logger/Profiler correlation remains mandatory.

## Baseline

A4BZ2R3 applies only after a successfully applied A4BZ2R2 baseline.
