# P117W R45B2A4BZ2R8A — Developer handler source authority handoff

State: OWNER VALIDATION FAILED — SUPERSEDED BY R8A1 REPAIR

## Exact OPUS baseline

`9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae`

## Artifact

`opus_p117w_r45b2a4bz2r8a_developer_handler_source_authority.zip`

ZIP SHA-256:

`c20cdcba7c60d652d1a08a293ca6d8cc644413b009e519077d94dc9368f1a244`

Applicator SHA-256:

`602934e6540ac4174eff29d2d23181cb132d29b90b0432feb85bc31669ff115c`

## Delivered architecture

R8A established the managed PHP source authority and the secured handler write pipeline, but owner validation exposed a blocking runtime defect in the new guard wrapper.

## Owner validation failure

OWASYS failed during normal page rendering with:

`OWASYS_EFSM_ACL_GUARD_NAMESPACE_RESERVED`

Root cause: `OwasysFsmGuardHandlers::forConfig()` added dynamic `acl:*` handlers while walking transitions and then treated any later reference to the same already-added dynamic handler as if it were an illegal developer-managed namespace collision. Canonical EFSM definitions legitimately reuse the same ACL guard across several transitions, so the check was non-idempotent.

The pre-delivery wrapper test covered one dynamic ACL reference only and therefore did not exercise the repeated-reference case. R8A must not be accepted or committed without R8A1.

## Correct continuation

Apply `P117W R45B2A4BZ2R8A1 — Repeated dynamic ACL guard repair` on top of the R8A-applied working tree. R8A1 changes only `sites/owasys-front/application/default/services/FsmGuardHandlers.php` and preserves the rest of the 17-path R8A differential.

## R8A architectural content retained by R8A1

- generic `FsmHandlerSourceEditor` + homonymous mandatory OPUS interface;
- application-owned `FsmDeveloperHandlers.php` with developer-programmed GUARD/ACTION callables;
- runtime wrappers delegating to those callables;
- dynamic reserved `acl:` guard namespace;
- handler catalog correlated with actual runtime registration and managed source;
- secured `PUT /api/v1/applications/{site_id}/fsm/handlers` mutation path;
- allow-listed `owasys:fsm:handler-write` backend Composer command;
- atomic/optimistic source persistence through `SiteSourceWorkspace`;
- no `eval`;
- no backend JavaScript/Node;
- designer CSRF rotation after mutation.

## Next slice

R8B remains blocked until R8A1 owner validation succeeds.