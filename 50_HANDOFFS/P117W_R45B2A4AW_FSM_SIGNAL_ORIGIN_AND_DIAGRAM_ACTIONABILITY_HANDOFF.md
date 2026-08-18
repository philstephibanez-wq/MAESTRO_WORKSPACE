# P117W R45B2A4AW — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS:

`eb160536bb82ff04a27a181f00fd6c9696be2099` — `opus_p117w_r45b2a4av_fsm_menu_post_command_dispatch`

A4AV is the current owner commit/push baseline.

## Owner correction that governs A4AW

On 2026-08-18 the owner explicitly corrected the FSM visual semantics:

> Color differentiates a signal sent by a user from a signal sent by an automatic process. GET/POST belongs to REST/transport and must not determine FSM color.

A4AW applies this as a strict contract.

## Resulting orthogonal dimensions

For every signal/transition the following dimensions are independent:

1. **FSM origin** — `user` or `automatic`; this controls semantic color.
2. **Functional type** — `navigation`, `command`, `outcome`, `system`; retained as metadata, not color.
3. **Transport** — e.g. GET/POST; never controls color.
4. **Actionability** — whether the current transition can be executed from the current UI state; controls hitbox/emphasis only, not color.

Therefore `cancel_creation` is canonically:

- `type=command`;
- `origin=user`;
- transported by the existing exact POST binding in the creation flow;
- actionable in Menu = FSM and in the diagram when the current state owns the transition.

## Generic OPUS evolution first

README-FIRST requires a generic OPUS evolution before a local non-business workaround. A4AW therefore changes the generic FSM renderer and geometry normalizer before OWASYS projection/style.

### Generic renderer

`Opus/Fsm/Diagram.class.php`:

- preserves `signal_type`;
- adds independent `signal_origin`;
- emits `signal-origin-user|automatic|unspecified`;
- accepts legacy definitions with no origin as `unspecified`;
- rejects invalid explicit origins;
- adds backward-compatible structured POST transition actions as the final optional `renderDefinition()` argument;
- keeps existing GET transition links unchanged;
- renders a real POST form in the SVG signal-label hitbox, without JavaScript and without a fake GET;
- uses origin-specific arrow markers;
- actionability no longer assigns one universal signal color.

### Generic geometry normalizer

`Opus/Fsm/FsmDiagramGeometryNormalizer.php`:

- understands both GET-link and POST-form actionability;
- keeps shared-rail action promotion valid for either transport;
- re-synchronizes POST form hitboxes after label geometry normalization;
- removes POST hitboxes when a duplicate shared label is hidden;
- preserves state positions, ranks, routing and physical scale contract.

## OWASYS canonical origin metadata

`sites/owasys-front/config/fsm.json` receives only additive `origin` keys on the 50 existing signals:

- 31 `user`;
- 19 `automatic`.

Removing the `origin` keys reconstructs the exact owner-baseline FSM blob:

`12b25a225d87d45de3977352a917cf26fec9a22e`

No FSM topology change is present.

## OWASYS projection

`NavigationBuilder.php` now validates and propagates explicit origin while retaining A4AV GET/POST binding logic.

`FsmDiagramBuilder.php` now projects current `menu_actionable` transitions to the diagram:

- GET remains an exact transition link;
- POST becomes a structured exact action containing the localized source-state URL and configured field/value.

For `cancel_creation` the emitted request remains exactly the A4AV contract:

- POST localized `applications/new` URL;
- `owasys_action=cancel-creation`.

The browser never supplies an arbitrary signal name.

## UI semantics

`navigation.score` carries both `data-signal-type` and `data-signal-origin`.

`fsm-native.css` uses only origin for semantic signal color:

- user → cyan/accent;
- automatic → amber/warning.

No type selector controls signal color.

Actionable state uses stronger edge weight and label hitbox/hover/focus while retaining the origin color.

`ScorePageRenderer.php` changes only the FSM stylesheet cache key from A4AP to A4AW so the browser cannot retain stale type-color CSS.

## Source integrity

Exact pre-A4AW owner blobs used:

