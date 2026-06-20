# OPUS P117SITE19 Status — Fullstack frontend/backend contract

Status: CONTRACT CREATED / READY FOR IMPLEMENTATION
Date: 2026-06-21
Repository: philstephibanez-wq/OPUS
Workspace: philstephibanez-wq/MAESTRO_WORKSPACE

## Purpose

P117SITE19 freezes the OPUS fullstack application model before further Composer authoring commands are added.

The user clarified and validated the target model:

- An OPUS application is a standalone fullstack site/project based on OPUS.
- Every OPUS application contains a clearly separated `frontend` and `backend`.
- `frontend` is the representation layer.
- `backend` is the business/data processing layer.
- Backend is not backoffice.
- Backoffice is a frontend/interface consuming the backend.
- Views replace Pages as the official frontend concept.
- Forms and menus are standard OPUS components, not architecture roots.
- OPUS owns the standard component library.
- Applications may own custom components.

## Workspace contract file

The definitions are now recorded in:

```text
CONTEXT/CONTRACTS/OPUS_FULLSTACK_FRONTEND_BACKEND_CONTRACT.md
```

## Implementation target

Next OPUS implementation work should align the generated application skeleton and Composer authoring commands with this contract.

Target skeleton direction:

```text
sites/<application_id>/
├── application.opus.json
├── public/
├── frontend/
│   ├── views/
│   ├── layouts/
│   ├── sections/
│   ├── custom-components/
│   ├── navigation/
│   ├── api-clients/
│   ├── assets/
│   └── theme/
├── backend/
│   ├── modules/
│   ├── services/
│   ├── actions/
│   ├── repositories/
│   ├── validators/
│   ├── policies/
│   ├── api-endpoints/
│   ├── runners/
│   ├── jobs/
│   ├── dto/
│   └── viewmodels/
├── resources/
└── docs/
```

## Next recommended milestone

```text
P117SITE20_CREATE_APPLICATION_FULLSTACK_SKELETON
```

Goal:

- implement/prepare `opus:create-application`,
- keep `opus:create-site` as alias if useful,
- generate explicit `frontend/` and `backend/` trees,
- remove mandatory blog/CMS vocabulary from the neutral skeleton,
- preserve compatibility path where needed,
- add smoke tests proving no backend/view mixing.
