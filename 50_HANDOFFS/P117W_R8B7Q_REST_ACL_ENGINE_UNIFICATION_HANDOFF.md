# P117W R8B7Q — REST ACL ENGINE UNIFICATION HANDOFF

## Status
READY FOR OWNER PREFLIGHT / APPLY

## Authoritative OPUS baseline
`7ae9c5277994c260da9877e13fceb6558b06c3f7` (`R8B7P`).

Applications, I18n and EFSM are owner-accepted and are outside this patch scope.

## Delivery
Native ZIP: `R8B7Q.zip`
SHA-256: `7550b313e42d8f014bcbd92512105c4f94c78776f23789e6b7c05c9758b6fe0a`

Archive contains exactly:
1. `Opus/Api/Security/RestIdentity.php`
2. `Opus/Api/Security/RestIdentityInterface.php`
3. `Opus/Api/Rest/RestServer.php`

## Root-cause correction
Before R8B7Q, `RestServer` authenticated a request then implemented authorization itself with `array_intersect()` on roles. R8B7Q preserves the operation-catalog role allow-list but delegates the access decision to the generic `HierarchicalAclEngine`, whose unmatched outcome is deny-by-default.

The authenticated REST identity now fulfills the OPUS identity-context contract required by that engine (`isAnonymous`, `roles`, `scopes`, `claims`).

## Preparation evidence
- all three changed PHP files lint successfully;
- ZIP read-back succeeds;
- ZIP contains exactly the three complete changed files above;
- OPUS GitHub master was rechecked immediately before handoff and remains the R8B7P baseline.

## Owner gate 1 — preflight only
The owner MUST first verify local HEAD, origin/master, clean worktree, ZIP SHA and ZIP members. Any mismatch is a stop condition.

## Owner gate 2 — apply/static validation
Only after gate 1 acceptance: extract ZIP, rebuild optimized Composer autoload, lint changed PHP files, validate both OWASYS sites, run `git diff --check`, inspect status and diff.

## Owner gate 3 — runtime acceptance
- unauthenticated secured REST operation remains HTTP 401;
- authenticated unauthorized role is HTTP 403 with OPUS REST ACL denial;
- authenticated authorized role still reaches the allow-listed Composer business operation;
- Applications / I18n / EFSM remain accepted;
- no JavaScript/Node artifact is introduced into owasys-back.

No OPUS/OWASYS commit or push before runtime acceptance. The assistant never commits or pushes OPUS/OWASYS.