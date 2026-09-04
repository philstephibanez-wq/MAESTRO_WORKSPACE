# P117W R8B7O — I18N VISIBLE KEY + STRUCTURED LOG SPEC

Status: DELIVERY CANDIDATE

## Authority

- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- OPUS GitHub baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- R8B7O supersedes the unvalidated I18n part of R8B7N for the current OWASYS runtime.

## Root cause

`sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php` is an OWASYS-local compatibility shim which currently catches `OPUS_I18N_MESSAGE_MISSING` and returns only the marker `⚠`. This suppresses the exact missing key and prevents the normal request-level exception/log path from carrying that key. The runtime screenshots therefore show anonymous triangles in Applications/Data sources/Navigation.

## Required behavior

For a genuinely missing message only:

- visible UI diagnostic: `⚠ <exact.i18n.key>`;
- structured OPUS log event on channel `i18n`, message `i18n.message_missing`;
- log context contains `error_code=OPUS_I18N_MESSAGE_MISSING`, exact `i18n_key`, active `locale`, active `module`;
- log entry uses the current `OPUS_TRACE_ID` when present;
- all other `TranslationException` failures remain exceptions.

The visible diagnostic is only a safety net. Expected UI labels must still be translated in supported locale catalogs.

## Scope

Changed file only:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

No REST/backend/FSM/ACL/catalog/topology change in this differential.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256:
`e57d6dbc37c18eafc6653d7814d7d869d49ea0332ebd942585886f84b4ec9749`

## Acceptance

- archive contains exactly the one complete file above;
- `php -l sites\owasys-front\application\default\services\ApplicationTranslationRuntime.php` passes;
- `composer opus:validate-site -- owasys-front` passes;
- existing anonymous I18n triangles become `⚠ <exact key>`;
- `sites/owasys-front/var/logs/owasys-front.log` contains `i18n.message_missing` entries with `i18n_key`, locale/module and matching trace_id;
- no non-I18n runtime regression.
