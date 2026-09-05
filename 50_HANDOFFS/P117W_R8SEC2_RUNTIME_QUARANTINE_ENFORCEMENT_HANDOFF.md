# P117W R8SEC2 — Runtime quarantine enforcement handoff

## Status
READY FOR OWNER APPLICATION

## Repository authority
OPUS current master baseline after owner R8SEC1 commit: `1798962392f5eabab9068c0438e7f26eb0d2aba1`.

## Source evidence
- `Opus/Security/Runtime/SecurityQuarantine.php` exists on master and persists `var/security/quarantine.json` fail-closed.
- `Opus/Application/Runtime/GeneratedSiteRuntime.php` currently has no quarantine dependency/check before business initialization.
- `Opus/Scaffold/SiteScaffoldPlan.php` currently generates `security_violation` NMI to `begin`/`api` and `critical_error` NMI to `begin`/`api`.
- `sites/essai/config/application.fsm.json` currently routes both NMI classes to `connexion`.
- `sites/owasys-back/config/fsm.json` currently routes `security_violation` and `fail` to `api`.

## Delivery
Native differential ZIP `R8SEC2.zip` containing one fail-closed applicator script. The script validates current Git blob baselines before modifying files.

## Modified targets
- `Opus/Application/Runtime/GeneratedSiteRuntime.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`
- `sites/essai/config/application.fsm.json`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-back/config/fsm.json`

## Result
- generated runtime blocks before business work while durable quarantine is active;
- generated scaffold exposes `security_quarantine` and `fault` states;
- generated and migrated FSM NMI security targets are no longer normal business states;
- no automatic unlock/recovery transition is added.

## Owner workflow
Apply only after SHA/content inspection. Run lint, autoload, JSON validation, diff checks and runtime quarantine test. Do not commit/push until the chat validates the owner evidence.
