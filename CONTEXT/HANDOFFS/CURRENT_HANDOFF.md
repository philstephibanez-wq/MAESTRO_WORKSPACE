# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat.

## Active priority

Stop OWASYS delivery acceptance and perform an architectural remediation before any further feature, visual patch, demo generation or delivery declaration.

The current OWASYS implementation contains a confirmed contract violation: too much application and rendering logic is located under `sites/owasys/www`, and JavaScript is used to construct or move global interface elements that must be rendered by the backend.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest remediation-gate OPUS commit: `81b5944a4d9ed265c253dab19b6f759a85da66f8`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- OPUS site architecture contract: `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
- `H:/OPUS` is an owner development detail only

## OWASYS acceptance status

Previous automated technical and HTTP results do not authorize delivery.

Visual acceptance is suspended.

OWASYS must not be declared delivered, visually accepted or ready for official demo until the backend-first architecture is restored and the owner validates the resulting structure.

The previous status `technical-acceptance-complete-visual-acceptance-pending` is no longer sufficient because the architecture itself has been identified as non-conforming.

## Blocking architecture gate now installed

- OPUS smoke: `tools/smoke_owasys_backend_first_architecture.php`
- Contract marker: `OWASYS_BACKEND_FIRST_ARCHITECTURE_SMOKE_OK`
- Added to `tools/smoke_all_opus.php`.
- The global smoke is intentionally red while the current non-conforming architecture remains.
- The gate rejects a non-minimal `www/index.php`, HTML generation in the public entry point, hard-coded locale ownership in JavaScript, DOM-owned navigation/layout, and missing server-side navigation/layout files.
- No previous green smoke may be used to declare OWASYS compliant while this gate fails.

## Confirmed architectural defects

- `sites/owasys/www/index.php` contains application bootstrap, routing, session, FSM, I18N, registry access, HTML rendering and menu composition instead of remaining a minimal public entry point.
- The global header and horizontal menu are partially constructed or moved by JavaScript.
- `theme.js` mutates the DOM to move navigation, current application and authentication elements.
- Menu ownership is not clearly located under `application/default`.
- Some smokes validate implementation markers rather than the canonical OPUS architecture.
- The presence of a working visual result does not compensate for these contract violations.

## Mandatory target architecture

- `www/index.php` is a minimal PHP entry point calling `application/default/bootstrap.php`.
- `www` contains only the public entry point and public assets.
- Shared bootstrap, layouts, navigation, templates, views and I18N live under `application/default`.
- Controller-specific code lives under its controller directory in `application`.
- Navigation, current application context, permissions and final HTML are rendered by PHP backend.
- JavaScript is progressive enhancement only.
- No site behavior required for navigation or application operation depends on JavaScript.
- CodeMirror keeps a functional `textarea` fallback.
- I18N fallback is `[[cle.i18n]]`; a raw key proves an I18N bypass and is blocking.

## Exact next work

1. Audit every file under `sites/owasys/www` and classify it as public entry point, public asset or misplaced application code.
2. Produce a migration map from the current files to canonical `application/default` and controller directories.
3. Identify smokes that currently encode or approve the wrong architecture.
4. Present the architectural diff and migration sequence before destructive moves.
5. Migrate atomically and reversibly.
6. Keep the backend-first architecture smoke red until the real structure is compliant.
7. Validate navigation and core forms with JavaScript disabled.
8. Resume visual acceptance only after owner validation of the backend-first structure.

## Security contract

- no free-form Git commands;
- no pull, push, reset or branch mutation from OWASYS;
- staging and commit limited to the selected application subtree;
- editor limited to authorized application/config/public-asset paths;
- traversal, absolute paths, `.git`, secrets and auth stores rejected;
- preview, validation, SHA-256 lock and atomic write required;
- backend remains the authority for permissions, writes, Git, build and export.

## Locked roadmap

1. Remediate OWASYS architecture to backend-first OPUS compliance.
2. Re-run technical and no-JavaScript acceptance.
3. Complete owner visual acceptance.
4. Generate official demo through compliant OWASYS.
5. User Book.
6. Reference Book.
7. LSTSAR.
8. KB.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
BACKEND FIRST.
SERVER-RENDERED HTML FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.