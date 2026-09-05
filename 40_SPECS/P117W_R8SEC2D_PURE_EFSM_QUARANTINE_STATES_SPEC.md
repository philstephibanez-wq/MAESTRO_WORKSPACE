# P117W R8SEC2D — Pure EFSM quarantine/fault states

## Source of truth

This correction is based on current GitHub `master` after OPUS commit `c1a9fc8748574633f29ea172e5ee0d557dbb6388` (R8SEC2C), plus the runtime evidence supplied after that commit.

## Problem

R8SEC2C correctly introduced application-FSM NMI targets `security_quarantine` and `fault`, but declared those two control states with application `module` fields (`security` and `system`).

`Opus\Fsm\FsmSiteLoader` explicitly defines a pure EFSM state as an engine object: only a state carrying an explicit `module` participates in the application-module-directory contract. Consequently, the added `module` fields make the loader require physical application module directories that do not exist for pure confinement/fault states.

Observed runtime result on owasys-front: `OPUS_FSM_SITE_MODULE_DIRECTORY_MISSING` from `FsmSiteLoader.php` before normal page dispatch.

## Contract

1. `security_quarantine` and `fault` are pure EFSM control states, not implicit application UI/business modules.
2. Their application FSM declarations MUST NOT contain `module` unless a real concrete application module is intentionally implemented for that state.
3. `security_quarantine` remains the NMI target for `security_violation`.
4. `fault` remains the NMI target for `critical_error`/backend `fail` where already established by R8SEC2C.
5. No fake `application/security` or `application/system` directory is created to satisfy the loader.
6. Generated frontend/backend scaffolds must emit these two states without `module`, otherwise new sites would reintroduce the defect.
7. Existing OPUS application FSMs migrated by R8SEC2C (`essai`, `owasys-front`, `owasys-back`) are migrated in place by removing only the erroneous `module` fields from these pure states.
8. Existing user/runtime layout persistence files are not modified.

## Files in scope

- `Opus/Scaffold/SiteScaffoldPlan.php`
- `sites/essai/config/application.fsm.json`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-back/config/fsm.json`

`Opus/Fsm/FsmSiteLoader.php` is not changed: its current pure-EFSM-vs-module distinction is the intended framework contract and exposed the bad state declarations correctly.

## Validation

- PHP lint `SiteScaffoldPlan.php`.
- JSON decode the three FSM files.
- Assert that `security_quarantine` and `fault` exist and have no `module` field.
- Assert the NMI targets remain `security_quarantine` and `fault`.
- `composer dump-autoload -o`.
- `composer opus:validate-site -- essai`, `owasys-front`, `owasys-back` when supported by the current command contract.
- Relaunch front/back and verify `/fr-FR/navigation` no longer fails with `OPUS_FSM_SITE_MODULE_DIRECTORY_MISSING`.
