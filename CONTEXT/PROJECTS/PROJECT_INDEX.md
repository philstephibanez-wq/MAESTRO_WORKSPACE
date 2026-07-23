# Project Index — MAESTRO WORKSPACE

## OPUS

- Repository: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `05a0639cda2e271e8aa6e77e2b5d8f762d15f6b9`
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
- Backend process: `127.0.0.1:8792`.
- Frontend process: `127.0.0.1:8000`.

## Mandatory code artifacts

### P117U

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`

### HF1

- ZIP: `opus_owasys_p117u_hf1_fsm_contract.zip`
- SHA-256: `e711af28142a5ad287569c5107b99d41065498ea3bed70ec13b977007ae605d2`

### HF2

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`

### HF3

- ZIP: `opus_owasys_p117u_hf3_composer_result_contract.zip`
- SHA-256: `f0860491df311a997d92c0a82796e7e11921911721bf02e3a8b45aece4ce6f17`
- Files: 3
- Bytes: 5,965

HF3 corrects the Composer machine-result contract and adds the exact local secret file to the existing `.gitignore`.

P117S and P117T remain rejected.

## Critical security gate

The public OPUS repository tracks `runtime/owasys/backend-env.cmd` containing OWASYS service secrets.

Before further acceptance:

1. remove the file from Git and local storage;
2. rotate all three values;
3. commit and push the deletion and ignore rule;
4. restart both OWASYS processes with the new values.

Previous values are compromised because they entered public history.

## Canonical documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
3. `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF2_COMPOSER_RESOLUTION_SPEC.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_SPEC.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF2_COMPOSER_RESOLUTION_2026-07-23.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF3_COMPOSER_RESULT_CONTRACT_2026-07-23.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Resume order

1. Apply P117U.
2. Apply HF1.
3. Apply HF2.
4. Apply HF3.
5. remove and rotate exposed secrets.
6. regenerate Composer autoload.
7. start backend on `8792` and verify `/api/v1/status`.
8. start frontend on `8000` with identical new secrets.
9. validate Registry and password workflows.
10. commit OPUS after owner acceptance.
11. decide `sites/owasys_old` separately.
