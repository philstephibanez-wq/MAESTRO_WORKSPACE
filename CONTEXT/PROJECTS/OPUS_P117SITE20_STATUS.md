# OPUS P117SITE20 Status

Status: DELIVERED
Date: 2026-06-21
Repository: philstephibanez-wq/OPUS
Milestone: P117SITE20_CREATE_APPLICATION_FULLSTACK_SKELETON

## Delivered OPUS commits

- `c60f1e3d8a24b5bb2720686c612e03620058d598` — `P117SITE20 create application command`
- `4fc79a1559467d78170152f461384372da30f2e8` — `P117SITE20 fullstack application scaffold plan`
- `a55a63492c4bae15e1bf701a7ca47c1854ae1955` — `P117SITE20 register create application command`
- `c0b6bd10b55c33f88831011e5226195efdb4be0b` — `P117SITE20 add create application composer script`
- `70c82f43ca168b03e695243d96b3378042c13713` — `P117SITE20 document fullstack skeleton`
- `b68933be7a3ac1635dcd19d18fa6bb3e35628eec` — `P117SITE20 add fullstack skeleton smoke`
- `ab32f8e9e71014e4bb31fed8ad57e1ce7aafc971` — `P117SITE20 fix generated front controller root`

## New command

```text
composer opus:create-application -- <application-id> --write
```

## Contract applied

A generated OPUS application is a fullstack application with two explicit roots:

```text
sites/<application_id>/
├── frontend/
└── backend/
```

Frontend owns representation:

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

Backend owns business/data processing:

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

## Validation command

```text
python tools/smoke_p117site20_create_application_fullstack_skeleton.py
```

Expected success marker:

```text
P117SITE20_CREATE_APPLICATION_FULLSTACK_SKELETON_SMOKE_OK
```

## Notes

- Existing `create:site` remains untouched for compatibility.
- New `create:application` is the canonical P117SITE19+ fullstack generator.
- Standard components stay owned by OPUS.
- Applications own custom components only.
- Backoffice remains a frontend specialization, never the backend.
- Generated `public/index.php` now resolves OPUS root from `sites/<app>/public` using three parent levels.
