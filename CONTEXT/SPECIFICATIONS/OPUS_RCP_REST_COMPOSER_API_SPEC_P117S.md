# OPUS P117S — API REST RCP / COMPOSER

Date: 2026-07-23
Status: REJECTED — NON-AUTHORITATIVE

P117S is retained only as historical context. It must not be used as a source of implementation truth.

Rejected artifact:

- ZIP: `opus_owasys_p117s_rest_composer_api.zip`
- SHA-256: `acb79eec5cc0ce4023e79e53963f203a2c143b78fa754a4411036170f3c4220e`

Rejection reasons:

- introduced a new global `public/rcp` tree;
- embedded delivery audit/check helpers;
- excessive delivery footprint;
- conflicted with the no-root-pollution rule.

Authoritative replacement:

`CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md`

Canonical handoff:

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_BACKEND_REST_COMPOSER_P117T_2026-07-23.md`

Binding P117T product split:

```text
Current OWASYS SCORE pages = frontend
Secured OPUS REST API + Composer = backend
```

Do not apply the P117S ZIP.
