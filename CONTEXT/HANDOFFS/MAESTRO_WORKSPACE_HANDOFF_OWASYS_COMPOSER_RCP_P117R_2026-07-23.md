# MAESTRO_WORKSPACE HANDOFF — OWASYS P117R COMPOSER/RCP

Date: 2026-07-23
Status: governance committed; differential ZIP prepared; isolated validation complete; target Windows/Composer/browser validation pending
Source OPUS head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`

## Binding rule

OWASYS is exclusively the interactive graphical surface.

Every executable or mutating operation must pass through an allow-listed Composer command invoked through RCP.

This includes site creation, validation, structure changes, source writes, build/export, Registry writes, Git stage/commit, cleanup, user bootstrap, administrator-password creation/reset/change, SSO configuration, Auth0 proxy and bastion administration, and all future persistent operations.

OWASYS may collect intent, drive SSO/ACL/FSM, request preview and confirmation, submit a typed RCP command and render the result through SCORE. It may not perform the mutation locally and may not provide a fallback.

Canonical specification:

`CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`

## P117R bootstrap differential

ZIP:

`opus_owasys_p117r_composer_rcp_bootstrap.zip`

SHA-256:

`ea7edbfca0e9df871ac7521cd9f8dd3f55811fc75bca7108259719d9ae884350`

Files: 16

The ZIP is differential against OPUS `master` at `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`.

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
- bootstrap and exhaustive RCP audits;
- CMD launch, validation and post-acceptance cleanup helpers.

## Complete target command catalog

The differential declares the target Composer operations for:

- site create/validate/build/export;
- structure preview/apply;
- source preview/write;
- Git stage/commit;
- Registry synchronization;
- user bootstrap;
- administrator password change/reset;
- SSO configuration;
- maintenance cleanup.

Only `security.admin-password.change` is marked implemented in this bootstrap.

Every other operation is marked `implemented=false` and fails explicitly with `OPUS_RCP_OPERATION_NOT_IMPLEMENTED`. There is no local OWASYS fallback.

## Validation completed

- PHP syntax validation for every PHP file in the differential;
- JSON parsing for `composer.json`, `config/rcp-commands.json` and `sites/owasys/config/rcp.json`;
- static verification that each new concrete OPUS RCP class implements its homonymous interface;
- static verification that each new interface extends the four standard markers;
- isolated bootstrap boundary audit returns `OWASYS_COMPOSER_RCP_PASSWORD_BOOTSTRAP_AUDIT_OK`;
- exhaustive audit returns non-zero while unmigrated operations remain;
- isolated functional administrator-password test:
  - command request accepted;
  - ACL role checked;
  - password hash changed;
  - `must_change_password` cleared;
  - response contains no current or new password;
  - audit payload states `secret_logged=false`;
- ZIP integrity and SHA-256 verified.

## Validation not performed

The artifact container has PHP 8.4 but no Composer binary and cannot clone GitHub through its network sandbox.

Therefore the following remain target gates:

- actual Composer nested-script/stdin behavior on the owner Windows installation;
- full OPUS autoload and P117M-R1 audit;
- real OWASYS SSO session and password-change form;
- browser validation;
- complete repository smoke suite;
- Windows/Linux parity;
- migration of every remaining command.

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

Do not delete `sites/owasys_old` during P117R bootstrap.

P117Q currently uses it as the explicit rejected duplicate that proves canonical Registry discovery. Deletion is authorized only after:

- all OWASYS operations cross Composer/RCP;
- exhaustive RCP audit is green;
- no code/config/doc reference requires the old root;
- no-JavaScript and browser acceptance are complete;
- the owner explicitly confirms deletion.

The ZIP contains `CLEAN_OWASYS_OLD_AFTER_ACCEPTANCE.cmd`, which is guarded by the exhaustive audit, reference search and an explicit `CONFIRMED` argument.

## Exact next work

1. Apply the P117R bootstrap ZIP on clean OPUS `36a8570…`.
2. Run the bootstrap validation commands.
3. Test the administrator-password form through the actual Composer/RCP process boundary.
4. Correct any Windows Composer/stdin issue without adding a local fallback.
5. Inventory every remaining OWASYS mutating call.
6. Move generic operation handlers to OPUS with homonymous four-marker interfaces.
7. Migrate site creation, structure, source, build/export, Registry writes, Git, bootstrap, password reset, SSO and cleanup.
8. Keep `composer opus:audit-owasys-rcp` red until the final direct mutation is removed.
9. Complete backend-first and no-JavaScript acceptance.
10. Decide `owasys_old` deletion only after owner acceptance.

## Permanent rules

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO FALLBACK SILENCIEUX.
OWASYS IS GUI ONLY.
ALL OPERATIONS USE COMPOSER THROUGH RCP.
SECRETS NEVER ENTER COMMAND-LINE ARGUMENTS OR LOGS.
BACKEND FIRST.
SERVER-RENDERED SCORE FIRST.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
