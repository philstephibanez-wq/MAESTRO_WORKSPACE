# P117W R45B2A4BZ2 R8B6P — Dependency-safe transition delete — SPEC

State: OWNER FUNCTIONALLY ACCEPTED AND PUSHED — FRESH RESPONSE-TIME LOGS PENDING

## Gate

- README-FIRST blob: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS exact owner baseline: `23be733f401ff526ff4d32a64277e6af1778f024`.
- R8B6O Bézier handles and persistence are owner accepted and pushed.
- The applicator must verify that its local worktree is clean on that exact
  commit before extraction.

## Runtime evidence and root cause

The supplied correlated traces contain eight rejected semantic requests:

- one duplicate `transition.create`, rejected by
  `OPUS_EFSM_TRANSITION_ID_DUPLICATE`;
- seven attempts to delete state `test`, all correctly rejected by
  `OPUS_EFSM_STATE_DELETE_DEPENDENCY` because transition `transac` targets it.

The safe backend invariant is correct. The dead-end is the toolbar: the
TRANSITION Delete control is a permanent disabled SCORE stub and OPUS exposes
no `transition.delete` semantic command. The owner therefore cannot remove the
dependency before deleting the state.

## Semantic contract

R8B6P adds one bounded generic OPUS command:

- `transition.delete` accepts `transition_id` plus an exact typed
  `confirmation`;
- the canonical transition must exist;
- exactly that transition is removed;
- the whole resulting EFSM is validated before persistence;
- the command passes through owasys-front -> secured REST -> owasys-back ->
  allow-listed Composer;
- optimistic `base_sha256`, empty semantic history and atomic canonical source
  write remain mandatory;
- the removed transition's signal is never deleted automatically;
- if no remaining transition uses that signal, its canonical ID is returned as
  `signal_orphaned` for an explicit later decision.

The generic layout store already filters geometry against canonical transition
IDs. Deleted-transition geometry is therefore ignored immediately and pruned
by the next normalized layout write; semantic deletion never writes arbitrary
browser geometry.

## Toolbar contract

- TRANSITION Delete is enabled only for a selected canonical transition.
- A dedicated confirmation form names the selected transition.
- STATE Delete is disabled client-side while dependent transition IDs exist.
- The STATE inspector lists `dependent_transitions`; the backend invariant
  remains authoritative even if the browser preflight is bypassed.
- After a successful persisted mutation, the post-reload status displays the
  operation, canonical hash, measured browser request duration and any orphaned
  signal ID.
- Every designer `fetch` records its measured duration under
  `data-fsm-last-response-ms`; OPUS Profiler traces remain the authoritative
  distributed measurement.

## Response-time baseline

From the supplied 2026-08-27 front/back traces, excluding the favicon request:

| Request class | n | min ms | p50 ms | p95 ms | max ms |
|---|---:|---:|---:|---:|---:|
| GET `/fr-FR/navigation` | 8 | 284.316 | 425.903 | 613.227 | 613.227 |
| POST layout write | 2 | 122.809 | 124.207 | 125.604 | 125.604 |
| POST semantic accepted | 2 | 150.401 | 162.228 | 174.054 | 174.054 |
| POST semantic rejected | 8 | 129.714 | 139.911 | 145.859 | 145.859 |

R8B6P runtime acceptance must publish the same class-separated table from
fresh logs. Any repeated request above one second or material increase over
this accepted local baseline must be investigated by correlated trace before
the slice is closed.

## Exact OPUS/OWASYS surface

- `Opus/Fsm/Definition/FsmDefinitionEditor.php`;
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

No backend JavaScript and no application-specific EFSM workaround are added.

## Runtime acceptance

1. Select transition `transac`; TRANSITION Delete becomes active.
2. A wrong confirmation must be rejected without source modification.
3. Confirm exactly `transac`; the transition disappears after reload.
4. The status contains `transition.delete`, the measured milliseconds and an
   orphan signal only when the deleted transition was its last consumer.
5. View and Design both remain consistent; the Bézier geometry of unrelated
   transitions is unchanged.
6. Select state `test`; STATE Delete is now available and can be confirmed.
7. Validate owasys-front, owasys-back and essai, then provide fresh correlated
   profiler logs for the mandatory response-time comparison.

## Scope boundary

Transition rename, signal rename/delete, Validate/Publish and Undo/Redo remain
separate architecture slices. R8B6P removes the observed deletion dead-end; it
does not pretend that the remaining disabled controls are implemented.
## Owner functional acceptance — 2026-08-27

- OPUS owner commit: `3c67eeeec81ae0a1fb9c057308d43a6eb17cf604`.
- The owner reports that the remaining R8B6P toolbar behavior is correct.
- Transition deletion, state deletion after dependency removal, active Bézier
  handles and persistence are functionally accepted.
- A separate presentation-identity defect was then isolated: renaming a state
  leaves its layout coordinate under the old state ID, so the new ID receives
  an automatic coordinate. That root cause is assigned to R8B6Q.
- No profiler/log bundle produced after owner commit `3c67eee...` was supplied.
  R8B6P is therefore not declared response-time-accepted; fresh class-separated
  timings are carried into the R8B6Q owner gate.
