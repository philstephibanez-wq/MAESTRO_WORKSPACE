# P117W R45B2A4AW — FSM signal origin and diagram actionability

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

OPUS owner baseline:

`eb160536bb82ff04a27a181f00fd6c9696be2099` — `opus_p117w_r45b2a4av_fsm_menu_post_command_dispatch`

## Owner semantic contract

FSM signal color represents only the emitter/origin of the signal:

- `user`: explicitly initiated by a user;
- `automatic`: emitted by an automatic/system process.

FSM signal color MUST NOT be derived from:

- GET/POST or any HTTP method;
- REST transport;
- signal functional `type` (`navigation`, `command`, `outcome`, `system`);
- whether the transition is currently clickable/actionable.

These are independent axes.

`cancel_creation` is therefore:

- functional type: `command`;
- origin: `user`;
- transport in the creation UI: POST;
- actionable from the current creation state when its exact request binding is available.

## Root causes

### 1. Generic renderer exposes type, not origin

`Opus/Fsm/Diagram.class.php` currently copies `signals[].type` to transitions and emits `signal-type-*` CSS classes. OWASYS CSS then colors navigation/command/outcome/system differently. This incorrectly couples FSM visual semantics to a functional classification.

### 2. Generic diagram actionability is href-only

The generic renderer accepts only `transitionLinks`, therefore an exact POST-bound FSM action can be actionable in Menu = FSM after A4AV but cannot be represented as an executable diagram transition without forging a GET.

### 3. Geometry normalization assumes every actionable transition has an href

`FsmDiagramGeometryNormalizer` resolves shared actionable rails by extracting `<a href>`. A structured POST action would otherwise be rejected or lose its hitbox during label normalization.

## Generic OPUS evolution

### `Opus/Fsm/Diagram.class.php`

- retain functional `signal_type` metadata for diagnostics/consumers;
- add independent `signal_origin` metadata;
- generic accepted origins: `user`, `automatic`; absent origin remains `unspecified` for legacy definitions;
- emit both `signal-type-*` and `signal-origin-*` classes, but origin is the visual semantic hook;
- add optional backward-compatible final `renderDefinition()` parameter for structured transition actions;
- add strict `setTransitionActions()` support for local POST actions with validated field names/values;
- a POST action is rendered as a real HTML form inside the SVG label hitbox through `foreignObject`;
- no JavaScript and no forged GET;
- GET links remain unchanged;
- actionability and origin remain independent;
- generic arrow markers are origin-aware.

### `Opus/Fsm/FsmDiagramGeometryNormalizer.php`

- accept actionable GET links and structured POST controls;
- preserve/promote either action kind when outer rails share a semantic signal/target;
- synchronize POST hitbox geometry after label movement/expansion;
- hidden duplicate labels cannot retain an active invisible POST hitbox;
- geometry/topology algorithm remains unchanged.

## OWASYS canonical FSM evolution

### `sites/owasys-front/config/fsm.json`

Every canonical signal receives explicit `origin` metadata.

Migration rule for the current OWASYS contract:

- user-origin signals: 31;
- automatic-origin signals: 19;
- total signals: 50.

`cancel_creation` remains `type: command` and receives `origin: user`.

Removing all newly added `origin` keys reconstructs the exact A4AV owner-baseline FSM Git blob:

`12b25a225d87d45de3977352a917cf26fec9a22e`

No state, transition, guard, action, runtime operation, rank/order, route, or topology is changed.

### `OwasysNavigationBuilder`

- require explicit `origin=user|automatic` for OWASYS canonical signals;
- propagate `signal_origin` independently of `signal_type`;
- preserve the A4AV GET/POST request binding contract unchanged.

### `OwasysFsmDiagramBuilder`

- require explicit canonical origin;
- use `menu_actionable` rather than GET-only `actionable` when projecting current actions;
- keep GET actions as `transitionLinks`;
- project exact POST action URL/field/value as structured `transitionActions`;
- no arbitrary signal supplied by the browser;
- fixed topology/geometry logic remains unchanged.

### SCORE / CSS

`navigation.score` exposes both type and origin metadata.

`fsm-native.css`:

- user signal color: current cyan/accent;
- automatic signal color: current amber/warning;
- no `signal-type-*` selector controls color;
- actionability changes weight/hitbox/hover/focus only and retains origin color;
- Menu = FSM and diagram use the same origin semantics.

`ScorePageRenderer.php` bumps the FSM CSS cache key to `p117w-r45b2a4aw` so the semantic color change cannot be masked by a stale browser stylesheet.

## Invariants

A4AW MUST NOT change:

- accepted A4Z/A4AN/A4AO/A4AP FSM topology/geometry behavior;
- initial state `login` and fixed layout;
- current-state-only highlighting;
- canonical transitions or their targets;
- A4AV exact POST binding for `cancel_creation`;
- A4AT/A4AS 303/finalization/profiler lifecycle;
- REST, ACL, SSO, session, backend or Composer business flow.

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

No patcher, deletion, backend file, JS file, route change or controller change.

## Pre-delivery validation

- exact owner ancestry verified for all eight source files;
- PHP lint OK on all five PHP files;
- strict JSON parse OK;
- stripping `origin` metadata reconstructs exact A4AV canonical FSM bytes;
- all 50 signals have exactly `user` or `automatic` origin;
- `cancel_creation`: `command + user`;
- no OWASYS CSS `signal-type-navigation|command|outcome|system` selector remains for color;
- generic renderer smoke: user/automatic classes, exact POST form, action field/value and geometry normalization survive;
- OWASYS smoke using canonical FSM/routes: active `t_creation_basics_cancel` is `signal-type-command + signal-origin-user + actionable`, exact POST `/fr-FR/applications/new`, field `owasys_action=cancel-creation`;
- automatic `t_creation_failed` remains `signal-origin-automatic` and passive;
- no trailing whitespace;
- ZIP contains exactly eight listed files.
