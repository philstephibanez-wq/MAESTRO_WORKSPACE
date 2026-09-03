# P117W R8B7M — I18N TOPOLOGY CLEANUP SPEC

Status: DELIVERY CANDIDATE

## Authority

- MAESTRO_WORKSPACE `README-FIRST.md` is authoritative.
- OPUS GitHub baseline: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).
- This candidate supersedes the R8B7K/R8B7L Applications-registry presentation candidates.

## Root causes addressed

1. The Applications topology did not express the actual OWASYS architecture clearly: `owasys-front` and `owasys-back` are the OWASYS core and must be rendered side-by-side under one OWASYS root.
2. Generated applications must remain visibly related to OWASYS while remaining distinct from its two core applications.
3. The Applications SCORE view referenced registry delete-specific I18n keys that are present in English/French but absent from multiple other base registry catalogs. With `silent_fallback=false`, this can surface untranslated/missing-key warning presentation.
4. Raw technical registry values (`generated`, `discovered`, `frontend`, `backend`, roles, roots, locale/theme metadata) were being used as user-facing labels, violating the required translated presentation and adding visual noise.
5. Registry audit/runtime panels duplicated developer diagnostics in the main user view and obscured the primary application-selection workflow.

## Required presentation

The Applications state must render one continuous topology:

`OWASYS`

→ core row containing exactly the non-generated/system applications, with `owasys-front` and `owasys-back` side-by-side on desktop

→ generated-applications row below, visually connected to the OWASYS topology.

Generated applications are not core children equivalent to front/back; they are outputs managed by OWASYS and therefore appear in a distinct connected group.

## I18n rule

All presentation labels in this view use existing I18n keys already covered by the supported locale chain. The candidate introduces no new literal English/French UI labels and no new registry catalog keys.

The view must not expose raw technical registry metadata as presentation labels. Application names/identifiers remain runtime/business data and are not translated.

The candidate uses the existing translated keys:

- `brand.name`
- `common.id`
- `fsm_designer.delete`
- `menu.applications`
- `registry.clear_current_context`
- `registry.create_application`
- `registry.current_application`
- `registry.empty_description`
- `registry.empty_title`
- `registry.error.action_invalid`
- `registry.error.application_not_found`
- `registry.error.application_required`
- `registry.select_instruction`
- `registry.sync_total`
- `registry.work_on_this_app`

## Scope

Changed files only:

- `sites/owasys-front/application/registry/templates/index.score`
- `sites/owasys-front/www/asset/themes/owasys/css/theme.css`

No change to:

- `owasys-back`;
- REST;
- Composer command contracts;
- FSM semantics;
- ACL/SSO;
- registry controller/model;
- site configuration;
- locale catalogs.

## UI compaction

The main Applications state no longer renders the discovery audit, Singleton audit, SQLite runtime or recent-events panels. Those are developer/diagnostic concerns and must not dominate the primary application registry workspace.

Per-application Singleton diagnostic badges and raw technical metadata are also removed from this primary view.

## Functional preservation

The existing controller/ACL-owned forms remain available:

- create application;
- clear current application context;
- select application;
- delete generated application when ACL and `entry.deletable` permit it.

The view keeps `entry.deletable` as the existing runtime discriminator between protected/system applications and Composer-generated applications. No application ID such as `essai` is hard-coded.

## Responsive rule

Desktop/tablet: OWASYS core applications render side-by-side.

Narrow viewport: the core row may stack vertically, with topology connector decoration suppressed where the existing responsive design already does so.

## Acceptance

- ZIP contains only the two complete final files above.
- ZIP SHA-256: `ef6f0945889338dc08cc524e08ce8fec453965ec5132967644c15b3cff1ad545`.
- SCORE structural directives are balanced.
- `composer opus:validate-site -- owasys-front` must pass after owner apply.
- Runtime `/applications` must show front/back side-by-side as OWASYS core and generated applications in a distinct connected group.
- No missing-I18n warning placeholder must be visible on the Applications view while switching through supported locales.
- Create/select/clear/delete workflows must remain functional.
