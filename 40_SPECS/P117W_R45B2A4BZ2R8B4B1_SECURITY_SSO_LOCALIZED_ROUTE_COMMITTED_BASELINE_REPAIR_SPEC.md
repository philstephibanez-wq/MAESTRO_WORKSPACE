# P117W R45B2A4BZ2R8B4B1 — Security SSO localized route committed-baseline repair spec

State: DELIVERY TARGET — CURRENT GITHUB BASELINE VERIFIED

## Mandatory same-cycle source-of-truth gate

Before this delivery was built, the following were re-read directly from GitHub in the same work cycle:

- `MAESTRO_WORKSPACE/README-FIRST.md` current blob `43564921659d743ec86c2fa4886841af4fc13aeb`;
- MAESTRO common development, patch-delivery, Git/branch and clean-workspace contracts;
- current OPUS master commit history;
- all files directly participating in this correction.

Current OPUS master is exactly:

`c5e7de78f70d14efc3b8c42f4ec53026b47253cf`

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair`

## Input state

The owner checkout must be:

- HEAD exactly `c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- tracked worktree clean;
- index clean;
- no untracked files.

R8B4A2 is already committed/pushed. R8B4B1 must not expect or reconstruct the former 15-path dirty differential.

Exact current dependency blobs required by the applicator:

- `sites/owasys-front/config/routes.localized.json` -> `1ace98302b62a10fb2f817f60063fdfd3f08180c`;
- `sites/owasys-front/config/site.json` -> `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- `sites/owasys-front/application/security/controllers/SecurityController.php` -> `3a13204eb4177f0638f6c1eb7c98449cf8a86597`;
- `Opus/Http/LocalizedRouteResolver.php` -> `5c302833b1f597210d0b4c7044cb18d672871fbf`.

## Previous R8B4B failure

The superseded R8B4B applicator required obsolete HEAD `76b5919...` and therefore stopped on:

`P117W_R45B2A4BZ2R8B4B_HEAD_INVALID`

The owner then reported an empty `git status --short`. No write occurred.

This is recorded as a delivery-preflight construction error, not an OPUS runtime error.

## Runtime evidence and root cause

Structure already passes the selected-application authority gate:

- application `essai`;
- EFSM `navigation`;
- source `config/application.fsm.json`.

For Security, the correlated back request succeeds through secured REST and allow-listed Composer with HTTP 200. The front then fails with:

`OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`

Current R8B4A2 `SecurityController` explicitly contains view `sso`, exposes `view_sso`, and builds:

`securityUrl($locale, 'sso')`

which localizes canonical path:

`security/sso`

Current `routes.localized.json` declares the previous Security subroutes through `security/resources` but contains no `security/sso` entry. `LocalizedRouteResolver::localize()` correctly rejects the undeclared canonical path. The cause is therefore the OWASYS-front route catalog, not REST, backend Composer, ACL, Unicode/accent resolution or the generic resolver.

## Required correction

Modify only:

`sites/owasys-front/config/routes.localized.json`

Add:

`security/sso`

with:

- `tail: false`;
- exactly the 25 base-language keys already present under canonical `security`;
- each path derived as `<localized-security-path>/sso`;
- `sso` kept opaque and untranslated.

No framework code, backend code, REST route, JavaScript or EFSM definition changes are permitted in this slice.

## Applicator requirements

Before writing, the applicator must:

1. verify exact HEAD `c5e7de78...`;
2. require a completely clean worktree/index with no untracked files;
3. verify the four exact dependency blobs listed above;
4. verify current Security SSO view/url markers are present exactly once;
5. read route/site configuration through OPUS `StructuredFileLoader` and source bytes through OPUS `File`;
6. reject an already-present `security/sso` entry;
7. derive the 25 localized SSO paths from canonical `security`;
8. serialize with OPUS `Json`;
9. validate the staged catalog with the real OPUS `LocalizedRouteResolver`;
10. prove `localize()`, `resolve()` and `isLocalized()` round-trip for all 37 supported regional locales.

Write must use OPUS `File::writeAtomic()`.

After writing, the applicator must:

1. re-read the catalog through `StructuredFileLoader`;
2. require 25 SSO language paths;
3. require French `sécurité/sso` and English `security/sso`;
4. re-run real resolver round-trips across all 37 locales;
5. require HEAD unchanged;
6. require the only tracked diff to be `sites/owasys-front/config/routes.localized.json`;
7. require no staged/untracked files;
8. require `git diff --check` clean;
9. restore the exact original route-catalog bytes if any post-write check fails.

## Non-regression constraints

- no broad refactor;
- no silent fallback;
- no hidden alternate route;
- no backend change;
- no JS/TS/Node artifact under `sites/owasys-back`;
- no REST naming/transport change;
- no selected micro-EFSM authority change;
- assistant does not commit or push OPUS/OWASYS.

## Repository acceptance

Required success markers, in order:

`P117W_R45B2A4BZ2R8B4B1_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4B1_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4B1_APPLIED`

Then:

- `baseline_head=c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- `changed_path=sites/owasys-front/config/routes.localized.json`;
- `localized_route=security/sso`;
- `localized_route_languages=25`;
- `localized_route_locales=37`.

`git status --short` must then contain exactly one modified path: the localized route catalog.

## Runtime acceptance

After application:

1. `/fr-FR/sécurité` renders without `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`;
2. Security authority shows `essai / security / config/security.fsm.json`;
3. dedicated SSO view opens through localized routing;
4. provider/default-provider metadata is real and secret-free;
5. Structure remains `essai / navigation / config/application.fsm.json`;
6. Sources + Git remains functional;
7. one temporary STATE created in Security Conception persists after reload.

Only after these runtime gates should the owner commit/push R8B4B1.
