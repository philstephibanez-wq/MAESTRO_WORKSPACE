# P117W R45B2A4BZ2 R8B6Q — Transactional state-layout identity refactor — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- Development contract blob: `b30b7cac8e5f2f2921d2f9e862447484111c3f26`.
- OPUS exact clean owner baseline: `3c67eeeec81ae0a1fb9c057308d43a6eb17cf604`.
- R8B6P toolbar behavior is owner functionally accepted; fresh post-commit
  response-time logs remain pending.

## Runtime evidence and root cause

The owner reports that renaming a state changes its diagram position while the
rest of the designer behavior is correct. The pushed owner commit provides
source evidence of the failure mode: semantic state `todelete` became `test2`,
but its presentation entry was not refactored under the new identity and the
new state received a different automatic coordinate.

`FsmDefinitionEditor` already refactors every semantic reference. The defect is
in the separate presentation authority: `FsmDiagramLayoutStore` indexes state
coordinates by canonical state ID, then correctly prunes the now-unknown old
key. Without an explicit identity migration, the renderer treats the renamed
state as a newly created state.

## Generic OPUS contract

R8B6Q corrects the authority boundary rather than moving DOM nodes after reload:

- `FsmDiagramLayoutStoreInterface` exposes a pure optimistic preparation of a
  state-identity refactor;
- the exact `{x,y}` state coordinate moves from the old canonical ID to the new
  canonical ID before stale-entry normalization;
- transition geometry remains keyed by its unchanged canonical transition ID,
  preserving manual paths and cubic Bézier controls;
- finite-global-source marker geometry is copied to the new deterministic
  marker identity when its finite state set changes through the rename;
- the `initial` marker identity remains stable;
- the new definition hash is written into the layout document;
- no browser-authored path, coordinate or semantic definition is accepted.

`SiteSourceWorkspaceInterface` gains a bounded multi-file optimistic write:

- at most sixteen existing allowed source files;
- deterministic lock order, revalidation under lock and per-file post-write
  hash verification;
- rollback to verified original contents if any write or verification fails;
- source contents never enter Logger or Profiler context;
- the existing outer FSM trace contains the nested `source.write_batch` span.

The OWASYS backend invokes that transaction only for a real `state.rename` with
an existing layout. With no layout file or a semantic no-op, canonical writing
keeps its previous path.

## Response-time discipline

Latest measured baseline available from the supplied 2026-08-27 traces:

| Request class | n | min ms | p50 ms | p95 ms | max ms |
|---|---:|---:|---:|---:|---:|
| GET `/fr-FR/navigation` | 8 | 284.316 | 425.903 | 613.227 | 613.227 |
| POST layout write | 2 | 122.809 | 124.207 | 125.604 | 125.604 |
| POST semantic accepted | 2 | 150.401 | 162.228 | 174.054 | 174.054 |
| POST semantic rejected | 8 | 129.714 | 139.911 | 145.859 | 145.859 |

No profiler/log bundle generated after owner HEAD `3c67eee...` is available, so
no R8B6Q timing is invented. Owner acceptance must supply fresh front and back
Profiler JSONL plus correlated logs. Page loads, successful `state.rename`,
rejected semantic requests and presentation writes must each report n, min,
p50, p95 and max separately. The same trace ID must be correlated through
front, REST, back and source write. Repeated requests above one second or a
material increase over the table require investigation before closure.

## Exact OPUS/OWASYS surface

- `Opus/Application/Source/SiteSourceWorkspace.php`;
- `Opus/Application/Source/SiteSourceWorkspaceInterface.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`;
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`;
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`.

No application configuration, backend JavaScript or application-specific EFSM
workaround is included.

## Runtime acceptance

1. Start from exact clean owner HEAD `3c67eee...` and apply `R8B6Q.zip`.
2. Record the selected state's exact `{x,y}` entry in its `.fsm.layout.json`.
3. Rename that state through the canonical toolbar operation.
4. Verify after reload that the old state key is absent, the new state key has
   exactly the same `{x,y}`, and `definition_sha256` matches the FSM file.
5. Verify in View and Design that all related transitions, cards, handles and
   persisted cubic Bézier controls remain attached and unchanged.
6. On an EFSM with finite-global transitions, verify that the source marker
   retains its coordinate after a member state is renamed.
7. Validate owasys-front, owasys-back and essai.
8. Supply fresh correlated front/back JSONL and logs for the class-separated
   response-time table.

## Scope boundary

R8B6Q preserves position for future canonical state renames. It cannot infer
or restore a coordinate already lost before installation. Signal rename/delete,
transition rename, Validate/Publish and Undo/Redo remain separate slices.
