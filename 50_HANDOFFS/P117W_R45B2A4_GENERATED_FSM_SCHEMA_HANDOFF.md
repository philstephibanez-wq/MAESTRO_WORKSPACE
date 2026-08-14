# Handoff — P117W R45B2A4 generated FSM schema

Date: 2026-08-14
State: OWNER VALIDATION REQUIRED

## Current point

`test7` is not the correction target. It only exposed a generic generation defect: the FSM definition exists, but the generated runtime does not render OPUS's native FSM diagram in the SCORE application shell.

## Root correction delivered

`opus_p117w_r45b2a4_generated_fsm_schema.zip`

SHA-256: `d8f6f6c4cf19833108b839364a7aecf31cf9e73c5ddc3efb20d2b369351cd5a1`

Target framework files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Application/Runtime/GeneratedSiteRuntime.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`

The correction establishes one canonical FSM source for dispatch, menu projection and visual diagram projection. ACL visibility and locale are applied to both menu and FSM schema. SVG state navigation remains JavaScript-free. SCORE remains the generated application composition surface.

## Owner sequence

From `H:\OPUS`:

1. extract the differential ZIP;
2. run `php tools\apply_p117w_r45b2a4_fsm_schema.php`;
3. run `composer dump-autoload -o`;
4. lint the three changed framework files;
5. delete the one-shot patch script before commit;
6. delete/recreate a fresh generated test site instead of manually repairing an existing site;
7. validate the FSM diagram, navigation, locale continuity, ACL filtering and wildcard transitions;
8. owner commits/pushes OPUS only after validation.

## Acceptance

Expected application surface after fresh generation:

`horizontal FSM menu -> native FSM SVG schema -> current module SCORE content`

The menu and diagram are projections of the same `OPUS_APPLICATION_FSM_V1` definition; they are not separate navigation registries.

If the patcher reports `OPUS_P117W_R45B2A4_ANCHOR_INVALID`, stop: OPUS master differs from the audited source and no local effect-level workaround is allowed.