# P117W R8B7O — I18N VISIBLE KEY + STRUCTURED LOG HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS remote baseline: `ec3586496acdac83f155a248c46013e3001cbef4`.
- README-FIRST and native ZIP stepwise workflow are authoritative.

## Delivery

Native ZIP: `R8B7O.zip`

SHA-256:
`e57d6dbc37c18eafc6653d7814d7d869d49ea0332ebd942585886f84b4ec9749`

Complete file in ZIP:

- `sites/owasys-front/application/default/services/ApplicationTranslationRuntime.php`

## Runtime target

Current anonymous I18n marker `⚠` becomes `⚠ <exact.i18n.key>`.
The same defect is duplicated into the structured OWASYS front log as `i18n.message_missing`, with exact key, locale, module and trace_id.

## First owner gate

Because earlier presentation candidates may still be applied locally, do not assume a clean worktree. Preflight must report current HEAD/status and verify archive SHA/member list before extraction. Unexpected HEAD or unrelated dirty files are stop conditions.

## Owner validation after apply

- syntax check changed PHP file;
- `git diff --check`;
- `composer opus:validate-site -- owasys-front`;
- reload Applications, Data sources and Navigation;
- verify visible missing keys and corresponding `i18n.message_missing` log records.

No commit/push before runtime acceptance.
