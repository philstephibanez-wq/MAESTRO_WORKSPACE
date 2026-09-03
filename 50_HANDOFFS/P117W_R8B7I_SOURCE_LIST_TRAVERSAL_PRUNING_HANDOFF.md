# P117W R8B7I — Source list traversal pruning handoff

Status: OPUS COMMITTED — RUNTIME PERFORMANCE GATE PENDING
Date: 2026-09-03

## Authoritative OPUS state

OPUS GitHub master now contains owner commit:

`ec3586496acdac83f155a248c46013e3001cbef4` — `R8B7I`

Its only changed file is:

`Opus/Application/Source/SiteSourceWorkspace.php`

The commit replaces unconditional recursive descent with `RecursiveCallbackFilterIterator` pruning for policy-blocked directories before recursion. No REST catalog, OWASYS application, controller, model, FSM, SCORE, ACL or I18n file is changed.

R8B7H remains rejected/superseded and must not be reused.

## Evidence retained

Prior owner traces established repeated `source.list` Composer costs around 155–201 ms on the pre-R8B7I baseline.

Assistant-side synthetic fixture before delivery:

- 500 visible files;
- 18,000 files below blocked directory segments;
- previous algorithm inspected 18,500 entries;
- pre-descent-pruned algorithm inspected 509 entries;
- visible result count identical: 500;
- validation-container timing approximately 60.76 ms vs 2.05 ms.

This demonstrates removal of unnecessary blocked-tree traversal but is not a Windows runtime timing guarantee.

## Current owner evidence

A browser screenshot supplied after R8B7I shows `/fr-FR/applications` rendering successfully with `owasys-front` as current application and the discovered `owasys-back` / `owasys-front` applications visible.

This is a useful smoke indication that OWASYS still renders, but it does not validate the R8B7I performance acceptance because it is not a fresh Sources/Git request and contains no `source.list` timing.

## Runtime acceptance gate

The next owner evidence must be a fresh request on `/fr-FR/sources-et-git`, preferably opening one real source file, with the corresponding OPUS Profiler view or fresh profiler evidence showing the post-R8B7I `source.list` duration and total request duration.

Acceptance requires:

- Sources/Git remains functional;
- source tree contents remain correct;
- no REST catalog mismatch;
- post-R8B7I `source.list` duration is materially below the retained 155–201 ms prepatch range under comparable runtime conditions;
- no stale-listing semantics are introduced.

## Next-development rule

Do not choose another performance patch from static code alone. The next deliverable target is selected from the fresh post-R8B7I Profiler evidence. Current source review retains the following facts only as candidates, not conclusions:

- `OwasysSourceController::loadSelection()` still uses `OwasysSourceModel::browse()` when a file is selected;
- `OwasysSourceModel::browse()` currently performs `list()` then `read()` sequentially;
- the rejected R8B7H REST-aggregate route must not be resurrected;
- further optimization must treat whichever measured span remains dominant after R8B7I.
