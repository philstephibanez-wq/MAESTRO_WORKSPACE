# P117W R8B7K — Horizontal Registry Layout

Date: 2026-09-03
Status: DELIVERY CANDIDATE
OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4`

## Owner request

Present the registry application grouping in width rather than vertically.

## Root cause

The R8B7J presentation separated OWASYS/system entries from generated applications semantically, but rendered the two groups one after another vertically. The requested correction is presentation-only: keep the same grouping contract and actions, but place the two groups in the existing OWASYS two-column grid.

## Scope

Exactly one OPUS/OWASYS source file changes:

- `sites/owasys-front/application/registry/templates/index.score`

No PHP, REST, backend, FSM, ACL, registry storage or application metadata changes.

## Required presentation

Inside the Applications registry card:

- left column: OWASYS/system applications (`entry.deletable == false`);
- right column: generated/deletable applications (`entry.deletable == true`);
- use the existing `ow-grid ow-runtime-grid` presentation contract to obtain a horizontal layout without introducing local CSS or JavaScript;
- preserve responsive behavior supplied by the existing OWASYS grid.

## Preserved contracts

The change must preserve unchanged:

- `select-app` POST action;
- `owasys_app_id` field;
- current-application disabled state;
- `registry.cannot_select` ACL state;
- delete action and confirmation field only for deletable applications and only when `registry.can_delete` is true;
- all existing SCORE/i18n semantics;
- no hardcoded application identifier.

## Acceptance

- ZIP differential contains exactly the complete `index.score` at its final path;
- SCORE conditional and foreach blocks remain balanced;
- both system and generated application groups render side-by-side at desktop width through the existing OWASYS grid;
- selection and deletion behavior remain unchanged;
- no OPUS/OWASYS file outside the stated scope changes.
