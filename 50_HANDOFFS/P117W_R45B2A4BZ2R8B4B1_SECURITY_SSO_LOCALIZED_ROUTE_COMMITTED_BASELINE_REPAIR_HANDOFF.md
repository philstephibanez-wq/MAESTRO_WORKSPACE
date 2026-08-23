# P117W R45B2A4BZ2R8B4B1 — Security SSO localized route committed-baseline repair handoff

State: COMMITTED/PUSHED — CLI PASS — SECURITY RUNTIME PASS — DESIGN PERSISTENCE PASS — DIRECT SSO SUBVIEW GATE PENDING

## Current source of truth — 2026-08-24

Current `README-FIRST.md` was re-read from GitHub immediately before this update.

Blob:

`007fa44f52522e5f3c6084502f17924a48918628`

It explicitly requires reading GitHub repositories and forbids using memorized source state.

Current OPUS `master` was re-read from GitHub and remains:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

The commit parent is `c5e7de78f70d14efc3b8c42f4ec53026b47253cf` and its only changed file is:

`sites/owasys-front/config/routes.localized.json`

with the explicit localized `security/sso` route addition.

## Artifact

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair.zip`

ZIP SHA-256:

`a8befc98a50b8c372cd69f449a74a0d36d6cdb4582b32f80108606c0070c8eef`

Applicator SHA-256:

`201fc474ec05f0bf70d1ad4d2bf80841de0fe3d6b2eafa982f012b6fc2ca8e3b`

R8B4B1 was constructed against OPUS HEAD `c5e7de78...`, passed all owner applicator markers, and was subsequently committed/pushed by the owner as current OPUS HEAD `4043702...`.

## Repository validation

Owner applicator execution passed:

- `P117W_R45B2A4BZ2R8B4B1_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B4B1_REPO_CHANGES_VERIFIED`;
- `P117W_R45B2A4BZ2R8B4B1_APPLIED`;
- localized route `security/sso`;
- 25 base languages;
- 37 regional locales.

After application, the only local change was `sites/owasys-front/config/routes.localized.json`.

The owner later committed/pushed it; current OPUS master confirms only that route-catalog change.

Repository gate: PASS.

## CLI validation

Owner supplied successful validation for:

- `owasys-front`: valid, 12 routes, 10 modules, Singleton, `fsm-module-first`;
- `owasys-back`: valid, 2 routes, 3 modules, Singleton, `fsm-module-first`;
- `essai`: valid, 1 route, 1 module, generated frontend profile, FSM `config/application.fsm.json`.

CLI gate: PASS.

## Security runtime validation

### Localized Security route

`/fr-FR/sécurité` renders normally. The previous `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN` HTTP 500 is absent.

Gate: PASS.

### Contextual Security micro-EFSM

The selected application `essai` renders the dedicated Security micro-EFSM from canonical source `config/security.fsm.json`.

Visible states:

- `anonymous`;
- `authenticating`;
- `authenticated`;
- `reauthenticating`.

Visible signals/transitions include:

- `login_requested`;
- `authentication_succeeded`;
- `authentication_failed`;
- `logout_requested`;
- `session_expired`;
- `reauth_required`;
- `reauthentication_succeeded`;
- `reauthentication_failed`.

Contextual Security graph gate: PASS.

### Security data / SSO snapshot

Rendered selected-application Security metadata includes:

- application `essai`;
- type `frontend`;
- ACL `OPUS_GENERATED_APPLICATION_ACL_V1`;
- SSO `OPUS_GENERATED_APPLICATION_SSO_V1`;
- default policy `deny`;
- default provider `session`.

Visible provider metadata:

- `auth0-proxy` disabled;
- `local-password` disabled;
- `session` enabled.

No secret material is visible in supplied evidence.

Security snapshot/data gate: PASS.

## Security Conception STATE persistence — PASS

Owner supplied direct graphical evidence for the missing persistence gate.

### Create + reload

First supplied Conception capture shows selected authority:

- application `essai`;
- EFSM `security`;
- source `config/security.fsm.json`;

and shows a fifth temporary STATE:

`test_temp`

present alongside the four canonical Security states after reload.

This directly proves the temporary STATE survived reload and was therefore persisted to the canonical selected-application Security EFSM rather than existing only in browser/UI memory.

### Delete + reload

Second supplied Conception capture shows the same selected authority after deletion and reload, with `test_temp` absent and only the four canonical Security states remaining.

Owner also supplied after cleanup:

- empty `git status --short`;
- empty `git diff -- sites\essai\config\security.fsm.json`.

This proves the supported STATE CRUD is reversible and the source returned exactly to committed state after graphical deletion.

Security graphical STATE create -> persist -> reload -> delete -> persist -> reload gate: PASS.

## Previously validated Structure / Sources evidence

Structure had already rendered selected application `essai`, EFSM `navigation`, source `config/application.fsm.json`.

Sources + Git had already rendered and source REST reads/listing completed successfully in the same R8B4 series.

## Remaining acceptance gate

Only one explicit runtime check remains before declaring the whole R8B4 slice fully accepted:

Open the dedicated localized SSO subview directly and require it to render without routing/runtime error:

`/fr-FR/sécurité/sso`

The route resolver and overview SSO data are already validated, but direct navigation into that dedicated subview has not yet been supplied as runtime evidence.

No patch is justified for the current evidence.

If the direct SSO subview passes, R8B4 is fully accepted and the next development slice starts from OPUS HEAD:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

## Next slice after full R8B4 acceptance

SecurityContext ownership plus first Security/Navigation inter-EFSM COMMAND/EVENT cooperation, followed by generic generated-application PHP ACTION/GUARD source authoring.
