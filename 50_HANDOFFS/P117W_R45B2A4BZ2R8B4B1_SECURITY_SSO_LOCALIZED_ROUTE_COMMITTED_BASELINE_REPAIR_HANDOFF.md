# P117W R45B2A4BZ2R8B4B1 — Security SSO localized route committed-baseline repair handoff

State: COMMITTED/PUSHED — CLI PASS — SECURITY RUNTIME PASS — FINAL DESIGN-PERSISTENCE GATE PENDING

## Artifact construction baseline

R8B4B1 was constructed against OPUS HEAD:

`c5e7de78f70d14efc3b8c42f4ec53026b47253cf`

`opus_p117w_r45b2a4bz2r8b4a2_applicator_profiler_anchor_repair`

The applicator required a clean worktree/index and modified only:

`sites/owasys-front/config/routes.localized.json`

Artifact:

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair.zip`

ZIP SHA-256:

`a8befc98a50b8c372cd69f449a74a0d36d6cdb4582b32f80108606c0070c8eef`

Applicator SHA-256:

`201fc474ec05f0bf70d1ad4d2bf80841de0fe3d6b2eafa982f012b6fc2ca8e3b`

## Historical superseded R8B4B failure

The previous R8B4B artifact failed before writes with:

`P117W_R45B2A4BZ2R8B4B_HEAD_INVALID`

because it had been built against obsolete pre-commit HEAD `76b5919...` while R8B4A2 had already been committed/pushed. The failure is preserved for traceability and must not be retried.

## R8B4B1 owner repository validation

Owner execution returned all required markers:

`P117W_R45B2A4BZ2R8B4B1_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4B1_PREFLIGHT_OK`

`P117W_R45B2A4BZ2R8B4B1_REPO_CHANGES_VERIFIED`

`P117W_R45B2A4BZ2R8B4B1_APPLIED`

with:

- `baseline_head=c5e7de78f70d14efc3b8c42f4ec53026b47253cf`;
- `changed_path=sites/owasys-front/config/routes.localized.json`;
- `localized_route=security/sso`;
- `localized_route_languages=25`;
- `localized_route_locales=37`;
- `runtime_gate=/fr-FR/sécurité`.

Immediately after application, `git status --short` showed only:

`M sites/owasys-front/config/routes.localized.json`

Repository gate: PASS.

## Current source-of-truth verification — 2026-08-24

Current `README-FIRST.md` was re-read from GitHub. Current blob:

`007fa44f52522e5f3c6084502f17924a48918628`

It now explicitly requires reading GitHub repositories and forbids using memorized source state.

Current OPUS `master` was re-read from GitHub and is now:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

The commit parent is `c5e7de78...` and its only changed file is:

`sites/owasys-front/config/routes.localized.json`

with exactly the expected explicit `security/sso` localized route addition.

Therefore R8B4B1 has now been committed/pushed by the owner and `4043702...` is the only valid current OPUS baseline for subsequent work.

## CLI validation supplied by owner

`composer opus:validate-site -- owasys-front`:

- valid: true;
- routes: 12;
- modules: 10;
- singleton: true;
- dispatch: `fsm-module-first`;
- role: `standard-opus-application`.

`composer opus:validate-site -- owasys-back`:

- valid: true;
- routes: 2;
- modules: 3;
- singleton: true;
- dispatch: `fsm-module-first`;
- role: `standard-opus-application`.

`composer opus:validate-site -- essai`:

- valid: true;
- routes: 1;
- modules: 1;
- singleton: true;
- dispatch: `fsm-module-first`;
- role: `generated-opus-application`;
- profile: `frontend`;
- FSM: `config/application.fsm.json`.

CLI validation gate: PASS.

## Security runtime evidence supplied by owner

### Localized Security route

`/fr-FR/sécurité` now renders normally. The previous `OPUS_LOCALIZED_ROUTE_CANONICAL_UNKNOWN` HTTP 500 is absent.

Localized-route runtime gate: PASS.

### Contextual Security micro-EFSM

The Security page displays the four-state security graph:

- `anonymous`;
- `authenticating`;
- `authenticated`;
- `reauthenticating`.

Visible transitions/signals include:

- `login_requested`;
- `authentication_succeeded`;
- `authentication_failed`;
- `logout_requested`;
- `session_expired`;
- `reauth_required`;
- `reauthentication_succeeded`;
- `reauthentication_failed`.

This matches the generated Security micro-EFSM contract for selected application `essai`, not the OWASYS host navigation FSM.

Security contextual graph gate: PASS.

### Selected application Security data

The rendered Security workspace identifies:

- application: `essai`;
- type: `frontend`;
- ACL: `OPUS_GENERATED_APPLICATION_ACL_V1`;
- SSO: `OPUS_GENERATED_APPLICATION_SSO_V1`;
- default policy: `deny`;
- default provider: `session`.

The overview exposes real counts for users/agents/unclassified identities/roles/resources and SSO providers.

### SSO provider metadata

Visible provider metadata:

- `auth0-proxy` — disabled;
- `local-password` — disabled;
- `session` — enabled.

No secret material is visible in the supplied UI evidence.

SSO snapshot/data gate: PASS.

## Previously validated runtime evidence preserved

Structure had already rendered selected application `essai`, EFSM `navigation`, source `config/application.fsm.json`, with the selected application's `begin` and `home` graph.

Sources + Git had already rendered and REST source reads/listing completed successfully in the correlated runtime evidence from the same R8B4 series.

## Remaining R8B4 acceptance gate

One product gate still requires direct owner evidence before declaring the contextual micro-EFSM slice fully accepted:

1. enter Security `Conception` for selected application `essai`;
2. create one temporary STATE through the graphical STATE CRUD;
3. require successful front -> secured REST -> back -> allow-listed Composer -> canonical source persistence;
4. reload the page;
5. require the new STATE still present in the Security graph;
6. remove the temporary STATE through the same supported CRUD path and require persistence after reload.

A direct open of the dedicated localized SSO subview `/fr-FR/sécurité/sso` should also be confirmed if not already exercised; the overview/provider snapshot proves data authority but does not by itself prove navigation into that subview.

No new patch is justified from the currently supplied evidence. If these remaining gates pass, R8B4 can be accepted and the next development slice may start from OPUS HEAD `4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`.

## Next slice after full R8B4 acceptance

SecurityContext ownership plus first Security/Navigation inter-EFSM COMMAND/EVENT cooperation, followed by generic generated-application PHP ACTION/GUARD source authoring.
