# P117W R8B7M — I18N TOPOLOGY CLEANUP HANDOFF

Status: READY FOR OWNER PREFLIGHT / APPLY

## Authority

- OPUS remote baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` and `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` remain authoritative.
- R8B7M supersedes the uncommitted R8B7K/R8B7L Applications-registry presentation candidates.

## Delivery

Native ZIP: `R8B7M.zip`

SHA-256:
`ef6f0945889338dc08cc524e08ce8fec453965ec5132967644c15b3cff1ad545`

Complete final files in the ZIP:

1. `sites/owasys-front/application/registry/templates/index.score`
2. `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

## Result targeted

- One OWASYS topology.
- `owasys-front` + `owasys-back` form the core and render side-by-side on desktop.
- Generated applications render below in a distinct group, with a continuous visual relationship to OWASYS.
- Main Applications workspace no longer shows discovery/Singleton/SQLite/events diagnostic panels.
- Raw technical registry metadata no longer acts as user-facing text.
- Applications-view labels use existing translated I18n keys covered by supported locale chains.
- No new backend, REST, FSM, ACL, controller or configuration behavior.

## Important local-state rule

The owner may currently have R8B7L applied locally to `sites/owasys-front/application/registry/templates/index.score`. Therefore R8B7M must not assume a clean worktree silently. The first owner action is the contractual preflight and archive verification only. If the only local modification is the known superseded R8B7L presentation file, the next step can explicitly replace it with R8B7M. Any other dirty path or unexpected HEAD is a stop condition.

## Stepwise next gate

Return complete output for:

- `git rev-parse HEAD`
- `git status --porcelain=v1 -uall`
- SHA-256 of downloaded `R8B7M.zip`
- ZIP member listing

Expected remote baseline HEAD: `ec3586496acdac83f155a248c46013e3001cbef4`.

Expected ZIP SHA-256: `ef6f0945889338dc08cc524e08ce8fec453965ec5132967644c15b3cff1ad545`.

After this gate passes, the next owner step is the standard rooted extraction to `H:\OPUS`, followed by diff/site/runtime validation. No owner commit/push occurs before runtime acceptance.
