# MAESTRO_WORKSPACE HANDOFF — OWASYS P117N-R4

Date: 2026-07-22
Status: differential ZIP prepared and statically validated
OPUS GitHub head reviewed: `e0c157273b498cb93529fcd2b1ee834c1668a270` (`p117n hs`)
Local prerequisite: P117N-R3 canonical regional i18n files already applied

## Incident

The regional locale itself is resolved correctly. A request such as:

`/en-IE/applications`

fails with:

`OWASYS_ROUTE_NOT_FOUND:applications`

The cause is the obsolete localized route-map contract. `routes.json` contains route tables only for the 25 base locales, while the runtime now passes the exact regional locale (`en-IE`, `fr-BE`, `de-CH`, and so on) to `resolveSignal()`.

The route path is not translated: `applications`, `structure`, `data`, and the other technical paths are identical for every locale. Locale-indexing this map is therefore incorrect duplication and creates regional gaps.

## P117N-R4 correction

The route map becomes locale-independent under contract:

`OPUS_SIGNAL_ROUTES_V2`

The application owns one canonical signal table:

- `login` -> `open_login`;
- `account/password` -> `open_account`;
- `applications` -> `change_app`;
- `structure` -> `open_structure`;
- `data` -> `open_data`;
- `workflows` -> `open_workflows`;
- `security` -> `open_security`;
- `source` -> `open_source`;
- `build` -> `open_build`;
- `logout` -> `logout`.

Every route still resolves to an FSM event. No route dispatches a controller or view directly, and no route bypasses SSO, ACL, guards or FSM actions.

`RuntimeController::resolveSignal()` no longer receives a locale. It reads the single map through `StructuredFileLoader`, verifies the exact V2 contract, and returns only the configured FSM event.

## Architecture boundaries

The request pipeline remains:

request -> browser/explicit locale -> SSO identity -> route signal -> FSM event/transition -> deny-by-default ACL and FSM guards -> ViewModel -> SCORE.

The locale affects catalogs, URLs, labels and presentation. It does not fork technical application routes.

The correction is application-level OWASYS work. No new generic OPUS framework capability is required and no new concrete OPUS class is introduced.

## I18n prerequisite

P117N-R4 assumes the P117N-R3 canonical catalog convention:

`<locale>.json`

No `asap.` prefix, PHP catalog, underscore alias or duplicate catalog name is allowed.

The audit validates:

- 62 configured locales;
- 248 canonical JSON catalogs across `default`, `login`, `account`, and `registry`;
- browser negotiation for Ireland, Belgium, Switzerland and Ukraine;
- `fr-CA` resolving explicitly to the supported base language `fr`;
- no prefixed or PHP catalog.

## FSM/ACL/SSO verification

The audit requires every configured route event to exist in the OWASYS FSM event catalog. It also requires state routes for login, account, Applications, structure, data, workflows, security, source and build.

The existing ACL remains deny-by-default. Registry access still requires `registry:open`, and write actions still require `registry:write` or the equivalent wildcard permission.

P117N-R4 does not add Auth0 credentials, an Auth0 implementation, a bastion bypass or a local authentication fallback. Future proxy/bastion providers remain behind the OPUS SSO boundary.

## OPUS component contract

P117N-R4 adds no concrete OPUS framework class. The exhaustive P117M-R1 audit remains a required gate.

Any future concrete framework class must implement a homonymous interface extending all four markers:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Files in the differential

- `sites/owasys/config/routes.json`;
- `sites/owasys/application/default/controllers/RuntimeController.php`;
- `tools/maintenance/audit_owasys_routes_p117n_r4.php`;
- `tools/maintenance/APPLY_OWASYS_ROUTES_P117N_R4.cmd`.

No Markdown, smoke test or script is placed at the OPUS root. No file is created under `sites/owasys` outside the application/config/public asset architecture.

## Validation performed before delivery

- PHP syntax validation of the corrected controller and maintenance audit;
- JSON syntax validation of the V2 route contract;
- static verification that the route map is not indexed by locale;
- static verification that `resolveSignal()` accepts only the route key;
- exact route-to-FSM-event matrix verification;
- confirmation from the current FSM that `applications` is the Registry state route and `change_app` is a declared transition event;
- confirmation from the current ACL that Registry remains deny-by-default and role-controlled.

No browser execution was performed against the user's Windows runtime during artifact generation.

## Delivery policy

No direct write is made to the OPUS repository. Runtime changes are delivered only as a differential ZIP. This handoff and its specification are the direct GitHub writes in `MAESTRO_WORKSPACE`.
