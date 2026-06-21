# OPUS P117SITE21 - create:site application alias

Status: DELIVERED

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

## Runtime test

Run from H:\OPUS:

python tools\smoke_p117site21_create_site_application_alias.py

Expected markers:

CHECK_CREATE_SITE_ALIAS_COMMAND=OK
CHECK_CREATE_SITE_ALIAS_FULLSTACK_STRUCTURE=OK
CHECK_CREATE_SITE_ALIAS_FRONTEND_BACKEND_SEPARATION=OK
CHECK_CREATE_SITE_ALIAS_NO_LEGACY_APPLICATION_ROOT=OK
P117SITE21_CREATE_SITE_APPLICATION_ALIAS_SMOKE_OK
CHECK_CLEANUP=OK

## Next

After validation, continue with frontend authoring commands: create:view, create:section, create:component.
