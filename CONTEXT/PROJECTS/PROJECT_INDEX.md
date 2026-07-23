# Project Index — MAESTRO WORKSPACE

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
NO ROOT BIN.
NO ROOT LOWERCASE CONFIG.
NO ROOT PUBLIC.
COMPOSER EXPOSES USER COMMANDS ONLY.
OPUS IS THE FRAMEWORK.
OWASYS IS AN OPUS APPLICATION.
OWASYS CURRENT PAGES ARE THE FRONTEND.
REST + COMPOSER IS THE OWASYS BACKEND.
CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
SECRETS NEVER ENTER ARGV OR LOGS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Repository: `philstephibanez-wq/OPUS`, branch `master`.
- Current committed head / P117U base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`.
- Generic framework only; no OWASYS business implementation under `Opus/`.
- Generic executables use existing `scripts/`.
- Global configuration uses existing `Config/` only when required.
- All concrete framework classes implement homonymous four-marker interfaces.
- Configuration crosses `File` and explicit structured parsers.
- Canonical site contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`.

## Canonical OPUS root

Admitted directories:

`.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Admitted root files:

`.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Root `bin/`, root lowercase `config/`, root `public/` and new top-level paths are forbidden.

## OWASYS

- One OPUS application under `sites/owasys/`.
- Current SCORE pages remain the frontend.
- Secured REST + Composer is its backend.
- One public PHP entrypoint: `sites/owasys/www/index.php`.
- Frontend owns forms/ViewModels/SCORE; no persistent business mutation.
- Registry/password implementations remain application-owned and execute through REST then Composer.
- Browser locale, FSM, I18n, ACL, local SSO and Auth0 proxy/bastion contracts apply.
- P117U specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`.
- P117U handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`.

## P117U differential

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`.
- SHA-256: `1ee231cbcbe9e5a4578aa6f50b7a83559f89b46f6916e93f682c50f360401e46`.
- Files: 55; bytes: 69,473.
- Top-level entries: `composer.json`, `Opus`, `scripts`, `sites`.
- P117S and P117T artifacts are rejected.
- `sites/owasys_old` remains until explicit owner deletion approval.

## Composer

Composer installs OPUS/dependencies and exposes stable user commands through `scripts/opus.php`. No smoke, audit, test or recipe alias belongs in `composer.json`.

Generic commands belong to OPUS. OWASYS commands are application-owned providers discovered from site configuration.

## Sites created by OWASYS

Independent OPUS applications under `sites/<site>/` using `application`, `config`, `www`, Singleton, FSM-module-first, browser locale, OPUS I18n, deny-by-default ACL, SSO/Auth0 proxy and SCORE.

`SiteScaffoldPlan` is the only canonical plan. No `public`, `application/states` or alternate fullstack tree is generated.

## OPUS Demo

After real P117U Composer/backend/browser/Auth0 acceptance and owner approval.

## User Book

After the compliant demo.

## Reference Book

After the User Book; SCORE technical documentation.

## LSTSAR

After OWASYS and documentation.

## KB

After LSTSAR.

## MAESTRO_WORKSPACE

Global decisions, contracts and handoffs. OPUS is a sub-project; OPUS is not the workspace.

## Resume order

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`.
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`.
4. Apply P117U to clean OPUS `36a8570…`.
5. Run real Composer/autoload and existing recipes outside Composer aliases.
6. Start REST backend and current frontend.
7. Validate Registry, password, browser, Auth0 and HTTPS.
8. Commit OPUS after owner acceptance.
9. Decide `owasys_old` separately.
10. Demo, User Book, Reference Book, LSTSAR, KB.
