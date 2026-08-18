# P117W R45B2A4BB — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS HEAD:

`e0267052c0ca9442b492f36dfc1daad5c40d7508` — `opus_p117w_r45b2a4ba_current_state_only_fsm_menu`

A4BA is owner committed/pushed and is the exact source baseline.

## Accepted architecture

The owner established the governing definition:

**workflow = FSM**.

- OWASYS FSM = workflow of the developer operating OWASYS.
- Selected application FSM = workflow of the application being developed.
- These are two different machines.
- A standalone OWASYS module named `Workflows` is therefore semantically wrong.
- The selected application's FSM must be visible in OWASYS and also in the generated application's development environment.

Repository audit confirms generated applications already receive `config/application.fsm.json` and `GeneratedSiteRuntime` already renders that FSM, so A4BB does not duplicate generated-runtime functionality.

## Root cause in A4BA

The canonical OWASYS FSM still exposes:

- state/module/route `workflows`;
- signal `open_workflows`;
- transition `g_open_workflows`;
- ACL resource `workflows`;
- localized Workflows routes.

But `sites/owasys-front/application/workflows/` has no implementation beyond scaffold placeholders.

## A4BB correction

### User-visible semantic

`Workflows` becomes **FSM**:

- module `fsm`;
- route `fsm`;
- label/title `FSM`;
- signal `open_fsm`;
- transition `g_open_fsm`;
- ACL resource `fsm`.

### Session compatibility

The internal state id `workflows` is intentionally retained for this migration so A4BA `OPUS_FSM_RUNTIME_SNAPSHOT_V1` sessions do not fail restore with an unknown state.

It is a temporary technical identifier only. The UI, route, signal, ACL and diagram label use FSM semantics.

### Route compatibility

Canonical route for all supported locales is now `/fsm`.

The historical localized Workflows paths remain only as alias `workflows -> fsm`; for example French `/flux-de-travail` resolves to FSM, while generated navigation uses `/fsm`.

### Selected-application FSM surface

A4BB adds:

`sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`

and:

`sites/owasys-front/application/fsm/templates/index.score`

`ApplicationFsmModel` uses the already secured `OwasysSourceModel::read()` boundary. Therefore the actual flow remains:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer source-read -> response -> owasys-front`.

No target-application path is read directly by `owasys-front`.

Generated apps use:

`config/application.fsm.json`

Protected OWASYS apps use their existing:

`config/fsm.json`

The JSON is parsed with `Opus\File\Json`, validated, and rendered by `OPUS_FSM_Diagram`.

## UI result expected

After selecting an application:

```text
... Sources de données  Structure  Sécurité  FSM  Sources et Git  Construction et validation ...
```

Opening `FSM` must show the selected application's FSM diagram inside the body.

The normal OWASYS `Navigation principale · FSM` diagram remains separately visible in the layout. The two diagrams must not be confused:

- outer/main diagram = OWASYS workflow;
- FSM module body = selected application's workflow.

## I18n

25 base-locale module catalogs are provided under:

`sites/owasys-front/application/fsm/local/`

Each defines the language-neutral acronym `menu.fsm = FSM`. Shared text continues through the global catalog fallback.

## Files

Exactly 33 complete files:

1. `sites/owasys-front/application/default/bootstrap.php`
2. `sites/owasys-front/application/default/controllers/RuntimeController.php`
3. `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
4. `sites/owasys-front/application/fsm/templates/index.score`
5. 25 `application/fsm/local/*.json` catalogs
6. `sites/owasys-front/config/acl.json`
7. `sites/owasys-front/config/fsm.json`
8. `sites/owasys-front/config/routes.json`
9. `sites/owasys-front/config/routes.localized.json`

No backend or JavaScript file is changed.

The obsolete empty `sites/owasys-front/application/workflows/` directory must be removed by owner cleanup after extraction.

## Delivery

Artifact:

`opus_p117w_r45b2a4bb_application_fsm_resource_surface.zip`

SHA-256:

`6bd7eb8a80c05761b8688018f601821898d53c0b15b3f1accf5641a8e0b6e7e8`

## Exact source-integrity reversal

Validated against owner A4BA blobs:

- FSM -> `5595cd8be05f01e6d8f2b8a1dd519e6ea9675c3c`;
- routes -> `f6718ac5f084ec1652f304a8183013bfab8a938e`;
- ACL -> `460d44acd922a867c0d7e0c23681ec740a066515`;
- localized routes -> `18b97e6491e8b31343d85aeafea187be6ccd8c77`;
- RuntimeController -> `5067de83d3a9600bee0985376f6c66fa63c8fa13`;
- bootstrap -> `6c9ceed1be9f804cf6aa5c927ae404f02943bb40`.

## Pre-delivery validation

- `php -l` bootstrap OK;
- `php -l` RuntimeController OK;
- `php -l` ApplicationFsmModel OK;
- smoke `A4BB_SMOKE_OK`;
- generated application source path validated;
- OWASYS front/back system FSM source path validated;
- global-transition validation covered;
- 25/25 locale catalogs validated;
- no active `open_workflows` or `menu.workflows` remains in canonical active FSM/routes/ACL;
- localized Workflows wording exists only in compatibility alias paths;
- no trailing whitespace;
- ZIP exactly 33 files.

## Owner runtime acceptance

1. Extract A4BB over `e0267052...`.
2. Delete obsolete empty `application/workflows` directory.
3. Start back then front.
4. Select a generated application.
5. Verify `FSM` replaces `Workflows` in Menu = FSM.
6. Verify canonical page URL is `/<locale>/fsm`.
7. Verify old French `/flux-de-travail` remains accepted only as a legacy alias.
8. Verify the FSM page body renders the selected application's own canonical FSM.
9. Verify the main OWASYS FSM diagram remains present as the separate OWASYS workflow.
10. Verify source-read REST/Composer evidence for `config/application.fsm.json`.
11. Verify `owasys-front` and `owasys-back` can show their `config/fsm.json` definitions when selected.
12. Verify no regression of guarded menu actionability, signal-origin colors, Security, Sources/Git, Build or Profiler.

## Explicit non-goal / next delivery

A4BB is a read-only canonical FSM surface. It does not claim CRUD.

Next delivery: guarded FSM-resource CRUD for states, signals, transitions, guards and actions through explicit REST resources and backend/Composer mutation contracts, with validation/preview before commit. A raw JSON textarea is not accepted as the final FSM editor.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
