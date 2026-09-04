# P117W R8B7Q — REST ACL ENGINE UNIFICATION SPEC

## Status
READY FOR OWNER PREFLIGHT / APPLY

## Audited baseline
OPUS master after accepted R8B7P: `7ae9c5277994c260da9877e13fceb6558b06c3f7`.

## Root cause
`Opus\Api\Rest\RestServer` authenticates the REST request correctly, then authorizes an operation through a local `array_intersect()` between operation roles and identity roles. This duplicates ACL semantics instead of delegating the decision to the generic OPUS ACL engine required by README-FIRST.

## Contract
R8B7Q MUST:
1. preserve all existing operation role declarations and effective permissions;
2. make the authenticated REST identity usable as an OPUS `IdentityContextInterface`;
3. delegate the REST operation authorization decision to `HierarchicalAclEngine`;
4. retain default-deny behaviour when an operation has no authorized role or no rule matches;
5. preserve 401 authentication failures and 403 ACL failures;
6. preserve existing REST → Composer dispatch, routes, EFSM, I18n, SCORE and application presentation;
7. add no local OWASYS authorization engine and no JavaScript to `owasys-back`.

## Changed OPUS files
- `Opus/Api/Security/RestIdentityInterface.php`
- `Opus/Api/Security/RestIdentity.php`
- `Opus/Api/Rest/RestServer.php`

## Acceptance
- PHP lint on the three changed files.
- `composer dump-autoload -o`.
- `composer opus:validate-site -- owasys-front`.
- `composer opus:validate-site -- owasys-back`.
- authenticated authorized OWASYS operation still succeeds;
- authenticated role without the required operation role receives HTTP 403 / OPUS REST ACL denial;
- unauthenticated request remains HTTP 401;
- no regression Applications / I18n / EFSM.

## Non-goals
This patch does not redesign business permissions or migrate every operation to a new CRUD naming scheme. It removes the duplicated authorization implementation first, without changing effective rights.