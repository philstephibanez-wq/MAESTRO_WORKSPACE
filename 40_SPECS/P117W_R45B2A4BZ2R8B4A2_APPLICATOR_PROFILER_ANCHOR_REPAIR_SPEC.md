# P117W R45B2A4BZ2R8B4A2 — Applicator profiler anchor repair spec

State: DELIVERY TARGET — R8B4 PRODUCT CONTENT UNCHANGED

## Purpose

Repair the second R8B4 applicator-only preflight defect while preserving the exact R8B4 product differential and exact OPUS baseline.

## Baseline

Required OPUS HEAD remains:

`76b59191492f4efabf343e85be841f4832fe0ced`

The owner evidence after the R8B4A1 failure confirms `git status --short` is empty, so no OPUS/OWASYS tracked file was written.

## R8B4A1 failure

Observed owner output:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4A_REPLACEMENT_ANCHOR_INVALID:sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php:named-efsm-profiler-received:2`

Immediately afterward `git status --short` was empty.

## Root cause

In exact R8B2 `OwasysFsmDraftCommandProvider.php`, both profiler events contain the same two-line prefix:

- `designer.draft_command.received`
- `designer.draft_command.validated`

Both event payloads contain:

`'site_id' => $siteId,`

followed by:

`'operation' => $operation,`

R8B4A1 attempted to inject `efsm_id` into the `received` event using only that two-line payload prefix. The uniqueness guard therefore correctly found two occurrences and aborted before writes.

This is an applicator anchor defect, not an OPUS baseline mismatch and not a runtime defect.

## Required correction

R8B4A2 must qualify profiler anchors by semantic event name.

For the received event, the source anchor must include:

- `designer.draft_command.received`
- opening payload array
- `site_id`
- `operation`

For the validated event, the source anchor must include:

- `designer.draft_command.validated`
- opening payload array
- `site_id`
- `operation`
- the already staged persistent-state `history_count` line

Each qualified anchor must occur exactly once. No occurrence-count relaxation, global replacement, positional replacement, or special case for count `2` is permitted.

## Non-regression invariants

R8B4A2 preserves all R8B4/R8B4A1 safety properties:

- exact HEAD verification;
- exact Git blob verification for every tracked target;
- clean tracked worktree/index gate;
- all content transformations staged before writes;
- PHP `TOKEN_PARSE` validation;
- JSON validation;
- real `FsmDefinitionValidator` validation;
- real `FsmProcessor` construction;
- atomic writes and full-byte rollback;
- actual Git-diff verification before success markers;
- same 14 modified tracked paths plus one new Security EFSM file;
- no JavaScript/TypeScript/Node artifact under `sites/owasys-back`;
- same contextual Security/Navigation micro-EFSM architecture and behavior.

## Artifact

ZIP:

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair.zip`

Contents exactly:

- `apply_a4bz2r8b4a2.php`

The assistant never commits or pushes OPUS/OWASYS. The owner applies, validates, then commits/pushes only after runtime acceptance.

## Acceptance markers

The corrected applicator must reach, in order:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4A_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4A_APPLIED`

Then `git status --short` must expose the expected 15-path R8B4 differential before any owner commit.