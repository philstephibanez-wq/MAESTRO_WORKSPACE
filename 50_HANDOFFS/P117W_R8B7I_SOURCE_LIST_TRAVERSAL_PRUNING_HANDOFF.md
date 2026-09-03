# P117W R8B7I — Source list traversal pruning handoff

Status: OWNER BASELINE GATE REQUIRED
Date: 2026-09-03

## Authoritative baseline

OPUS GitHub master: `5cf15edce7001dbe35f144614eba2f7ee4025209` (`owasys fonctionne`).

R8B7H is rejected/superseded. Do not reapply it and do not carry any of its REST catalog changes forward.

## Diagnosis retained

Fresh owner traces established repeated `source.list` Composer costs around 155–201 ms. The authoritative implementation of `SiteSourceWorkspace::list()` recursively descends into the complete site tree and only afterwards rejects paths under `.git`, `vendor`, `node_modules`, `var`, `cache`, `logs` and `tmp`.

The next correction therefore targets generic OPUS filesystem traversal only.

## R8B7I intended delta

One complete file only:

`Opus/Application/Source/SiteSourceWorkspace.php`

The listing traversal will prune policy-blocked directories before recursion. No cache is introduced, so external source changes remain visible on the next list operation. No REST, OWASYS application, controller, model, FSM, SCORE, ACL or I18n contract changes are in scope.

## Assistant-side evidence already obtained

Synthetic fixture:

- 500 visible files;
- 18,000 files placed below blocked directory segments;
- existing algorithm inspected 18,500 entries;
- pre-descent-pruned algorithm inspected 509 entries;
- visible file count was identical (500);
- measured validation-container time approximately 60.76 ms vs 2.05 ms.

This establishes removal of unnecessary blocked-tree traversal. It is not presented as a Windows timing guarantee.

## Delivery gate

Before ZIP application, owner must provide exactly:

- local `git rev-parse HEAD`;
- local `git status --porcelain=v1 -uall`.

Expected baseline is the authoritative SHA above and a clean worktree. Any mismatch is a stop condition.

After the baseline gate, chat will deliver the native differential ZIP only after complete-file PHP syntax and traversal fixture validation, archive listing verification and SHA-256 verification.
