# P117W R45B2A4BZ2 R8B6O — Active persisted Bézier handles — HANDOFF

State: OWNER RUNTIME ACCEPTED — PUSHED

## Baseline

- README-FIRST: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS owner HEAD: `9fbcb714d5113e32f881a13bff8925b9dcc29159`.
- baseline blobs:
  - diagram: `86c56e0d1d59e604064f491b392ce7890ea194ae`;
  - layout store: `6d7858ad254d059dd1cb036211e6e7bab480d2e9`;
  - diagram builder: `f16bc1603b539c16eb23cd79017ab16cacc4c499`;
  - SCORE renderer: `78a7b9cdf6278a7c6e4b44bc359d5fcd6794cc0e`;
  - SCORE partial: `935d3d50573989c060f9621ab637face5cff61b3`;
  - native FSM CSS: `085e6a9e68b775461f18e5276e4b4c95d5b76d29`;
  - designer JavaScript: `d05e806b91383e5b3200c7c8f71a3f2d30c0a82f`.

## Delivery

The preview handles are now real layout controls. Primary-pointer movement of `C1/C2` edits only the selected cubic path. `P0/P3` remain attached ports. Relative control offsets are stored in `fsm.layout.json` and used by the generic OPUS renderer when attached states or a finite-global source marker move.

## Artifact

- ZIP: `R8B6O.zip`
- ZIP SHA-256: `6934a03821c70b41a5d1b6a57ca8605380c5dabbbd8fb7ce0b0f1ab8651f9120`
- size: `69435` bytes
- exact contents:
  - `Opus/Fsm/Diagram.class.php`
  - `Opus/Fsm/FsmDiagramLayoutStore.php`
  - `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
  - `sites/owasys-front/application/default/services/ScorePageRenderer.php`
  - `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
  - `sites/owasys-front/www/asset/css/fsm-native.css`
  - `sites/owasys-front/www/asset/js/fsm-designer.js`
- delivered blobs:
  - diagram: `b369b4fd8a2cf81f40fc4acbc1295f167773a59a`;
  - layout store: `b6c7261c054113321ee340798e88a472ebc51649`;
  - diagram builder: `2e392a98b64b26a0fdd29de9402f493680335bca`;
  - SCORE renderer: `6d50d596fd3723db15588adcf983c080bf83d5ae`;
  - SCORE partial: `9966f0dbed6738bfb71591da7c4775a26b8752d3`;
  - native FSM CSS: `39ea43ddbca85877360b4413346cd5a8428f65ef`;
  - designer JavaScript: `d4fd7f15f447b20acb290c579c2ce79e4f813728`.

## Delivery-environment verification

- external designer JavaScript syntax: PASS;
- embedded generic layout JavaScript syntax and required contract tokens: PASS;
- `git diff --check`: PASS;
- backend-JavaScript exclusion: PASS;
- ZIP integrity and exact-path round trip: PASS.

PHP and a browser executable are unavailable in the delivery environment. Owner PHP lint and real OWASYS runtime interaction are mandatory acceptance gates.

## Commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\R8B6O.zip" -C H:\OPUS
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Fsm\FsmDiagramLayoutStore.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime gate

Select the owner-created local transition, drag both controls, reload, switch View/Design, then move each attached state. The manual curve must remain persisted and attached throughout. Repeat on a finite-global cubic if available. Curve-only editing must change only the applicable layout JSON, never the canonical FSM JSON.

Do not commit/push until all gates pass.

## Owner closure

- Both Bézier handles are functional.
- Relative control geometry persists after reload and View/Design switching.
- Owner commit pushed: `23be733f401ff526ff4d32a64277e6af1778f024`.
- The next toolbar defect is separate: STATE deletion is correctly blocked by
  a dependent transition, while TRANSITION deletion is still an inactive
  toolbar stub. That dependency dead-end is owned by R8B6P.
