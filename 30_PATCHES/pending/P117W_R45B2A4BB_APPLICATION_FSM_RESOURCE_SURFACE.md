# P117W R45B2A4BB — Application FSM resource surface

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`e0267052c0ca9442b492f36dfc1daad5c40d7508` — `opus_p117w_r45b2a4ba_current_state_only_fsm_menu`

## Governing architecture decision

The owner confirmed that **workflow = FSM**.

Two different machines coexist and must remain distinct:

1. **OWASYS FSM** — workflow of the developer operating OWASYS. It remains the authority for Menu = FSM, guarded actionability and the OWASYS workflow diagram.
2. **Selected application FSM** — workflow of the application being developed. It is an application resource that OWASYS must expose and eventually CRUD.

`Workflows` is therefore not a valid independent OWASYS development module.

## Cause in current owner baseline

The canonical OWASYS FSM still contains a visible `workflows` state/module/route and `open_workflows` signal, while `sites/owasys-front/application/workflows/` contains no functional implementation beyond scaffold placeholders.

Generated OPUS applications already receive `config/application.fsm.json`, and the generic generated runtime already knows how to render that FSM. A second generated-runtime implementation is forbidden.

## A4BB scope

A4BB is the first application-FSM resource surface. It is intentionally **read-only**: no CRUD claim is made yet.

It:

- changes the user-visible OWASYS module semantic from `Workflows` to `FSM`;
- changes canonical frontend route from `workflows` to `fsm`;
- changes canonical signal from `open_workflows` to `open_fsm`;
- changes ACL resource from `workflows` to `fsm`;
- keeps the internal state id `workflows` temporarily so existing `OPUS_FSM_RUNTIME_SNAPSHOT_V1` sessions remain restorable;
- preserves the old localized Workflows URLs only as aliases targeting canonical `/fsm`;
- adds an `application/fsm` SCORE module;
- loads the selected application's canonical FSM through the existing secured REST source boundary (`source.read`), never by cross-application filesystem access from `owasys-front`;
- parses FSM JSON with `Opus\File\Json`;
- validates the canonical FSM structure before rendering;
- renders the selected application's FSM with `OPUS_FSM_Diagram`;
- supports generated applications (`config/application.fsm.json`) and protected OWASYS applications (`config/fsm.json`).

## Runtime architecture

```text
OWASYS front /fsm
       |
       | current application + ACL fsm:open
       v
OwasysApplicationFsmModel
       |
       | OwasysSourceModel::read()
       v
secured REST
       |
       v
owasys-back source.read
       |
       v
allow-listed Composer source-read
       |
       v
canonical FSM JSON
       |
       v
Opus\File\Json -> validation -> OPUS_FSM_Diagram
       |
       v
SCORE FSM application surface
```

The OWASYS FSM diagram remains separately present in the normal OWASYS layout. The selected application's FSM diagram is a second machine shown inside the FSM module body.

## Compatibility migration

The state id `workflows` is retained only as a technical compatibility identifier in A4BB. It is not the user-facing semantic.

Canonical visible/runtime metadata becomes:

```text
state id (temporary legacy): workflows
module: fsm
route: fsm
title/menu key: menu.fsm
signal: open_fsm
transition id: g_open_fsm
```

`routes.localized.json` exposes canonical `/fsm` for every supported base language and preserves the old localized Workflows paths through alias `workflows -> fsm`.

## I18n

A dedicated `application/fsm/local/<base-locale>.json` catalog exists for all 25 base locales. The acronym `FSM` is intentionally language-neutral; global default catalogs remain the fallback for shared summary/common text.

## Files

Exactly 33 complete files are delivered:

- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
- `sites/owasys-front/application/fsm/templates/index.score`
- 25 files under `sites/owasys-front/application/fsm/local/`
- `sites/owasys-front/config/acl.json`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

No backend file changes in A4BB because the existing secured `source.read` REST/Composer contract already provides the exact read capability required.

## Delivery

Artifact:

`opus_p117w_r45b2a4bb_application_fsm_resource_surface.zip`

SHA-256:

`6bd7eb8a80c05761b8688018f601821898d53c0b15b3f1accf5641a8e0b6e7e8`

## Source-integrity checks

Exact owner-baseline reversals were verified before packaging:

- `config/fsm.json` reversal -> Git blob `5595cd8be05f01e6d8f2b8a1dd519e6ea9675c3c`;
- `config/routes.json` reversal -> Git blob `f6718ac5f084ec1652f304a8183013bfab8a938e`;
- `config/acl.json` reversal -> Git blob `460d44acd922a867c0d7e0c23681ec740a066515`;
- `config/routes.localized.json` reversal -> Git blob `18b97e6491e8b31343d85aeafea187be6ccd8c77`;
- `RuntimeController.php` reversal -> Git blob `5067de83d3a9600bee0985376f6c66fa63c8fa13`;
- `bootstrap.php` reversal -> Git blob `6c9ceed1be9f804cf6aa5c927ae404f02943bb40`.

## Pre-delivery validation

- PHP lint: bootstrap, RuntimeController, ApplicationFsmModel OK;
- `A4BB_SMOKE_OK` for generated, owasys-front and owasys-back FSM source selection/validation;
- all JSON configs parse;
- 25/25 FSM base-locale catalogs present;
- canonical active configs contain no `open_workflows` or `menu.workflows`;
- canonical route is `fsm -> open_fsm`;
- ACL is `fsm:*` / `fsm:open`;
- old Workflows localized routes are aliases only;
- ZIP contains exactly 33 complete final-path files;
- no JS/back/backend change;
- no direct target-application filesystem access from frontend.

## Owner acceptance

1. Apply A4BB over owner HEAD A4BA.
2. Remove obsolete empty `sites/owasys-front/application/workflows` directory.
3. Start `owasys-back`, then `owasys-front`.
4. Select a generated application.
5. Confirm menu label `FSM` replaces `Workflows`.
6. Confirm canonical URL is localized `/<locale>/fsm`.
7. Confirm old `/flux-de-travail` resolves as legacy alias and canonical navigation returns to `/fsm`.
8. Open FSM and confirm the selected application's own diagram is rendered inside the page.
9. Confirm the separate OWASYS FSM diagram remains present and is not confused with the selected application's FSM.
10. Confirm back/profiler evidence shows secured source read of `config/application.fsm.json` for a generated app.
11. Select `owasys-front` or `owasys-back` and confirm their `config/fsm.json` can also be visualized.
12. Confirm Menu = FSM actionability, signal-origin colors, source/Git, security and build have no regression.

## Explicit next step

A4BB does **not** yet implement FSM CRUD. The next evolution must expose guarded CRUD over the selected application's FSM resource (states, signals, transitions, guards, actions) through proper REST resources and backend/Composer mutations, with validation/preview before commit. Editing the raw JSON file is not accepted as the final FSM CRUD UX.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
