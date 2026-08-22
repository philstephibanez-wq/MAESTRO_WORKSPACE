# P117W R45B2A4BZ2R7R1 — Single EFSM graphics authority

State: OWNER VALIDATION FAILED — SUPERSEDED BY R7R2

## Baseline

Intended OPUS baseline: `72101e0cfb77f2933284371e142d30b3d30073ad` (`opus_p117w_r45b2a4bz2r7_authoritative_handler_binding`).

Owner commit after attempted validation: `340d195907c7743154728578c255fe6ea46b7c14` (`opus_p117w_r45b2a4bz2r7r1_single_graphics_authority`).

## Intended correction

R7R1 intended to remove the false user-facing FSM destination, isolate read-only FSM projection from the host layout persistence, keep `sites/owasys-front/config/fsm.layout.json` as the single vertical graphics authority, and reset stale runtime snapshots after removal of the `workflows` state.

## Owner validation result

FAILED.

The real OPUS commit produced after validation differs from R7 in only one tracked path: `sites/owasys-front/config/fsm.layout.json`. The intended source/configuration changes were therefore not present in the owner baseline now on GitHub.

Consequences observed on the real runtime:

- `sites/owasys-front/config/fsm.json` still contains state `workflows` with `module=fsm`, `route=fsm` and visible navigation metadata;
- signal `open_fsm` remains `menu=true`;
- FSM CRUD menu signals remain;
- transition `g_open_fsm` remains;
- `config/routes.json` still maps `fsm -> open_fsm`;
- localized route `fsm` remains;
- the user-facing FSM entry therefore still exists;
- a POST used for graphics persistence fails first with `OPUS_FSM_DIAGRAM_LAYOUT_COORDINATE_INVALID`, then later saves repeatedly fail with `OPUS_CSRF_TOKEN_INVALID`;
- GET `/fr-FR/fsm` fails with `OPUS_FSM_DIAGRAM_SIGNAL_ORIGIN_INVALID`.

## Additional root causes found during failed owner validation

### 1. Single-use CSRF consumed before geometry validation

`FsmDiagramLayoutStore::applySaveRequest()` validates/consumes the layout CSRF token before validating state coordinates and presentation geometry. `CsrfTokenManager` is single-use. Therefore one malformed geometry request consumes the token and fails afterwards; the browser cannot rotate a token from the failed response and every retry reuses a stale token.

### 2. Client presentation geometry can emit invalid coordinates

The development drag script serializes derived state/signal/marker coordinates without a finite/canvas-bound validation step. The server correctly rejects negative/non-finite/out-of-range coordinates, but the client must not emit them.

### 3. Signal-origin normalization is not idempotent

`Diagram::signalOrigin('')` returns `unspecified`, but the same normalizer rejects literal `unspecified`. Definitions whose signals omit `origin` can therefore fail when metadata is normalized a second time. This is visible when rendering the backend FSM, whose signals currently omit `origin`.

## Disposition

R7R1 must not be considered validated or delivered. Its claims are superseded by P117W R45B2A4BZ2R7R2, which starts from the exact real owner baseline `340d195907c7743154728578c255fe6ea46b7c14` and treats all three runtime failures plus the still-present FSM menu at their causes.
