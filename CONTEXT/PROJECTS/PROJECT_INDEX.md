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

## Active artifact

- ZIP: `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256: `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- Files: 57
- Bytes: 73,261
- Top-level entries: `composer.json`, `Opus`, `scripts`, `sites`

P117S and P117T are rejected.

## Canonical documents

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Roadmap

1. Apply P117U to a clean OPUS base.
2. Remove the obsolete OWASYS template layout.
3. Run Composer and the existing repository recipes.
4. Validate the OWASYS frontend and backend together.
5. Commit OPUS after owner acceptance.
6. Decide `sites/owasys_old` separately.
