# P117W R8NMI17A — Handoff

Date: 2026-09-08

## Owner report

`essai` is HS on `127.0.0.1:8001` with `OPUS_FSM_ENTRY_STATE_ID_INVALID`.

## Evidence reviewed

- Fresh `essai` log: development server starts, first GET fails with `OPUS_FSM_ENTRY_STATE_ID_INVALID`; another request completes; a later unrelated path returns `OPUS_GENERATED_ROUTE_NOT_FOUND`.
- GitHub `sites/essai/config/application.fsm.json`: initial/entry state is `connexion` instead of canonical `begin`, and three local transitions share `(connexion, open_home)`.
- `FsmProcessor` requires a typed entry state to be `begin`, unique and initial, and rejects duplicate local `(from,signal)` transitions.
- `FsmDefinitionValidator` did not enforce those runtime invariants, allowing the semantic editor to persist invalid runtime definitions.
- Current `SiteScaffoldPlan::fsmConfig()` already generates valid `begin`; scaffold is not the cause.

## Delivery scope

Differential ZIP R8NMI17A:
- `Opus/Fsm/Definition/FsmDefinitionValidator.php`
- `sites/essai/config/application.fsm.json`

No front/back heartbeat work is included; owner explicitly deferred it.

## Owner validation required

Apply native ZIP in `H:\OPUS`, run PHP lint / JSON checks / autoload / `opus:validate-site -- essai`, then relaunch `essai` on port 8001 and verify `/` no longer returns `OPUS_FSM_ENTRY_STATE_ID_INVALID`.
