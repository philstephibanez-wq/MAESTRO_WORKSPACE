# P117W R45B2A4BD — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

GitHub OPUS HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BC is applied locally for validation but not owner committed/pushed. A4BD is cumulative over A4BB and includes the A4BC context-visibility correction.

## Owner runtime evidence leading to A4BD

After A4BC, the selected-application menu correctly reduced to permanent modules, but the active `Sources de données` dropdown still contained global navigation signals (`open_structure`, `open_security`, `open_fsm`, `open_source`, `open_build`, etc.).

Owner clarified the developer/admin contract:

- `Applications` = registry/application collection operations;
- after an application is in context: `Application`, `Données`, `Structure`, `Sécurité`, `FSM`, `Sources`, `Build`;
- top-level menu = navigation between those resource domains;
- active item dropdown = only internal CRUD/operations of that resource;
- account/password/logout are OWASYS operator chrome, not selected-application resources;
- application Security owns target-application identities/accounts/roles/permissions/ACL.

## Root causes

1. `NavigationBuilder` hosted global navigation under the current state dropdown.
2. `change_app` doubled as navigation to Registry and destructive `clear_current_app` action.
3. There was no dedicated current-application resource state.
4. selection/creation entered `data`, skipping an application-level workspace.
5. account/password states were still marked as permanent top-menu items.

## A4BD correction

### Top-level resource navigation

Menu resources are now projected from global user navigation signals onto their target states. Inactive resources are direct links. The active resource is highlighted.

Global navigation projections are still retained internally for `FsmDiagramBuilder`, so diagram actionability does not depend on whether the signal is rendered in the top menu or header.

### Active-resource operations only

`NavigationBuilder` maintains two distinct projections:

- `signals` / `global_signals` = complete actionability facts consumed by the FSM diagram;
- `operations` = local current-state user signals explicitly `menu=true` and target-accessible.

`navigation.score` renders only `operations` inside the active resource dropdown. It never renders `global_signals` there.

A resource with no declared operation has no dropdown arrow.

### Applications navigation no longer destroys context

New signal/transition:

`open_applications -> registry`

No `clear_current_app` action.

The historical `change_app` remains hidden for explicit/fallback clearing semantics.

The header `Changer` link therefore opens Applications without silently destroying the current working context.

### Current Application resource

New state:

`application`

with:

- module `application`;
- route `/application`;
- ACL `application:open`;
- signal `open_application`;
- requires current application;
- SCORE read surface for current app id/type/root.

`select_app` and successful `application_created` now target `application` instead of `data`.

### Resource menu after current app exists

Expected developer/admin menu:

`Applications | Application | Sources de données | Structure | Sécurité | FSM | Sources et Git | Construction et validation`

No `Compte` or password item in this resource menu; OWASYS operator account remains in the global header.

### First explicit internal operation

Registry's already-existing no-argument POST `create-new-app` is mapped to local signal `create_new_app` and can appear in `Applications` dropdown.

Context-specific row operations `select-app` and `delete-app` remain on the Applications page because they require row data/confirmation.

No unavailable Data/Structure/Application/FSM CRUD is invented.

## Artifact

`opus_p117w_r45b2a4bd_resource_domain_fsm_menu.zip`

SHA-256:

`3afb61e6524ffdb9c151972d584143b8f0b4c37c25b6da7c53409b34fa5b7e55`

Exactly 33 complete files.

## Validation performed

- PHP lint: RuntimeController OK;
- PHP lint: NavigationBuilder OK;
- config JSON parse OK;
- 25 application locale catalogs parse OK;
- smoke: `A4BD_SMOKE_OK`;
- no current app -> Applications only in resource menu;
- current app -> exactly eight resource domains visible for developer;
- current `data` -> zero active dropdown operations and no leaked `open_*` navigation;
- current Registry -> `create_new_app` is the only generic internal menu operation currently declared;
- `Application` navigation is guard-enabled only with current app;
- Applications navigation preserves current app;
- selection/creation enter Application;
- A4BC hidden creation states remain in canonical FSM/diagram but not permanent menu.

## Owner runtime acceptance

1. Apply A4BD over the current local tree (A4BC may already be applied).
2. Start `owasys-front` (back remains required for normal OWASYS data operations).
3. With no selected app, verify top resource menu contains `Applications` only.
4. Select an app and verify redirect lands on `/<locale>/application`, not Data.
5. Verify menu becomes exactly:
   `Applications | Application | Sources de données | Structure | Sécurité | FSM | Sources et Git | Construction et validation` subject to ACL.
6. Verify `Compte` and password are absent from that menu but OWASYS `Compte` remains in header.
7. Click `Sources de données`: there must be no dropdown when no internal Data operation is declared; specifically no `change_app`, `open_creation`, `open_structure`, `open_security`, `open_fsm`, `open_source`, `open_build`, `open_account` inside it.
8. Verify clicking `Structure`, `Sécurité`, `FSM`, Sources and Build navigates directly via their global FSM navigation signal.
9. Click `Applications` while a current app exists: current-app header must remain populated and all current-app resource items must remain visible.
10. On Applications, verify dropdown contains only the real generic `create_new_app` operation; row select/delete remain page-level context operations.
11. Verify the main OWASYS FSM diagram still contains global navigation, internal creation states and signal-origin colors.
12. Verify current-app FSM surface A4BB remains available under `FSM`.

## Next delivery

Implement real guarded CRUD for the current `Application` resource first, using explicit REST resources and back/Composer operations. Then proceed resource-by-resource (Data, Structure, FSM, etc.) without creating menu operations before their backend contracts exist.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
