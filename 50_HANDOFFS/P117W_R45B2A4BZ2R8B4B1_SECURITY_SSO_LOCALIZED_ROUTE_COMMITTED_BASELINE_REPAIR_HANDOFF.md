# P117W R45B2A4BZ2R8B4B1 — Security SSO localized route committed-baseline repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Same-cycle GitHub verification

Current mandatory control sources were re-read before artifact construction:

- `README-FIRST.md` blob `43564921659d743ec86c2fa4886841af4fc13aeb`;
- MAESTRO development/patch/Git/clean-workspace contracts;
- OPUS current master commit history;
- current route catalog, front site config, Security controller and generic localized-route resolver.

Current OPUS master:

`c5e7de78f70d14efc3b8c42f4ec53026b47253cf`

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair`

## Superseded R8B4B evidence

Owner execution of the previous artifact returned:

`P117W_R45B2A4BZ2R8B4B_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4B_HEAD_INVALID`

and `git status --short` was empty.

Cause: R8B4B had been built against obsolete pre-commit HEAD `76b5919...` even though R8B4A2 had already been committed/pushed. No source write occurred. The failed artifact is retained for history but must not be executed again.

## Current exact input contract

R8B4B1 requires:

- HEAD exactly `c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- clean tracked worktree;
- clean index;
- no untracked files.

Exact dependency blobs:

- routes localized: `1ace98302b62a10fb2f817f60063fdfd3f08180c`;
- OWASYS-front site config: `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- Security controller: `3a13204eb4177f0638f6c1eb7c98449cf8a86597`;
- LocalizedRouteResolver: `5c302833b1f597210d0b4c7044cb18d672871fbf`.

## Runtime diagnosis preserved

Structure already renders `essai / navigation / config/application.fsm.json`.

Security back flow succeeds through secured REST -> `owasys:security-snapshot` -> HTTP 200. The front later fails with `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`.

Current Security controller contains dedicated `sso` view and builds canonical `security/sso`. Current route catalog has no `security/sso`. The generic resolver is correctly fail-closed on undeclared canonical routes.

## Artifact

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair.zip`

ZIP SHA-256:

`a8befc98a50b8c372cd69f449a74a0d36d6cdb4582b32f80108606c0070c8eef`

Contents exactly:

- `apply_a4bz2r8b4b1.php`

Applicator SHA-256:

`201fc474ec05f0bf70d1ad4d2bf80841de0fe3d6b2eafa982f012b6fc2ca8e3b`

Applicator length: `10488` bytes.

## Applicator behavior

The applicator:

1. requires exact committed R8B4A2 HEAD `c5e7de78...`;
2. requires a fully clean worktree/index with no untracked files;
3. validates the four current Git blobs above;
4. verifies current Security SSO view/url markers;
5. reads route/site configuration through OPUS `StructuredFileLoader` and source bytes through OPUS `File`;
6. rejects an already-declared `security/sso`;
7. derives exactly 25 base-language SSO paths from canonical `security`;
8. serializes with OPUS `Json`;
9. validates staged routing with the real OPUS `LocalizedRouteResolver` over all 37 locales using `localize`, `resolve` and `isLocalized`;
10. writes only `sites/owasys-front/config/routes.localized.json` via `File::writeAtomic()`;
11. requires French `sécurité/sso` and English `security/sso` after reload;
12. reruns resolver validation on the written file;
13. requires HEAD unchanged, exactly one tracked diff, no staged/untracked files, and clean `git diff --check`;
14. restores original route-catalog bytes on any post-write exception before reporting failure.

## Assistant-side validation

Completed before delivery:

- current GitHub source-of-truth gate completed in the same cycle;
- previous R8B4B stale-baseline cause confirmed from GitHub current master;
- current target/dependency blob SHAs verified from GitHub;
- current route catalog inspected and `security/sso` confirmed absent;
- current Security controller inspected and SSO view/url confirmed present;
- generic resolver fail-closed behavior inspected;
- applicator PHP lint: OK;
- old pre-commit worktree expectations removed;
- post-write rollback path strengthened so validation exceptions are rollback-capable;
- ZIP inspected: exactly one applicator file.

The assistant does not claim execution against the owner's Windows checkout.

## Required owner markers

In order:

`P117W_R45B2A4BZ2R8B4B1_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4B1_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4B1_APPLIED`

Then:

- `baseline_head=c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- `changed_path=sites/owasys-front/config/routes.localized.json`;
- `localized_route=security/sso`;
- `localized_route_languages=25`;
- `localized_route_locales=37`.

Expected `git status --short` after success:

only `sites/owasys-front/config/routes.localized.json` modified.

## Runtime gates after successful application

1. Reload `/fr-FR/sécurité` and require no localized-route 500.
2. Require Security authority `essai / security / config/security.fsm.json`.
3. Open the SSO subview and verify real provider/default-provider metadata with no secrets.
4. Require Structure still `essai / navigation / config/application.fsm.json`.
5. Require Sources + Git functional.
6. Create one temporary STATE in Security Conception and require persistence after reload.

Do not commit/push R8B4B1 until these runtime gates pass.
