# P117W R45B2A4E — FSM compact signal coverage and generated preview compatibility

Status: PENDING OWNER VALIDATION
Date: 2026-08-15
OPUS base: `554a8ed90ebf51c87632c173223bfabb6b5c6e56`
Previous delivery: R45B2A4D readable localized menu-synchronized FSM

## Owner observations

After R45B2A4D:

1. the principal-navigation FSM is no longer compressed, but its natural geometry is now too wide/tall for the normal OWASYS viewport;
2. the owner cannot verify visually that the schema is complete at signal level;
3. preview of the selected generated application `essai2` fails with `OPUS_GENERATED_RUNTIME_FAILED`.

## Audited causes

### A. Excessive graph geometry

R45B2A4D intentionally switched `OPUS_FSM_Diagram` to natural SVG dimensions. The generic layout still uses 204 px nodes, 150 px rank gaps, 110 px margins and a 430 px minimum height. A seven-state navigation projection therefore becomes unnecessarily large.

The correction is generic OPUS first: add an explicit compact-layout presentation mode to `OPUS_FSM_Diagram`. FSM semantics, state identity, transition identity, guards, effects and runtime operations are unchanged. OWASYS opts into compact mode; other OPUS diagrams keep the default geometry.

### B. Signal identity hidden by presentation labels

R45B2A4D synchronized state labels with the translated SCORE menu, but replaced each visible transition label by the translated destination label. The real technical signal survived only in the SVG `<title>` tooltip. The graph therefore did not visibly prove which signal drives an edge.

R45B2A4E keeps translated state labels but displays the canonical signal id on each rendered edge. Full semantic labels remain in the tooltip.

### C. Canonical OWASYS signal registry is incomplete

`sites/owasys-front/config/fsm.json` declares 42 signal ids while its transition set references 44 distinct signal ids. The two transition signals absent from `signals[]` are:

- `open_source_file`;
- `change_locale`.

R45B2A4E adds those two declarations and adds fail-closed validation in `OwasysFsmDiagramBuilder`: every transition signal must be declared, every declared signal must be referenced, and duplicate/empty ids are forbidden. The current accepted coverage is therefore exactly `44/44`.

The principal-navigation SVG remains a projection and deliberately does not redraw all internal self-transitions. To make completeness inspectable without recreating the unreadable graph, the SCORE card exposes a collapsed canonical signal inventory (`Σ 44/44`), with projected signals visually distinguished from internal signals.

### D. Generated preview failure is a framework/runtime compatibility defect

The generic `GeneratedSiteRuntime` introduced by R45B2A4B/R45B2A4C now renders `default/templates/components/fsm-diagram.score` unconditionally before page composition.

The versioned generated site `sites/essai2` predates that generated component and its `layout.score` also predates the `{{{ common.fsm_diagram }}}` slot. Therefore the runtime attempts to render a site-owned SCORE component that does not exist and converts the resulting exception to `OPUS_GENERATED_RUNTIME_FAILED`.

The correction is not a manual `essai2` migration:

- `GeneratedSiteRuntime` explicitly detects whether the site's layout declares `{{{ common.fsm_diagram }}}`;
- legacy layouts without the slot do not request the diagram;
- when the slot exists, the FSM wrapper SCORE component is rendered from `Opus/Application/Runtime/templates/fsm-diagram.score`, owned by the framework like the runtime profiler/logout templates;
- no generated site is patched in place.

## Delivery

Artifact: `opus_p117w_r45b2a4e_fsm_signal_preview.zip`

SHA-256: `536c1d89b8e116e735d86b6bb29aa6579467398a7fc9e72861d8fd22a1edec85`

ZIP entry:

- `tools/apply_p117w_r45b2a4e_fsm_signal_preview.php`

The runner is fail-closed, validates the R45B2A4D source anchors, reads configuration through `StructuredFileLoader`, writes through the OPUS `File` atomic boundary, lints every patched PHP result before source replacement, validates signal coverage as 44/44, creates the framework-owned SCORE component, and rolls back all touched files on write failure.

## Files modified by the runner

- `Opus/Fsm/Diagram.class.php`
- `Opus/Application/Runtime/GeneratedSiteRuntime.php`
- `Opus/Application/Runtime/templates/fsm-diagram.score` (new)
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`
- `sites/owasys-front/config/fsm.json`

No `sites/essai2` source file is modified.

## Acceptance

OWASYS:

- the seven permitted menu states remain synchronized with the translated SCORE menu;
- the principal-navigation graph fits approximately one desktop viewport instead of requiring multi-screen horizontal scrolling;
- every drawn edge visibly shows its real canonical signal id;
- `Σ 44/44` is shown and expands to the complete canonical signal inventory;
- projected versus internal signals are visually distinguishable;
- `open_source_file` and `change_locale` are declared in `signals[]`;
- any future declared/referenced signal divergence fails closed.

Generated application preview:

- `essai2` no longer fails merely because its historical layout has no FSM slot/component;
- legacy layout capability is detected explicitly;
- new FSM-aware generated layouts use the framework-owned SCORE component;
- no manual repair of `essai2` is allowed.

No OPUS/OWASYS commit or push is performed by the assistant. Owner applies, validates, removes the temporary runner, commits and pushes OPUS/OWASYS.