# P117W R45B2A4BZ2 — EFSM graphical toolbar + state draft CRUD

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Feedback addressed

A4BZ1 deliberately rendered state/transition/condition mutation buttons disabled because that slice was read-only. This was an implementation-stage limitation, not an ACL denial. The presentation was nevertheless ambiguous: an administrator could reasonably interpret disabled controls as missing rights.

A4BZ2 removes that ambiguity and starts the first real semantic-editing slice.

## Scope

- replace the text-heavy designer toolbar with a compact graphical/icon-oriented toolbar;
- expose an explicit `fsm:update` capability badge when Design mode is authorized;
- enable graphical state Create / Edit / Rename / Delete for admin/developer;
- keep transition and condition mutation disabled until A4BZ3;
- apply every state semantic command to a validated draft only;
- keep canonical `config/fsm.json` unchanged until the later Publish slice;
- preserve the mandatory distributed path `owasys-front -> secured REST -> owasys-back -> allow-listed Composer` for each draft semantic command.

## ACL truth

Frontend authorization remains `fsm:update`.

Current OWASYS front ACL already grants:

- admin through `*:*`;
- developer through `fsm:*`;
- viewer does not receive update permission.

A4BZ2 also grants `fsm:*` to developer in the autonomous owasys-back ACL. Admin remains granted through `*:*`.

The designer displays `🔓 fsm:update` only after server-side authorization. Disabled Edit/Rename/Delete state buttons before a state is selected are contextual selection state, not an ACL representation.

## Generic OPUS first

A4BZ2 introduces generic framework components before the OWASYS adapter:

- `Opus\Fsm\Definition\FsmDefinitionValidatorInterface`;
- `Opus\Fsm\Definition\FsmDefinitionValidator`;
- `Opus\Fsm\Definition\FsmDefinitionEditorInterface`;
- `Opus\Fsm\Definition\FsmDefinitionEditor`.

Both concrete framework classes implement their homonymous interfaces. Each interface extends directly the four mandatory OPUS framework interfaces required by README-FIRST.

The editor exposes semantic commands, not JSON text replacement:

- `state.create`;
- `state.update`;
- `state.rename`;
- `state.delete`.

## State rename contract

`state.rename` is an atomic semantic refactor in the draft.

It migrates, when present:

- `states[].id`;
- `initial_state`;
- `final_state`;
- transition `from`;
- transition `next_state` / `nextState`;
- finite global `from_states`.

It never performs blind textual replacement.

Layout-key migration is not published in A4BZ2 because canonical persistence is still disabled. The later publish/layout refactor slice must migrate the corresponding `fsm.layout.json` state key atomically.

## State delete contract

Draft deletion requires explicit typed confirmation equal to the selected state ID.

Deletion is refused when:

- the state is the current canonical initial state;
- the state is the canonical final state;
- any transition references the state as source, target or finite global source.

No cascade deletion is allowed.

## Draft architecture

The complete canonical FSM definition is included in the Design-mode inspection payload with a SHA-256 of the exact live `config/fsm.json` source.

The browser carries the current non-authoritative draft for the lifetime of the design page.

For every state command:

1. owasys-front receives the SCORE designer POST with CSRF protection;
2. frontend rechecks `fsm:update`;
3. `RestClient` sends the draft, command and immutable `base_sha256` to owasys-back;
4. owasys-back REST authorizes the delegated actor;
5. the allow-listed Composer command `owasys:fsm-draft-edit` runs in-process;
6. backend re-reads the live FSM via OPUS File + StructuredFileLoader;
7. live source SHA-256 must still equal `base_sha256`;
8. generic `FsmDefinitionEditor` applies the semantic command;
9. generic `FsmDefinitionValidator` validates the resulting definition;
10. the normalized draft and diagnostics return through REST to the frontend;
11. the browser updates only its design projection.

No canonical file write occurs in A4BZ2.

A concurrent live FSM change causes `OWASYS_FSM_DRAFT_BASE_HASH_CONFLICT`; the draft is never silently rebased or overwritten.

## REST resource

`POST /api/v1/applications/{site_id}/fsm/drafts/commands`

Operation: `fsm.draft.edit`

Allowed REST roles: admin, developer.

Request data:

- `base_sha256`;
- `draft_json`;
- `command_json`.

