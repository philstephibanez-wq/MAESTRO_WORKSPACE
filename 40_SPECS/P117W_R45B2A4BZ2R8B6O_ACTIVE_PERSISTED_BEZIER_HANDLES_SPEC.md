# P117W R45B2A4BZ2 R8B6O — Active persisted Bézier handles — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS exact owner baseline: `9fbcb714d5113e32f881a13bff8925b9dcc29159`.
- Owner worktree: clean.
- R8B6N semantic signal and local-transition creation: owner accepted and pushed.

## Confirmed cause

The Design overlay renders `P0`, `C1`, `C2` and `P3`, but R8B6N attaches no pointer interaction or layout persistence to those elements. The handles are therefore decorative.

## Contract

R8B6O activates the existing native SVG surface without introducing another graph authority:

- `P0` remains the canonical source port and `P3` the canonical target port;
- primary-pointer drag is accepted only on `C1` and `C2`;
- the cubic SVG path and helper lines update during drag;
- signal-card movement remains independent;
- a curve edit writes presentation geometry only through the existing secured FSM-layout resource;
- `fsm.json` and every EFSM semantic field remain untouched;
- persisted transition geometry records `path_kind=cubic_bezier` plus finite relative `source_control` and `target_control` offsets;
- the generic OPUS layout store validates the path kind and signed finite offsets;
- the renderer rebuilds manual curves from current source/target ports and relative controls, so later state or finite-global marker movement retains the curve character;
- legacy V4 transition entries without Bézier metadata remain valid and use deterministic automatic routing.

The active overlay is nested inside its canonical transition group. This keeps self-loop and transformed transition coordinates in the same SVG coordinate system.

## Exact surface

- `Opus/Fsm/Diagram.class.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

No backend JavaScript and no canonical FSM definition are part of this slice.

## Acceptance

In `essai` Navigation Conception:

1. select a simple cubic transition;
2. drag `C1` and `C2` with the primary pointer;
3. confirm the edge and helper lines follow while `P0/P3` stay attached;
4. reload and confirm the same manual curve;
5. switch to View and confirm the same curve without edit handles;
6. return to Design, move source and target states, and confirm the manual controls retain their relative shape;
7. for a finite-global cubic, move its source marker and confirm the source side follows;
8. confirm the layout JSON contains `path_kind`, `source_control` and `target_control`;
9. confirm the canonical FSM JSON is unchanged by curve-only edits.

Reset-to-automatic UI remains a later explicit command; R8B6O does not silently reset a manual curve.
