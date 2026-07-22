# MAESTRO_WORKSPACE HANDOFF — OWASYS P117O

Date: 2026-07-23
Status: differential ZIP prepared and statically validated
Source OPUS head: `f7bf7bf89eaa85e1bc2e90b2cbc1dcfe669ec2dd` (`p117n_r5`)

## Objective

P117O resumes development of the OWASYS Applications page and repairs the horizontal navigation regression introduced by the variable-height global header.

## Navigation incident

The global header now contains:

- the OWASYS identity;
- current application context;
- the 37-entry regional locale selector;
- SSO identity and account/logout controls.

Its rendered height is no longer guaranteed to be 72 pixels. The horizontal navigation nevertheless remained independently sticky with `top: 72px`. This fixed offset allowed the navigation to overlap, detach from or be hidden behind the actual header.

## Navigation correction

The header and authenticated navigation are placed inside one common `ow-global-chrome` container.

The container is the only sticky element:

- `position: sticky`;
- `top: 0`;
- one shared stacking context;
- no hard-coded header-height offset.

The header and navigation remain normal children of that sticky stack. The locale options keep their higher internal z-index and can open over the navigation without displacing it.

The header is also allowed to wrap safely. Its actions have a bounded flex layout and the navigation remains horizontally scrollable when required.

## Applications page increment

The flat application-card list is replaced by a SCORE-rendered visual application tree:

- one OWASYS Registry root;
- one branch per registered application;
- current application highlighted;
- application name, kind, status, root, locale and theme shown as data;
- selection remains a POST action named `select-app`;
- the current application button remains disabled;
- empty Registry state remains explicit;
- SQLite synchronization and event panels remain available.

No application discovery or persistence logic is duplicated in the template. The page consumes the existing Registry ViewModel only.

## Runtime pipeline

The page remains governed by:

request -> regional locale resolution -> SSO identity -> deny-by-default ACL -> FSM event -> Registry ViewModel -> SCORE.

The `applications` route still resolves to the `change_app` FSM event. The event targets the `registry` state. The template does not call a controller or repository directly.

## SCORE and i18n

The implementation introduces no PHP view, no UI-producing echo and no HTML/PHP mixture.

All interface vocabulary uses existing SCORE i18n directives. Application names, roots, kinds, statuses, locales and themes are Registry data, not hard-coded presentation strings.

## OPUS framework boundary

No OPUS framework class is added or modified by P117O. The existing P117M-R1 exhaustive component-contract audit remains a release gate.

Every future concrete OPUS framework class must still implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

## Delivery

No direct write is made to the OPUS repository. Runtime corrections are delivered in a differential ZIP.

The ZIP contains only:

- the common SCORE layout;
- the Registry SCORE template;
- OWASYS theme and application CSS;
- a maintenance audit;
- a CMD application/validation wrapper.

No Markdown, smoke file or root-level launcher is included.

## Validation performed

- PHP syntax validation of the maintenance audit;
- balanced SCORE `if` and `foreach` blocks;
- balanced CSS blocks;
- static validation of the common sticky navigation contract;
- static validation of the Registry visual tree and POST selection contract;
- validation that routes, FSM and ACL remain the sources of truth;
- validation that no PHP or script block was introduced in the Registry SCORE template.

Browser execution on the user's Windows runtime remains required after extraction.