Composer alias:

`owasys:fsm-draft-edit -> owasys:fsm:draft-edit`

Provider bootstrap:

`sites/owasys-back/application/fsm/console.php`

## Front gateway

New frontend service:

`OwasysFsmDesignerGateway`

The gateway is loaded by the autonomous owasys-front bootstrap and routed before runtime FSM menu POST handling.

It:

- accepts only the dedicated designer POST marker;
- requires authenticated identity;
- requires `fsm:update`;
- validates CSRF scope `owasys.fsm.designer`;
- delegates to the server-side OPUS REST client;
- returns JSON data only, never UI markup.

The normal SCORE UI remains generated by SCORE templates.

## Profiler

A4BZ2 adds real measured events only:

Frontend:

- `designer.draft_command.forwarding`;
- `designer.draft_command.failed`.

Backend:

- `designer.draft_command.received`;
- `designer.draft_command.validated`.

The generic RestClient sensitive-key list is extended with `draft_json` and `command_json`; full EFSM draft contents are therefore not copied into profiler payloads.

The application composition root marks the designer AJAX response as data so it does not fabricate `score.response.rendered` for JSON responses.

## Graphical toolbar

A4BZ2 uses icon-oriented buttons with compact captions/tooltips:

- View;
- Select;
- State + / Edit / Rename / Delete;
- Transition tools shown but pending/disabled;
- Condition tools shown but pending/disabled;
- Validate and Publish shown but pending/disabled;
- explicit unlocked `fsm:update` capability badge.

At narrower widths captions collapse and icons remain.

## State graphical interaction

Create:

1. click State `+`;
2. click empty diagram canvas;
3. SCORE inspector opens the state form;
4. submit validates through the distributed backend command;
5. accepted new state is projected as a dashed draft state at the clicked position.

Edit:

1. select a state;
2. click Edit;
3. edit canonical state properties in the SCORE inspector;
4. submit through backend validation;
5. inspector refreshes from normalized draft.

Rename:

1. select a state;
2. click Rename;
3. change canonical ID;
4. backend atomically migrates semantic references;
5. diagram state label/selection changes to the new draft ID.

Delete:

1. select a state;
2. click Delete;
3. type its ID as confirmation;
4. backend dependency analysis decides;
5. accepted non-referenced state disappears from the draft projection.

## Files introduced

Framework:

- `Opus/Fsm/Definition/FsmDefinitionValidatorInterface.php`
- `Opus/Fsm/Definition/FsmDefinitionValidator.php`
- `Opus/Fsm/Definition/FsmDefinitionEditorInterface.php`
- `Opus/Fsm/Definition/FsmDefinitionEditor.php`

owasys-front:

- `application/default/services/FsmDesignerGateway.php`

owasys-back:

- `application/fsm/console.php`
- `application/fsm/services/OwasysFsmDraftCommandProviderInterface.php`
- `application/fsm/services/OwasysFsmDraftCommandProvider.php`

Existing configuration/composition/UI files are updated by the differential applicator.

## Explicitly not in A4BZ2

- transition CRUD;
- condition/guard CRUD;
- editable Bézier handles;
- signal menu toggle mutation;
- canonical Publish/write;
- Git commit/push;
- persistent cross-page draft recovery;
- Undo/Redo.

These remain subsequent slices.

## Acceptance

1. admin entering Design mode sees `🔓 fsm:update`.
2. developer entering Design mode also receives state draft CRUD.
3. viewer cannot enter Design mode.
4. toolbar is graphical/icon-oriented rather than a long flat text row.
5. State Create is enabled immediately.
6. Edit/Rename/Delete enable when a state is selected.
7. accepted state commands traverse front -> REST -> back -> Composer.
8. state rename migrates semantic references in the returned draft.
9. initial/final/referenced state deletion is refused.
10. live `config/fsm.json` is unchanged after every A4BZ2 operation.
11. a live source-hash conflict blocks the next draft command.
12. transition/condition mutation remains disabled.
13. owasys-back contains no JavaScript or JS package/runtime dependency.
14. both applications retain Logger/Profiler correlation.

## Next slice

P117W R45B2A4BZ3 — transition + signal + condition CRUD/refactor, including explicit `Dans le menu utilisateur` signal mutation.