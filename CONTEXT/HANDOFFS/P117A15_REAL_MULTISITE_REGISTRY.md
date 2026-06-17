# P117A15_REAL_MULTISITE_REGISTRY

## Status

Validated runtime step: OPUS Server Control Plane now uses a real multi-site registry contract instead of the P117A14 shared-public-root placeholder.

## Scope

OPUS runtime changes only:

- `config/opus_server_sites.php`
- `framework/Opus/Server/ServerSiteDefinition.php`
- `framework/Opus/Server/ServerOverviewSnapshot.php`
- `framework/Opus/Server/ServerSiteSupervisor.php`
- `framework/Opus/Admin/AdminServerOverviewDashboardResponseRenderer.php`
- `framework/Opus/Runtime/NativeServerOverviewDashboardSmoke.php`

No OPUS `DOC/` file was added. The project handoff remains in `MAESTRO_WORKSPACE`.

## Contract

Each site now declares `id`, `label`, `host`, `site_type`, `engine_root`, `site_root`, `public_root`, `expected_fsm_state`, `auth_profile`, `acl_profile`, `routes_profile`, `api_profile`, and `enabled`.

The dashboard is read-only and admin-only. It may display internal roots only after the admin gate allows access. Public denial remains opaque: `Site temporairement bloqué. Contactez le support.`

## Runtime validation

Smoke gate: `P117A15_REAL_MULTISITE_REGISTRY_SMOKE`.

Expected highlights: `registry_count=4`, `has_real_registry_fields=true`, `denied_status=503`, `denied_is_public_response=true`.

## Next step

P117A16 should connect the admin dashboard through UwAmp/Apache with `opus.localhost` and `DocumentRoot` restricted to `H:\OPUS\public`.

P117A17 should add the real Auth + API SSO + FSM + ACL gate.
