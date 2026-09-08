# P117W R8NMI16B — APPLICATION FSM / EXACT fr-FR HANDOFF

Date: 2026-09-08
Status: DELIVERED — OWNER RUNTIME VALIDATION PENDING

## Authority

Implemented from current OPUS GitHub master under `README-FIRST.md`, the patch delivery contract, the native ZIP stepwise workflow contract, and the security baseline. OPUS/OWASYS GitHub sources are not mutated by this delivery.

## Runtime evidence received

Owner diagnostics show that, with `essai` selected, the Application context requests `/api/v1/applications/essai/fsm/layouts/navigation`. This confirms the Application page is still bound to the named `navigation` EFSM instead of the selected application's root FSM.

The same diagnostics expose exact-locale `fr-FR` misses for `build.preview_button` and the security keys `security.controlled_mutations`, `security.authentication_public`, `security.onboarding_present`, and `security.disabled`. The corresponding `fr-FR` module catalogs on current master are empty while the `fr` catalogs contain the translations. Exact-locale semantics are preserved: no implicit parent/base fallback is introduced.

## Delivered change

Native differential ZIP `R8NMI16B.zip` contains complete files only:

- `Opus/Fsm/FsmSiteLoader.php`
- `sites/owasys-front/application/default/services/ContextEfsmRegistry.php`
- `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`
- `sites/owasys-front/application/build/local/fr-FR.json`
- `sites/owasys-front/application/security/local/fr-FR.json`

The Application context now uses semantic EFSM id `application`. That id resolves to the selected application's canonical `application_fsm` pointer when declared, otherwise to `config/fsm.json` for standard applications. It no longer aliases the application's optional navigation micro-EFSM. Backend layout/draft resolution receives the same semantic id through `FsmSiteLoader`, keeping rendering and persistence on one source.

The exact `fr-FR` build/security catalogs are populated from their authoritative French module catalogs instead of relying on an implicit `fr` fallback.

## Validation status

Artifact-side PHP syntax and JSON parsing passed before ZIP creation. No owner runtime success is claimed. Owner must apply the ZIP to the expected local OPUS baseline, run Composer/site validation, restart both bastions, and verify ESSAI plus another generated application.

## Acceptance gates

1. With ESSAI selected, Application context must request `/fsm/layouts/application`, not `/fsm/layouts/navigation`.
2. The diagram source must be ESSAI's root application FSM (`application_fsm` when declared, otherwise `config/fsm.json`).
3. Host context EFSMs `registry`, `data`, `source`, `git`, `build` remain unchanged.
4. Exact `fr-FR` requests must no longer emit the evidenced build/security missing-message warnings.
5. NMI geometry/Bezier persistence from R8NMI15/R8NMI16A must remain intact.
