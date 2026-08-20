# P117W R45B2A4BR — Generated application canonical begin scaffold

## Status

OWNER RUNTIME VALIDATION IN PROGRESS

## Current committed baseline

- OPUS `master`: `dc9095c108842931bbfad184d88f5ae1c2480ee2` — owner commit `fsm` dated 2026-08-20.
- Its parent is `5fa113426e44f1c9f8489f8317affa34b755fe6d` — A4BQ.
- The `dc9095c...` commit changes only persisted OWASYS FSM layout data: `sites/owasys-front/config/fsm.layout.json`.
- The committed scaffold source remains blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1` before A4BR application.
- Menu behavior remains frozen.

## Root cause

`Opus/Scaffold/SiteScaffoldPlan.php` still emitted new generated applications using the pre-A4BO contract shape:

- frontend/fullstack: `initial_state = home`;
- backend: `initial_state = api`;
- no real `begin` state was emitted.

Consequently, new applications created after A4BO could still be born with the old direct-functional-state startup model even though generic OPUS and OWASYS use the canonical real entry-state model.

A runtime synthesizer or hidden migration would violate the zero-fallback contract. The cause is corrected at scaffold generation time.

## Canonical generation rule

Every newly generated OPUS application contains one real FSM entry state:

```json
{
  "id": "begin",
  "type": "entry"
}
```

and:

```json
"initial_state": "begin"
```

The generated application leaves `begin` only through an explicit signal-driven transition.

The FSM contract remains `OPUS_APPLICATION_FSM_V1`. This milestone changes generator policy, not the wire/schema identifier.

## Frontend/fullstack generation

`begin` is emitted as a real state using the existing `home` module and `/` route:

- `id = begin`;
- `type = entry`;
- `module = home`;
- `route = /`.

No `application/begin` module directory is created.

The ordinary generated transition matrix includes `begin` in its source-state set. Therefore the first requested route is entered explicitly, for example:

`begin --open_home--> home`

and, when a generated login page exists:

`begin --open_login--> login`

Profiler navigation is likewise an explicit transition from `begin` when requested.

## Backend generation

Generated backend application FSMs contain:

- real `begin`, `type=entry`, mapped to the existing `api` module;
- `initial_state = begin`;
- explicit `begin --dispatch_api--> api` transition;
- preserved `api --dispatch_api--> api` relation.

The separate REST request-processing FSM inside `backend.rest.json` is intentionally unchanged.

No backend JavaScript, TypeScript, Node/npm metadata or frontend asset is introduced.

## Generic runtime compatibility

`GeneratedSiteRuntime` resolves the session FSM state from `FsmProcessor::initialState()` and dispatches `open_<target>` when the requested route differs from the current state. With generated source state `begin`, the first route request therefore executes the explicit generated transition rather than silently starting inside a functional state.

`FsmSiteLoader` derives module directories from each state's `module`. Mapping `begin` to `home` or `api` keeps entry-state semantics without inventing a physical module directory.

## Scope

Exactly one complete framework file changes:

- `Opus/Scaffold/SiteScaffoldPlan.php`

No OWASYS site file changes. No menu file changes. No new concrete framework class is introduced.

## Delivery application semantics

The canonical OPUS/OWASYS delivery format is a differential ZIP containing complete files at their final repository paths.

When such a ZIP is extracted directly over `H:\OPUS`, the delivered complete file is already installed. An auxiliary patch/applicator must not subsequently attempt to transform the same file again.

Owner evidence on 2026-08-20 showed exactly this ordering issue: after direct extraction of the A4BR reissue, `SiteScaffoldPlan.php` had working-tree blob `c1832750c05642c8639f7ce8ed32676842cb7a79`; an auxiliary applicator expecting source blob `bac0a838...` then correctly rejected the already-transformed input as a baseline mismatch. This does not invalidate the installed A4BR target.

## Acceptance

1. Keep the directly extracted A4BR `SiteScaffoldPlan.php`; do not reapply or restore it before validation.
2. Confirm PHP lint and autoload generation succeed.
3. Generate one fresh frontend/fullstack application and inspect `config/application.fsm.json`.
4. Confirm `initial_state=begin`, state `begin` has `type=entry`, and explicit first transitions reach functional states.
5. Open its DEV FSM diagram and confirm `begin` is a real ordinary draggable state, not a pseudo marker.
6. Generate one fresh backend application and confirm `initial_state=begin`, `begin --dispatch_api--> api`, and preserved `api --dispatch_api--> api`.
7. Confirm no `application/begin` directory is generated.
8. Validate generated sites through the normal OPUS validation path.
9. Existing generated applications are not rewritten by this milestone.
10. Owner commits/pushes OPUS only after runtime acceptance.
