# P117W R45B2A4BC — Handoff

State: OWNER RUNTIME PARTIAL — CONTEXT VISIBILITY FIXED, RESOURCE/NAVIGATION SEMANTICS FAILED — A4BD FOLLOW-UP

## Baseline

Owner OPUS HEAD remains:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BC was applied by the owner for runtime validation but is not yet committed/pushed in OPUS.

## Owner runtime evidence

A4BC corrected the first visibility defect: after an application is selected, the permanent application domains appear and the creation workflow/result states no longer pollute the permanent menu.

The owner then provided runtime evidence exposing the next architectural defect:

- the active `Sources de données` dropdown contains global navigation signals such as `change_app`, `open_creation`, `open_structure`, `open_security`, `open_fsm`, `open_source`, `open_build`, `open_account`;
- global navigation is therefore incorrectly duplicated inside the current resource dropdown;
- `Compte` and `Changer le mot de passe` are still projected as application-domain menu items although they already belong to the authenticated OWASYS user chrome;
- there is no explicit `Application` resource for the selected current application;
- selecting an application still lands in `data`, which is not the natural developer/admin workspace entry point.

Owner contract is now explicit:

- OWASYS top menu = resource domains;
- navigation signals between resource domains = top-level menu items only;
- active resource dropdown = internal user operations/CRUD of that resource only;
- global navigation signals must never appear in that dropdown;
- OWASYS account/password/logout remain user-chrome concerns, not current-application resource domains;
- `Applications` is the registry CRUD surface;
- once an application is in context, the workspace must expose `Application`, `Données`, `Structure`, `Sécurité`, `FSM`, `Sources`, `Build` subject to ACL;
- `Sécurité` owns application identities/accounts/roles/permissions/ACL; OWASYS operator account remains separate.

## A4BC correction retained by A4BD

A4BC visibility rules remain valid and are carried forward cumulatively:

- creation workflow/result states remain canonical FSM states but are not permanent menu items;
- `requires_current_app` controls visibility of application resource domains;
- login is not shown after authentication;
- ACL remains deny-by-default.

## Superseding correction

A4BD replaces the incorrect Menu = FSM projection semantics while retaining A4BC visibility behavior.

See:

`50_HANDOFFS/P117W_R45B2A4BD_RESOURCE_DOMAIN_FSM_MENU_HANDOFF.md`

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
