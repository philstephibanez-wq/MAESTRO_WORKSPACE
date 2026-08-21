# P117W R45B2A4BX — Persisted vertical canvas authority

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Preconditions

README-FIRST is authoritative.

A4BX follows A4BW. A4BW successfully corrected the Registry card/delete-form height, but browser validation showed that the FSM diagram itself remained at the old physical height even though its persisted vertical geometry had been compressed.

A4BX requires the A4BW/A4BV local baseline:

- OWASYS deletion workflow contains user signal `begin_application_deletion`;
- `g_delete_current_application` targets `registry`;
- Registry CSS contains the A4BW scoped selection form rule and compact `.ow-delete-form` rule;
- `config/fsm.layout.json` is `OPUS_FSM_DIAGRAM_LAYOUT_V4`, direction `vertical`, matches the exact current FSM definition hash, and already carries the A4BW compacted canvas range.

## Observed failure

A4BW changed persisted Y geometry and `canvas.height`, but the browser height did not follow it.

The persisted layout itself is not the missing layer. `FsmDiagramLayoutStore` explicitly treats canvas metadata as part of the portable presentation contract and returns that persisted canvas together with state, transition and marker geometry.

The generic renderer then drops the persisted canvas:

1. `OPUS_FSM_Diagram::renderDefinition()` resolves the persisted layout;
2. it forwards persisted state positions, transition geometry and marker geometry;
3. it does not forward persisted `canvas` dimensions;
4. `applyPersistedStatePositions()` later recalculates rendered height as `max(automatic height, max persisted state bottom + 72)`.

Therefore the pre-compaction automatic vertical height remains a hard lower bound. A4BW correctly compressed the persisted data but the generic renderer could not physically shrink to it.

This is the cause of the unchanged visible height.

## Generic OPUS correction

README-FIRST requires a generic OPUS evolution before an OWASYS-local non-business workaround. A4BX therefore changes the generic OPUS FSM renderer, not OWASYS CSS or SCORE.

`OPUS_FSM_Diagram` gains persisted-canvas support:

- persisted `canvas` from `FsmDiagramLayoutStore::resolve()` is forwarded to the renderer;
- `setPersistedCanvas()` validates positive finite width/height presentation metadata;
- in vertical mode, when persisted state coordinates and persisted canvas height are available, persisted canvas height becomes authoritative;
- a safety floor of `max persisted state bottom + 72` remains so states cannot be clipped;
- horizontal rendering keeps the existing automatic-height behavior.

The correction changes presentation geometry only. FSM topology, signals, guards, actions, runtime operations, ACL, REST, SCORE and Composer behavior are untouched.

## Why no CSS workaround

No `height`, `max-height`, clipping, CSS transform, `zoom`, nested vertical scroll viewport or OWASYS-specific renderer override is added.

Those would only mask the generic renderer defect and would contradict the portable persisted-layout contract.

## Framework contract

The modified concrete framework class remains `OPUS_FSM_Diagram implements OPUS_FSM_DiagramInterface`.

The homonymous interface already extends directly:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No new concrete framework class is introduced.

## Differential target

A4BX changes exactly one final OPUS file:

- `Opus/Fsm/Diagram.class.php`

No `sites/owasys-front` file is changed by A4BX.
No `sites/owasys-back` file is changed.
No JavaScript is changed.

A4BW's already-compacted `fsm.layout.json` remains the presentation source used by the corrected generic renderer.

## Baseline guards

The applicator refuses to write unless:

- `Opus/Fsm/Diagram.class.php` has baseline Git blob `21482d322975a7272470beedd130c59b672e83bd`;
- current FSM/layout definition hashes match;
- layout direction is `vertical`;
- persisted A4BW canvas height is in the compacted range `1500..2400` px;
- A4BW Registry CSS markers are present;
- A4BV deletion semantics are present.

This supports the currently persisted A4BW geometry (which may vary slightly after compatible renderer self-healing) without accepting the old ~3000 px pre-compaction canvas.

## Delivery

Artifact:

`opus_p117w_r45b2a4bx_persisted_vertical_canvas_authority.zip`

ZIP SHA-256:

`7c7e866ecdbe41c90f39bdc99933a7a111345794cc8914dad3616b2cd3b61e28`

Contained one-shot applicator:

`apply_a4bx.php`

Applicator SHA-256:

`dd7568a84340da2e613d335cb7c74b3f7107154c5d8a3f7139a082370219afdd`

Applicator lint: OK under PHP 8.4.23.

## Runtime acceptance

After apply:

1. PHP lint passes for `Opus/Fsm/Diagram.class.php`;
2. `composer opus:validate-site -- owasys-front` remains valid;
3. the browser-visible vertical FSM physical height follows the already-compacted persisted canvas rather than the old automatic height floor;
4. the expected visual reduction is approximately one third versus the pre-A4BW renderer height;
5. no state, signal card or transition is clipped;
6. persisted manual X/Y positioning remains active;
7. horizontal FSM rendering is unchanged;
8. Registry A4BW correction remains unchanged;
9. FSM semantics/actionability/color remain unchanged.
