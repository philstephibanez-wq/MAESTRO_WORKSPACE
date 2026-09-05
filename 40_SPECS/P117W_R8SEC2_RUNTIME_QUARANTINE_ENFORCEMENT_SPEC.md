# P117W R8SEC2 — Runtime quarantine enforcement

## Status
READY FOR OWNER APPLICATION

## Authority
- `README-FIRST.md`
- `00_COMMON_CONTRACTS/SECURITY_BASELINE_CONTRACT.md`
- current OPUS `master`

## Baseline
OPUS master after R8SEC1: `1798962392f5eabab9068c0438e7f26eb0d2aba1`.

## Cause treated
R8SEC1 introduced the durable `SecurityQuarantine` primitive, but the generic generated runtime does not yet enforce it before business dispatch. The current scaffold also routes `security_violation` NMI back to normal business states (`begin`/`api`) and routes `critical_error` back to normal business states instead of a dedicated `fault` state.

## Contract
1. `GeneratedSiteRuntime` owns a `SecurityQuarantineInterface` instance for its site root.
2. `handle()` checks quarantine before loading routes/ACL/SSO, starting the application session or dispatching business work.
3. Active, malformed or unreadable quarantine remains fail-closed through `SecurityQuarantine::assertBusinessAllowed()`.
4. Generated application FSMs expose explicit non-business states `security_quarantine` and `fault`.
5. `* --security_violation/NMI--> security_quarantine`.
6. `* --critical_error/NMI--> fault`.
7. No ordinary generated navigation/dispatch transition originates from `security_quarantine` or `fault`.
8. Existing applications migrated in this livrable: `essai`, `owasys-front`, `owasys-back` receive the same explicit confinement/fault states and NMI targets without adding any automatic unlock transition.
9. `auth_required` remains authentication flow and is not reclassified as a security violation.
10. No administrative unlock mechanism is introduced in R8SEC2.

## Runtime response
A quarantined generated application may return a generic error response, but no business route, login, logout, profiler route, ACL decision, FSM business transition or SCORE page rendering may execute before quarantine enforcement. Management/recovery plane is a later isolated gate.

## Validation
- PHP lint of modified framework files.
- JSON decode of migrated FSM files.
- `composer dump-autoload -o`.
- `git diff --check`.
- Negative runtime test proving a persisted quarantine prevents generated runtime business execution after runtime reconstruction.
- FSM inspection proving NMI targets are `security_quarantine` and `fault`.

## Non-goals
- admin recovery/unlock;
- HMAC/tamper-evident strengthening of the quarantine artifact;
- OWASYS custom runtime enforcement wiring beyond FSM migration;
- injection/XSS/CSRF hardening phases, which remain subsequent security-baseline gates.
