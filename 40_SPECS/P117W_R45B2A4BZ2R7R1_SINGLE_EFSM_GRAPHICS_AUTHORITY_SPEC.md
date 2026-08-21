# P117W R45B2A4BZ2R7R1 — Single EFSM graphics authority

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Baseline

OPUS baseline: `72101e0cfb77f2933284371e142d30b3d30073ad` (`opus_p117w_r45b2a4bz2r7_authoritative_handler_binding`).

## Root cause

OWASYS currently exposes two distinct FSM rendering paths for the same `owasys-front` canonical EFSM.

1. The normal OWASYS EFSM surface is built by `OwasysFsmDiagramBuilder`, which renders the canonical `config/fsm.json` vertically and uses the portable `config/fsm.layout.json` presentation store.
2. The user-visible `FSM` menu enters state `workflows`; `OwasysRuntimeController` then asks `OwasysApplicationFsmModel` to render the selected application's FSM. For `owasys-front`, that model reads the same canonical `config/fsm.json`, but calls `OPUS_FSM_Diagram::renderDefinition()` with its default horizontal direction.
3. `FsmDiagramLayoutStore::discover()` binds that second render to the host `owasys-front/config/fsm.layout.json`. Because the stored direction is vertical while the second renderer requests horizontal, `loadPersisted()` rejects the existing layout and `resolve()` may persist the automatically generated horizontal layout in DEV.
4. The normal vertical renderer can then regenerate/persist vertical geometry again. Therefore the same graphics file can be rewritten under two rendering contracts, producing visibly different diagrams.

This is the cause to remove. It is not a CSS issue and not two independent canonical graphics files.

## Invariants

- OPUS is a framework; the EFSM is its execution engine.
- `FSM` is not a user navigation destination in OWASYS.
- The EFSM designer is developer tooling, not a user-facing runtime state/module.
- `sites/owasys-front/config/fsm.json` remains the canonical EFSM definition.
- `sites/owasys-front/config/fsm.layout.json` is the single portable graphics authority for that definition.
- A read-only projection of an arbitrary FSM definition must never auto-discover and mutate the host application's layout file.

## Generic OPUS correction

`OPUS_FSM_Diagram::renderDefinition()` gains an optional final boolean `persistLayout` parameter, default `true` for existing canonical runtime rendering.

When `persistLayout=false`, the renderer does not discover or write `FsmDiagramLayoutStore`.

`OwasysApplicationFsmModel` explicitly renders its read-only projection with `persistLayout:false` so a remotely/read-only sourced definition cannot mutate the OWASYS host layout.

No new concrete OPUS framework class is introduced.

## OWASYS navigation correction

Remove the obsolete user-facing FSM destination from the canonical OWASYS runtime EFSM:

- remove state `workflows`;
- remove signals `open_fsm`, `create_fsm`, `read_fsm`, `update_fsm`, `delete_fsm`;
- remove transitions using those signals or the removed state;
- remove `workflows` from remaining finite global `from_states` sets;
- remove canonical route `fsm -> open_fsm`;
- remove localized public route `fsm`.

The ACL resource `fsm` is retained because `fsm:update` remains the authorization capability for the developer designer.

## Graphics migration

`config/fsm.layout.json` remains `OPUS_FSM_DIAGRAM_LAYOUT_V4` and `layout_direction=vertical`.

The migration removes presentation entries for the deleted `workflows` state and for transitions no longer present in the canonical EFSM, preserves all remaining persisted geometry, and updates `definition_sha256` to the new canonical `fsm.json` bytes.

## Runtime snapshot compatibility

Removing a canonical state can leave an existing PHP session with a stale EFSM runtime snapshot. `OwasysRuntimeController` must detect only `OPUS_FSM_RUNTIME_SNAPSHOT_STATE_UNKNOWN:*`, clear that obsolete snapshot, reset the processor to the canonical initial state, and emit a profiler event `fsm/runtime.snapshot.reset`. Other restore errors remain fatal.

## UI revision

The visible FSM partial no longer says `menu = FSM`; revision marker becomes `A4BZ2R7R1`.

## Acceptance

- no `FSM` top-level menu item is generated;
- canonical `fsm.json` contains no `workflows`, `open_fsm`, or FSM CRUD menu signals;
- public/localized route catalogs contain no `fsm` route;
- canonical vertical `config/fsm.layout.json` remains the single graphics persistence authority;
- read-only `OwasysApplicationFsmModel` cannot mutate any host layout file;
- stale session state removed by the new definition resets safely and is profiled;
- PHP lints pass;
- `composer opus:validate-site -- owasys-front` and `-- owasys-back` remain owner acceptance checks;
- no JavaScript is added to `sites/owasys-back`.
