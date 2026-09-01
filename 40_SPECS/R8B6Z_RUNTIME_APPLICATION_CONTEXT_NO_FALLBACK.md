# R8B6Z — Runtime Application Context / NO FALLBACK

Status: BLOCKING REGRESSION CORRECTION
Baseline OPUS: 86c40c9bf1a782fc7d5d76e2436298c40c2e82c4 + owner-applied R8B6Y

## Evidence
Fresh owner runtime evidence after R8B6Y:
- GET /fr-FR/application returns HTTP 500.
- Front log trace `bcccfe4938f164d6d02cd6b3d18cf49a` reports `OWASYS_CONTEXT_RUNTIME_EFSM_UNKNOWN` at `ContextRuntimeCoordinator.php:35`.
- Menu/chrome labels render as missing markers because the exact `fr-FR` default catalog is sparse while runtime locale fallback is disabled.

## Root causes
1. `RuntimeController::renderState()` still enters an `application` context through `OwasysContextRuntimeCoordinator`, while R8B6Y correctly removed `application` from OWASYS host EFSM ownership. The runtime coordinator must therefore model `application` as a selected-application navigation context, not load an OWASYS host EFSM.
2. Regional catalogs were authored as deltas that depended on runtime fallback to base language catalogs. With NO FALLBACK, every selectable exact locale must own all visible messages it needs. The immediate French runtime must therefore use a complete exact `fr-FR` catalog; no parent-locale lookup is permitted.

## Contract
- No fallback or silent substitution is reintroduced.
- `application` never becomes a host EFSM again.
- Opening Application with a selected app synchronizes OWASYS navigation to the Application page but does not load/write `owasys-front/config/application.fsm.json` as the selected application's FSM.
- Exact locale catalogs are data authorities; missing exact messages remain explicit missing markers.
- The global follow-up must materialize complete exact catalogs for every active regional locale and remove fallback declarations/policies from OPUS/OWASYS.

## Acceptance
- `/fr-FR/application` no longer throws `OWASYS_CONTEXT_RUNTIME_EFSM_UNKNOWN`.
- Main OWASYS menu labels are restored in French from `fr-FR` itself, not from `fr`.
- Application designer identifies the selected application as owner of its FSM source.
- No write can target `owasys-front/config/application.fsm.json` when another application is selected.
