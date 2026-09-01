# R8B7F — Exact locale FSM label runtime

Date: 2026-09-01

## Baseline

OPUS HEAD: `1034e0b7cc0bb323219458dbf08b07cf8843c316` with local R8B7E already applied.

## Root cause

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php` still calls `Locale::fallbackChain()` inside `applicationCatalogMessages()`. R8B7E correctly removed the fallback API from OPUS core, so this residual caller produces the OWASYS front runtime failure.

## Contract

Strict NO-FALLBACK:
- one active locale only;
- one exact catalog path only: `application/default/local/<locale>.json`;
- no parent locale;
- no base-language substitution;
- no host-locale substitution;
- no locale-family merge;
- missing exact catalog returns no messages, then the existing visible marker `⚠ <id>` identifies untranslated states/transitions.

## User layout preservation

`sites/owasys-front/config/navigation.fsm.layout.json` contains a valid user-authored geometry change. R8B7F must not touch, reset or replace this file.

## Delivery

Native differential ZIP `R8B7F.zip` contains a bounded migration script that modifies only `FsmDiagramBuilder.php`, verifies exact anchors, refuses unexpected source, and leaves the user layout untouched.
