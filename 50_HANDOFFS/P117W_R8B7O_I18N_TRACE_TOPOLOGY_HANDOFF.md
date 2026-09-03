# P117W R8B7O — I18N TRACE + APPLICATION TOPOLOGY HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- R8B7O supersedes R8B7N and all earlier uncommitted Applications presentation candidates.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256: `37cb538bfe206a48be29073c3afbbad46dcbca4406a713e97ca3affbb6a3b27a`

Complete final files:

1. `Opus/I18n/ApplicationTranslationRuntime.php`
2. `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`
3. `sites/owasys-front/application/registry/templates/index.score`
4. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Target result

- Missing I18n renders `⚠ <exact.i18n.key>`, never an anonymous triangle.
- Missing key is duplicated to structured log and OPUS Profiler with `i18n_key`, locale, module, path and current trace ID.
- OWASYS core front/back is side-by-side on desktop.
- Generated applications are underneath in a distinct connected group.
- Diagnostic clutter is removed from the primary Applications workspace.
- No REST/back/FSM/ACL behavior change.

## Local-state rule

The owner may have R8B7L/R8B7M-style presentation changes applied locally. Gate 1 is therefore preflight and archive verification only. Any HEAD other than the baseline or any dirty file outside the known presentation/I18n candidate paths is a stop condition.

## Gate 1

Return complete output of:

- `git rev-parse HEAD`
- `git status --porcelain=v1 -uall`
- SHA-256 of `R8B7O.zip`
- ZIP member listing

Expected baseline: `ec3586496acdac83f155a248c46013e3001cbef4`.
Expected ZIP SHA-256: `37cb538bfe206a48be29073c3afbbad46dcbca4406a713e97ca3affbb6a3b27a`.

## Gate 2 after preflight acceptance

Rooted extraction:

`tar -xf "%USERPROFILE%\\Downloads\\R8B7O.zip" -C H:\\OPUS`

Then lint both PHP files, run `git diff --check`, `composer opus:validate-site -- owasys-front`, inspect status/diff, and only then proceed to runtime verification.

No commit/push before runtime acceptance.
