# P117W R8B6S — Handoff

State: CODE DELIVERY PREPARED — OWNER APPLICATION REQUIRED
Date: 2026-09-05

## Source authority

The delivery is prepared from GitHub `master` sources, not from chat memory or an assumed local checkout.

Authoritative sources reviewed:

- `README-FIRST.md`;
- `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md`;
- `00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`;
- `40_SPECS/P117W_R45B2A4F_FINITE_STATE_NMI_SPEC.md`;
- OPUS `Opus/Scaffold/SiteScaffoldPlan.php`;
- OPUS `sites/essai/config/application.fsm.json`;
- OPUS `sites/owasys-front/config/fsm.json`;
- OPUS `sites/owasys-back/config/fsm.json`.

## Root cause

The generic scaffold currently generates application FSMs without mandatory security/critical NMI coverage. `essai` consequently has no NMI. OWASYS has only one established NMI class per side: front security (`auth_required`) and back critical (`fail`).

## Correction contract

- generated frontend/fullstack: security + critical NMI -> safe `begin` state;
- generated backend: security + critical NMI -> safe `api` state;
- `essai`: add both classes -> `connexion`;
- `owasys-front`: keep `auth_required`, add critical NMI -> `login`;
- `owasys-back`: keep `fail`, add security NMI -> `api`.

No ordinary transition, geometry, NMI color, REST, SCORE, ACL, SSO or Composer semantics are changed.

## Owner workflow

Owner verifies the ZIP SHA/content, extracts it at `H:\OPUS`, runs the applicator, reviews the resulting diff, validates PHP/JSON/site/runtime, and commits/pushes OPUS only after acceptance. Assistant does not commit or push OPUS/OWASYS.
