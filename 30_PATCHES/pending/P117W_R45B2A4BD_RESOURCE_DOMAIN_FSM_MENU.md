# P117W R45B2A4BD — Resource-domain FSM menu

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

GitHub OPUS HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BC was applied locally for runtime validation but is not owner committed/pushed. A4BD is therefore cumulative over A4BB and carries the A4BC visibility correction forward.

## Governing owner model

OWASYS is used as a developer/admin workspace.

The menu is not a list of every FSM state and the active dropdown is not a container for global navigation.

### Resource domains

Without current application:

`Applications`

With a current application:

`Applications | Application | Sources de données | Structure | Sécurité | FSM | Sources et Git | Construction et validation`

`Compte`, password and logout are OWASYS operator chrome and remain outside the application-resource menu.

### FSM projection

- top-level menu items = user navigation transitions between resource domains;
- active-resource dropdown = only internal user operations explicitly declared `menu=true` on local transitions;
- global `open_*` navigation signals are never rendered in the active-resource dropdown;
- automatic signals are never menu operations;
- diagram remains a complete projection of the canonical FSM and may still expose actionable navigation/header/internal transitions independently of menu placement;
- color remains signal origin only (`user` vs `automatic`), unrelated to HTTP transport or menu placement.

## Application context semantics

Opening `Applications` must not clear the current application.

A4BD introduces `open_applications` as pure navigation to Registry. Existing `change_app` is kept hidden for explicit/fallback context-clearing semantics.

Selection or successful creation now enters a dedicated `application` state/resource instead of entering `data` directly.

## New current-application resource

New canonical state:

- id/module/route: `application`;
- requires auth + current app;
- ACL resource: `application`;
- canonical signal: `open_application`;
- simple SCORE read surface showing current application identity/type/root.

No fake update/delete implementation is claimed by this delivery.

## Applications internal operation

The existing real Registry POST operation `create-new-app` is bound to local FSM signal `create_new_app` and becomes the first explicit active-resource dropdown operation.

Selection and deletion remain row/context operations in the Applications SCORE page because they require an application identifier and delete confirmation.

## Files

Exactly 33 complete files:

1. `sites/owasys-front/application/default/controllers/RuntimeController.php`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`
3. `sites/owasys-front/application/default/templates/partials/navigation.score`
4. `sites/owasys-front/config/acl.json`
5. `sites/owasys-front/config/fsm.json`
6. `sites/owasys-front/config/routes.json`
7. `sites/owasys-front/config/routes.localized.json`
8. `sites/owasys-front/application/application/templates/index.score`
9. 25 base-language catalogs under `sites/owasys-front/application/application/local/*.json`.

No backend or JavaScript file is changed.

## Artifact

`opus_p117w_r45b2a4bd_resource_domain_fsm_menu.zip`

SHA-256:

`3afb61e6524ffdb9c151972d584143b8f0b4c37c25b6da7c53409b34fa5b7e55`

## Pre-delivery validation

- `NavigationBuilder.php` lint OK;
- `RuntimeController.php` lint OK;
- 4 changed JSON configuration files parse;
- 25/25 application I18n catalogs parse;
- isolated behavioral smoke: `A4BD_SMOKE_OK`;
- authenticated/no-app -> `Applications` resource menu only;
- selected app -> exactly Registry + seven current-app resource domains;
- `data` active -> no `open_*` signal in active dropdown;
- Registry active -> only real generic `create_new_app` operation is projected;
- `open_applications` keeps current application context;
- select/create targets `application`;
- account/password/login are not application-domain menu items;
- diagram actionability data (`signals`/`global_signals`) remains available to `FsmDiagramBuilder` independently from menu rendering.

## Explicit non-goal / next work

A4BD fixes the resource/navigation/operation architecture. It does not invent unavailable CRUD.

Next deliveries must implement actual guarded CRUD/domain operations through the contractual front -> secured REST -> back -> Composer flow, beginning with the current `Application` resource and then Data/Structure/FSM as their backend operations are defined.
