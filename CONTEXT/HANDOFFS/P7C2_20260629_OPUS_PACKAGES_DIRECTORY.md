# P7C2 — 2026-06-29 — OPUS packages directory

## Status

Validated in OPUS and pushed.

## OPUS references

- Repository: `philstephibanez-wq/OPUS`
- Latest OPUS commit: `6df37d4`
- Functional package directory commit: `8b25ba2`
- Tag: `OPUS_P7_OPUS_PACKAGES_DIRECTORY_CONTRACT_CORE`

## Decision confirmed

Official OPUS applications are Composer-installable packages.

Development monorepo convention:

```text
packages/
  opus-ref-book/
  opus-demo/
  opus-odbc-manager/
```

Each application package must own:

- `composer.json`
- `opus.application.json`
- PHP source
- routes/config
- ScoreTemplate views when HTML is rendered
- I18N resources
- package validation smoke

## Additional package to add

The LogAndPlay public portal must also be delivered as a Composer-installable OPUS application package:

```text
packages/logandplay-portal/
```

It must not be a loose copy or hardcoded external folder.

## Next OPUS milestone

Continue on ODBC:

`P7_ODBC_EXPLORER_READONLY_CORE`

Then:

`P7_ODBC_EXPLORER_SITE_APP_CORE`
