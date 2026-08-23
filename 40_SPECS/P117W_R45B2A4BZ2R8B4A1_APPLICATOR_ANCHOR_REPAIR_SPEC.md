# P117W R45B2A4BZ2R8B4A1 — Applicator anchor repair spec

State: DELIVERY TARGET — R8B4A CONTENT UNCHANGED

## Purpose

Repair only the failed R8B4A delivery applicator while preserving the exact R8B4A product differential and exact OPUS baseline.

## Baseline

Required OPUS HEAD:

`76b59191492f4efabf343e85be841f4832fe0ced`

The tracked worktree and index must be clean before execution.

## Defect

In `sites/owasys-front/www/asset/js/fsm-designer.js`, R8B2 contains one late declaration:

`const handlerSourceEditor = section.querySelector('[data-fsm-handler-source-editor]');`

The R8B4A applicator must move it before surface validation to eliminate the JavaScript temporal-dead-zone defect.

The failed applicator inserted the new early declaration before removing the old late declaration. Because the removal helper requires exactly one source occurrence, the staged buffer contained two matching declarations and preflight aborted with occurrence count `2`.

## Required correction

The applicator transformation order is normative:

1. verify the exact baseline file/blob;
2. remove the unique late `handlerSourceEditor` declaration, requiring occurrence count exactly `1`;
3. insert the same declaration at the unique earlier surface anchor, requiring that anchor exactly once;
4. continue all remaining R8B4A transformations unchanged.

The implementation must not weaken a uniqueness check, use a broad/global replacement, or special-case occurrence count `2`.

## Non-regression invariants

The corrected applicator must preserve all R8B4A safety properties:

- exact HEAD verification;
- exact Git blob verification for every tracked target;
- clean tracked worktree/index gate;
- all content transformations staged before writes;
- PHP `TOKEN_PARSE` validation;
- JSON validation;
- real `FsmDefinitionValidator` validation of migrated/new EFSM definitions;
- real `FsmProcessor` construction of those definitions;
- atomic writes;
- full-byte rollback on write failure;
- Git-diff verification for every tracked target;
- new-file existence verification;
- no JavaScript/TypeScript/Node artifact under `sites/owasys-back`.

## Product scope

R8B4A1 must not alter the R8B4A product architecture, behavior, target paths or acceptance criteria. It remains the same 14 tracked modifications plus one new Security EFSM file.

The expected product outcomes remain:

- generic named application micro-EFSM registry;
- selected-application Security `security` authority in VIEW and DESIGN;
- selected-application Structure `navigation` authority in VIEW and DESIGN;
- persistent STATE create/rename/delete through front -> secured REST -> back -> allow-listed Composer -> OPUS source edit;
- removal of the browser TDZ;
- direct STATE create;
- generated-application handler authoring isolated instead of misdirected to OWASYS-front;
- real Security SSO/provider snapshot view without secrets;
- Sources + Git behavior unchanged.

## Required delivery

ZIP:

`opus_p117w_r45b2a4bz2r8b4a1_applicator_anchor_repair.zip`

Contents exactly:

- `apply_a4bz2r8b4a1.php`

The owner applies and validates the ZIP. The assistant never commits or pushes OPUS/OWASYS.

## Acceptance markers

The corrected applicator must reach, in order:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4A_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4A_APPLIED`

Only then proceed with normal PHP lint, JavaScript syntax validation, Composer autoload, `opus:validate-site`, restart and browser/runtime validation.