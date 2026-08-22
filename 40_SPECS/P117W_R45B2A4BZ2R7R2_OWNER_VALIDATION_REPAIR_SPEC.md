# P117W R45B2A4BZ2R7R2 — Owner validation repair

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact baseline

`340d195907c7743154728578c255fe6ea46b7c14`

Commit: `opus_p117w_r45b2a4bz2r7r1_single_graphics_authority`.

R7R2 is intentionally based on the actual owner baseline, not on the intended R7R1 result.

## Evidence and root causes

Owner logs and profiler data establish three independent failures plus one structural failure:

1. **FSM still in user navigation.** Current canonical `fsm.json` still contains state `workflows`, signal `open_fsm` with `menu=true`, FSM CRUD menu signals and transition `g_open_fsm`. `routes.json` and localized routes still expose `fsm`.
2. **Persistence first fails on geometry.** A layout POST fails `OPUS_FSM_DIAGRAM_LAYOUT_COORDINATE_INVALID`.
3. **Persistence then enters a CSRF failure cascade.** `FsmDiagramLayoutStore::applySaveRequest()` currently calls the single-use `CsrfTokenManager::assertValid()` before validating coordinates/geometry. A bad payload therefore consumes the token before failing; subsequent browser retries reuse the stale token and fail `OPUS_CSRF_TOKEN_INVALID`.
4. **Opening the still-present FSM destination fails diagram rendering.** `/fr-FR/fsm` fails `OPUS_FSM_DIAGRAM_SIGNAL_ORIGIN_INVALID`. Generic `Diagram::signalOrigin()` maps an omitted origin to `unspecified` but then rejects `unspecified` if normalized again. Backend FSM signals currently omit origin, exposing this idempotence defect.

## Required correction

### Generic OPUS — diagram persistence authority

`OPUS_FSM_Diagram::renderDefinition()` gains a final optional `bool $persistLayout = true` parameter.

When false, `FsmDiagramLayoutStore::discover()` is not called. `OwasysApplicationFsmModel` uses `persistLayout:false` because its selected-application diagram is a read-only projection and must not own or rewrite the OWASYS host layout.

### Generic OPUS — signal-origin normalization

`signalOrigin()` accepts exactly:

- `user`;
- `automatic`;
- `unspecified`;
- empty input, normalized to `unspecified`.

The normalizer becomes idempotent.

### Generic OPUS — robust layout payload

The client development drag persistence must serialize only finite, canvas-bounded coordinates. Non-finite SVG paths are dropped instead of being sent as invalid geometry.

Server-side coordinate validation remains strict.

### Generic OPUS — CSRF transaction order

The layout CSRF token format is checked before payload parsing, but the real single-use token is consumed only after the complete state/geometry payload has passed validation.

Therefore:

- malformed payload + valid token => payload error, token remains usable;
- valid payload + valid token => save succeeds and token is consumed;
- token reuse after successful save => `OPUS_CSRF_TOKEN_INVALID`.

### OWASYS — remove false FSM user destination structurally

From `sites/owasys-front/config/fsm.json`:

- remove state `workflows`;
- remove signals `open_fsm`, `create_fsm`, `read_fsm`, `update_fsm`, `delete_fsm`;
- remove all transitions referencing those objects;
- remove `workflows` from surviving finite-global `from_states` lists;
- validate every remaining state/signal/transition reference;
- validate the complete resulting definition through `FsmDefinitionValidator` and `FsmProcessor` before writing.

From route configuration:

- remove canonical `fsm -> open_fsm`;
- remove localized public route `fsm`.

The ACL resource/capability `fsm:update` remains because it authorizes the developer EFSM designer; it is not a user navigation resource.

### OWASYS — stale runtime snapshot

If the live session snapshot contains a state removed by this deployment, `OwasysRuntimeController` catches only `OPUS_FSM_RUNTIME_SNAPSHOT_STATE_UNKNOWN:*`, clears that snapshot, resets to the canonical initial state and emits Profiler event:

`fsm / runtime.snapshot.reset`

Other restore errors remain fatal.

### Graphics migration

`sites/owasys-front/config/fsm.layout.json` remains the single portable graphics authority:

- contract `OPUS_FSM_DIAGRAM_LAYOUT_V4`;
- `fsm_path=config/fsm.json`;
- `layout_direction=vertical`;
- preserve all surviving state and transition geometry;
- remove `workflows` and geometry for removed transitions;
- update `definition_sha256` to exact new `fsm.json` bytes.

## Differential paths

Exactly nine files after application:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/fsm.layout.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

No backend JavaScript/TypeScript is introduced.

## Applicator safety contract

- exact HEAD required: `340d195907c7743154728578c255fe6ea46b7c14`;
- clean worktree required;
- exact Git blob SHA preflight for all nine source files;
- all semantic transforms and PHP lints happen before first write;
- exactly nine resulting changed paths are verified after writes;
- any post-write verification failure rolls every written file back to its original bytes;
- second execution is refused.

## Acceptance

- no user menu `FSM`;
- `/fr-FR/fsm` is no longer a public application route;
- no canonical `workflows/open_fsm/FSM CRUD menu` remnants;
- one vertical `config/fsm.layout.json` graphics authority;
- dragging a state/signal no longer produces coordinate failure from invalid client geometry;
- one invalid geometry payload does not consume its valid layout CSRF token;
- signal-origin normalization accepts omitted/`unspecified` metadata safely;
- read-only application FSM projection never writes host layout;
- stale removed-state session resets with measured profiler event;
- PHP/JS lint and owner site validations pass.
