# P117W R45B2A4Q — NavigationBuilder call-site migration

State: OWNER VALIDATION REQUIRED

## Evidence

A4P resolved the latest OWASYS frontend failure to:

- `TypeError`
- `sites/owasys-front/application/default/services/NavigationBuilder.php:9`

`OwasysNavigationBuilder` now requires `(string $siteRoot, OwasysRuntimeSecurity $security)`.

Audit of OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093` shows:

- `RuntimeController` already uses `new OwasysNavigationBuilder($this->siteRoot, $security)`;
- `CreationController`, `SourceController` and `SecurityController` still use the obsolete one-argument call `new OwasysNavigationBuilder($security)`.

`OwasysFrontApplication::components()` eagerly constructs all four controllers before route selection, so any stale constructor call makes every frontend route fail, including `/applications`.

## Root cause

A4M evolved the constructor contract but did not migrate every call site. A4N corrected FSM route semantics but did not address this incomplete constructor migration.

## Correction

Artifact:

`opus_p117w_r45b2a4q_navigation_builder_callsites.zip`

SHA-256:

`a89067c2f5ef51a19aa86f42f7436d0b1342e5bc70718eb02a6d51e4b3b78bca`

The one-shot runner changes only:

- `sites/owasys-front/application/creation/controllers/CreationController.php`
- `sites/owasys-front/application/source/controllers/SourceController.php`
- `sites/owasys-front/application/security/controllers/SecurityController.php`

Each caller is migrated to:

`new OwasysNavigationBuilder($this->siteRoot, $security)`

The runner is fail-closed against OPUS HEAD `c5122e03...`, validates the three expected Git blob SHAs, lints every patched PHP file before writing, rolls back on failure, scans all OWASYS frontend PHP files for obsolete constructor calls, and requires exactly four valid NavigationBuilder call sites after application.

## Acceptance

- runner outputs `OPUS_P117W_R45B2A4Q_APPLY_OK`;
- `STALE_CALLSITES=0`;
- `VALID_CALLSITES=4/4`;
- `/fr-FR/applications` no longer fails during component composition;
- menu/FSM functional contract from A4N remains unchanged;
- owner validates before commit/push OPUS.
