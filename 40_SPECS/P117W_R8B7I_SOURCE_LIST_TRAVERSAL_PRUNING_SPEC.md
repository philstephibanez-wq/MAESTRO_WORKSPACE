# P117W R8B7I — Source list traversal pruning

Status: READY FOR OWNER BASELINE GATE
Date: 2026-09-03
Authoritative OPUS baseline: `5cf15edce7001dbe35f144614eba2f7ee4025209` (`owasys fonctionne`)

## Context

R8B7H is rejected and must not be reused. It attempted to optimize source opening by changing the REST resource catalog. That changed a deployment-wide REST fingerprint and introduced unnecessary protocol risk.

Fresh OWASYS traces show that `source.list` repeatedly costs roughly 155–201 ms while `source.read` is materially lower. The authoritative OPUS implementation shows the root cause in `Opus/Application/Source/SiteSourceWorkspace::list()`.

## Root cause

`SiteSourceWorkspace::list()` constructs `RecursiveDirectoryIterator($siteRoot)` and walks the complete site tree. The policy later rejects paths containing blocked segments such as `.git`, `vendor`, `node_modules`, `var`, `cache`, `logs` and `tmp`, but rejection happens only after the recursive iterator has already descended into those directories.

This means runtime/profiler/log/cache trees that are contractually invisible to the source browser are nevertheless traversed on every source listing.

This is especially costly for OWASYS because `sites/owasys-front/var/...` contains growing runtime traces and logs.

## Required correction

Correct the generic OPUS source workspace, not OWASYS REST.

`SiteSourceWorkspace::list()` must prune blocked directories before recursive descent by using a recursive filtering iterator (or an equivalent native PHP traversal that provably does not descend into blocked segments).

The correction must preserve:

- existing `OPUS_SITE_SOURCE_LIST_V2` response shape;
- exact allowed extension policy;
- exact blocked name/segment policy;
- symlink rejection;
- `maxFiles` and `maxBytes` bounds;
- sorting by relative path;
- current Logger/Profiler behavior;
- current `read`, `preview`, `write`, and `writeBatch` contracts;
- no REST catalog change;
- no OWASYS front/back application change.

## Scope

Expected OPUS change:

- `Opus/Application/Source/SiteSourceWorkspace.php`

No interface change is required.

## Validation requirements before native ZIP delivery

1. Source file is reconstructed from exact GitHub blob `62b6a589f6899fbed03ffb0c2c076385d8feb555` at baseline `5cf15ed...`.
2. `php -l` passes on the complete changed PHP file.
3. Traversal-equivalence fixture proves allowed files are unchanged while blocked directories are never descended into.
4. Fixture covers nested/case-insensitive blocked segments, blocked names, `.env.*`, disallowed extensions, symlinks, `maxFiles`, and `maxBytes` behavior.
5. Synthetic performance fixture with large blocked trees demonstrates that work is proportional to the visible source tree rather than hidden runtime trees.
6. No `rest.resources.json`, `backend.resources.json`, source model, controller, or REST framework file is changed.
7. Native ZIP contains only the complete changed file at its final OPUS path and its SHA-256/archive listing is verified.

## Current independent benchmark evidence

A synthetic tree containing 500 visible source files plus 18,000 files under blocked directories was exercised with the current traversal algorithm and with pre-descent pruning:

- current traversal: 18,500 entries inspected, approximately 60.76 ms in the Linux validation container;
- pruned traversal: 509 entries inspected, approximately 2.05 ms;
- visible result count remained 500.

The benchmark is not a Windows runtime promise; it establishes that the correction removes the identified unnecessary traversal class without caching or stale-data semantics.

## Acceptance

Owner runtime acceptance remains on Windows/OPUS after baseline gate. Success is:

- OWASYS remains functional;
- no REST catalog mismatch;
- source tree contents are unchanged;
- fresh `source.list` profiler/Composer duration materially decreases, particularly after `var/profiler` and logs have accumulated;
- opening several source files does not introduce stale listings because the correction uses traversal pruning, not caching.
