# P117W R8SEC2D — Handoff

## Baseline

OPUS GitHub `master`: `c1a9fc8748574633f29ea172e5ee0d557dbb6388` (`R8SEC2C`).

## Runtime evidence

The supplied owasys-front log after R8SEC2C shows repeated HTTP 500 failures for `/fr-FR/navigation` and `/fr-FR` with `OPUS_FSM_SITE_MODULE_DIRECTORY_MISSING` at `Opus/Fsm/FsmSiteLoader.php:411`.

Current `FsmSiteLoader` states that a pure EFSM state is an engine object and only an explicit `module` field participates in application module-directory validation. R8SEC2C added `module: security` to `security_quarantine` and `module: system` to `fault`, so the loader correctly interpreted those as real application modules.

## Correction

R8SEC2D removes only those erroneous module declarations from pure EFSM states in:

- canonical generated frontend FSM in `SiteScaffoldPlan.php`;
- canonical generated backend FSM in `SiteScaffoldPlan.php`;
- `sites/essai/config/application.fsm.json`;
- `sites/owasys-front/config/fsm.json`;
- `sites/owasys-back/config/fsm.json`.

No fake application directories are created. No layout file is touched. NMI targets introduced by R8SEC2C remain unchanged.

## Owner workflow

Apply the native ZIP to `H:\OPUS`, run the bundled fail-closed applicator, validate PHP/JSON/autoload/site contracts, then restart front/back and retest navigation. Owner validates, commits and pushes OPUS; assistant does not commit/push OPUS.
