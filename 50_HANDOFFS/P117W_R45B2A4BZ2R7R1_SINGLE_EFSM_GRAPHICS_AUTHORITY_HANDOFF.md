# P117W R45B2A4BZ2R7R1 — Single EFSM graphics authority handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## OPUS baseline

`72101e0cfb77f2933284371e142d30b3d30073ad`

## Artifact

`opus_p117w_r45b2a4bz2r7r1_single_graphics_authority.zip`

ZIP SHA-256:

`04465093ad87e87070f5cc490d3a7a9f40298ad0133e29540376996a00ebe307`

Applicator SHA-256:

`3bb82ff9cbec9b80996642468874cf91f02fa2cbb71960960475df65e0745b05`

The ZIP contains one differential applicator: `apply_a4bz2r7r1.php`.

The applicator requires the exact clean baseline above and never commits or pushes OPUS/OWASYS.

## Changed paths after application

Exactly nine paths:

- `Opus/Fsm/Diagram.class.php`
- `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/fsm.layout.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

No backend JavaScript or TypeScript is introduced.

## Delivered result

The user-facing `FSM` navigation destination is removed from OWASYS. The canonical runtime EFSM no longer contains the obsolete `workflows` state, the `open_fsm` navigation signal, nor the `create_fsm/read_fsm/update_fsm/delete_fsm` user-menu operation signals. Related transitions and route mappings are removed, and remaining global source sets are refactored.

The portable graphics file remains `sites/owasys-front/config/fsm.layout.json`, vertical, with all surviving coordinates/transition geometry preserved. Geometry belonging to removed EFSM objects is pruned and `definition_sha256` is refreshed.

The generic diagram renderer gains an explicit persistence opt-out. `OwasysApplicationFsmModel`, which is a read-only projection of a selected application's FSM, uses that opt-out. It therefore cannot auto-discover or overwrite the host OWASYS `fsm.layout.json`.

This corrects the observed two-diagram problem at its cause: the read-only application FSM projection previously rendered horizontally while the canonical OWASYS diagram rendered vertically; both could bind to the same layout store during a DEV request.

If a live PHP session still references a state removed from the canonical definition, `OwasysRuntimeController` clears only that stale EFSM snapshot, resets to the canonical initial state, and profiles `fsm/runtime.snapshot.reset`. Other snapshot errors still propagate.

## Validation performed before delivery

- applicator itself: `php -l` OK;
- complete synthetic clean-Git fixture: applicator applied end-to-end;
- generated `Diagram.class.php`: `php -l` OK;
- generated `ApplicationFsmModel.php`: `php -l` OK;
- generated `RuntimeController.php`: `php -l` OK;
- generated `FsmDiagramBuilder.php`: `php -l` OK;
- fixture assertions: `workflows` absent;
- fixture assertions: all five obsolete FSM menu signals absent;
- fixture assertions: no remaining transition references removed state/signals;
- fixture assertions: canonical and localized `fsm` routes absent;
- fixture assertions: layout remains vertical and obsolete layout entries are pruned;
- fixture assertions: read-only application projection contains `persistLayout:false`;
- fixture assertions: generic renderer exposes `persistLayout=true` default;
- fixture assertions: stale runtime snapshot reset path is present;
- second applicator execution refused with exit code 20.

The fixture exercises the complete applicator transaction and semantic transforms. Owner validation on the real `H:\OPUS` checkout remains required.

## Expected marker

`P117W_R45B2A4BZ2R7R1_APPLIED`

Additional markers:

- `menu_fsm=removed`
- `efsm_state_workflows=removed`
- `graphics_authority=config/fsm.layout.json`
- `readonly_projection_layout_persistence=disabled`
- `layout_direction=vertical`
- `changed_files=9`

## Owner validation

After application:

1. lint the four changed PHP sources;
2. regenerate Composer autoload;
3. validate `owasys-front` and `owasys-back`;
4. verify the top navigation no longer contains `FSM`;
5. open the developer EFSM designer through its designer control/query and verify the canonical diagram uses the persisted vertical layout;
6. refresh/change normal OWASYS pages and verify the diagram geometry remains stable;
7. verify `config/fsm.layout.json` stays vertical and is not rewritten to a second layout contract;
8. inspect `git status --short`; expected exactly nine changed paths;
9. commit/push only after owner validation.

## Next slice

After owner validation, resume developer tooling: real PHP GUARD/ACTION authoring from the EFSM designer through `owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> response -> owasys-front`.
