# R8B6U — Application I18N locale-chain handoff

## Baseline

OPUS `master`: `57e79e6b4a6eb5733ce62b1ebf483c350064507a`.

Target source blob before change:
`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` = Git blob `092909fd4cf52e65ca76fdc52ee1330d4bb191dd`.

## Failure evidence

The captured `/en-IE/security` run proves that Navigation and Security EFSM synchronization succeeds. The subsequent selected-application catalog source read for `application/default/local/en-IE.json` fails with `OPUS_SITE_SOURCE_FILE_INVALID` when the regional file is absent, producing HTTP 500.

## Delivery

Native differential ZIP: `R8B6U.zip`.

Complete replacement file only:
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

## Repair

- imports canonical `Opus\I18n\Locale`;
- resolves application EFSM catalog candidates through `Locale::fallbackChain()`;
- uses the secured source listing to avoid requesting absent source paths;
- loads existing parent catalog(s) first, then regional catalog(s), merging with `array_replace`;
- shares one resolved message map between state and transition label projections;
- preserves `⚠` for unresolved visible keys;
- performs no fallback to French/default locale;
- leaves `SiteSourceWorkspace::read()` and exact source REST semantics untouched;
- rejects truncated source listings instead of treating them as evidence of absence.

## Artifact validation

The generated replacement was reverse-reconstructed to the pre-change source and reproduced the exact expected Git blob SHA `092909fd4cf52e65ca76fdc52ee1330d4bb191dd` before R8B6U transformations.

`php -l` passes on the replacement file.

## Runtime acceptance gate

After installation, validate Navigation first, then Security, on a regional locale whose selected application has only the parent-language catalog (e.g. `en-IE` with `en.json`). The run must not request the absent regional catalog path and must not return HTTP 500. Missing visible message keys must remain `⚠`.
