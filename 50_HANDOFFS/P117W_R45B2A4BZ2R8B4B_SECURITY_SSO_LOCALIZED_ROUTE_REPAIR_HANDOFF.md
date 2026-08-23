# P117W R45B2A4BZ2R8B4B — Security SSO localized route repair handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Input state

OPUS HEAD must remain exactly:

`76b59191492f4efabf343e85be841f4832fe0ced`

The worktree must preserve the already integrated R8B4A2 differential:

- 14 tracked modified paths from R8B4A2;
- untracked `sites/essai/config/security.fsm.json`;
- no staged changes.

R8B4B is incremental and must be applied without resetting R8B4A2.

## Runtime failure being repaired

Observed on `/fr-FR/sécurité`:

`OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`

The same trace reaches owasys-back successfully:

- `GET /api/v1/applications/essai/security`;
- Composer `owasys:security-snapshot` succeeds;
- REST `security.snapshot` returns HTTP 200.

Structure renders successfully with application `essai`, EFSM `navigation`, source `config/application.fsm.json`.

## Root cause

R8B4A2 Security rendering includes a dedicated `sso` view and always builds its URL. `securityUrl($locale, 'sso')` delegates to localized canonical path `security/sso`.

`sites/owasys-front/config/routes.localized.json` declares every previous Security subroute but not `security/sso`. The generic resolver therefore correctly rejects the undeclared canonical path.

## Artifact

`opus_p117w_r45b2a4bz2r8b4b_security_sso_localized_route_repair.zip`

ZIP SHA-256:

`ddb10e020fa90555eb0bc352bc6510a0e7f200eeb077395b95ddb483ef2a38c1`

Contents exactly:

- `apply_a4bz2r8b4b.php`

Applicator SHA-256:

`681210412d557c2591e4ee656c06655fcaba73c5c2dd003308e785c61bbf4866`

Applicator length: `11184` bytes.

## Applicator behavior

The applicator:

1. verifies exact OPUS HEAD;
2. verifies the exact 14 tracked R8B4A2 changes;
3. verifies the only untracked path is `sites/essai/config/security.fsm.json`;
4. rejects staged changes;
5. verifies `routes.localized.json` still hashes to exact baseline blob `1ace98302b62a10fb2f817f60063fdfd3f08180c`;
6. verifies the current Security controller contains the R8B4A2 SSO view and URL construction;
7. reads `routes.localized.json` and `site.json` through OPUS `StructuredFileLoader`;
8. derives every `security/sso` public path from the existing localized `security` path plus opaque `/sso`;
9. serializes through OPUS `Json`;
10. validates the staged catalog using the real `LocalizedRouteResolver` for every supported locale, including `localize()` / `resolve()` round-trip;
11. writes only `sites/owasys-front/config/routes.localized.json` using OPUS `File::writeAtomic()`;
12. reloads and revalidates the real resolver;
13. verifies the post-write worktree is exactly 15 tracked modified files plus the existing untracked Security EFSM;
14. restores original route-catalog bytes if post-write validation fails.

## Assistant-side validation

Completed before delivery:

- current README-FIRST re-read from GitHub;
- front and back owner logs correlated on trace `bc0c3e165f29f831cb53eb2fba151758`;
- backend REST/Composer success confirmed;
- front localized-route failure confirmed;
- exact baseline `LocalizedRouteResolver::localize()` behavior inspected;
- exact OWASYS-front localized route catalog inspected;
- `security/sso` confirmed absent;
- existing `security/resources` and other Security subroutes confirmed explicit;
- applicator PHP lint: OK;
- ZIP inspection: exactly one applicator file.

The assistant does not claim execution against the owner's Windows checkout.

## Owner application markers

Required in order:

`P117W_R45B2A4BZ2R8B4B_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4B_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4B_APPLIED`

Then expect:

- `localized_route=security/sso`;
- `localized_route_languages=25`;
- `localized_route_locales=36`.

## Runtime acceptance after application

1. Restart/refresh OWASYS-front as required by the dev server.
2. Open `/fr-FR/sécurité`.
3. Confirm no `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`.
4. Confirm Security authority is `essai / security` from `config/security.fsm.json`.
5. Open dedicated SSO view and verify real provider/default-provider metadata without secrets.
6. Confirm Structure still projects `essai / navigation`.
7. Confirm Sources + Git remains functional.
8. Create one temporary STATE in Security Conception and verify persistence after reload.

Do not commit/push until all runtime gates pass.
