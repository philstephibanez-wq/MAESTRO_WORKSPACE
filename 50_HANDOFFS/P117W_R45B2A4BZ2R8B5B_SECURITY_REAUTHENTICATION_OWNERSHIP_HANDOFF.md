# P117W R45B2A4BZ2 R8B5B — Security reauthentication ownership handoff

State: COMMITTED/PUSHED — RUNTIME ACCEPTANCE BLOCKED BY R8B5C NAVIGATION EVENT-CONSUMER REGRESSION

## Current OPUS baseline

OPUS GitHub `master`, re-read after owner runtime report:

`3e589a8b1f58e744eeb6af23e87c8ca216a55b4c`

`opus_p117w_r45b2a4bz2r8b5b_security_reauthentication_ownership`

Parent:

`97e437c954efd2ee9aeddabaeaad56dc41b391a9`

The pushed R8B5B commit contains only the three intended files:

- `sites/owasys-front/application/security/controllers/SecurityController.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinatorInterface.php`
- `sites/owasys-front/application/security/services/SecurityRuntimeCoordinator.php`

## R8B5B intent

R8B5B makes the Security EFSM the runtime owner of real mutation reauthentication while preserving credential/fresh-auth authorities:

- `authenticated -> reauthenticating` with `reauth_required`;
- real success -> `reauthentication_succeeded -> authenticated`;
- real failure -> `reauthentication_failed -> authenticated` and original failure rethrow;
- Navigation invariant remains `security`;
- no password, CSRF token or fresh-auth proof is copied into SecurityContext, Profiler or SignalBus.

## Runtime incident after push

Owner supplied current OWASYS-front/back Logger and Profiler captures.

Observed global frontend failure:

`OWASYS_NAVIGATION_SIGNAL_TYPE_INVALID`

from:

`sites/owasys-front/application/default/services/NavigationBuilder.php:719`

This error occurs on ordinary routes such as `/fr-FR/application` and `/fr-FR/applications`, and also after successful Security COMMAND/EVENT exchange on `/fr-FR/sécurité` and `/fr-FR/sécurité/sso`.

OWASYS-back is healthy in the same traces: `owasys:registry-sync` and `owasys:security-snapshot` complete successfully with HTTP 200.

The SignalBus is also healthy enough to enqueue/deliver:

- COMMAND `enter_security_context` Navigation -> Security;
- EVENT `security_context_ready` Security -> Navigation;
- shared correlation id;
- EVENT causation id equal to COMMAND message id.

Therefore R8B5B runtime acceptance cannot yet be evaluated: page rendering is blocked afterward by NavigationBuilder's signal-type registry.

## Root cause assigned to R8B5C

Current Navigation FSM correctly declares:

`security_context_ready` with semantic `type = event`, `origin = automatic`, `menu = false`.

The active micro-EFSM architecture explicitly distinguishes COMMAND and EVENT.

However current `OwasysNavigationBuilder::SIGNAL_TYPES` accepts only:

- navigation
- command
- outcome
- system

The menu projection therefore rejects the architecture's legitimate EVENT before it can render any page that constructs navigation.

R8B5C repairs that consumer incompatibility without rewriting EVENT to `outcome`, without fallback, and without touching backend or Security reauthentication code.

## Original R8B5B artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5b_security_reauthentication_ownership.zip`

ZIP SHA-256:

`663f85fc194ed4697e469621725c648a66db25f1fa26db99f7c47a8779a3f1da`

Applicator SHA-256:

`f0743cab975c9d1f0e2f77084984f55ac0113947cbf26689be5cc7c29ddf0d7f`

## Next gate

Apply and validate R8B5C first. Then resume R8B5B success/failure reauthentication acceptance; do not claim R8B5 complete until that runtime gate passes.
