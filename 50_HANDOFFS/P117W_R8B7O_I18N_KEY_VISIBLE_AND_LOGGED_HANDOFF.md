# P117W R8B7O — I18N KEY VISIBLE + LOGGED HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS remote baseline: `ec3586496acdac83f155a248c46013e3001cbef4`.
- README-FIRST.md, PATCH_DELIVERY_CONTRACT.md and CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md remain authoritative.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256:
`baf3f173d7192ab8d24ad6fe20e7a93f0f5f50bc8e6baa578618bd53c9dc51dd`

Complete final file in ZIP:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Targeted result

- anonymous I18n triangle becomes `⚠ <exact.i18n.key>`;
- exact key is duplicated into `owasys-front.log` as `context.i18n_key`;
- log record also carries `error_code=OPUS_I18N_MESSAGE_MISSING`, `locale`, `module`, and active `trace_id`;
- valid translations and all non-missing I18n failures are unchanged.

## Root cause confirmed

The active OWASYS-local `ApplicationTranslationRuntime` catches missing-message exceptions and currently returns only `⚠`, which removes the key and prevents application-level failure logging. R8B7O corrects that active interception point directly.

## Stepwise owner flow

1. preflight HEAD/worktree + ZIP hash/member list;
2. rooted extraction to `H:\OPUS`;
3. PHP lint + `git diff --check` + site validation;
4. runtime refresh of `/en-EN/applications`, Data sources and Navigation;
5. inspect fresh `owasys-front.log` for `translation.missing` records and exact `i18n_key` values;
6. commit/push only after runtime acceptance.
