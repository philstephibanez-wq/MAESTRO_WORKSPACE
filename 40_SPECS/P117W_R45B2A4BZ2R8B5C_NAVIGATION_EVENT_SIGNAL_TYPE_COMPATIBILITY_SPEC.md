# P117W R45B2A4BZ2 R8B5C — Navigation EVENT signal-type compatibility repair

State: DESIGN FROZEN — READY FOR OWNER APPLY

## Source-of-truth gate

Re-read in this work cycle:

- `README-FIRST.md`;
- `DEVELOPMENT_CONTRACT.md`;
- `ZERO_FALLBACK_CONTRACT.md`;
- `PATCH_DELIVERY_CONTRACT.md`;
- `GIT_AND_BRANCH_CONTRACT.md`;
- active micro-EFSM architecture specification;
- current OPUS GitHub `master`;
- current `NavigationBuilder.php`;
- current `config/fsm.json`;
- owner-supplied OWASYS-front/back Logger and Profiler captures.

Authoritative OPUS baseline:

`3e589a8b1f58e744eeb6af23e87c8ca216a55b4c`

## Proven incident

OWASYS-front globally fails with:

`OWASYS_NAVIGATION_SIGNAL_TYPE_INVALID`

at `NavigationBuilder.php:719` while building navigation.

The same failure affects ordinary application/registry routes and Security routes.

OWASYS-back continues to complete registry and Security snapshot REST operations successfully.

Security COMMAND/EVENT messages are successfully enqueued and delivered before the frontend render failure.

## Root cause

The current Navigation FSM legitimately contains:

- signal id `security_context_ready`;
- semantic type `event`;
- origin `automatic`;
- `menu = false`.

The active architecture explicitly distinguishes COMMAND and EVENT.

Current `OwasysNavigationBuilder::SIGNAL_TYPES` accepts only:

- `navigation`;
- `command`;
- `outcome`;
- `system`.

Thus the menu projection rejects a valid architectural EVENT before rendering.

## Required repair

Modify only `sites/owasys-front/application/default/services/NavigationBuilder.php` so its declared accepted signal types include `event`.

Do not:

- rewrite `security_context_ready` as `outcome`;
- remove the EVENT;
- add a fallback;
- change Security/SignalBus behavior;
- change `owasys-back`;
- change configuration.

Existing NavigationBuilder behavior already makes only `navigation` and `command` signals human-menu controls. EVENT therefore remains a non-menu runtime signal.

## Acceptance

Static/apply:

- exact baseline HEAD and current blobs;
- clean worktree/index/untracked inventory;
- exact one-line semantic change inside `SIGNAL_TYPES`;
- staged and post-write PHP lint PASS;
- current `config/fsm.json` loaded via `StructuredFileLoader`;
- reflection-based invocation of the real staged `signalRegistry()` accepts the entire current signal registry and specifically `security_context_ready:type=event`;
- exact one modified path;
- zero untracked paths;
- `git diff --check` PASS.

Runtime:

- `/fr-FR/application` renders again;
- `/fr-FR/applications` renders again;
- `/fr-FR/sécurité` renders again;
- `/fr-FR/sécurité/sso` renders again;
- no `OWASYS_NAVIGATION_SIGNAL_TYPE_INVALID`;
- COMMAND/EVENT correlation remains present;
- backend registry/security snapshot remains HTTP 200.

After this repair, resume the R8B5B reauthentication success/failure gate.
