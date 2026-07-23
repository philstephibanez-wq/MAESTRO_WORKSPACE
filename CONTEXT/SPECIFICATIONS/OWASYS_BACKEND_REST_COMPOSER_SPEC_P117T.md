# OWASYS P117T — REST + COMPOSER BACKEND SPECIFICATION

Date: 2026-07-23
Status: REJECTED — NON-AUTHORITATIVE

P117T must not be used or applied.

Rejected artifact:

- ZIP: `opus_owasys_p117t_backend_rest_composer.zip`
- SHA-256: `ad1494d92f068789d8363b4b6a7a823ff7b6be189d36f66724f92fec91baf2c5`

Rejection reason:

- introduced root `bin/`;
- introduced root lowercase `config/`;
- both paths violate the only owner-confirmed OPUS root.

Authoritative replacement:

- specification: `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`;
- handoff: `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`;
- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`;
- SHA-256: `1ee231cbcbe9e5a4578aa6f50b7a83559f89b46f6916e93f682c50f360401e46`.

Binding separation:

```text
OPUS = framework
OWASYS = OPUS application
OWASYS pages = frontend
REST + Composer = OWASYS backend
created sites = independent OPUS applications
```
