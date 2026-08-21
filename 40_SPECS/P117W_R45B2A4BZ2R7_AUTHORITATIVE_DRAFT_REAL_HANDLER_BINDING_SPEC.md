# P117W R45B2A4BZ2R7 — Authoritative draft + real EFSM handler binding

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

OPUS baseline: `6a5926f2fccb0cbaa5bacba803bdfd18af1cf40e` (`opus_p117w_r45b2a4bz2r6_pure_efsm_state_designer`).

## Architectural invariant

OPUS is a framework whose execution engine is the EFSM.

The graphical designer is a development tool for that EFSM. It does not redefine STATE as page/module/route data, does not invent application guards/actions inside the generic engine, and does not treat a browser-authored JSON definition as authoritative executable input.

EFSM transition semantics remain:

- source state;
- signal USER/AUTOMATE;
- ordered developer-programmed guard references;
- ordered developer-programmed action references;
- native EFSM runtime operations kept distinct;
- target state.

## Root cause corrected in this slice

R6 made STATE editing semantically pure, but the draft transport still sent the entire browser-held `draft_json` back to the backend. The backend then applied the next semantic command to that browser-authored definition.

That left a semantic-authority bypass: a modified browser payload could inject unrelated definition fields and have them carried forward by an otherwise valid command.

R7 removes browser definition authority.

The authoritative non-persistent draft algorithm is now:

`canonical config/fsm.json + bounded semantic command history + current semantic command`.

For every designer mutation, the backend:

1. reloads canonical `config/fsm.json`;
2. verifies the canonical SHA-256 against the designer base SHA-256;
3. rejects any non-empty legacy `draft_json` payload;
4. replays every prior semantic command through `FsmDefinitionEditor`;
5. applies the current semantic command through the same editor;
6. returns the rebuilt validated draft.

There is no unbounded server-side replay store and no browser-authored raw definition authority.

## Real handler catalog

The handler catalog shown to the developer is derived from the real PHP registrations, not from descriptive keys in `fsm.json`.

### Guards

`OwasysFsmGuardHandlers` exposes the names produced by its actual `forConfig()` handler map, including application guards and the ACL guards actually registered for the current canonical FSM.

### Actions

`OwasysFsmActionHandlers` exposes the exact keys of the same handler map used to construct `FsmActionDispatcher`.

### Catalog metadata

Top-level `fsm.json` `guards` / `actions` text is optional description metadata only. It cannot create an executable handler.

Every existing transition guard/action reference is checked against the real catalog before the catalog is served.

## Generic OPUS EFSM editor evolution

`Opus/Fsm/Definition/FsmDefinitionEditor.php` gains one semantic operation:

`transition.handlers.update`

Payload:

- `transition_id`;
- ordered `guards` list;
- ordered `actions` list.

Rules:

- a referenced guard must exist in the authoritative guard handler catalog;
- a referenced action must exist in the authoritative action handler catalog;
- duplicate handler references are rejected;
- list order is preserved exactly;
- NMI guards remain forbidden;
- singular legacy `guard` / `action` aliases are normalized to plural lists when edited;
- source, signal, target and `runtime_operations` are not mutated by this operation;
- R6 STATE restrictions remain unchanged.

The editor also validates all existing transition guard/action references against supplied authoritative catalogs before and after semantic operations.

## Designer UI

Transition selection remains EFSM-only and shows:

- transition identity/scope/source;
- signal and signal origin;
- guards and real registration status;
- actions and real registration status;
- native runtime operations separately;
- target;
- layout diagnostic.

For an existing transition, the developer can edit the ordered guard/action bindings using only real registered handlers from the catalog. Manual text is accepted only when every entered ID exists in that real catalog.

NMI guard editing is disabled while NMI actions remain editable.

Standalone GUARD/ACTION code-authoring buttons remain pending in this slice. R7 binds real existing handlers; it does not yet generate or edit PHP handler implementations.

## Distributed path

Semantic mutations continue strictly through:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> response -> owasys-front`.

The front gateway derives the handler catalog server-side and adds it to the trusted Composer command envelope. The browser never supplies the authoritative catalog.

The existing REST/Composer route remains:

- `POST /api/v1/applications/{site_id}/fsm/drafts/commands`;
- operation `fsm.draft.edit`;
- Composer alias `owasys:fsm-draft-edit`.

No backend JavaScript is introduced.

## Native runtime operations

R7 does not edit `runtime_operations` and does not invent semantics for native primitives.

The existing validator/runtime parity of individual primitives is outside this slice and must be corrected explicitly rather than hidden inside handler binding.

## Changed OPUS/OWASYS paths after application

- `Opus/Fsm/Definition/FsmDefinitionEditor.php`
- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/default/services/FsmActionHandlers.php`
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`
- `sites/owasys-front/application/default/services/FsmHandlerCatalog.php` (new)
- `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/js/fsm-designer.js`
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`

No OPUS/OWASYS commit or push is performed by the assistant.

## Acceptance

- browser JavaScript no longer submits `draft_json`;
- backend rejects any legacy raw draft other than the empty sentinel `{}`;
- every draft is reconstructed from canonical FSM + validated semantic history;
- state-field smuggling through command history is rejected by the generic editor;
- catalog is derived from actual guard/action PHP registrations;
- existing dangling guard/action references prevent catalog publication;
- transition handler binding preserves explicit developer order;
- unknown/dangling guard/action binding is rejected;
- NMI guard binding is rejected;
- STATE remains pure R6 semantics;
- transition source/signal/target/native operations are unchanged by handler binding;
- no JavaScript is added to `sites/owasys-back`;
- PHP/JS syntax checks pass;
- owner validates both OWASYS applications after application.

## Next slice

After owner validation, add real GUARD/ACTION PHP authoring from the EFSM designer, still through the secured front -> REST -> back -> Composer path, so creation of a handler creates/updates real developer PHP and registration rather than only a string reference.
