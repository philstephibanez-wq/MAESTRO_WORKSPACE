# P117W R45B2A4BR — Generated application canonical begin scaffold

## Status

CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Committed baseline

- OPUS `master`: `5fa113426e44f1c9f8489f8317affa34b755fe6d` — `opus_p117w_r45b2a4bq_entry_state_i18n_projection_isolation`.
- That committed baseline contains A4BO real `begin` semantics plus A4BP/A4BQ consumer compatibility.
- Menu behavior remains frozen.

## Runtime evidence closing the preceding integration sequence

Owner runtime evidence now shows OWASYS rendering normally with a real rectangular `begin` FSM state, `login` as an ordinary downstream state, translated human menus intact and no white pseudo-state marker.

The OPUS commit above confirms A4BO/A4BP/A4BQ were committed together. The remaining architectural gap is therefore no longer OWASYS runtime semantics: it is Composer generation.

## Root cause

`Opus/Scaffold/SiteScaffoldPlan.php` still emitted new generated applications using the pre-A4BO contract shape:

- frontend/fullstack: `initial_state = home`;
- backend: `initial_state = api`;
- no real `begin` state was emitted.

Consequently, new applications created after A4BO could still be born with the old direct-functional-state startup model even though generic OPUS and OWASYS now use the canonical real entry-state model.

A runtime synthesizer or hidden migration would violate the zero-fallback contract. The cause must be corrected at scaffold generation time.

## Canonical generation rule

Every newly generated OPUS application now contains one real FSM entry state:

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

The generated application then leaves `begin` only through an explicit signal-driven transition.

The FSM contract remains `OPUS_APPLICATION_FSM_V1`. A4BO already made the canonical entry declaration an explicit supported semantic form under that contract while retaining legacy V1 definitions without entry states. This milestone changes generator policy, not the wire/schema identifier.

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

Generated backend application FSMs now contain:

- real `begin`, `type=entry`, mapped to the existing `api` module;
- `initial_state = begin`;
- explicit `begin --dispatch_api--> api` transition;
- the existing `api --dispatch_api--> api` transition remains.

The separate REST request-processing FSM inside `backend.rest.json` is not the application FSM and is intentionally unchanged.

No backend JavaScript, TypeScript, Node/npm metadata or frontend asset is introduced.

## Generic runtime compatibility

`GeneratedSiteRuntime` already resolves the session FSM state from `FsmProcessor::initialState()` and dispatches `open_<target>` when the requested route differs from the current state. With the generated source state now `begin`, the first route request therefore executes the explicit generated transition rather than silently starting inside a functional state.

`FsmSiteLoader` derives module directories from each state's `module`. Mapping `begin` to `home` or `api` keeps the entry state semantic without inventing a physical module directory.

## Scope

Exactly one complete framework file changes:

- `Opus/Scaffold/SiteScaffoldPlan.php`

No OWASYS site file changes. No menu file changes. No new concrete framework class is introduced.

## Artifact

`opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold.zip`

SHA-256:

`726e17bf9f59769b4b83492a89c51fbf741ad3457e652641724147b341e5fac1`

## Validation performed

- current `SiteScaffoldPlan.php` baseline reconstructed byte-for-byte from OPUS blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1` before modification;
- PHP lint: OK;
- frontend scaffold smoke: `initial_state=begin`, real entry state, processor starts at `begin`, `begin --open_home--> home` succeeds;
- fullstack scaffold smoke: same canonical entry behavior;
- backend scaffold smoke: `initial_state=begin`, real entry state mapped to `api`, `begin --dispatch_api--> api` succeeds;
- login-enabled frontend smoke: `begin --open_login--> login` succeeds;
- no generated `application/begin` directory;
- no trailing whitespace;
- ZIP contains exactly one complete final-path framework file.

## Acceptance

1. Apply A4BR over OPUS commit `5fa113426e44f1c9f8489f8317affa34b755fe6d`.
2. Generate one new frontend/fullstack application and inspect `config/application.fsm.json`.
3. Confirm `initial_state=begin`, state `begin` has `type=entry`, and an explicit first transition reaches the requested functional state.
4. Open its DEV FSM diagram and confirm `begin` is a real ordinary draggable state, not a pseudo marker.
5. Generate one backend application and confirm `begin --dispatch_api--> api` in its application FSM.
6. Confirm no `application/begin` directory is generated.
7. Validate generated sites through the normal OPUS validation path.
8. Existing generated applications are not rewritten by this milestone.
