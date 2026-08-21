# P117W R45B2A4BZ2R6 — Pure EFSM state designer

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

OPUS baseline: `5b9d9835a864215725d849d8d3d318103192a75c` (`opus_p117w_r45b2a4bz2r5_developer_programmed_guards`).

## Invariant

OPUS is a framework whose execution engine is the EFSM. The graphical designer must expose EFSM semantics only.

A STATE is not a module, route, template, page, navigation item, ACL resource, action container or guard container.

For this slice, the editable STATE contract is deliberately minimal:

- identity: `id`;
- machine-level initial/final membership is displayed only when present in the canonical definition;
- incoming/outgoing/self-transition counts and outgoing signals are derived diagnostics only.

Existing OWASYS legacy/application metadata currently stored inside state records remain preserved for runtime compatibility, but the generic EFSM editor must not create or mutate them as STATE semantics.

## Generic OPUS correction

`Opus/Fsm/Definition/FsmDefinitionEditor.php` must:

- accept `state.create` only with `{id}`;
- reject any additional state field with `OPUS_EFSM_STATE_FIELD_FORBIDDEN:<field>`;
- reject legacy `state.update` with `OPUS_EFSM_STATE_UPDATE_NOT_SEMANTIC`;
- keep `state.rename` dependency-safe and update initial/final and transition references atomically;
- keep `state.delete` dependency-safe;
- preserve pre-existing non-EFSM compatibility metadata during rename until the separate runtime decoupling migration removes that legacy storage.

No new concrete OPUS framework class is introduced by this slice.

## OWASYS designer correction

The STATE inspector must show only:

- `id`;
- `initial`;
- `final` only if the canonical definition declares `final_state`;
- derived `incoming`, `outgoing`, `self`, `outgoing_signals`.

It must not show `type`, `module`, `route`, `template`, auth flags, navigation metadata or diagram metadata as STATE semantics.

The STATE toolbar for this slice is:

- create;
- rename;
- delete.

There is no generic `Edit state properties` operation because no mutable application metadata is part of a pure EFSM STATE contract.

The create form contains only the state identifier. The delete confirmation is visible only in delete mode.

Transition inspection remains read-only in this slice and is limited to EFSM/runtime-relevant information: source/scope, signal, signal origin USER/AUTOMATE, guards, developer actions, native runtime operations, target and diagram path diagnostic.

## Persistence

This slice keeps the existing draft-only mutation path. It does not publish to canonical `config/fsm.json`.

All semantic mutations continue through the required OWASYS distributed path already introduced by the prior slice:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> response -> owasys-front`.

## Acceptance

- state create emits only `{id}`;
- a state payload containing `module`, `route`, `template` or any other extra field is rejected by generic OPUS;
- `state.update` cannot mutate legacy/application state metadata;
- state rename preserves existing compatibility metadata while refactoring all EFSM references;
- state inspector contains no module/route/template/auth/navigation/diagram fields;
- transition inspector does not present route/module metadata;
- delete confirmation is hidden outside delete mode;
- PHP and JS syntax checks pass;
- OWASYS front/back validation remains required from the owner after extraction.
