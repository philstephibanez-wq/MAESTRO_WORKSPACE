# P117W R45B2A4G — Signal-driven FSM interaction

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS committed base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96` (R45B2A4E)
Compatible local base: R45B2A4E or locally-applied R45B2A4F
Previous semantic contract: R45B2A4F finite states + NMI exception

## Owner correction

A FSM UI must not use the destination state as the command surface. The current state is the context; the outgoing signal is the event/control that requests a transition.

Therefore:

- state boxes are passive representation of the finite state domain;
- the current state is highlighted as context;
- selectable controls are outgoing signals enabled by the current state;
- clicking a signal follows the corresponding existing localized GET route;
- the route resolves back to the exact FSM signal through `OPUS_SIGNAL_ROUTES_V2`;
- signals requiring POST/body/runtime context are not turned into GET links;
- NMI remains out-of-band and is never exposed as a normal navigation control.

## Generic OPUS evolution

`OPUS_FSM_Diagram` gains optional transition links keyed by transition id.

This is deliberately generic:

- state links remain available for compatibility but OWASYS stops supplying them;
- `setTransitionLinks()` accepts only known transition ids and local absolute paths;
- linked signal labels are native SVG anchors;
- no JavaScript is required;
- technical signal/guard/effect semantics remain attached to the transition tooltip.

## OWASYS projection

`OwasysFsmDiagramBuilder` becomes a current-state signal projection:

1. consume the same ACL/I18n ordered visible state projection as the menu;
2. reject any normal `from:"*"` source;
3. ignore explicit NMI in the principal navigation surface;
4. retain only transitions whose source equals the current finite state;
5. retain only state-changing transitions between visible principal states;
6. retain only signals present in `config/routes.json` (`OPUS_SIGNAL_ROUTES_V2`) as interactive navigation transitions;
7. target state boxes stay passive;
8. signal controls display the technical signal id and translated target label;
9. signal controls are sorted by the menu target order;
10. all other canonical signals remain visible/auditable through the 44/44 inventory and Profiler.

The SCORE partial renders an explicit current-state signal-control strip above the SVG. The same signal labels on SVG edges are also links. No JS is introduced.

## Finite-state cumulative correction

Because OPUS master is still committed at R45B2A4E, this delivery is cumulative and does not assume that R45B2A4F was committed.

The runner accepts either R45B2A4E or a locally applied R45B2A4F and ensures:

- `states[]` is the finite state domain;
- state id `*` is forbidden;
- normal `from:"*"` is forbidden;
- only explicit `interrupt:"nmi"` may retain `from:"*"`;
- normal legacy global transitions are expanded over the finite declared state list;
- OWASYS front `auth_required` remains NMI;
- OWASYS back `fail` remains NMI;
- generated application FSMs already present locally are migrated so existing previews remain compatible;
- new `SiteScaffoldPlan` output contains finite explicit normal sources.

## Visible acceptance

On a principal page such as `build`:

- no destination state box is clickable;
- a strip begins with the translated current state `Construction et validation`;
- available controls are signal-centric, e.g. `change_app → Applications`, `open_data → Sources de données`, `open_structure → Structure`, etc.;
- the current state's self-navigation signal is not shown as a useless self-control;
- every projected SVG signal is clickable and maps to the same route as its control strip;
- the CSS cache key changes to `p117w-r45b2a4g`, making the visual change observable without reusing the R45B2A4E stylesheet;
- canonical non-navigation signals remain in the 44/44 inventory but are not mislabeled as GET navigation actions.

## Delivery

Artifact: `opus_p117w_r45b2a4g_signal_driven_fsm_ui.zip`
SHA-256: `35c5ec12e2bd5e7ae6fc82f8f4c5f8dc7a24dcee98a5ac9cedf07f8c55f79939`

ZIP entry:

- `tools/apply_p117w_r45b2a4g_signal_driven_fsm_ui.php`

The runner lints all patched PHP before writing, migrates structured FSM configuration through `StructuredFileLoader`, writes through `File`, rolls back on failure, proves that normal global sources are rejected, proves NMI remains accepted, validates OWASYS front/back under the strict processor, and asserts that OWASYS no longer supplies destination-state links.