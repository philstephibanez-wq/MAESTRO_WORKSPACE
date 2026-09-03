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

### Missing-I18n diagnostic presentation — mandatory

A missing-I18n warning must never render as a warning triangle alone.

Whenever a translation key is unresolved and the runtime chooses to expose a visible warning, the visible warning must contain both:

- the warning triangle/indicator;
- the exact unresolved I18n key, rendered adjacent to that indicator.

Canonical visible form:

`⚠ <exact.i18n.key>`

The exact key is diagnostic data and must not itself be translated, shortened, replaced by a generic message, hidden in a tooltip only, or omitted.

This rule is independent from the primary requirement that every supported locale provide the expected translation. It exists so that any residual or future missing translation is immediately identifiable by its exact key instead of producing an anonymous triangle.

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
- ZIP SHA-256: `93e8ac324d76dacd4f48ac541850802fdd5b685115e38f6aa2c662d40849ec9c`.
- SCORE structural directives are balanced.
- `composer opus:validate-site -- owasys-front` must pass after owner apply.
- Runtime `/applications` must show front/back side-by-side as OWASYS core and generated applications in a distinct connected group.
- All expected Applications-view presentation labels must resolve in every supported locale.
- If any unresolved I18n key is deliberately surfaced as a visible diagnostic, its warning triangle must be immediately accompanied by the exact unresolved key; triangle-only warning presentation is non-conformant.
- Create/select/clear/delete workflows must remain functional.
