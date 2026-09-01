# R8B6Y — STRICT NO-FALLBACK EFSM OWNERSHIP

## Severity

BLOCKER.

## Baseline

OPUS GitHub baseline observed before delivery preparation: `a227509d53c0296e01b698c0e6678420eb1128a1`.

## Contract

No fallback or silent substitution is allowed anywhere in the OPUS/OWASYS ownership path.

An operation involving an application, EFSM, source or locale MUST resolve the exact requested owner and exact requested resource. If that exact resource cannot be resolved, execution MUST stop explicitly. It MUST NOT substitute OWASYS, another application, another EFSM, another source, another locale, a parent locale, a default locale, a previous context or any guessed path.

### Application / EFSM ownership

For every OWASYS EFSM read, layout write or semantic designer write:

- the selected application id is authoritative for application-owned EFSMs;
- `application` in the Application page is application-owned, not an OWASYS designer fallback;
- internal OWASYS host-context EFSM ownership is a distinct runtime concern and MUST NOT be used to redirect designer ownership;
- the designer target application, snapshot application and REST resource application MUST be identical;
- any ownership divergence is a blocking error before read or write.

### Source resolution

- Source paths MUST come from an explicit canonical declaration of the exact application contract.
- No `??` chain or guessed path is permitted as source resolution.
- System and generated application schemas may have different explicit canonical fields, but choosing between them MUST be based on an explicit application contract/role, never on absence of a previous candidate.

### I18n

- Exact locale only.
- No parent-language inheritance.
- No regional fallback.
- No French fallback.
- No `fallback_locale`, `silent_fallback`, `fallbackChain`-driven catalog substitution or equivalent behavior.
- If an exact visible translation is absent, OWASYS displays `⚠ <technical_id>` where applicable; the technical id is never translated.

## Confirmed defect

`sites/owasys-front/config/application.fsm.json` was contaminated with application-specific state/transition identities (`essai`, `transition.modiee`). Historical canonical OWASYS host-context definition used `unselected -> selected` with transition `application.context.select`.

The defect is enabled by ownership code that classifies `application` as a host EFSM for designer resolution and then substitutes `owasys-front` instead of the selected application.

## Required correction

1. Separate internal OWASYS runtime host-context ownership from designer/application ownership.
2. Application-page EFSM reads and writes target the exact selected application.
3. Restore the canonical OWASYS internal application-context EFSM.
4. Remove source-path fallback resolution from application EFSM loading.
5. Remove active I18n fallback behavior and fallback policy configuration.
6. Extend the OPUS/OWASYS audit so fallback/substitution and application-owner divergence are blocking findings.
7. Do not overwrite or discard uncommitted owner changes; validate the exact worktree before applying the ZIP.

## Acceptance

- Selecting `essai` and opening Application displays the exact `essai` application FSM source, never `owasys-front`.
- Selecting `owasys-front` displays only OWASYS-owned source.
- A semantic edit made while `essai` is selected can never write under `sites/owasys-front`.
- Deliberate owner mismatch is rejected before REST mutation.
- OWASYS internal Application context is restored to `unselected -> selected`.
- No functional locale fallback remains.
- Audit reports BLOCKER for fallback/substitution mechanisms or owner divergence.
- PHP/JSON validation and `git diff --check` pass.
