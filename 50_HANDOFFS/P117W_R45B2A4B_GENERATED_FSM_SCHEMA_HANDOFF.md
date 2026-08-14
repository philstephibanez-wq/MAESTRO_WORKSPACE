# Handoff — P117W R45B2A4B generated FSM schema

Date: 2026-08-14
State: OWNER VALIDATION REQUIRED

## Current point

The target is the generated OPUS FSM schema, not `test7` itself and not the profiler. `test7` exposed the generic generation defect only.

Audited OPUS master: `58bd2b15cf4fc19cf405715f5057fac129ada0c5`.

## Delivery

`opus_p117w_r45b2a4b_generated_fsm_schema.zip`

SHA-256: `5be76d4b59ac4a4fbcae46cc16343d4f2a779bc96cbbb8324639adfd0f3a5b25`

The ZIP contains the fail-closed one-shot patcher:

`tools/apply_p117w_r45b2a4b_fsm_schema.php`

Framework targets only:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Application/Runtime/GeneratedSiteRuntime.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`

The correction keeps one canonical `OPUS_APPLICATION_FSM_V1` source for runtime dispatch, horizontal navigation and native SVG schema projection. Menu and diagram share the same ACL visibility perspective; state links preserve locale; wildcard transitions remain semantic; the generated visual slot is SCORE; no JavaScript is added.

## Owner sequence

From `H:\OPUS`:

1. extract the differential ZIP;
2. run `php tools\apply_p117w_r45b2a4b_fsm_schema.php`;
3. run `composer dump-autoload -o`;
4. lint the three modified framework files;
5. delete `tools\apply_p117w_r45b2a4b_fsm_schema.php` before commit;
6. delete/recreate a fresh generated test site;
7. validate `horizontal FSM menu -> native FSM SVG schema -> current module SCORE content`;
8. validate current-state highlighting, state navigation, locale continuity, ACL filtering and wildcard transitions;
9. owner commits/pushes OPUS only after validation.

If `OPUS_P117W_R45B2A4B_ANCHOR_INVALID` is emitted, stop and return the exact output. No manual repair of the generated site is allowed.
