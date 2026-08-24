# P117W R45B2A4BZ2 R8B5B — Security reauthentication ownership

State: IMPLEMENTATION FROZEN — READY FOR OWNER APPLY

## Source-of-truth gate

This slice was prepared only after re-reading in the same work cycle:

- `README-FIRST.md`;
- `00_COMMON_CONTRACTS/DEVELOPMENT_CONTRACT.md`;
- `00_COMMON_CONTRACTS/ZERO_FALLBACK_CONTRACT.md`;
- `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md`;
- `00_COMMON_CONTRACTS/GIT_AND_BRANCH_CONTRACT.md`;
- active micro-EFSM architecture specification;
- current OPUS GitHub `master` after accepted R8B5A3;
- current `OwasysSecurityController`;
- current `OwasysSecurityRuntimeCoordinator` and interface;
- current `OwasysSecurityContextWriterInterface`;
- current `OwasysRuntimeSecurity::reauthenticate()`;
- current `config/security.fsm.json`;
- current `FsmSessionStore` and `File` boundaries.

Authoritative OPUS baseline:

`97e437c954efd2ee9aeddabaeaad56dc41b391a9`

`opus_p117w_r45b2a4bz2r8b5a3_repository_inventory_verifier_repair`

## Cause

R8B5A3 established an autonomous OWASYS-front Security EFSM and the first Navigation/Security COMMAND/EVENT handshake.

The remaining runtime ownership gap is the real fresh-auth path used before Security mutations.

`OwasysSecurityController` still calls `OwasysRuntimeSecurity::reauthenticate()` directly. Therefore the actual credential/fresh-auth operation does not yet execute inside the already-declared Security lifecycle:

- `authenticated --reauth_required--> reauthenticating`;
- `reauthenticating --reauthentication_succeeded--> authenticated`;
- `reauthenticating --reauthentication_failed--> authenticated`.

The Security definition already contains these states/signals/transitions. No configuration change is required.

## Decision

R8B5B extends `OwasysSecurityRuntimeCoordinator` with one explicit `reauthenticate()` orchestration method.

The controller gives the coordinator a callable representing the existing real reauthentication operation. The coordinator owns only EFSM lifecycle orchestration; `OwasysRuntimeSecurity` remains the authority for credential verification, REST fresh-auth proof creation and existing mutation semantics.

No credential value is copied into SecurityContext, Logger, Profiler or FsmSignalBus context.

## Required runtime sequence

Before invoking the real fresh-auth callable:

1. restore Navigation runtime from `opus.fsm.owasys-front`;
2. require Navigation current state `security`;
3. restore Security runtime from `opus.fsm.owasys-front.security`;
4. require Security current state `authenticated`;
5. synchronize request-local SecurityContext from the authenticated identity and selected application;
6. transition Security with `reauth_required` to `reauthenticating`;
7. expose that real transition to the Profiler.

The intermediate `reauthenticating` state is deliberately request-local and is not persisted before the credential operation. This avoids leaving a stale persisted reauthentication state if the PHP process terminates abnormally. The real transition still occurs and is measured by FsmProcessor/Profiler.

On real success:

- emit `reauthentication_succeeded`;
- require Security returns to `authenticated`;
- require Navigation remains `security`;
- persist the final Security snapshot;
- emit metadata-only Profiler event `security_context.reauthentication.succeeded`;
- return the untouched real fresh-auth result to the existing controller flow.

On real failure:

- emit `reauthentication_failed`;
- require Security returns to `authenticated`;
- require Navigation remains `security`;
- persist the final Security snapshot;
- emit metadata-only Profiler event `security_context.reauthentication.failed` with exception class only;
- rethrow the original real failure unchanged.

## Exact differential

Modified only:

- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`

No new file.

No configuration change.

No `sites/owasys-back` path.

## Preserved authorities

R8B5B does not replace or weaken:

- SSO/local-password credential verification;
- secured REST fresh-auth proof creation;
- ACL;
- CSRF;
- Security mutation preview;
- confirmation token/state hash;
- mutation commit/rollback;
- selected-application contextual Security EFSM display/design;
- Navigation ownership;
- Sources + Git behavior.

## Acceptance gates

Repository/static:

- exact HEAD and three exact blobs;
- clean worktree/index/untracked inventory;
- staged PHP TOKEN_PARSE PASS;
- real `php -l` PASS before writes for all three staged files;
- atomic writes through OPUS `File`;
- real `php -l` PASS after writes;
- exact three modified paths, zero new paths;
- index remains empty;
- HEAD unchanged;
- `git diff --check` PASS.

Owner CLI after apply:

- lint the three modified PHP files;
- `composer dump-autoload -o`;
- `composer opus:validate-site -- owasys-front`;
- `composer opus:validate-site -- owasys-back`;
- `composer opus:validate-site -- essai`.

Runtime:

1. normal Security workspace still opens;
2. Navigation remains `security`, Security is `authenticated` at rest;
3. perform a Security mutation preview with correct local-password reauthentication;
4. Profiler shows `reauth_required`, temporary Security `reauthenticating`, then `reauthentication_succeeded`, final `authenticated`;
5. Navigation remains `security`;
6. repeat with an invalid password;
7. Profiler shows `reauthentication_failed`, final Security `authenticated`, and the existing real error remains visible;
8. no password/token/CSRF/fresh-auth proof appears in the new Profiler context;
9. existing preview/commit/rollback and Sources + Git remain functional.

## Next

After R8B5B acceptance, R8B5 is complete. Continue with generic generated-application PHP ACTION/GUARD managed-source authoring unless runtime evidence exposes a blocking defect.