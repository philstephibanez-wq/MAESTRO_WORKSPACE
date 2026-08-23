# P117W R45B2A4BZ2 R8B5 — SecurityContext + inter-EFSM COMMAND/EVENT foundation handoff

State: SPEC FROZEN — WAITING FOR OWNER R8B4C OPUS COMMIT/PUSH

## Current OPUS source-of-truth

GitHub `master` was re-read after owner reported R8B4C `réglé`.

It still points to:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

Therefore the accepted R8B4C system Security micro-EFSM registry repair is not yet part of the OPUS GitHub baseline.

Per `README-FIRST.md`, the assistant does not commit or push OPUS/OWASYS. The owner must commit/push the accepted R8B4C differential.

## R8B4C acceptance recorded

Owner report:

`réglé`

The R8B4C handoff has been updated to `OWNER RUNTIME ACCEPTED — OPUS COMMIT/PUSH REQUIRED BEFORE NEXT DIFFERENTIAL`.

## R8B5 source diagnosis completed

Current OPUS sources were re-read before specification.

Key facts:

- `FsmSiteLoader` already resolves named EFSMs and can create a processor for one named EFSM.
- `FsmProcessor` supports deterministic transitions, guards, runtime memory/stack and Profiler events.
- `FsmProcessorInterface` does not yet declare the existing `transition()` operation.
- `FsmActionDispatcher` executes only explicitly registered PHP actions.
- `FsmSessionStore` persists one independent processor snapshot under an explicit session key.
- OWASYS-front `SecurityController` still uses the host Navigation processor and Navigation session key as its runtime FSM.
- the active micro-EFSM architecture explicitly requires private EFSM states, inter-EFSM signal cooperation, COMMAND/EVENT distinction and SecurityContext writer/read-only ownership.
- selected-application source access from OWASYS-front already crosses secured REST; R8B5 must not introduce cross-application filesystem access.

## R8B5 design decision

R8B5 is the first runtime-ownership/network slice after definition-authority R8B4/R8B4C.

It will establish:

1. generic OPUS `FsmSignalBusInterface` + `FsmSignalBus` foundation;
2. additive `FsmProcessorInterface::transition()` contract alignment;
3. independent OWASYS-front SecurityContext runtime using its own `security` EFSM and session snapshot;
4. Navigation remains owner of Navigation state;
5. first bounded unicast COMMAND Navigation -> Security when entering Security context;
6. causally linked EVENT Security -> Navigation confirming Security context readiness;
7. real reauthentication state transitions owned by Security while Navigation remains in its own state.

The selected application's Security EFSM remains the design/diagnostic subject. OWASYS-front runtime Security state is `owasys-front/security`, not the selected application's runtime.

## No code ZIP yet — reason

Generating a differential before R8B4C is committed/pushed would violate the explicit source-of-truth gate: the assistant would have to target an uncommitted local state that cannot be re-read from GitHub.

This is an intentional blocking condition, not a deferred implementation choice.

Once the owner push is visible:

1. re-read exact OPUS HEAD and all candidate target blobs;
2. compare post-R8B4C against delivery baseline;
3. fix the exact R8B5 differential paths;
4. build the direct differential ZIP/applicator;
5. run deterministic construction/preflight tests;
6. update this handoff with artifact hashes and owner apply gates.

## Owner gate now

Commit/push only the already accepted R8B4C four-path differential. Do not mix R8B5 or unrelated changes into that commit.

Expected R8B4C concern remains:

- `sites/owasys-front/config/site.json`;
- `sites/owasys-front/config/security.fsm.json`;
- `sites/owasys-back/config/site.json`;
- `sites/owasys-back/config/security.fsm.json`.

After the push, R8B5 code delivery is unblocked.