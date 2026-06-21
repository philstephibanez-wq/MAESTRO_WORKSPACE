# OPUS P117SITE21 - create:site application alias

Status: VALIDATED_WITH_FOLLOWUP_FIX

## Purpose

P117SITE21 makes create:site a backward-compatible alias of the canonical create:application command.

## Contract

- create:application remains the canonical command for fullstack application scaffolds.
- create:site is an alias, not a separate legacy scaffold.
- create:site must generate an application with frontend/backend clearly separated.
- frontend is representation only.
- backend is business/data processing only.
- backoffice is not backend.

## OPUS commits delivered

- 87a8b92f52b26589fcd1a9fd5d6583b13e23e020 - P117SITE21_CREATE_SITE_APPLICATION_ALIAS_COMMAND
- 1ea1f078bb9b43b7e7528aadc062f9689f63857d - P117SITE21_HELP_CREATE_SITE_ALIAS
- 7a3253364cef924b0454691047cc8f682ccd53bc - P117SITE21_CREATE_SITE_APPLICATION_ALIAS_SMOKE
- 668b68efe6855215b1689ef19c24bfb6e9502005 - P117SITE21_CREATE_SITE_APPLICATION_ALIAS_DOC
- fefaa437c13a01beccbcaca5863fb1405b883ae2 - P117SITE21B_CREATE_SITE_ALIAS_SMOKE_WINDOWS_COMPOSER_FIX
- 1e0acb88a9469dda83e4cbfd809ec479367b9088 - P117SITE21C_CREATE_SITE_ALIAS_SMOKE_CMD_COMPOSER_FIX
- 42d4fc92b5eac1059e345a21757451e3e8ec03eb - P117SITE20B_CREATE_APPLICATION_SMOKE_CMD_COMPOSER_FIX

## Runtime issue fixed

The first Windows smoke run failed with:

```text
[WinError 2] Le fichier spécifié est introuvable
```

Root cause: the Python smoke called Composer through `subprocess.run([...])`. On Steve's Windows setup `composer` is available from CMD, but `composer.cmd` is not available and Python may not resolve the Composer command like CMD does.

Final fix for P117SITE21: on Windows the smoke now calls Composer through CMD explicitly:

```text
cmd /d /c composer
```

Follow-up fix for P117SITE20: the same Composer resolution was applied to `tools/smoke_p117site20_create_application_fullstack_skeleton.py` after manual testing revealed the older smoke still failed with WinError 2.

## Manual test finding

Manual commands using underscores were rejected:

```text
OPUS_CREATE_APPLICATION_INVALID_APPLICATION_ID: test_app_fullstack
OPUS_CREATE_APPLICATION_INVALID_APPLICATION_ID: test_site_alias
```

This is expected under the current application id contract. Application ids must use the accepted slug form; use hyphenated ids such as:

```text
test-app-fullstack
test-site-alias
```

## Runtime validation

Validated by Steve from `H:\OPUS` after P117SITE21C fix.

Validated command sequence:

```cmd
python tools\smoke_p117site21_create_site_application_alias.py
git status --short
```

Validated markers:

```text
CHECK_CREATE_SITE_ALIAS_COMMAND=OK
CHECK_CREATE_SITE_ALIAS_FULLSTACK_STRUCTURE=OK
CHECK_CREATE_SITE_ALIAS_FRONTEND_BACKEND_SEPARATION=OK
CHECK_CREATE_SITE_ALIAS_NO_LEGACY_APPLICATION_ROOT=OK
P117SITE21_CREATE_SITE_APPLICATION_ALIAS_SMOKE_OK
CHECK_CLEANUP=OK
```

Final local state reported clean after smoke:

```text
git status --short
```

(no output)

## Next

Continue with frontend authoring commands: create:view, create:section, create:component.
