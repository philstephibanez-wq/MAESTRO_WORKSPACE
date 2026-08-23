# P117W R45B2A4BZ2R8B3 — Selected application EFSM authority + persistent STATE CRUD

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Exact OPUS baseline

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

## Owner failure treated

After recreating `essai`, Conception displays another FSM and STATE Create does not work.

The root causes are independent but converge on one architectural defect: the development designer is still partially bound to the OWASYS host instead of the selected OPUS application.

## Confirmed root causes

### Wrong semantic source

`OwasysFsmDiagramBuilder` loads the host `owasys-front` navigation FSM. In design mode the selected application's canonical FSM must be read through secured REST and must be the unique semantic source.

### Wrong mutation target

`OwasysFsmDesignerGateway` still uses `/api/v1/applications/owasys-front/...` for draft and handler operations. The application ID must come from the authenticated OWASYS current-application session, never from browser input and never from a host constant.

### Wrong backend canonical path

`OwasysFsmDraftCommandProvider` hardcodes `sites/<id>/config/fsm.json`. Generated OPUS applications use `config/application.fsm.json`. R8B3 uses generic `FsmSiteLoader::resolve()` as the canonical source resolver.

### JavaScript initialization failure

R8B2 tests `handlerSourceEditor instanceof HTMLFormElement` before the `const handlerSourceEditor` declaration. This is a JavaScript temporal-dead-zone failure and can abort initialization before STATE button listeners exist.

### Invalid generated FSM contract

The generic `FsmDefinitionValidator` requires every transition signal to be declared in `signals`. Current generated application FSMs do not emit this registry.

The profiler environment normalizer removes the `profiler` state but not all semantic profiler residues. Actual profiler transition IDs are not exactly `open.profiler`; transitions can also originate from `profiler`. This leaves generated definitions with dangling state references.

### Pure STATE/module coupling

`FsmSiteLoader` currently falls back from missing `state.module` to `state.id`. A designer-created pure STATE `{id: ...}` therefore incorrectly implies an `application/<state-id>` module directory. R8B3 removes this fallback: only an explicit module field participates in application module validation.

## R8B3 behavior

### Selected application authority

When `fsm_design=1`:

- a current application is mandatory;
- `OwasysFsmDiagramBuilder` reads that application's canonical FSM through `OwasysSourceModel` -> secured REST -> back;
- `OwasysApplicationFsmModel` supplies the selected definition, source path, source hash and diagram;
- the designer payload becomes `OWASYS_EFSM_DESIGNER_SNAPSHOT_V3` and carries the selected `application_id`, canonical `source_path`, base hash and definition;
- the OWASYS host FSM is never substituted as the design graph.

Read-only runtime/navigation rendering outside design mode remains the OWASYS host diagnostic projection.

### STATE Create/Rename/Delete are real writes

STATE commands target the selected application ID resolved from the authenticated server-side session.

The backend:

1. resolves the canonical FSM with `FsmSiteLoader`;
2. verifies optimistic `base_sha256` against the live canonical file;
3. applies the semantic command through generic `FsmDefinitionEditor` / `FsmDefinitionValidator`;
4. does not require an unrelated handler catalog for STATE-only operations;
5. persists the complete validated canonical definition using `SiteSourceWorkspace` inside the allow-listed Composer operation;
6. returns the new canonical source hash;
7. the browser reloads Conception and therefore re-reads the persisted selected-application FSM.

The resulting path remains:

`owasys-front -> secured REST -> owasys-back -> Composer -> SiteSourceWorkspace -> selected application canonical FSM`.

### Direct STATE creation UX

STATE Create opens the STATE ID editor directly. It no longer requires a second undocumented click on the SVG canvas. Geometry remains presentation data and is not inserted into STATE semantics.

### Handler isolation

R8B3 deliberately does not redirect the existing OWASYS-front PHP handler source editor into a generated application that has no equivalent managed handler source yet.

For selected applications other than `owasys-front`:

- STATE CRUD remains available;
- handler catalog/source authoring and transition handler binding are disabled rather than silently mutating OWASYS-front.

Target-specific generated-application GUARD/ACTION source authority is a separate subsequent slice.

## Generic scaffold repair

`SiteScaffoldPlan` now declares canonical signals:

- generated presentation navigation signals: `origin=user`;
- generated backend `dispatch_api`: `origin=automatic`.

`ProfilerEnvironmentScaffoldPolicy` now removes:

- profiler state;
- `open_profiler` signal;
- transitions from profiler;
- transitions to profiler;
- transitions driven by `open_profiler`;
- profiler membership from finite global source sets, dropping an empty global transition if necessary.

The currently recreated `sites/essai/config/application.fsm.json` is migrated in the same differential slice: canonical `open_home` signal added and every profiler residue removed.

## Differential scope

Exactly 10 paths are modified:

- `Opus/Fsm/FsmSiteLoader.php`
- `Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`
- `sites/essai/config/application.fsm.json`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/js/fsm-designer.js`

No JavaScript is added to `sites/owasys-back`.

## Applicator safety

The differential applicator is bound to exact HEAD `76b5919...` and exact audited Git blob IDs for all 10 paths. It refuses any divergent baseline or tracked dirty tree.

All transformations are prepared in memory. Proposed PHP is parsed with `TOKEN_PARSE` and JSON is decoded before the first write. Writes are atomic and any write-phase failure restores all previously written original bytes.

## Owner acceptance gate

1. apply R8B3;
2. lint changed PHP and JavaScript;
3. regenerate Composer autoload;
4. validate `owasys-front`, `owasys-back` and `essai`;
5. restart front/back;
6. select `essai` as current application;
7. enter Conception and verify the graph is the small canonical `essai` FSM, not OWASYS-front;
8. STATE Create -> enter a temporary ID -> validate;
9. verify page reload and the new STATE remains visible;
10. verify `sites/essai/config/application.fsm.json` contains the new pure `{id: ...}` state and remains valid;
11. repeat rename/delete as needed;
12. inspect correlated front/back Profiler/log events;
13. no commit/push before this gate passes.