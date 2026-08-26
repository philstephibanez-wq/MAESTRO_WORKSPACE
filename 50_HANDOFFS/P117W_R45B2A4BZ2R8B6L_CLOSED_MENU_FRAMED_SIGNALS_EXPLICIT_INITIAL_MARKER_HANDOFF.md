# P117W R45B2A4BZ2 R8B6L — Closed menu, framed signals and explicit initial marker — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD: `636b3cc9d98e33cfbac5dcea58a2188e4e77c8de`.
- expected working blobs after R8B6K:
  - `Opus/Fsm/Diagram.class.php`: `5fab5513837bc77705ed84f47ac4cd6999860144`;
  - `Opus/Fsm/FsmDiagramLayoutStore.php`: `dd42e76d5e635821d1f0e538bea411b2a82ff451`.
- baseline `navigation.score` blob: `8f11a401e5d75db3c918645e22f6a827b0f08562`.

## Delivery

The active menu item no longer forces its operation `<details>` open. Horizontal signal cards now allow up to 520 px, include 30 px horizontal padding and use a 28 px frame with corrected text baseline. The renderer and layout store no longer exclude an `initial_state` merely because its state type is `entry`.

R8B6K source-marker persistence remains included in the two complete OPUS files.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6l_closed_menu_framed_signals_explicit_initial_marker.zip`
- ZIP SHA-256: `c2ac8acf925fa9c088c7d053c4edbafd9a6469b50f771ae56a751425cd68eb91`
- size: `39137` bytes
- exact contents:
  - `Opus/Fsm/Diagram.class.php`
  - `Opus/Fsm/FsmDiagramLayoutStore.php`
  - `sites/owasys-front/application/default/templates/partials/navigation.score`
- file SHA-256:
  - Diagram: `f0bfb6729b30f4dbea27945fe0827d4affaacbf1194e4f5bfabb6d0b989df8f0`
  - Store: `536fc57e85c59e5f07a3ce1f7a31f853d9893e843909b7a8cf9ffe5cde031c94`
  - SCORE navigation: `2e40dfbf6594501ef8604b0ff2eb224660a2e130a7970dd4a27df8727cf753bf`
- delivered blobs:
  - Diagram: `51025e42711b4c83612056933a2307d7a6a223c3`
  - Store: `6d7858ad254d059dd1cb036211e6e7bab480d2e9`
  - SCORE navigation: `c7d78c69b9d1f42cfbfab3db09629aa2541f65bd`
- embedded JavaScript syntax: PASS
- `git diff --check`: PASS
- ZIP round-trip: PASS

PHP is unavailable in the delivery environment; owner lint is mandatory.

## Commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bz2r8b6l_closed_menu_framed_signals_explicit_initial_marker.zip"
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Fsm\FsmDiagramLayoutStore.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime gate

Open application, security and navigation in turn: no operation submenu may be pre-opened. Verify that every semantic label is fully enclosed. In `essai` Navigation, verify the white initial point and arrow to `begin`; move the marker in Conception, reload and switch View/Conception to confirm persistence.

Do not commit/push until these gates pass.
