# P117W R45B2A4BZ2 R8B5B — Security reauthentication ownership handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

OPUS GitHub `master` re-read in this work cycle:

`97e437c954efd2ee9aeddabaeaad56dc41b391a9`

`opus_p117w_r45b2a4bz2r8b5a3_repository_inventory_verifier_repair`

R8B5A3 is accepted, committed and pushed.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5b_security_reauthentication_ownership.zip`

ZIP SHA-256:

`663f85fc194ed4697e469621725c648a66db25f1fa26db99f7c47a8779a3f1da`

Contained applicator only:

`apply_a4bz2r8b5b.php`

Applicator SHA-256:

`f0743cab975c9d1f0e2f77084984f55ac0113947cbf26689be5cc7c29ddf0d7f`

Applicator PHP lint: PASS.

## Exact differential

Modified only:

- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`

Total: 3 paths.

No new file.

No config change.

No backend path.

## Functionality

R8B5B makes the Security EFSM the runtime owner of the real mutation reauthentication lifecycle while preserving existing credential and fresh-auth authorities.

The coordinator now wraps the existing `OwasysRuntimeSecurity::reauthenticate()` callable with:

- Security `authenticated -> reauthenticating` using `reauth_required`;
- real success -> `reauthentication_succeeded -> authenticated`;
- real failure -> `reauthentication_failed -> authenticated`, then rethrow original failure;
- Navigation state invariant `security` throughout;
- final Security snapshot persistence only after success/failure resolution;
- metadata-only Profiler lifecycle events;
- no credential, token, CSRF or fresh-auth proof copied to SecurityContext/Profiler/SignalBus.

## Applicator safety

Required baseline HEAD:

`97e437c954efd2ee9aeddabaeaad56dc41b391a9`

Required exact blobs:

- `SecurityController.php` = `1096d948670fc49012fee157cecdc52fbf185c35`
- `SecurityRuntimeCoordinatorInterface.php` = `3c8fc48c99c83ae8227ebe7cca84d17d02290b00`
- `SecurityRuntimeCoordinator.php` = `a7d5f4c28df4cecfc57be8841cf98fe7b652173e`

The applicator requires:

- clean worktree including individual untracked inventory;
- clean index;
- exact HEAD and blobs;
- Composer autoload present;
- OPUS `File` reads and atomic writes;
- unique encoded replacement anchors;
- TOKEN_PARSE of all staged PHP;
- real `php -l` of all staged PHP before write;
- real `php -l` of actual files after write;
- exact three modified paths from `git diff --name-only`;
- zero untracked paths from `git ls-files --others --exclude-standard`;
- unchanged HEAD and index;
- `git diff --check` PASS;
- rollback to exact originals on post-write failure.

## Construction tests already executed

- applicator PHP lint PASS;
- exact current R8B5A3 `SecurityRuntimeCoordinator.php` decoded from the accepted applicator payload and R8B5B method inserted: PHP lint PASS;
- exact current R8B5A3 coordinator interface with R8B5B contract inserted: PHP lint PASS;
- controller's two exact current GitHub anchors inserted into a syntactically valid controller harness: PHP lint PASS;
- full R8B5B applicator executed in a temporary Git repository with current coordinator/interface plus the exact controller anchors: PRELIGHT_OK, REPO_CHANGES_VERIFIED, APPLIED;
- temporary repository reported exactly the three intended modified paths and zero untracked paths;
- post-apply PHP lint PASS for all three paths.

## Required success markers

- `P117W_R45B2A4BZ2R8B5B_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5B_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5B_APPLIED`
- `baseline_head=97e437c954efd2ee9aeddabaeaad56dc41b391a9`
- `changed_paths=3`
- `reauth_lifecycle=security-owned`
- `navigation_state_invariant=security`
- `security_reauth_states=authenticated>reauthenticating>authenticated`

## Owner gate

Apply on the clean pushed R8B5A3 baseline.

Do not commit/push immediately after apply.

Validate PHP lint, Composer autoload, all three site validators and the runtime success/failure reauthentication lifecycle first.
