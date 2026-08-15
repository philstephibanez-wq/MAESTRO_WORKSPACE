# P117W R45B2A4Q — NavigationBuilder call-site migration handoff

State: OWNER VALIDATION REQUIRED

## Proven failure

A4P resolved the current 500 to `TypeError` at `NavigationBuilder.php:9`.

The current NavigationBuilder constructor requires `siteRoot` then `security`. `RuntimeController` is already migrated, but `CreationController`, `SourceController` and `SecurityController` still call the obsolete single-argument constructor. Because `OwasysFrontApplication::components()` eagerly constructs every controller, the stale call fails before route dispatch and breaks `/applications` as well.

## Artifact

`opus_p117w_r45b2a4q_navigation_builder_callsites.zip`

SHA-256: `a89067c2f5ef51a19aa86f42f7436d0b1342e5bc70718eb02a6d51e4b3b78bca`

## Owner sequence

1. Extract ZIP at `H:\OPUS`.
2. Run `php tools\apply_p117w_r45b2a4q_navigation_builder_callsites.php`.
3. Require `STALE_CALLSITES=0`, `VALID_CALLSITES=4/4`, `GIT_REQUIRED_DIFFS=3/3`.
4. Run Composer autoload optimization and lint the three modified controllers.
5. Restart `owasys-front` dev server.
6. Validate `/fr-FR/applications` first, then Creation, Source/Git and Security routes.
7. Validate that menu = FSM contract remains: state entries are context; outgoing signals are the functional submenu commands; diagram consumes the same projection.
8. Delete the one-shot runner before committing OPUS.
9. Owner commits/pushes OPUS only after validation.

Do not repair generated applications or bypass the NavigationBuilder constructor contract.
