# P117W R45B2A4BZ2 R8B5D — Contextual EFSM remote layout persistence

State: DESIGN FROZEN — IMPLEMENTATION IN CURRENT WORK CYCLE

## Source-of-truth gate

This specification is based on a fresh same-cycle read of:

- `README-FIRST.md`;
- current OPUS GitHub `master` = `0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- `DEVELOPMENT_CONTRACT.md`, `ZERO_FALLBACK_CONTRACT.md`, `PATCH_DELIVERY_CONTRACT.md`, `GIT_AND_BRANCH_CONTRACT.md`;
- active `P117W_MICRO_EFSM_APPLICATION_SKELETON_ARCHITECTURE_SPEC.md`;
- current `OPUS_FSM_Diagram`, `FsmDiagramLayoutStore` + interface;
- current OWASYS-front `ApplicationFsmModel`, `FsmDiagramBuilder`, `FsmDesignerGateway`, `fsm-designer.js` and contextual SCORE partial;
- current OWASYS-back FSM provider, REST resource/operation catalogs and Composer provider registry.

## Runtime report

Owner confirms R8B5C recovered OWASYS-front, but right-button dragging of STATE and SIGNAL presentation objects is no longer available on contextual selected-application EFSM diagrams.

## Cause

The right-button drag implementation still exists in the generic OPUS renderer. It is emitted only when the diagram has a writable `FsmDiagramLayoutStore` client configuration.

For selected-application contextual diagrams, `OwasysApplicationFsmModel::snapshot()` currently calls:

`OPUS_FSM_Diagram::renderDefinition(..., persistLayout: false)`.

That disables `data-layout-draggable=1`, `data-layout-signal-draggable=1` and the generic right-button interaction script.

This `false` cannot simply become `true`: the current `FsmDiagramLayoutStore::discover()` resolves ownership from the web process `DOCUMENT_ROOT`, which is OWASYS-front. A selected application EFSM is intentionally read through secured REST and may live on another bastion. Enabling local discovery would therefore create a wrong filesystem authority and violate the OWASYS separation contract.

## Required architecture

R8B5D restores portable diagram geometry through explicit remote authority:

`browser right-drag -> owasys-front CSRF/ACL -> secured REST -> owasys-back -> allow-listed Composer -> generic FsmDiagramLayoutStore bound explicitly to selected application/EFSM -> atomic *.fsm.layout.json write -> response -> front`

No selected-application filesystem access is introduced in OWASYS-front.

No JavaScript is added under `sites/owasys-back`.

Layout metadata remains presentation-only. It may alter only canvas/state coordinates, transition presentation geometry and presentation markers. It never mutates STATE, SIGNAL, transition, GUARD, ACTION or runtime state.

## Generic OPUS evolution

### `OPUS_FSM_Diagram`

`renderDefinition()` gains an explicit external-layout authority input that is mutually exclusive with local `persistLayout=true` discovery.

The existing right-button drag script remains the single implementation for both local and remote persistence.

Layout client configuration can carry:

- writable flag;
- layout key;
- CSRF token;
- layout path;
- explicit same-origin action URL;
- bounded additional request fields supplied by trusted server code.

The generic script keeps the existing local `persist-fsm-layout` transport when no external request fields are supplied. When explicit fields are supplied, it sends those instead and accepts either HTML token rotation (legacy/local path) or JSON `csrf_token` rotation (OWASYS remote path).

### `FsmDiagramLayoutStore`

The generic store gains an explicit source-bound factory so backend code can bind the store to a known application root + canonical EFSM relative path without `DOCUMENT_ROOT` discovery.

It also gains a transport-neutral layout mutation operation which reuses the existing validation/normalization rules for:

- save-state;
- save-signal;
- save-marker;
- canvas bounds;
- transition presentation SVG paths;
- marker geometry.

The existing local HTTP/CSRF path remains intact.

## OWASYS-front

### Selected application snapshot

`OwasysApplicationFsmModel` derives the portable companion path from the server-resolved canonical EFSM path (`*.json -> *.layout.json`).

It checks the existing secured source listing. If the companion file exists it is read through the existing secured REST source boundary and validated. If it does not exist, absence is explicit and the deterministic renderer layout is used until the first drag creates the companion through the backend layout command.

A truncated source listing is an explicit error; absence is never guessed.

### Contextual rendering

`OwasysFsmDiagramBuilder` reuses the selected application's layout snapshot in both VIEW and DESIGN.

Only DESIGN mode with the existing `fsm:update` capability exposes writable right-button drag markers. VIEW remains read-only but uses the same persisted geometry.

The external persistence client configuration targets the existing OWASYS designer action URL and existing designer CSRF scope. The browser never supplies a site id; the selected application remains server-owned session context.

### Layout request gateway

`OwasysFsmDesignerGateway` gains exactly one new mutually-exclusive request kind for layout persistence.

It keeps the existing authentication, current-application, `efsm_id`, `fsm:update` and CSRF checks, validates the bounded OPUS layout command payload, then forwards it through secured REST.

## OWASYS-back

A dedicated application command provider owns contextual EFSM layout writes. It:

1. validates the REST/Composer request actor;
2. enforces backend `fsm:update` ACL;
3. resolves `site_id + efsm_id` with `FsmSiteLoader::resolveEfsm()`;
4. reads the canonical definition through `File` / `StructuredFileLoader`;
5. binds `FsmDiagramLayoutStore` explicitly to that source;
6. computes deterministic automatic layout for first-file creation;
7. applies the bounded presentation-only command;
8. atomically writes the derived companion layout file;
9. returns application id, efsm id, canonical source path/hash and layout path/hash;
10. emits metadata-only Profiler events.

REST resource:

`PUT /api/v1/applications/{site_id}/fsm/layouts/{efsm_id}`

Composer operation:

`fsm.layout.write -> owasys:fsm-layout-write -> owasys:fsm:layout-write`

Roles: admin/developer.

## Portable file naming

The companion layout path is derived deterministically from the canonical EFSM source:

- `config/application.fsm.json` -> `config/application.fsm.layout.json`;
- `config/security.fsm.json` -> `config/security.fsm.layout.json`;
- `config/fsm.json` -> `config/fsm.layout.json`.

No browser-authored source path is accepted.

## R8B5C commit observation

Current OPUS commit `0a0805ae...` contains the intended R8B5C `NavigationBuilder.php` change plus a separately modified `sites/owasys-front/config/fsm.layout.json` that was not part of the R8B5C ZIP. R8B5D treats that committed file as current authoritative baseline and does not delete, reset or rewrite it implicitly.

## Acceptance gates

### Static/repository

- exact baseline `0a0805ae0a9e0981c80f1304ea167bab4740afe1`;
- exact target blobs checked;
- clean worktree/index before apply;
- PHP lint all changed/new PHP;
- JSON parse through `StructuredFileLoader` for changed backend catalogs;
- `git diff --check` PASS;
- exact differential only;
- no JS/TS/Node/package artifact under `sites/owasys-back`;
- framework interface rule remains satisfied;
- `composer dump-autoload -o` PASS;
- `composer opus:validate-site -- owasys-front` PASS;
- `composer opus:validate-site -- owasys-back` PASS;
- `composer opus:validate-site -- essai` PASS.

### Runtime

Using a selected generated application such as `essai`:

1. open Structure DESIGN (`efsm_id=navigation`);
2. right-button drag one STATE; geometry moves live and persists without page reload;
3. reload; STATE remains at saved position;
4. right-button drag one SIGNAL card; geometry moves live and persists;
5. reload; SIGNAL remains at saved position;
6. repeat in Security DESIGN (`efsm_id=security`);
7. companion files are created only in the selected application and have the derived canonical names;
8. VIEW uses the saved layout but is not writable;
9. Sources + Git remains functional and can see the companion layout files;
10. front/back Logger/Profiler show the secured REST/Composer layout write path without secrets;
11. no selected-application filesystem access occurs from OWASYS-front;
12. existing R8B5 COMMAND/EVENT Security handshake and reauthentication ownership remain unchanged.
