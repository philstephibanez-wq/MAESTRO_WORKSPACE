# OWASYS P117T — REST + COMPOSER BACKEND SPECIFICATION

Date: 2026-07-23
Status: REJECTED — NON-AUTHORITATIVE

P117T must not be used or applied.

Rejected artifact:

- ZIP: `opus_owasys_p117t_backend_rest_composer.zip`
- SHA-256: `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`

Rejection reason:

- introduced root `bin/`;
- introduced lowercase root `config/`;
- both paths violate the only owner-confirmed OPUS root.

Authoritative replacement:

- specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`;
- handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`;
- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`;
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`.

Binding separation:

```text
OPUS = framework
OWASYS = OPUS application
OWASYS pages = frontend
REST + Composer = OWASYS backend
created sites = independent OPUS applications
```
