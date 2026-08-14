# P117W R45B2A4 — Generated FSM schema

Status: PENDING OWNER VALIDATION
Date: 2026-08-14
Scope: OPUS framework root cause only; no local correction of `test7`.

## Cause

The generated application already declares `config/application.fsm.json` with contract `OPUS_APPLICATION_FSM_V1`, and OPUS already provides the native semantic SVG renderer `OPUS_FSM_Diagram`. However `GeneratedSiteRuntime::renderPage()` builds the horizontal route/menu surface without loading that canonical FSM definition and without feeding any FSM-diagram slot to the generated SCORE layout. The generated site's visual FSM schema therefore disappears even though the FSM engine and definition exist.

## Required generic correction

1. `Opus/Fsm/Diagram.class.php`
   - keep the native dependency-free SVG renderer;
   - support optional state-to-route links so an FSM node can be navigated without JavaScript;
   - preserve current-state highlighting, transition identity, wildcard/fallback semantics and accessibility metadata.

2. `Opus/Application/Runtime/GeneratedSiteRuntime.php`
   - load the canonical application FSM through the existing structured configuration path;
   - derive the visual FSM from the same definition used by FSM runtime dispatch;
   - filter menu and diagram states through the same deny-by-default ACL perspective for the current identity;
   - preserve the current locale in generated state links;
   - render the schema through the generated SCORE component slot;
   - never create a second independent navigation model.

3. `Opus/Scaffold/SiteScaffoldPlan.php`
   - generate `application/default/templates/components/fsm-diagram.score`;
   - expose `common.fsm_diagram` in the generated layout directly below the horizontal header/menu;
   - include only shell styling required around OPUS native SVG output;
   - no JavaScript dependency.

## Delivery

Artifact: `opus_p117w_r45b2a4_generated_fsm_schema.zip`
SHA-256: `d8f6f6c4cf19833108b839364a7aecf31cf9e73c5ddc3efb20d2b369351cd5a1`

The ZIP contains a fail-closed PHP application script under `tools/`. It patches only the three OPUS framework files above, requires every expected source anchor exactly once, lints all generated temporary PHP files before replacement, and rolls back already-written targets if replacement fails. Temporary files are removed.

## Validation gate

Owner applies the ZIP in `H:\OPUS`, runs the patcher, runs `composer dump-autoload -o`, validates PHP syntax, recreates a fresh test site, starts it, then verifies:

- horizontal menu still follows FSM routes;
- native FSM SVG is visible under the header;
- current state is highlighted;
- permitted state nodes navigate using the current locale;
- unauthorized states are absent from both menu and diagram;
- wildcard transitions from `*` remain represented;
- no JavaScript is introduced by this correction.

Do not mark APPLIED until owner validation succeeds and OPUS is committed/pushed by the owner.