# P117W_R8SEC1 — Persistent Security Quarantine Primitive — Handoff

## Objective

Begin implementation of `SECURITY_BASELINE_CONTRACT.md` with the smallest generic OPUS primitive required to make a security quarantine durable across restarts.

## Delivery ownership

Assistant:

- reads current GitHub repositories;
- owns this spec/handoff;
- prepares native differential ZIP;
- does not commit/push OPUS/OWASYS.

Owner:

- verifies local gate;
- applies ZIP only after gate validation;
- runs validation;
- commits/pushes OPUS after acceptance.

## Files delivered

- `Opus/Security/Runtime/SecurityQuarantineInterface.php`
- `Opus/Security/Runtime/SecurityQuarantine.php`

No OWASYS file is modified in this gate.

## Security properties

- store at `<site>/var/security/quarantine.json`;
- durable across runtime/process restart;
- atomic write;
- exclusive activation lock;
- malformed existing artifact fails validation rather than allowing business execution;
- original active incident preserved on repeated activation;
- no programmatic unlock API in R8SEC1.

## Next security gates after acceptance

1. Wire `assertBusinessAllowed()` before generated business dispatch and add security events to Logger/Profiler.
2. Add `security_quarantine` / `security_recovery` to generated EFSMs and route `security_violation` NMI to quarantine.
3. Add separate administrator recovery command with fresh strong auth, ACL, audit and integrity validation.
4. Add generic boundary hardening for injection/XSS/CSRF/headers/traversal/SSRF/rate limits and corresponding negative tests.

## STOP conditions

Any unexpected local OPUS HEAD, dirty target path, extraction/hash error, PHP lint error, or validation error stops the workflow. Existing unrelated owner/runtime layout changes must not be reset.
