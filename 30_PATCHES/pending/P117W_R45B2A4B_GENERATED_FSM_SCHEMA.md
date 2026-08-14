# P117W R45B2A4B — Generated FSM schema delivery

Status: PENDING OWNER VALIDATION
Date: 2026-08-14
Scope: generic OPUS framework root cause only; no local repair of `test7`.

## Audited OPUS source

`philstephibanez-wq/OPUS` master: `58bd2b15cf4fc19cf405715f5057fac129ada0c5` (`opus_p117w_r45d2a29_fsm_diagram_semantic_conformance`).

The native semantic FSM SVG renderer already exists. The remaining generation defect is that `GeneratedSiteRuntime` still projects the horizontal menu from `routes.json` and does not project the canonical `OPUS_APPLICATION_FSM_V1` definition into the generated SCORE layout.

## Generic correction

Artifact: `opus_p117w_r45b2a4b_generated_fsm_schema.zip`

SHA-256: `5be76d4b59ac4a4fbcae46cc16343d4f2a779bc96cbbb8324639adfd0f3a5b25`

The ZIP contains only:

- `tools/apply_p117w_r45b2a4b_fsm_schema.php`

The one-shot patcher modifies only:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Application/Runtime/GeneratedSiteRuntime.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`

It requires every audited source anchor exactly once, prepares and lints all three temporary PHP targets before replacement, rolls back already-written targets on failure, and removes temporary files.

### Diagram

- adds optional local route links to visible FSM states;
- emits native SVG anchors only;
- introduces no JavaScript and preserves the semantic renderer delivered by R45D2A29.

### Generated runtime

- loads `config/application.fsm.json` through the existing structured configuration path;
- derives horizontal navigation and the visual schema from that canonical FSM definition;
- uses route metadata only for executable path and ACL policy resolution, never as a second navigation registry;
- applies the same deny-by-default ACL perspective to menu and diagram states;
- preserves the current locale in state links;
- preserves wildcard transitions whose visible target remains authorized;
- renders the native FSM output through a generated SCORE component.

### Scaffold

- generates `application/default/templates/components/fsm-diagram.score`;
- exposes `common.fsm_diagram` directly below the generated header/menu;
- adds only shell-level CSS around the native FSM output.

## Owner validation gate

From `H:\OPUS` after extracting the ZIP:

1. run `php tools\apply_p117w_r45b2a4b_fsm_schema.php`;
2. run `composer dump-autoload -o`;
3. lint the three framework targets;
4. delete the one-shot patch script before commit;
5. delete/recreate a fresh generated site;
6. verify horizontal FSM menu, native FSM SVG, current-state highlighting, locale-preserving state navigation, ACL filtering and wildcard transitions;
7. verify that the correction introduced no JavaScript;
8. owner commits/pushes OPUS only after successful validation.

Expected surface:

`horizontal FSM menu -> native FSM SVG schema -> current module SCORE content`

If the patcher reports `OPUS_P117W_R45B2A4B_ANCHOR_INVALID`, stop: the OPUS source differs from the audited master and no effect-level workaround is permitted.
