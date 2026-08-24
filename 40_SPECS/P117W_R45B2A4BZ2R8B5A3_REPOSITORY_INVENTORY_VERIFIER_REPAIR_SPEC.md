# P117W R45B2A4BZ2 R8B5A3 — Repository inventory verifier repair

State: ACTIVE CORRECTIVE SPEC

## Source-of-truth gate

Before this corrective delivery, `README-FIRST.md` and OPUS GitHub `master` were re-read. OPUS remains on:

`9031967e6f57929208b950920cd665d6ee6b749c`

`opus_p117w_r45b2a4bz2r8b4c_system_security_micro_efsm_registry_repair`

Owner evidence shows the R8B5A2 post-write failure rolled the repository back to a clean worktree.

## Failure cause

R8B5A2 correctly staged and parsed the intended 11-path functional differential but its post-write verifier used `git status --porcelain` and expected seven individual untracked files.

Default porcelain status collapses untracked directory trees, producing e.g. `?? Opus/` and `?? sites/owasys-front/application/security/services/`. The verifier therefore rejected a valid staged differential.

This is a verifier defect, not an OPUS runtime/source defect.

## Corrective rule

R8B5A3 does not modify R8B5A2 functional content.

It replaces only post-write repository inventory logic:

1. `git diff --name-only` must enumerate exactly the four tracked modified paths.
2. `git ls-files --others --exclude-standard` must enumerate exactly the seven new files, recursively and individually.
3. `git diff --cached --name-only` must remain empty.
4. Any mismatch triggers rollback.

No parser of compact `git status --porcelain` output is used for the post-write exact-path gate.

## Intended functional differential

Modified:

- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/security.fsm.json`

New:

- `Opus/Fsm/FsmSignalBus.php`
- `Opus/Fsm/FsmSignalBusInterface.php`
- `sites/owasys-front/application/security/services/SecurityContext.php`
- `sites/owasys-front/application/security/services/SecurityContextInterface.php`
- `sites/owasys-front/application/security/services/SecurityContextWriterInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`

Total: 11 paths. No backend path.

## Construction acceptance

A deterministic temporary Git repository was constructed with exactly the same four tracked modifications and seven nested untracked files.

Observed default `git status --porcelain` reproduces the failure class by collapsing untracked roots.

Observed R8B5A3 inventory commands return exactly:

- four individual modified paths via `git diff --name-only`;
- seven individual untracked paths via `git ls-files --others --exclude-standard`.

The R8B5A3 applicator is PHP-linted before delivery.

## Owner gate

R8B5A3 applies directly to the still-clean R8B4C baseline. No reset is required.

After success, `git status --short` is expected to show 4 modified files plus two compact untracked directory roots on default Git presentation; that display is informational only. The applicator acceptance uses exact file inventories, not compact status display.
