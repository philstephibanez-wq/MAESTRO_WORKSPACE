# P117W R8SEC2E — Handoff

Date: 2026-09-06
Status: OWNER VALIDATION REQUIRED

## Evidence before delivery

Fresh runtime evidence shows `owasys-back` healthy and `owasys-front` failing HTTP 500 with `OWASYS_NAVIGATION_STATE_TYPE_INVALID` at `sites/owasys-front/application/default/services/NavigationBuilder.php:105`.

The three site validations pass after the local generic `SiteCommandService::modules()` correction that ignores moduleless pure EFSM states.

## Root cause

`OwasysNavigationBuilder` still projected all EFSM states as human-navigation resources. Pure NMI control states `security_quarantine` and `fault` are intentionally moduleless and must remain outside the menu/application-module projection.

## Delivered correction

`R8SEC2E.zip` contains one complete final repository file:

`sites/owasys-front/application/default/services/NavigationBuilder.php`

Behavior:

- all states remain registered canonically;
- moduleless control states are not projected as menu entries;
- only `security`, `fault`, `system` are accepted as moduleless control types;
- NMI targets are validated against all EFSM states before menu-target validation;
- non-NMI transitions to moduleless states fail closed;
- no fake modules, routes, templates, views, JS, Node, temporary project files or PHP-in-configuration are introduced.

## Owner validation

Apply ZIP, lint `NavigationBuilder.php`, validate `essai`, `owasys-front`, `owasys-back`, then run both development bastions and reproduce the formerly failing front request. Accept only if the HTTP 500 and `OWASYS_NAVIGATION_STATE_TYPE_INVALID` disappear and no new error is introduced.

Do not reset or overwrite `sites/essai/config/application.fsm.layout.json` or any unrelated owner change.
