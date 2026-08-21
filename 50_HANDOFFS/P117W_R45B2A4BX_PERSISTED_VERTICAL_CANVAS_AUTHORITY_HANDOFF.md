# P117W R45B2A4BX — Persisted vertical canvas authority — HANDOFF

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Browser feedback closing A4BW

A4BW Registry compaction is accepted: deletion controls are now usable.

The FSM-height part is not accepted: the browser still renders the diagram at the old tall physical height.

## Root cause

A4BW did compress the persisted vertical FSM data. The generic OPUS renderer was the remaining blocker.

`FsmDiagramLayoutStore` persists and resolves `canvas.width` / `canvas.height` as part of `OPUS_FSM_DIAGRAM_LAYOUT_V4`, but `OPUS_FSM_Diagram::renderDefinition()` forwards only persisted states, transitions and markers.

The renderer then applies persisted state coordinates while keeping:

`rendered height = max(automatic layout height, persisted state bottom + margin)`

The automatic pre-compaction height therefore prevents the SVG from becoming physically shorter.

A4BX corrects this at the generic OPUS layer.

## Resulting renderer contract

When a vertical FSM has a valid persisted layout:

```text
FsmDiagramLayoutStore
  -> states
  -> transitions
  -> markers
  -> canvas
       |
       v
OPUS_FSM_Diagram
  -> persisted state coordinates
  -> persisted canvas height is authoritative
  -> safety floor = lowest persisted state + 72
```

Horizontal diagrams retain their previous automatic-height behavior.

No CSS zoom, crop, max-height or nested scroll workaround is introduced.

## Changed OPUS file

Exactly one final source path:

- `Opus/Fsm/Diagram.class.php`

The existing class/interface architecture remains compliant: `OPUS_FSM_Diagram` continues to implement `OPUS_FSM_DiagramInterface`, whose contract extends the four required OPUS framework interfaces.

No OWASYS frontend/backend file is modified by A4BX.

## Applicator preconditions

The one-shot applicator requires:

- baseline `Diagram.class.php` Git blob `21482d322975a7272470beedd130c59b672e83bd`;
- A4BV deletion semantics;
- A4BW Registry CSS markers;
- `OPUS_FSM_DIAGRAM_LAYOUT_V4` vertical layout;
- layout definition SHA-256 matching exact current `fsm.json` bytes;
- compacted A4BW canvas height between 1500 and 2400 px.

It refuses the old pre-A4BW ~3000 px canvas.

## Artifact

`opus_p117w_r45b2a4bx_persisted_vertical_canvas_authority.zip`

SHA-256:

`7c7e866ecdbe41c90f39bdc99933a7a111345794cc8914dad3616b2cd3b61e28`

ZIP content:

- `apply_a4bx.php`

Applicator SHA-256:

`dd7568a84340da2e613d335cb7c74b3f7107154c5d8a3f7139a082370219afdd`

Applicator lint: OK under PHP 8.4.23.

## Owner commands

```cmd
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bx_persisted_vertical_canvas_authority.zip" -C "%USERPROFILE%\Downloads"
cd /d H:\OPUS
php "%USERPROFILE%\Downloads\apply_a4bx.php"
php -l Opus\Fsm\Diagram.class.php
composer opus:validate-site -- owasys-front
composer opus:dev-server -- owasys-front
```

Expected applicator output:

`P117W_R45B2A4BX_APPLIED`

followed by:

`persisted_vertical_canvas_height_authoritative=<current A4BW compacted height>`

On the current owner geometry this height is approximately 2.0k px; the important acceptance criterion is that the browser SVG now uses that compacted persisted height instead of the larger automatic vertical-layout floor.

## Browser acceptance

1. Reload OWASYS after restarting the dev server with the modified framework source.
2. The FSM surface must be visibly about one third shorter than the pre-A4BW physical rendering.
3. No state or transition may be cut off.
4. Manual persisted positions remain where expected.
5. Registry deletion UI remains compact.
6. Signal origin colors, actionability, guards, actions and topology remain unchanged.

## Workspace specification

`40_SPECS/P117W_R45B2A4BX_PERSISTED_VERTICAL_CANVAS_AUTHORITY_SPEC.md`

Specification commit:

`52318a98489682b166d3287e6ec58319128e9a15`

## Next

After browser acceptance, reassess the live FSM topology/geometry from the corrected physical canvas. Do not compensate further in OWASYS CSS if the persisted canvas is still not honored; that would indicate another generic renderer/persistence defect.
