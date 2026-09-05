# P117W_R8SEC1 — Persistent Security Quarantine Primitive

## Authority

- `README-FIRST.md`
- `00_COMMON_CONTRACTS/SECURITY_BASELINE_CONTRACT.md`
- `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md`
- `00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`

## Repository baseline

Implementation is prepared from current OPUS `master`, not from chat memory or a local checkout.

Existing generic security runtime contains `RuntimeSecretStore` / `RuntimeSecretStoreInterface` but no persistent security-quarantine primitive. Generated runtime and scaffold integration are intentionally deferred to the next bounded gate so this first implementation can be audited independently.

## Problem

The security contract requires a violation to survive process/application/server restart and remain fail-closed until an explicit administrative recovery procedure. A transient FSM state or session variable cannot satisfy this.

## Scope R8SEC1

Create a generic OPUS runtime primitive:

- `Opus/Security/Runtime/SecurityQuarantineInterface.php`
- `Opus/Security/Runtime/SecurityQuarantine.php`

The concrete class must satisfy the OPUS homogeneous-interface contract.

### Required behavior

1. Factory rooted at an OPUS site root.
2. Canonical durable store: `var/security/quarantine.json`.
3. Atomic persistence through OPUS `File`.
4. Structured read through `StructuredFileLoader`.
5. Exclusive process lock while creating the quarantine incident.
6. Idempotent activation: an already active quarantine keeps the original incident instead of silently replacing evidence.
7. Cryptographically random incident identifier.
8. Reason code validation and bounded format.
9. `isQuarantined()` reports presence of the quarantine artifact.
10. `state()` validates the complete stored contract and throws on malformed/incoherent data.
11. `assertBusinessAllowed()` is fail-closed: valid active quarantine throws; malformed existing artifact also throws through validation.
12. No unlock/delete/clear method exists in this primitive. Recovery is a separate administrative-plane contract and future bounded implementation.
13. Runtime artifact is non-versioned application data; Unix permissions are restricted where supported.

## Explicit non-scope

R8SEC1 does not yet:

- wire quarantine into `GeneratedSiteRuntime` bootstrap;
- add/modify generated FSM states;
- expose an admin recovery command;
- modify OWASYS;
- implement injection/XSS/CSRF/SSRF hardening layers.

Those are subsequent gates under the global security contract. This separation prevents an unreviewed unlock surface and keeps the first security primitive independently testable.

## Acceptance

- both PHP files lint;
- concrete class implements the homonymous interface;
- interface extends the four required OPUS framework interfaces;
- activation survives reconstruction of the PHP object because state is on disk;
- malformed existing store is not treated as unblocked;
- no clearing API is present;
- `git diff --check` passes after owner application.
