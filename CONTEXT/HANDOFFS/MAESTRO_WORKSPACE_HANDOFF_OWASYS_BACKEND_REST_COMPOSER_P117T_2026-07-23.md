# MAESTRO_WORKSPACE HANDOFF — OWASYS P117T REST + COMPOSER BACKEND

Date: 2026-07-23
Status: REJECTED — SUPERSEDED BY P117U

Do not apply:

- `opus_owasys_p117t_backend_rest_composer.zip`
- SHA-256 `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`

P117T introduced root `bin/` and lowercase root `config/`, which are forbidden by the owner-confirmed OPUS root.

Authoritative replacement:

- specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`;
- handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`;
- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`;
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`.

P117U top-level entries are only:

```text
composer.json
Opus/
scripts/
sites/
```
