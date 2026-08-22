# P117W R45B2A4BZ2R8B — Graphical PHP GUARD/ACTION authoring handoff

State: OWNER COMMITTED/PUSHED — RUNTIME FAILED — REPAIR REQUIRED

## Actual OPUS baseline now on GitHub

Commit:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

Message:

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

This supersedes the earlier assumption that R8A/R8B still existed only in an uncommitted working tree.

## Runtime failure

`owasys-front` returns HTTP 500 with:

`OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`

before any REST call reaches `owasys-back`.

Inspection of this exact R8B commit confirms `sites/owasys-front/application/default/services/FsmGuardHandlers.php` still contains the original duplicate dynamic-ACL collision branch:

- first `acl:<resource>:<action>` occurrence inserts a dynamic handler into the runtime map;
- a later occurrence finds that handler and incorrectly throws the reserved-namespace exception.

## Required repair

P117W R45B2A4BZ2R8B1 is the only current recovery slice.

It is bound to HEAD `8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`, repairs or accepts the canonical fixed guard source idempotently, then forces a genuinely fresh front/back runtime before probing `/fr-FR`.

Do not continue designer evolution until R8B1 owner runtime acceptance passes.
