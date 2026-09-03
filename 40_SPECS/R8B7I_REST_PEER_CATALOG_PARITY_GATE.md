# R8B7I — REST peer catalog parity gate

## Problem

R8B7H exposed a systemic validation gap. OPUS REST correctly rejects requests when the client and server resource-catalog fingerprints differ, but `opus:validate-site` can currently report the two local OWASYS applications as valid before that divergence is detected.

The concrete incident occurred when `source.stat` was added to the back resource catalogs but omitted from `sites/owasys-front/config/rest.resources.json`. The first ordinary `source.read` request then failed with `OPUS_REST_API_CATALOG_MISMATCH`, causing a front HTTP 500 and visible loss of translated labels.

## Goal

Detect deterministic REST peer-catalog drift during validation, before the first runtime business request.

## Generic OPUS contract

1. The solution is generic OPUS behavior, not an OWASYS-only special case.
2. A site declaring `exchange.transport = rest` and `exchange.peer_application_id` participates in the parity gate.
3. If the peer application is locally present under the same OPUS root, validation resolves both peers' declared REST resource catalogs and compares their canonical `RestResourceCatalog` fingerprints.
4. If the peer is not locally present, validation remains deployment-safe and does not fail solely because a separately deployed peer is unavailable on the filesystem.
5. Client configuration `OPUS_REST_API_CLIENT_CONFIG_V1` resolves `resource_catalog` relative to its configuration file, matching `RestClient::fromConfig()` semantics.
6. Server configuration `OPUS_REST_API_SERVER_CONFIG_V1` resolves `resource_catalog` relative to the OPUS root, matching `RestServer::fromRoot()` semantics.
7. If both local peers are present and fingerprints differ, validation fails explicitly before runtime.
8. The validation must not weaken runtime fingerprint enforcement in `RestClient` or `RestServer`.
9. No cross-application runtime filesystem dependency is introduced; the comparison is a development/validation-time check only.
10. Configuration is read through `File` / `StructuredFileLoader` and catalog normalization through `RestResourceCatalog`.
11. No changes to OWASYS FSM, SCORE, I18n semantics, ACL, SSO, signing or business commands.

## Acceptance

- With the current corrected OWASYS front/back catalogs, both site validations pass.
- Removing one resource from either local peer catalog causes validation to fail deterministically before any server is launched.
- A site whose REST peer is not present locally remains valid if its own configuration is otherwise valid.
- Canonical `composer opus:dev-server -- owasys-front` and `composer opus:dev-server -- owasys-back` behavior and configured ports remain unchanged.
- Runtime REST catalog fingerprint checks remain active.
- `git diff --check` clean; changed PHP files pass `php -l`; Composer validation remains valid.
