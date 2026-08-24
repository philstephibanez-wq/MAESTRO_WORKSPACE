# P117W R45B2A4BZ2 R8B5C — Navigation EVENT signal-type compatibility handoff

State: READY FOR OWNER APPLY — NOT YET APPLIED

## Baseline

Current OPUS GitHub `master` re-read in this work cycle:

`3e589a8b1f58e744eeb6af23e87c8ca216a55b4c`

`opus_p117w_r45b2a4bz2r8b5b_security_reauthentication_ownership`

Required blobs:

- `sites/owasys-front/application/default/services/NavigationBuilder.php` = `63baf6f2d13afc8590b1cff96069b8c533207610`
- `sites/owasys-front/config/fsm.json` = `5114d51e701b34345c5b0e37b1502dc6c1478f49`

## Runtime evidence

Owner-supplied OWASYS-front logs/profiler show repeated HTTP 500 on ordinary and Security routes with:

`OWASYS_NAVIGATION_SIGNAL_TYPE_INVALID`

from `NavigationBuilder.php:719`.

The same traces show the R8B5A3 SignalBus COMMAND/EVENT handshake being enqueued and delivered successfully before the render error.

Owner-supplied OWASYS-back traces show `owasys:registry-sync` and `owasys:security-snapshot` succeeding with HTTP 200.

## Cause

Current Navigation FSM declares `security_context_ready` as semantic `event`, automatic and non-menu, as required by the active micro-EFSM architecture.

Current NavigationBuilder rejects `event` because its `SIGNAL_TYPES` registry contains only `navigation`, `command`, `outcome`, `system`.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b5c_navigation_event_signal_type_compatibility_repair.zip`

ZIP SHA-256:

`7f4d9e3681b059721cb9720b9f7eccfed65f680f5ce68e8f35f3351f065be662`

Contained applicator only:

`apply_a4bz2r8b5c.php`

Applicator SHA-256:

`9ab1fd74035ce0459cd2ce9333225c1692b26ee5f9545844a4ab94ac4b0202ab`

Applicator PHP lint: PASS.

## Exact differential

Modified only:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`

Semantic code change:

add `event => true` to the strict `SIGNAL_TYPES` registry.

No JSON/config change.

No Security reauthentication code change.

No backend path.

## Safety/validation in applicator

The applicator requires:

- exact HEAD and both exact blobs;
- clean tracked worktree;
- clean index;
- zero individual untracked paths;
- Composer autoload present;
- source read through OPUS `File`;
- current FSM read through `StructuredFileLoader`;
- exact `security_context_ready` contract = event/automatic/non-menu;
- unique exact `SIGNAL_TYPES` replacement anchor;
- TOKEN_PARSE of staged NavigationBuilder;
- real PHP lint of staged NavigationBuilder;
- load staged NavigationBuilder and use Reflection to invoke its real private `signalRegistry()` against the complete current FSM registry;
- explicit assertion that `security_context_ready` is accepted as `event`;
- OPUS atomic write;
- real PHP lint after write;
- exact one modified path from `git diff --name-only`;
- zero untracked paths;
- clean index and unchanged HEAD;
- `git diff --check` PASS;
- rollback to original on any post-write failure.

## Construction reproduction

The complete applicator was executed in a temporary Git repository containing all five relevant signal-type categories including the failing EVENT.

Result:

- PREFLIGHT_OK;
- staged PHP lint PASS;
- real reflection `signalRegistry()` acceptance PASS;
- REPO_CHANGES_VERIFIED;
- APPLIED;
- exactly one modified path;
- `git diff --check` PASS.

The produced diff was exactly one added line: `event => true` in `SIGNAL_TYPES`.

## Required success markers

- `P117W_R45B2A4BZ2R8B5C_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B5C_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B5C_APPLIED`
- `baseline_head=3e589a8b1f58e744eeb6af23e87c8ca216a55b4c`
- `changed_paths=1`
- `navigation_signal_type_event=accepted`
- `security_context_ready_type=event`
- `owasys_back_change=none`

## Owner runtime gate

After apply, do not commit/push until these routes are checked:

- `/fr-FR/application`
- `/fr-FR/applications`
- `/fr-FR/sécurité`
- `/fr-FR/sécurité/sso`

No `OWASYS_NAVIGATION_SIGNAL_TYPE_INVALID` may remain.

Then resume the R8B5B success/failure reauthentication validation.
