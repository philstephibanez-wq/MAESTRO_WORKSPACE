# DECISION 2026-06-29 — OPUS applications are Composer-installable packages

## Status

Accepted.

## Context

OPUS is a framework and one sub-project inside MAESTRO_WORKSPACE. OPUS-owned applications must not be copied manually as loose folders or treated as ad-hoc demos.

Examples of OPUS-owned applications:

- OPUS RefBook;
- OPUS demo application;
- OPUS ODBC Manager / ODBC Explorer;
- future OPUS User Guide;
- any future OPUS official site application.

## Decision

Every official OPUS application must be contractually installable by Composer as a package.

This applies to RefBook, demo, ODBC Manager / ODBC Explorer and future OPUS applications.

The OPUS framework repository remains the framework source. Official applications may live in the OPUS repository during development or in separate repositories later, but their delivery contract is Composer package installation.

## Required package contract

Each OPUS application package must provide:

- a `composer.json`;
- a stable package name;
- PSR-4 autoloading for PHP classes;
- an OPUS application manifest;
- OPUS routes;
- OPUS controllers;
- ScoreTemplate `.score` views when HTML is rendered;
- I18N resources;
- SSO/ACL policy declarations when the application is protected;
- diagnostics/profiler/logging compatibility;
- install/update/uninstall documentation;
- smoke tests proving that the package is discoverable and installable.

## Rules

- No manual folder copy as the official installation method.
- No hidden hardcoded path to a local workspace folder.
- No direct dependency on UwAmp paths.
- No silent fallback if a package manifest is missing.
- No application is considered complete until its Composer package contract is validated.

## Immediate consequence for ODBC Manager

The OPUS ODBC Manager / ODBC Explorer site must be designed as a Composer-installable OPUS application package.

The next OPUS milestone must account for this package contract before building the site UI.

Suggested next milestone:

`P7_OPUS_APP_PACKAGE_CONTRACT_CORE`

Then resume:

`P7_ODBC_EXPLORER_READONLY_CORE`

Then:

`P7_ODBC_EXPLORER_SITE_APP_CORE`
