# MAESTRO_WORKSPACE HANDOFF — OWASYS P117R COMPOSER/RCP

Date: 2026-07-23
Status: governance committed; strict differential ZIP prepared; isolated validation complete; target Windows/Composer/browser validation pending
Source OPUS head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding rule

OWASYS is exclusively the interactive graphical surface.

Every executable or mutating operation must pass through an allow-listed Composer command invoked through RCP. OWASYS may collect intent, drive SSO/ACL/FSM, request preview and confirmation, submit a typed RCP command and render the result through SCORE. It may not perform the mutation locally and may not provide a fallback.

Canonical specification:

`CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`

## Rejected artifact

The first P117R archive was rejected because it added delivery-only files at the OPUS root:

```text
CLEAN_OWASYS_OLD_AFTER_ACCEPTANCE.cmd
DIFFERENTIAL_MANIFEST.json
README_P117R.md
RUN_P117R_CHECKS.cmd
START_OWASYS.cmd
```

Rejected archive:

- name: `opus_owasys_p117r_composer_rcp_bootstrap.zip`;
- SHA-256: `ea7edbfca0e9df871ac7521cd9f8dd3f55811fc75bca7108259719d9ae884350`;
- status: invalid, must not be extracted or committed.

No delivery README, report, manifest or helper script may pollute the OPUS root.

## Authoritative strict differential

ZIP:

`opus_owasys_p117r_composer_rcp_differential.zip`

SHA-256:

`587638d2b436a74b41c0ecb3efe5d28468ab9806a7aefbe5051bdd541d491d8d`

Files: 11

The only root-level entry is `composer.json`, because that existing OPUS source file is legitimately modified to register Composer commands.

Exact archive content:

```text
composer.json
config/rcp-commands.json
Opus/Rcp/ComposerRcpClient.php
Opus/Rcp/ComposerRcpClientInterface.php
Opus/Rcp/RcpCommandCatalog.php
Opus/Rcp/RcpCommandCatalogInterface.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
sites/owasys/application/default/services/RuntimeSecurity.php
sites/owasys/config/rcp.json
tools/audit_owasys_composer_rcp_boundary.php
tools/opus_rcp_dispatch.php
```

No direct write was made to the OPUS repository.

## Implemented in this bootstrap

- generic `Opus\Rcp\RcpCommandCatalog` and homonymous four-marker interface;
- generic `Opus\Rcp\ComposerRcpClient` and homonymous four-marker interface;
- root Composer command catalog;
- typed RCP request/result process boundary;
- allow-listed Composer script mapping;
- no shell string and no free-form command;
- request payload transferred through standard input, not command-line arguments;
- administrator password change migrated from the direct OWASYS SSO mutation call to `security.admin-password.change` through Composer/RCP;
- command-side ACL revalidation;
- stable error codes with no password or raw stack trace in the result;
- local password store reads/writes migrated to OPUS `File` + `Json`, including atomic write;
- bootstrap and exhaustive RCP audits.

## Complete target command catalog

The differential declares target Composer operations for site create/validate/build/export, structure preview/apply, source preview/write, Git stage/commit, Registry synchronization, user bootstrap, administrator password change/reset, SSO configuration and maintenance cleanup.

Only `security.admin-password.change` is marked implemented in this bootstrap. Every other operation is marked `implemented=false` and fails explicitly with `OPUS_RCP_OPERATION_NOT_IMPLEMENTED`. There is no local OWASYS fallback.

## Validation completed

- PHP syntax validation for every PHP file in the clean differential;
- JSON parsing for `composer.json`, `config/rcp-commands.json` and `sites/owasys/config/rcp.json`;
- static verification of homonymous interfaces and four standard markers;
- isolated bootstrap boundary audit;
- exhaustive audit correctly non-zero while unmigrated operations remain;
- isolated administrator-password test with ACL check, hash change, `must_change_password` clearing and no secret in response;
- clean archive integrity test;
- exact root-entry audit confirming `composer.json` is the only root file;
- SHA-256 verification.

## Validation not performed

The artifact container has PHP but no Composer binary and cannot clone GitHub through its network sandbox. Real Windows Composer/stdin behavior, OPUS autoload, P117M-R1, SSO session, browser validation, complete smoke suite and Windows/Linux parity remain target gates.

## Target validation commands

```cmd
cd /d H:\OPUS
composer dump-autoload
composer opus:audit-owasys-rcp-bootstrap
php -l Opus\Rcp\RcpCommandCatalog.php
php -l Opus\Rcp\ComposerRcpClient.php
php -l Opus\Security\Sso\LocalPasswordSsoProvider.php
php -l sites\owasys\application\default\services\RuntimeSecurity.php
php -l tools\opus_rcp_dispatch.php
php -l tools\audit_owasys_composer_rcp_boundary.php
git diff --check
```

The exhaustive command must remain red until all operations are migrated:

```cmd
composer opus:audit-owasys-rcp
```

## OWASYS launch command

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8080 -t sites\owasys\www sites\owasys\www\index.php
```

## `owasys_old`

Do not delete `sites/owasys_old` during P117R bootstrap. P117Q currently uses it as the explicit rejected duplicate that proves canonical Registry discovery.

Deletion commands are documentation only and are not placed in the differential ZIP. Deletion remains authorized only after the exhaustive RCP audit, reference scan, no-JavaScript/browser acceptance and explicit owner confirmation.

## Exact next work

1. Apply the authoritative clean differential on OPUS `36a8570…`.
2. Run the validation commands.
3. Test the administrator-password form through the actual Composer/RCP boundary.
4. Correct Windows Composer/stdin issues without fallback.
5. Inventory and migrate every remaining OWASYS mutation.
6. Keep `composer opus:audit-owasys-rcp` red until the final direct mutation is removed.
7. Complete backend-first and no-JavaScript acceptance.
8. Decide `owasys_old` deletion only after owner acceptance.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
NO DELIVERY FILE POLLUTION IN OPUS ROOT.
OWASYS IS GUI ONLY.
ALL OPERATIONS USE COMPOSER THROUGH RCP.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
