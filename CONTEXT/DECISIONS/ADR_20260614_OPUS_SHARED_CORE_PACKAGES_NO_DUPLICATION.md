# ADR 2026-06-14 — OPUS shared core packages, no framework duplication

## Status

Accepted.

## Context

The user confirmed that the original ASAP idea remains valid for OPUS: several websites or applications may use the framework, but the framework itself must not be duplicated into every site.

This decision complements:

```text
ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
```

OPUS_REF_BOOK is optional at delivery time, but optional does not imply a separate framework copy.

## Decision

OPUS must use a shared-core package topology.

```text
One OPUS framework core.
Several optional OPUS-powered sites/packages.
No framework duplication per site.
```

The source of truth should be organized so that OPUS core and official optional packages are versioned coherently.

Target source layout:

```text
OPUS/
  framework/Opus/              core framework
  packages/opus-refbook/       optional official RefBook site package
  packages/opus-user-guide/    optional future User Guide package
  tools/                       build, smoke, packaging and checks
  tests/                       core and package tests
```

`packages/` is preferred because RefBook and User Guide are optional deliverables, not mandatory core runtime.

## Runtime installation contract

A deployed site may live outside the OPUS source tree, but it must reference one shared OPUS core.

Valid runtime shape:

```text
OPUS_ROOT/
  framework/Opus/
  packages/opus-refbook/

UwAmp/www/OPUS_REF_BOOK/
  public/
  application/
  resources/
  opus-package.json            declares required OPUS core/version/root
```

Invalid runtime shape:

```text
site_a/framework/Opus/
site_b/framework/Opus/
site_c/framework/Opus/
```

## Package manifest contract

Each optional OPUS package must declare its dependency on OPUS explicitly.

Expected manifest fields:

```text
package_name
package_type
requires_opus_version
entrypoint
public_root
resources
i18n
assets
license_profile
publication_profile
```

No package may silently guess a framework path. If OPUS core cannot be resolved through the official manifest/config contract, startup must fail with a clear error.

## Consequences

- OPUS core remains clean and unique.
- OPUS_REF_BOOK can be optional without duplicating the framework.
- OPUS_USER_GUIDE can later follow the same package contract.
- The old separate `OPUS_REF_BOOK` repository is transitional only, not the long-term source of truth.
- Build scripts may generate separate artifacts from one coherent OPUS source tree.

Expected artifacts:

```text
OPUS-core.zip
OPUS-refbook-package.zip
OPUS-user-guide-package.zip
```

All artifacts must be clean: no active Twig, no legacy backups, no dead CSS overrides, no hidden fallback.

## Canonical wording

```text
OPUS has one shared framework core.
Official OPUS sites such as OPUS_REF_BOOK are optional packages powered by that core.
A package may be installed separately, but it must not embed or duplicate the framework.
```
