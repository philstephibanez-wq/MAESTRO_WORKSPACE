# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- P117U base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- OPUS is the generic framework.
- Generic command entrypoint: `scripts/opus.php`.
- Framework classes use homonymous four-marker interfaces.
- Configuration uses `File` and explicit structured parsers.

## OPUS root

Allowed directories only:

```text
.git .github application Config DOC Opus packages runtime scripts sites tools vendor
```

Allowed root files only:

```text
.gitignore AGENTS.md composer.json composer.lock composer.phar LICENSE README.md
```

No root `bin/`, lowercase root `config/`, root `public/` or new top-level path.

## OWASYS

- OWASYS is one OPUS application.
- Current SCORE pages are its frontend.
- Secured REST plus Composer is its backend.
- Generated sites are independent OPUS applications.
- Contract: `OPUS_SITE_STANDARD_CONTRACT_CORE`.
- Role: `standard-opus-application`.
- Public entrypoint: `sites/owasys/www/index.php`.
- Canonical layout: `sites/owasys/application/default/layouts/layout.score`.
- Backend process: `127.0.0.1:8792`.
- Frontend process: `127.0.0.1:8000`.

## Mandatory code artifacts

### P117U

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- Files: 57
- Bytes: 73,261

### HF1

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`

### HF2

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- Files: 4
- Bytes: 10,447

HF2 corrects global Composer PHAR discovery and the REST HTTP/JSON error boundary. It introduces no new root.

P117S and P117T are rejected.

## Canonical documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
3. `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
4. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply P117U.
2. Apply HF1.
3. Apply HF2.
4. Start backend on `8792` with the shared secret environment.
5. Verify `/api/v1/status`.
6. Start frontend on `8000` with the same environment.
7. Validate Registry and password workflows.
8. Commit OPUS after owner acceptance.
9. Decide `sites/owasys_old` separately.
