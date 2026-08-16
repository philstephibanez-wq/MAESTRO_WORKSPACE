# P117W R45B2A4AD — Account / password FSM split

State: OWNER VALIDATION REQUIRED

## Baseline

Continuation of the accepted fixed FSM work through A4AC.

A4AC remains the graphical/runtime baseline for:

- fixed classic FSM geometry;
- current-state highlight only;
- Menu = FSM;
- native menu autocollapse;
- current-state semantic actions (`change_app`, `logout`, `open_*`);
- cyan reserved for actionable transitions;
- anti-overlap label routing.

## Owner feedback — 2026-08-17

Owner reports that `open_account` opens the password-change page and explicitly states the governing rule:

> if the FSM is wrong, navigation cannot be right.

## Root cause

The canonical `sites/owasys-front/config/fsm.json` conflates two different concepts:

- state id `account`;
- route `account/password`;
- title `auth.change_password`;
- summary `auth.change_password_description`.

Every `open_account` transition therefore targets a state whose semantic meaning is "change password".

The runtime reinforces the conflation:

- `account` GET is translated to `open_account` then redirected;
- `account/password` GET is also translated to `open_account`;
- `urls.account` points directly to `account/password`;
- the only `account/templates/index.score` body is the password-change form.

The localized route catalog also contains `account/password` as a canonical route while `account` is only a self-targeting alias.

NavigationBuilder is not the correction target: it correctly projects the FSM it receives.

## A4AD correction

A4AD separates account identity/profile navigation from password mutation while keeping both in the existing `account` application module.

### Canonical FSM

`sites/owasys-front/config/fsm.json`:

- `account` becomes a real state:
  - module `account`;
  - route `account`;
  - template `index.score`;
  - title/label `menu.account`;
- new state `password`:
  - module `account`;
  - route `account/password`;
  - template `password.score`;
  - title `auth.change_password`;
- new signal `open_password_change`;
- every `open_account` transition targets `account`;
- every `open_password_change` transition targets `password`;
- `password_change_required` targets `password`;
- `password_changed` originates from `password` and returns to `registry`;
- `password_change_failed` loops on `password`;
- the new `password` state receives the same global navigation/session transitions required by the existing FSM contract;
- all concrete `(from, signal)` pairs remain unique;
- no signal is undeclared or unused.

### Signal routes

`sites/owasys-front/config/routes.json`:

- `account -> open_account`;
- `account/password -> open_password_change`.

### Localized routes

`sites/owasys-front/config/routes.localized.json`:

- `account` becomes a canonical route using the already-existing localized account paths from the previous alias;
- `account/password` remains the canonical password-change route;
- the old self-targeting `account` alias is removed;
- all 25 configured base languages remain present;
- localized-path collision check passes for every language.

French canonical public paths are therefore:

- `account` -> `compte`;
- `account/password` -> `compte/mot-de-passe`.

### Runtime controller

`sites/owasys-front/application/default/controllers/RuntimeController.php`:

- mandatory password enforcement emits `open_password_change`, never `open_account`;
- GET account/password resolution comes from `OPUS_SIGNAL_ROUTES_V2` instead of a hardcoded `open_account` special case;
- password failures are handled only while FSM state is `password`;
- `urls.account` points to canonical `account`;
- new `urls.password` points to canonical `account/password`;
- state configuration may select a SCORE template through a validated basename-only `template` field; default remains `index.score`.

The state `template` field is presentation metadata carried by the existing FSM state array; it does not create a second state registry.

### SCORE templates

`sites/owasys-front/application/account/templates/index.score` becomes the actual Account page and shows the authenticated identity plus an optional change-password action.

The previous password form is preserved as:

`sites/owasys-front/application/account/templates/password.score`.

No new I18n message key is introduced. Existing `menu.account` and `auth.change_password*` catalogs remain authoritative.

### Fixed diagram

`FsmDiagramBuilder.php` keeps the A4AC fixed classic renderer and adds the semantic split to its stable projection:

- `login --password_change_required--> password`;
- `registry --open_account--> account`;
- `account --open_password_change--> password`;
- password failure self-loop;
- password success return to registry.

Current-state action mapping, cyan semantics and fixed layout contracts are preserved.

## Direct artifact

`opus_p117w_r45b2a4ad_account_password_fsm_split.zip`

SHA-256:

`c213f21a611677c3f14ab25ee7ee857f8554193ef8605c72319091021dd7388e`

Contains exactly seven complete final-path files:

- `sites/owasys-front/application/account/templates/index.score`
- `sites/owasys-front/application/account/templates/password.score`
- `sites/owasys-front/application/default/controllers/RuntimeController.php`
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/config/fsm.json`
- `sites/owasys-front/config/routes.json`
- `sites/owasys-front/config/routes.localized.json`

## Pre-delivery validation actually executed

- `RuntimeController.php`: PHP lint success;
- `FsmDiagramBuilder.php`: PHP lint success;
- all three JSON files decode successfully;
- FSM has 11 states, 45 declared signals and 165 transitions;
- `open_account`: 11/11 transitions target `account`;
- `open_password_change`: 11/11 transitions target `password`;
- password required/success/failure state ownership is correct;
- duplicate concrete `(from, signal)` pairs: 0;
- undeclared signals: 0;
- unused signals: 0;
- localized route catalog: 17 canonical routes x 25 languages;
- localized path collisions: 0;
- `account` and `account/password` French routes resolve to distinct paths.

## Owner acceptance

After extraction/restart:

1. Header `Compte` opens `/fr-FR/compte` and FSM state `account`.
2. Account page is not the password form.
3. Account page exposes `Changer le mot de passe` only when allowed.
4. That action opens `/fr-FR/compte/mot-de-passe` and FSM state `password`.
5. `open_account` never selects the password state.
6. `open_password_change` never selects the account state.
7. Mandatory password change still forces the password state.
8. Password success returns to Applications/registry.
9. Password validation failures remain on the password state.
10. Menu = FSM reflects the two distinct states.
11. A4AC fixed diagram, cyan actionability, focus behavior, autocollapse and anti-overlap remain intact.
12. Locale switching preserves whether the user is on Account or Password.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.