# P117W R45B2A4BZ2R8B4B — Security SSO localized route repair handoff

State: FAILED PREFLIGHT — NO WRITE — SUPERSEDED BY R8B4B1

## Failure evidence

Owner execution:

`php "%USERPROFILE%\Downloads\apply_a4bz2r8b4b.php"`

returned:

`P117W_R45B2A4BZ2R8B4B_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4B_HEAD_INVALID`

Immediately afterward `git status --short` was empty. No OPUS/OWASYS source write occurred.

## Cause

The R8B4B applicator required the obsolete pre-commit R8B4A2 HEAD:

`76b59191492f4efabf343e85be841f4832fe0ced`

and the previously dirty R8B4A2 worktree.

GitHub source of truth was not re-read immediately before R8B4B delivery. In reality, R8B4A2 had already been committed and pushed by the owner. Current OPUS master is:

`c5e7de78f70d14efc3b8c42f4ec53026b47253cf`

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair`

The preflight correctly prevented an unsafe write, but the delivery baseline was wrong and should not have reached the owner.

## Functional diagnosis remains valid

Observed on `/fr-FR/sécurité`:

`OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN`

For the correlated trace, owasys-back successfully executed:

- `GET /api/v1/applications/essai/security`;
- allow-listed Composer `owasys:security-snapshot`;
- REST `security.snapshot` -> HTTP 200.

Structure renders successfully with application `essai`, EFSM `navigation`, source `config/application.fsm.json`.

R8B4A2 `SecurityController` contains dedicated view `sso` and constructs canonical URL `security/sso`, while current `sites/owasys-front/config/routes.localized.json` has no `security/sso` entry. The generic resolver correctly rejects that undeclared canonical route.

## Failed artifact retained for traceability

`opus_p117w_r45b2a4bz2r8b4b_security_sso_localized_route_repair.zip`

ZIP SHA-256:

`ddb10e020fa90555eb0bc352bc6510a0e7f200eeb077395b95ddb483ef2a38c1`

Applicator SHA-256:

`681210412d557c2591e4ee656c06655fcaba73c5c2dd003308e785c61bbf4866`

Do not execute this artifact again.

## Replacement

R8B4B1 is the active delivery. It is constructed from a same-cycle GitHub verification of:

- README-FIRST current SHA `43564921659d743ec86c2fa4886841af4fc13aeb`;
- OPUS master HEAD `c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- current route catalog blob `1ace98302b62a10fb2f817f60063fdfd3f08180c`;
- current OWASYS-front site config blob `0c705f40b05128ab0f7197b99310c5d14c6f79da`;
- current Security controller blob `3a13204eb4177f0638f6c1eb7c98449cf8a86597`;
- current LocalizedRouteResolver blob `5c302833b1f597210d0b4c7044cb18d672871fbf`.

R8B4B1 requires a clean worktree and changes only the localized route catalog.
