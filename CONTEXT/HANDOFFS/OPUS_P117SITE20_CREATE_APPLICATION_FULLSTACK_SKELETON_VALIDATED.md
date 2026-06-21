# OPUS P117SITE20 Create Application Fullstack Skeleton — Validated

Status: VALIDATED
Date: 2026-06-21
Repository: `philstephibanez-wq/OPUS`
Milestone: `P117SITE20_CREATE_APPLICATION_FULLSTACK_SKELETON`

## User validation

The user confirmed the P117SITE20 smoke test as OK and requested continuation.

Validated command:

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\smoke_p117site20_create_application_fullstack_skeleton.py
git status --short
```

Expected validated markers:

```text
CHECK_CREATE_APPLICATION_COMMAND=OK
CHECK_FRONTEND_BACKEND_ROOTS=OK
CHECK_VIEW_LAYOUT_SECTION_LINKS=OK
CHECK_COMPONENT_CONTRACTS=OK
CHECK_BACKEND_API_ENDPOINT=OK
CHECK_BACKOFFICE_NOT_BACKEND=OK
CHECK_NO_LEGACY_APPLICATION_ROOT=OK
CHECK_NEUTRAL_NO_BLOG_CMS_DEFAULT=OK
P117SITE20_CREATE_APPLICATION_FULLSTACK_SKELETON_SMOKE_OK
CHECK_CLEANUP=OK
```

## Contract validated

P117SITE20 validates the canonical fullstack OPUS application scaffold:

```text
sites/<application_id>/
├── frontend/
└── backend/
```

Frontend responsibilities:

```text
views/
layouts/
sections/
custom-components/
navigation/
api-clients/
assets/
theme/
```

Backend responsibilities:

```text
modules/
services/
actions/
repositories/
validators/
policies/
api-endpoints/
runners/
jobs/
dto/
viewmodels/
```

## Invariants confirmed

- Fullstack does not mean mixed responsibilities.
- Frontend and backend are mandatory and clearly separated.
- Backend is not backoffice.
- Backoffice is a frontend specialization consuming backend APIs.
- Views, layouts and sections form the HTML representation.
- Forms and menus are OPUS standard components.
- OPUS owns the standard component library.
- Generated applications own only custom components when needed.
- Neutral application scaffold must not impose blog/CMS vocabulary.
- Generated smoke application is removed after validation.

## Next recommended milestone

`P117SITE21_CREATE_VIEW_SECTION_COMPONENT_COMMANDS`

Goal: add authoring commands that target the new fullstack frontend structure:

```text
composer opus:create-view
composer opus:create-section
composer opus:create-component
```

with no business logic in frontend generated artifacts.
