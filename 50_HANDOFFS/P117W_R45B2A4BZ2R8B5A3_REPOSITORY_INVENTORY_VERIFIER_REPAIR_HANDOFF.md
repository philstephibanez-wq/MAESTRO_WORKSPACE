# P117W R45B2A4BZ2 R8B5A3 — Repository inventory verifier repair handoff

State: OWNER ACCEPTED — COMMITTED/PUSHED — CLOSED

## Accepted OPUS baseline

Owner reported R8B5A3 `c'est ok`.

OPUS GitHub `master` was re-read after that report and now points to:

`97e437c954efd2ee9aeddabaeaad56dc41b391a9`

`opus_p117w_r45b2a4bz2r8b5a3_repository_inventory_verifier_repair`

The previous baseline was:

`9031967e6f57929208b950920cd665d6ee6b749c`

GitHub comparison confirms one commit and exactly the intended R8B5A3 functional differential:

Modified:

- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/security.fsm.json`

Added:

- `Opus/Fsm/FsmSignalBus.php`
- `Opus/Fsm/FsmSignalBusInterface.php`
- `sites/owasys-front/application/security/services/SecurityContext.php`
- `sites/owasys-front/application/security/services/SecurityContextInterface.php`
- `sites/owasys-front/application/security/services/SecurityContextWriterInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`

Total: 11 paths. No `sites/owasys-back` path.

## Closed failure history

R8B5A failed in PHP staging due applicator nowdoc construction.

R8B5A1 repeated the staging failure and is superseded.

R8B5A2 passed staging but its post-write verifier incorrectly relied on compact `git status --porcelain` output and rolled back.

R8B5A3 repaired repository inventory by separately reading tracked modifications and individual untracked files. It is the accepted implementation.

## Accepted architecture

R8B5A3 establishes:

- independent OWASYS-front Navigation and Security EFSM session snapshots;
- request-local `SecurityContext` writer/read-only contracts;
- generic OPUS bounded in-process `FsmSignalBus` foundation;
- COMMAND `enter_security_context` Navigation -> Security;
- EVENT `security_context_ready` Security -> Navigation;
- correlation/causation metadata;
- Navigation remains `security` while Security is `authenticated` after the context handshake;
- no selected-application filesystem access from OWASYS-front;
- no backend JavaScript or backend change.

## Next slice

R8B5B owns the existing real fresh-auth mutation lifecycle with the Security EFSM:

- `authenticated --reauth_required--> reauthenticating` before the real credential/fresh-auth operation;
- real success -> `reauthentication_succeeded` -> `authenticated`;
- real failure -> `reauthentication_failed` -> `authenticated` and rethrow the real failure;
- Navigation must remain `security` throughout;
- existing ACL, CSRF, REST, preview/commit/rollback and fresh-auth proof semantics remain authoritative.
