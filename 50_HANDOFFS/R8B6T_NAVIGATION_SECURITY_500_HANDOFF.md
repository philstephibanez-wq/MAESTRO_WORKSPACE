# R8B6T — Navigation / Security HTTP 500 handoff

Date: 2026-08-31
Status: DELIVERY PREPARATION
OPUS source authority: `57e79e6b4a6eb5733ce62b1ebf483c350064507a`

## Evidence from current OPUS

The visible `Navigation` page is the canonical `structure` state. Its render path invokes the dedicated Navigation EFSM runtime with requested state `structure`, mapped to dedicated state `navigation`.

Security uses `OwasysSecurityRuntimeCoordinator`; its first cross-EFSM step invokes the same Navigation runtime with requested state `security`, then restores the dedicated Security EFSM.

Both dedicated stores currently call strict `FsmSessionStore::restore()` directly. `FsmProcessor::restore()` throws `OPUS_FSM_RUNTIME_SNAPSHOT_STATE_UNKNOWN:` when a session snapshot contains a state absent from the current EFSM definition. The main OWASYS runtime already handles exactly that compatibility case by clearing/resetting the stale snapshot.

This explains the reported shape of the regression: Application can work while Navigation and Security share a failing dedicated-navigation restoration path.

## Delivery scope

R8B6T is intentionally narrow and root-cause based:

- generic OPUS `FsmSessionStore::restoreCompatible()` API + homonymous interface update;
- Navigation dedicated runtime switches to the compatible restore API;
- Security dedicated runtime switches both restore points to the same API;
- no catalog, route, ACL, template, JS or EFSM semantic change;
- no manual session deletion is part of the fix.

## Validation gates

Gate 1: owner verifies the expected HEAD and clean worktree, checks archive/hash, extracts the native ZIP and runs PHP lint + `git diff --check` + bounded diff review.

Gate 2, only after Gate 1 passes: fresh runtime test of Navigation and Security without manually clearing the browser/PHP session. This is required to prove self-healing rather than a cleanup workaround.

Gate 3: owner commits and pushes OPUS only after runtime acceptance, then returns the pushed SHA. MAESTRO_WORKSPACE is updated independently by the assistant.
