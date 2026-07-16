# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat.

## Active priority

Complete the final human browser acceptance of OWASYS, then declare delivery and generate the official demo.

## Source of truth

- OPUS repository: `philstephibanez-wq/OPUS`
- OPUS branch: `master`
- Latest owner-validated OPUS commit: `745f64787123e48ca413511f6314c92b5dc868a9`
- Workspace repository: `philstephibanez-wq/MAESTRO_WORKSPACE`
- `H:/OPUS` is an owner development detail only

## OWASYS acceptance status

All known automated technical, UI-contract and HTTP recipes are green at OPUS commit `745f64787123e48ca413511f6314c92b5dc868a9`.

Versioned closure contract:

- `sites/owasys/config/delivery-acceptance.json`
- contract: `OWASYS_DELIVERY_ACCEPTANCE_V1`
- status: `technical-acceptance-complete-visual-acceptance-pending`
- smoke: `tools/smoke_owasys_delivery_acceptance.php`

OWASYS must not be declared delivered until the owner completes the browser recipe and `visual_acceptance.completed` is explicitly set to `true`.

## Confirmed automated markers

- `OWASYS_DELIVERY_ACCEPTANCE_SMOKE_OK`
- `OPUS_SMOKE_ALL_OK`
- `OWASYS_STRUCTURE_DRAFT_APPLY_UI_HTTP_SMOKE_OK`
- `OWASYS_RUNTIME_FSM_HTTP_SMOKE_OK`
- `OWASYS_SOURCE_HTTP_SMOKE_OK`
- `OWASYS_SOURCE_EDITOR_UI_SMOKE_OK`
- `OWASYS_SOURCE_GIT_WRITE_UI_SMOKE_OK`
- `OWASYS_REPOSITORY_OPERATOR_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_VALIDATE_SITE_OK: demo-app`

## Final browser recipe

1. Authenticate in OWASYS.
2. Select `demo-app`.
3. Open Source & Git.
4. Open an authorized file.
5. Make a reversible edit.
6. Preview the diff.
7. Confirm the validated save.
8. Prepare only application changes.
9. Commit with a bounded single-line message.
10. Verify HEAD and repository state.
11. Run Build preview.
12. Run generation and ZIP export.
13. Inspect essential screens for layout defects and placeholders.

## Security contract

- no free-form Git commands;
- no pull, push, reset or branch mutation;
- staging and commit limited to the selected application subtree;
- editor limited to `config/`, `application/`, `www/asset/`;
- traversal, absolute paths, `.git`, secrets and auth stores rejected;
- preview, validation, SHA-256 lock and atomic write required.

## Locked roadmap

1. Finish OWASYS visual acceptance.
2. Generate official demo through OWASYS.
3. User Book.
4. Reference Book.
5. LSTSAR.
6. KB.

## Permanent rules

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
REUSE EXISTING OPUS BRICKS.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

OPUS is a sub-project inside MAESTRO_WORKSPACE. OPUS is not the workspace.
