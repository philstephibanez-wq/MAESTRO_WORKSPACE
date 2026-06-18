# ADR 20260618 - OPUS system sites integrated into OPUS repository

Status: accepted
Scope: OPUS / MAESTRO_WORKSPACE / local UwAmp development

## Decision

OPUS system sites are no longer maintained as autonomous root repositories when they are part of the OPUS framework ecosystem.

The following sites are now integrated into the OPUS repository:

- RefBook: `H:\OPUS\sites\opus-refbook`
- Log&Play public identity site: `H:\OPUS\sites\logandplay`

The former autonomous local roots have been removed:

- `H:\OPUS_REF_BOOK`
- `H:\LOGANDPLAY.ORG`

The corresponding autonomous GitHub repositories were removed by the user.

## Current local host mapping

- `refbook.opus.localhost` serves `H:\OPUS\sites\opus-refbook\public`
- `logandplay.localhost` serves `H:\OPUS\sites\logandplay\public`
- `localhost` remains the UwAmp default local page

Apache/UwAmp is a local development binding only. It is not the source of truth.

## Source of truth

The source of truth for both integrated sites is now:

- local root: `H:\OPUS`
- GitHub repository: `philstephibanez-wq/OPUS`

Relevant OPUS commits:

- `6eb7a1d P117SITE7_REFBOOK_INTEGRATED_IN_OPUS`
- `96d2f7a P117SITE8_LOGANDPLAY_INTEGRATED_IN_OPUS`

## Consequences

- Do not recreate `H:\OPUS_REF_BOOK`.
- Do not recreate `H:\LOGANDPLAY.ORG`.
- Do not patch former autonomous repositories.
- Future RefBook and Log&Play work must target `H:\OPUS\sites\...`.
- MAESTRO_WORKSPACE must stay synchronized after every structural repository move.

## Technical TODO

- Standardize local tests with explicit IPv4 when using UwAmp: `curl.exe -4`.
- Fix/implement proper HEAD handling for RefBook pages so `curl -I` does not produce a false failure.
- Clean old `httpd.conf.P117*.bak` files after final user validation.
