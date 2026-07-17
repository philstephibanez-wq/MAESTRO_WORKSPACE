# Project Index — MAESTRO WORKSPACE

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
BACKEND FIRST.
SERVER-RENDERED HTML FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Framework PHP principal.
- Repository: `philstephibanez-wq/OPUS`.
- Branch: `master`.
- Database access: ODBC-only.
- `Opus\Model`: official representation layer.
- Canonical site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`.
- All OPUS sites are backend-first and server-rendered.
- JavaScript is limited to progressive enhancement and must not own navigation, layout, permissions or business state.

## OWASYS

- Portable OPUS deliverable for OPUS users on supported Windows/Linux environments.
- Distribution contract: `OWASYS_DISTRIBUTION_V1`.
- Dev/prod based on `OPUS_ENV`.
- Delivery and visual acceptance are suspended pending architectural remediation.
- Confirmed violation: excessive application/rendering logic under `sites/owasys/www`.
- Confirmed violation: global UI elements are moved or composed by JavaScript.
- Required target: minimal `www/index.php`, public assets only under `www`, shared application code under `application/default`, controller-specific code under `application/<controller>`.
- Required target: backend-rendered navigation, layout, current application context, forms, permissions, validation, Git, build and export.
- Required target: core navigation and operation remain functional with JavaScript disabled.
- CodeMirror and Mermaid are allowed only as non-blocking enhancements with functional fallbacks.
- I18N fallback is `[[cle.i18n]]`; raw keys are blocking bypass defects.
- Existing technical and HTTP smoke results do not authorize delivery until structural conformity is restored.
- Next exact work: architectural audit, migration map, smoke correction, atomic backend-first remediation, then owner validation.

## OPUS Demo

Official demonstration to generate through OWASYS only after backend-first compliance, renewed technical validation and owner visual acceptance.

## User Book

After the compliant demo.

## Reference Book

After the User Book; official OPUS technical documentation rendered with ScoreTemplate `.score`.

## LSTSAR

Load / Secure / Transform / Store / Audit / Restore. After OWASYS and documentation. Model-driven + ODBC-driven, with independent source and transformed-target validation.

## KB

Resume after LSTSAR.

## LOGANDPLAY

Public identity and `logandplay.org` entry map; contractual alignment pending.

## MAESTRO_WORKSPACE

Global context, decisions and handoffs. OPUS is a sub-project; OPUS is not the workspace.

## Resume order

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
3. Audit `sites/owasys/www` and prepare the migration map.
4. Restore backend-first OPUS architecture atomically.
5. Re-run technical, no-JavaScript and visual acceptance.
6. Demo, User Book, Reference Book, LSTSAR, KB.