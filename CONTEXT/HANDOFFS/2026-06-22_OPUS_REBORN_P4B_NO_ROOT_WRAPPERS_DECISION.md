# OPUS reborn - P4B no root wrappers decision

Date: 2026-06-22

## Validated decision

The OPUS framework must not keep direct root wrapper classes such as:

- `Opus/Acl.php`
- `Opus/Fsm.php`
- `Opus/I18n.php`
- `Opus/Router.php`

These files were temporary reborn runtime wrappers and are not clean final architecture.

## Rationale

The user wants OPUS to remain close to the original ASAP spirit:

- simple framework layout;
- no pointless wrappers;
- protected variables accessed through automatic getter/setter policy;
- singleton per site/application;
- historical classes remain recognizable.

## Consequence

If Kernel remains, it must become a real responsibility area with real classes, for example:

- `Opus/Kernel/Kernel.php`
- `Opus/Kernel/Acl.php`
- `Opus/Kernel/Fsm.php`
- `Opus/Kernel/I18n.php`
- `Opus/Kernel/Router.php`

HTTP and site responsibilities must also move to real folders:

- `Opus/Http/Request.php`
- `Opus/Http/Response.php`
- `Opus/Site/Package.php`
- `Opus/Site/PackageRepository.php`

No historical ASAP/OPUS class should be deleted without a dedicated review.
