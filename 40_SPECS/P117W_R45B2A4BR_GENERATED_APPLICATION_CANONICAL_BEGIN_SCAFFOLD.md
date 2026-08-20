# P117W R45B2A4BR — Generated application canonical begin scaffold

## Status

OWNER COMMITTED / FRESH-GENERATION ACCEPTANCE PENDING

## Canonical baseline

- OPUS `master`: `3e5d9e18b19015807b6d1320b5d93c3bcd21f571`.
- Commit: `opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold_reissue_dc9095c`.
- Direct parent: `dc9095c108842931bbfad184d88f5ae1c2480ee2`.
- A4BR changes exactly `Opus/Scaffold/SiteScaffoldPlan.php`.
- Menu behavior remains frozen.

## Root cause

Before A4BR, `Opus/Scaffold/SiteScaffoldPlan.php` still emitted new generated applications using the pre-canonical startup shape:

- frontend/fullstack: `initial_state = home`;
- backend: `initial_state = api`;
- no real `begin` entry state.

That allowed newly created applications to reintroduce the old direct-functional-state startup model after generic OPUS/OWASYS had moved to a real FSM entry state.

A runtime synthesizer or hidden migration is forbidden by the zero-fallback contract. The correction therefore belongs at scaffold generation time.

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

The FSM contract remains `OPUS_APPLICATION_FSM_V1`; this milestone changes generator policy, not the schema identifier.

## Frontend/fullstack generation

`begin` is emitted as a real state using the existing `home` module and `/` route:

- `id = begin`;
- `type = entry`;
- `module = home`;
- `route = /`.

No `application/begin` module directory is created.

The ordinary generated transition matrix includes `begin` in its source-state set. Therefore the first requested route is entered explicitly, for example:

`begin --open_home--> home`

and, when present:

`begin --open_login--> login`

Profiler navigation is likewise reachable through an explicit transition from `begin`.

## Backend generation

Generated backend application FSMs contain:

- real `begin`, `type=entry`, mapped to the existing `api` module;
- `initial_state = begin`;
- explicit `begin --dispatch_api--> api` transition;
- preserved `api --dispatch_api--> api` relation.

The separate REST request-processing FSM inside `backend.rest.json` is intentionally unchanged.

## Generic runtime compatibility

`GeneratedSiteRuntime` resolves the session FSM state from `FsmProcessor::initialState()` and dispatches `open_<target>` when the requested route differs from the current state. With generated source state `begin`, the first route request executes the explicit generated transition instead of silently starting in a functional state.

`FsmSiteLoader` derives module directories from each state's `module`. Mapping `begin` to `home` or `api` preserves entry-state semantics without inventing a physical module directory.

## Scope

Exactly one complete framework file changed:

- `Opus/Scaffold/SiteScaffoldPlan.php`

No OWASYS site file changes. No menu file changes. No new concrete framework class is introduced.

## Current evidence classification

The owner commit `3e5d9e18...` proves the A4BR source delta is reconciled in canonical OPUS `master`.

The 2026-08-20 supplied OWASYS runtime capture proves the current OWASYS navigation/REST request is healthy, including the `registry --open_applications--> registry` global transition and HTTP 200 registry request. It does not prove that a site generated after A4BR contains and executes the new scaffolded `begin` state.

The selected generated application `essai2` is represented in that capture by records dated 2026-08-19, before A4BR was committed. It is therefore excluded from A4BR fresh-generation acceptance.

## Acceptance

1. Generate one fresh frontend/fullstack application after OPUS commit `3e5d9e18...`.
2. Confirm its `config/application.fsm.json` contains `initial_state=begin`.
3. Confirm state `begin` has `type=entry`, maps to `home`, and explicit first transitions reach functional states.
4. Start the fresh generated application and confirm first functional routing occurs through a real transition from `begin`.
5. Open its DEV FSM diagram and confirm `begin` is a real ordinary draggable state, not a pseudo marker.
6. Generate one fresh backend application after the same OPUS baseline.
7. Confirm backend `initial_state=begin`, real entry state mapped to `api`, `begin --dispatch_api--> api`, and preserved `api --dispatch_api--> api`.
8. Confirm no `application/begin` directory is generated.
9. Validate both fresh sites through the normal OPUS validation path.
10. Existing generated applications are not rewritten by this milestone.

## Next package gate

No next OPUS/OWASYS source package is specified before the acceptance above. If acceptance passes, A4BR closes and the next generic FSM propagation boundary may be selected. If acceptance fails, the next package is the smallest OPUS root-cause correction supported by the fresh-site evidence.
