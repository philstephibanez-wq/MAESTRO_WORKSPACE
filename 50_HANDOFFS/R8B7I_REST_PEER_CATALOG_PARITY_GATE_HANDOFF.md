# R8B7I handoff — REST peer catalog parity gate

## Status

READY FOR IMPLEMENTATION AFTER R8B7H CLIENT-CATALOG CORRECTION.

## Trigger

R8B7H runtime acceptance exposed a deterministic `OPUS_REST_API_CATALOG_MISMATCH`: the back resource set had gained `source.stat` while the front client catalog had not. OPUS correctly rejected the request, but the mismatch was only discovered at runtime.

## Required implementation

Add a generic OPUS validation-time parity gate for local REST peers declared by the site `exchange` contract.

When validating a site:

- if `exchange.transport` is not `rest`, no parity check is required;
- if the declared peer application is not locally present, preserve separate-deployment compatibility and do not fail for absence alone;
- if the peer is locally present, resolve both declared REST resource catalogs according to their native client/server configuration semantics;
- compare canonical `RestResourceCatalog` fingerprints;
- fail validation explicitly when they differ.

The implementation must reuse `StructuredFileLoader` and `RestResourceCatalog`, introduce no runtime cross-application filesystem dependency, and leave the existing runtime fingerprint enforcement untouched.

## Non-goals

- no change to development-server port selection;
- no OWASYS-specific hardcoding;
- no I18n fallback change;
- no SCORE/FSM/layout change;
- no weakening of REST HMAC/ACL/SSO security.

## Acceptance

1. Corrected local `owasys-front` and `owasys-back` pass validation.
2. A controlled one-route catalog divergence fails validation before server launch.
3. A separately deployed/missing peer is not treated as invalid solely because it is not on the local filesystem.
4. Existing `RestClient` and `RestServer` fingerprint enforcement remains active.
5. Canonical dev-server commands remain unchanged and resolve front=8000, back=8080 from site configuration.
6. PHP lint, Composer validation and `git diff --check` pass.

## Owner workflow

The assistant delivers a native differential ZIP only after construction validation. The owner applies, validates and returns complete evidence before runtime acceptance. The assistant does not commit or push OPUS/OWASYS.
