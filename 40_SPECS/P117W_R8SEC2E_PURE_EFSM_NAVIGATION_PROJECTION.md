# P117W R8SEC2E — Pure EFSM navigation projection

Date: 2026-09-06
Status: DELIVERY

## Cause

R8SEC2D correctly models `security_quarantine` and `fault` as pure EFSM control states without an application `module`. `SiteCommandService::modules()` was corrected locally so only states declaring `module` participate in application module validation.

OWASYS front still returned HTTP 500 because `OwasysNavigationBuilder` treated every EFSM state as a navigable application state. It therefore rejected pure control-state types (`security`, `fault`) and, independently, required every transition target to exist in the menu projection before recognizing NMI transitions.

## Contract

- A pure EFSM state is an engine/control object, not a menu resource and not an implicit application module.
- `OwasysNavigationBuilder` registers every valid state in the canonical state registry.
- States without an explicit `module` are excluded from human navigation projection.
- Moduleless control states are accepted only for explicit control types: `security`, `fault`, `system`.
- NMI targets are validated against the canonical EFSM state registry, not against menu items.
- Non-NMI navigation transitions remain fail-closed if they target a non-navigable state.
- No fake `security`/`system` module, route, template, PHP view or presentation artifact is created.
- No JavaScript/Node addition is permitted in `owasys-back`.

## Delivery

R8SEC2E changes only:

`sites/owasys-front/application/default/services/NavigationBuilder.php`

Acceptance requires PHP lint, all three `opus:validate-site` checks, HTTP front runtime without `OWASYS_NAVIGATION_STATE_TYPE_INVALID`, and clean review of the resulting Git diff. Existing unrelated layout changes are preserved.
