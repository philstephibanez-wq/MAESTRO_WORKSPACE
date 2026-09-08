# P117W R8NMI17C — Application FSM surface ownership

Status: READY FOR OWNER VALIDATION

## Problem

A generated OPUS application such as `essai` currently renders its own application FSM directly in its public/runtime page. The requested ownership rule is different: application FSM inspection/design belongs to OWASYS when that application is selected; the application itself must render only its functional UI.

## Root cause

`Opus/Application/Runtime/GeneratedSiteRuntime.php` renders the application FSM through the generic SCORE component `Opus/Application/Runtime/templates/fsm-diagram.score`. OWASYS already owns its distinct contextual FSM designer surface.

## Contract

- Generated/application runtime pages do not expose an FSM diagram surface.
- OWASYS remains the developer/design surface for the selected application's canonical FSM.
- FSM runtime execution remains active in the application; only the direct visualization surface is removed.
- The Web Profiler remains available independently.
- No ESSAI-specific conditional is introduced; the correction is generic OPUS.

## Implementation slice

Neutralize the generic runtime SCORE component `Opus/Application/Runtime/templates/fsm-diagram.score` so `GeneratedSiteRuntime` emits no application FSM markup. This preserves compatibility with existing generated layouts containing `{{{ common.fsm_diagram }}}` while removing the visible runtime diagram for existing and future generated applications.

## Acceptance

1. `essai` still starts and renders its functional home page.
2. No FSM diagram appears on `essai` itself.
3. OPUS Profiler remains available.
4. In OWASYS with `essai` selected, the application FSM remains visible/editable through the OWASYS FSM surface.
