# P117W R45B2A4BZ2R1 — EFSM graphical toolbar + state draft CRUD — applicator reissue

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Cause

The first A4BZ2 applicator aborted before any write with:

`P117W_R45B2A4BZ2_PATCH_ANCHOR_INVALID:builder-revision`

The applicator incorrectly searched the pre-A4BZ1 renderer revision:

`P117W_R45B2A4BI`

while the validated/current A4BZ1 baseline correctly contains:

`P117W_R45B2A4BZ1`.

This was an applicator baseline defect. It was not an ACL failure and no A4BZ2 file was written because the applicator aborts before its write phase.

## Evidence

Owner validation after the failure reported:

- `git status --short` empty;
- no `A4BZ2` occurrence found in the targeted OPUS tree;
- UI still displayed `EFSM designer · A4BZ1` and `Lecture seule`.

Current OPUS master `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` also declares `private const REVISION = 'P117W_R45B2A4BZ1';`.

## Correction

A4BZ2R1 is a strict reissue of the A4BZ2 semantic payload with only the applicator baseline anchor corrected:

`P117W_R45B2A4BZ1 -> P117W_R45B2A4BZ2`

The feature scope and architecture remain exactly those defined in:

`40_SPECS/P117W_R45B2A4BZ2_EFSM_STATE_DRAFT_CRUD_GRAPHICAL_TOOLBAR_SPEC.md`

No OPUS/OWASYS source is committed by the assistant.

## Safety

The reissued applicator still requires the A4BZ1 baseline on the relevant frontend files and still refuses an already-applied A4BZ2 tree.

The correction does not relax any REST, ACL, Composer, Profiler, SCORE, backend-JavaScript prohibition or generic OPUS interface contract.

## Acceptance

1. applicator does not stop on `builder-revision` when run on the clean A4BZ1 baseline;
2. applicator prints `P117W_R45B2A4BZ2_APPLIED`;
3. `git status --short` shows the A4BZ2 differential;
4. the designer revision becomes A4BZ2;
5. admin sees explicit `fsm:update` authorization and graphical state CRUD controls;
6. normal A4BZ2 validation from the parent specification is then executed.