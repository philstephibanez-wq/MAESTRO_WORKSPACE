# P117W R45B2A4BZ2 R8B5D2 — External Composer validation runner repair — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- CSS blob: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`.
- ScorePageRenderer blob: `0512c3427a190f4a6184710372d78e21f758b39f`.
- R8B5D1 is recorded FAILED/ROLLED BACK and MUST NOT be retried.
- R8B5D2 spec commit: `5a16a154fbe4387751549fb0b86c494b44ca824e`.

## Failure repaired

R8B5D1 reached preflight success but its internal post-write Composer validation failed with:

`OWASYS_FRONT_VALIDATE_FAILED:Could not open input file: H:\OPUS\composer.phar`

Owner showed empty `git status --short` and empty `git diff --check`; rollback restored the baseline.

Current OPUS root contains a tracked zero-byte file named `composer`. R8B5D2 therefore removes bare Composer subprocess execution from the applicator instead of adding a platform-specific hidden fallback.

## Functional correction retained

Exactly the same two-file source transformation as R8B5D1:

1. `sites/owasys-front/www/asset/css/fsm-native.css` — three FSM SVG `max-width: 100%` shrink rules become `max-width: none`, canvas remains scrollable;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php` — FSM CSS cache-buster becomes `p117w-r45b2a4bz2r8b5d1`.

No backend, FSM definition, persisted layout data, REST catalog, ACL, Composer registry or JS change.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b5d2_external_composer_validation_runner_repair.zip`;
- ZIP SHA-256: `a3185cf0a5ea546dcf8147536081c356415debad779e38df4f67ad2c21d5db22`;
- ZIP contains exactly `apply_a4bz2r8b5d2.php`;
- applicator SHA-256: `dd4decc9c8c5cfbb576d9d8a03cff5e8b0bca08847f6dc2a77112372343c3e98`;
- applicator size: 9899 bytes;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS.

## Deterministic test

The applicator logic was replayed end-to-end in a temporary Git repository with synthetic files containing the exact replacement anchors. The test passed:

- PREFLIGHT_OK;
- REPO_CHANGES_VERIFIED;
- APPLIED;
- exactly two modified paths;
- zero untracked files;
- clean index;
- `git diff --check` PASS;
- no `composer`, `composer.phar` or `validate-site` invocation remains in the applicator.

## Applicator gates

Before write:

- exact OPUS HEAD `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- clean tracked/index/untracked state;
- exact target blob SHAs;
- exact replacement anchors;
- generated renderer PHP lint;
- CSS fixed-geometry contract.

After write:

- renderer PHP lint;
- CSS contract revalidation;
- exact two-file differential;
- no untracked files;
- clean index;
- `git diff --check`;
- unchanged HEAD.

Success emits `composer_validation=external_terminal`.

## Owner controls after successful application

Run interactively from `H:\OPUS`:

1. `composer opus:validate-site -- owasys-front`;
2. inspect `git status --short` and `git diff --check`;
3. runtime DESIGN -> VIEW -> DESIGN and F5 in both modes;
4. STATE/SIGNAL geometry must keep identical intrinsic scale;
5. wide diagrams must scroll inside the canvas rather than shrink differently.

Do not commit/push until those gates pass.
