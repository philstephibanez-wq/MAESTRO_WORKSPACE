# P117W R8B7N — GENERIC I18N DIAGNOSTIC + APPLICATION TOPOLOGY HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS remote baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` are authoritative.
- R8B7N supersedes R8B7M/R8B7L/R8B7K.

## Delivery

Native ZIP: `R8B7N.zip`

SHA-256:
`ba19399ccbd4b49d6397d043dcede126d489e8b621ef151783a850c53bd5a319`

Complete final files:

1. `Opus/I18n/Translator.php`
2. `sites/owasys-front/application/registry/templates/index.score`
3. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Result targeted

- Generic OPUS missing-I18n presentation becomes `⚠ <exact key>` for the specific `OPUS_I18N_MESSAGE_MISSING` condition; unrelated translation exceptions remain errors.
- Applications page uses translated labels and no literal English/French presentation labels.
- OWASYS core is `owasys-front` + `owasys-back`, side-by-side on desktop.
- Generated applications appear below in a distinct but visually connected group.
- Discovery/Singleton/SQLite/events diagnostic panels and raw technical metadata are removed from the primary Applications workspace.
- Create/select/clear/delete workflows remain unchanged at controller/ACL level.

## Local-state rule

The owner may currently have an earlier uncommitted Applications presentation candidate applied locally. Therefore the first owner gate is preflight + archive verification only. Do not extract until the complete output has been checked. Any unexpected HEAD or dirty path outside the known superseded Applications presentation files is a stop condition.

## Gate 1

Return complete output of:

- `git rev-parse HEAD`
- `git status --porcelain=v1 -uall`
- SHA-256 of `R8B7N.zip`
- ZIP member listing

Expected remote baseline HEAD: `ec3586496acdac83f155a248c46013e3001cbef4`.
Expected ZIP SHA-256: `ba19399ccbd4b49d6397d043dcede126d489e8b621ef151783a850c53bd5a319`.

## Gate 2 after preflight acceptance

Rooted extraction to `H:\\OPUS`, then:

- `php -l Opus\\I18n\\Translator.php`;
- `git diff --check`;
- `composer opus:validate-site -- owasys-front`;
- diff/status inspection.

Runtime acceptance follows only after static/site validation passes. No owner commit/push before runtime acceptance.
