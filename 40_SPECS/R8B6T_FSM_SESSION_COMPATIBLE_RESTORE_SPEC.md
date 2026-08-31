# R8B6T — FSM session compatible restore

Date: 2026-08-31
Status: SPEC — NEXT DELIVERY
OPUS baseline: `57e79e6b4a6eb5733ce62b1ebf483c350064507a`

## Observed regression

OWASYS `Application` remains usable while the visible `Navigation` resource (canonical `structure` state) and `Security` return HTTP 500.

The failure predates R8B6S5. The current repository shows a shared runtime dependency:

- `structure` renders through `OwasysNavigationRuntime::synchronize('structure')`;
- Security enters through `OwasysSecurityRuntimeCoordinator`, which first calls `OwasysNavigationRuntime::synchronize('security')`;
- the dedicated navigation runtime restores session key `opus.fsm.owasys-front.navigation` directly;
- the dedicated security runtime restores session key `opus.fsm.owasys-front.security` directly;
- neither dedicated restore path handles a persisted snapshot whose state was removed or renamed by a later EFSM definition.

The main OWASYS runtime already treats `OPUS_FSM_RUNTIME_SNAPSHOT_STATE_UNKNOWN:` as a recoverable compatibility condition by clearing that one snapshot and resetting the processor. This establishes the intended semantics.

## Root cause

`Opus\Fsm\FsmSessionStore` exposes only strict `restore()`. Runtime consumers that own versioned/dedicated EFSMs therefore duplicate — or omit — the compatibility policy. The omission leaves browser sessions pinned to obsolete state identifiers and produces a runtime exception before Navigation or Security can synchronize to their requested state.

## Generic OPUS evolution

Add `FsmSessionStoreInterface::restoreCompatible(FsmProcessor $processor): bool` and implement it in `FsmSessionStore`.

Contract:

- no stored snapshot: return `false`, processor remains at its current initial state;
- valid compatible snapshot: restore it and return `true`;
- only `OPUS_FSM_RUNTIME_SNAPSHOT_STATE_UNKNOWN:` is recoverable: remove that session snapshot, reset the processor to the current EFSM initial state, return `false`;
- every other invalid/corrupt snapshot condition remains an exception;
- no history rewrite, no filesystem cleanup and no unrelated session mutation.

OWASYS dedicated runtimes use this generic method:

- `OwasysNavigationRuntime::synchronize()`;
- `OwasysSecurityRuntimeCoordinator::enter()`;
- `OwasysSecurityRuntimeCoordinator::reauthenticate()`.

The existing main-runtime explicit recovery is left unchanged in this bounded delivery.

## Acceptance

1. Baseline is exactly `57e79e6b4a6eb5733ce62b1ebf483c350064507a` with a clean worktree before extraction.
2. PHP syntax and `git diff --check` pass.
3. A stale dedicated Navigation snapshot referring to a removed state self-recovers; Navigation reaches dedicated state `navigation` instead of HTTP 500.
4. The same stale Navigation snapshot does not prevent Security; Security reaches Navigation state `security` and Security EFSM state `authenticated`.
5. A stale dedicated Security snapshot whose state was removed self-recovers through the same generic policy.
6. Valid current snapshots remain restorable.
7. Corrupt snapshots and contract/data mismatches still fail closed; they are not silently reset.
8. No OPUS/OWASYS commit or push is performed by the assistant. Delivery is a native differential ZIP only.