- `Opus/Fsm/Diagram.class.php` → `df9644293c194fc4da7cf56b8d1e1d0b5425d9e9`
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php` → `2a9f6595c2174cfd79b247c82cea63deb00c66de`
- `sites/owasys-front/config/fsm.json` → `12b25a225d87d45de3977352a917cf26fec9a22e`
- `sites/owasys-front/application/default/services/NavigationBuilder.php` → `0ef180e3fb51c6b79b408753b0859ba95f7686a8`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` → `114f5e3683950b9f55a10ec4721fa056ddd54cbc`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` → `1f7c6995ac081c0f020af2d3b945a993dc35ca08`
- `sites/owasys-front/application/default/templates/partials/navigation.score` → `9bfab6fb3b1bc80e23c98735a34807b446ec8653`
- `sites/owasys-front/www/asset/css/fsm-native.css` → `79d0f9c5d1ab8b2de3f4fa8ac9a1bb40a9d0429e`

Delivered blobs:

- `Opus/Fsm/Diagram.class.php` → `47c925051b087ab1a0cba15fb4b6faf633add79a`
- `Opus/Fsm/FsmDiagramGeometryNormalizer.php` → `a5cec8b917276fb5bd210ab6a3558a3731277c04`
- `sites/owasys-front/config/fsm.json` → `5595cd8be05f01e6d8f2b8a1dd519e6ea9675c3c`
- `sites/owasys-front/application/default/services/NavigationBuilder.php` → `412a51d7fca717b431d772333646e64bc668f984`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` → `3f9595466e6c7294d0748a5e759764b4cd51c8bd`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` → `d11919527cd333cfc3b3d86c14c37b30c6710b1c`
- `sites/owasys-front/application/default/templates/partials/navigation.score` → `9c8150e72d2ee3fc8888a5fdf441cca8c034f68d`
- `sites/owasys-front/www/asset/css/fsm-native.css` → `ca15bd37a987f40f3ef58b9522f5c3b944199f68`

## Delivery

Artifact:

`opus_p117w_r45b2a4aw_fsm_signal_origin_and_diagram_actionability.zip`

SHA-256:

`fdfad46b905aca3992bc54ec565d387865c5515fb1e8137baa5fc6010d0f7cbc`

Exactly eight complete files:

1. `Opus/Fsm/Diagram.class.php`
2. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
3. `sites/owasys-front/config/fsm.json`
4. `sites/owasys-front/application/default/services/NavigationBuilder.php`
5. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
6. `sites/owasys-front/application/default/services/ScorePageRenderer.php`
7. `sites/owasys-front/application/default/templates/partials/navigation.score`
8. `sites/owasys-front/www/asset/css/fsm-native.css`

No patcher. No deletion. No route/controller/backend/REST/ACL/SSO/session business change. No JavaScript.

## Pre-delivery validation completed

- PHP lint: 5/5 OK;
- strict JSON parse: OK;
- original source ancestry: 8/8 exact Git blobs;
- canonical FSM origin-only transformation: exact;
- signal origins: 50/50 explicit and valid;
- `cancel_creation`: `command + user`;
- no signal-type color selector remains in OWASYS FSM CSS;
- generic renderer+normalizer structured POST smoke: OK;
- canonical OWASYS FSM/routes smoke: OK;
- active `t_creation_basics_cancel`: `signal-type-command + signal-origin-user + actionable`;
- exact request: POST `/fr-FR/applications/new`, `owasys_action=cancel-creation`;
- automatic `t_creation_failed`: `signal-origin-automatic`, passive;
- POST hitbox remains synchronized after geometry normalization;
- no trailing whitespace;
- ZIP exactly 8 files.

## Owner runtime acceptance

1. Enter Creation Basics with no application id/profile filled.
2. Confirm Menu = FSM `cancel_creation -> Applications` remains actionable and works.
3. In the FSM diagram, locate the `cancel_creation` transition from the current Creation Basics state.
4. `cancel_creation` must have the **user-signal color**, not a special command/POST color.
5. Click the diagram `cancel_creation` label: it must execute the exact canonical POST and return to Applications through the existing 303 lifecycle.
6. Profiler/FSM evidence must identify `cancel_creation`, not `change_app`.
7. Automatic outcomes such as `application_creation_failed` must use the automatic-signal color.
8. Changing signal functional type or HTTP method must not be the reason for a color change.
9. Fixed FSM topology/geometry, initial Connexion, current-state-only highlight, branches, returns and self-loops remain unchanged.
10. A4AT/A4AS profiler lifecycle remains: successful 303 logs/completes/persists without false SCORE rendered event.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
