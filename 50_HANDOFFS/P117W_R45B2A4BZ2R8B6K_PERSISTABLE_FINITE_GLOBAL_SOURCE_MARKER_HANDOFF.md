# P117W R45B2A4BZ2 R8B6K — Persistable finite-global source marker — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD: `636b3cc9d98e33cfbac5dcea58a2188e4e77c8de`.
- Baseline blobs:
  - `Opus/Fsm/Diagram.class.php`: `7a365a1c522b0d0e0fee08414aa1bd7d61c6e6d8`;
  - `Opus/Fsm/FsmDiagramLayoutStore.php`: `1733e3dc69814d2d55f094c019b99a8958ca8cbf`.

## Delivery

The finite-global source node now participates in the established generic marker lifecycle. Its stable marker identity is derived identically by the renderer and layout store from the ordered canonical source set.

Right-button movement translates the node and reroutes all associated global paths live. Persistence writes its center into the existing V4 `markers` map together with canonical transition geometry. Reload restores that center before the ports and paths are computed.

No OWASYS-local source, EFSM definition, layout contract version or transition identifier changes.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6k_persistable_finite_global_source_marker.zip`
- ZIP SHA-256: `71905e1c2f770277042ac419b4d8769a499c069606219dc1d49776b39e48f250`
- size: `38059` bytes
- exact contents:
  - `Opus/Fsm/Diagram.class.php`
  - `Opus/Fsm/FsmDiagramLayoutStore.php`
- file SHA-256:
  - Diagram: `d3ba5c34c8b9b075d39e0ff299d8280455958600783c69589afd711250562e57`
  - Store: `5a308e47986f56d36f69a3cc1b4725dbf7cffbfc5fd935923b2b134974bc5225`
- delivered blobs:
  - Diagram: `5fab5513837bc77705ed84f47ac4cd6999860144`
  - Store: `dd42e76d5e635821d1f0e538bea411b2a82ff451`
- JavaScript syntax: PASS
- `git diff --check`: PASS
- ZIP round-trip: PASS

PHP is unavailable in the delivery environment; owner lint is mandatory.

## Commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bz2r8b6k_persistable_finite_global_source_marker.zip"
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

In Conception, move the `FINITE GLOBAL SOURCE SET` node with the right mouse button. Seven distinct source ports and paths must follow live. Reload, switch View/Conception and confirm persistence. Inspect `sites/owasys-front/config/navigation.fsm.layout.json`: its `markers` object must contain exactly one stable `finite-global-source-*` entry in addition to any valid initial marker.

Do not commit/push until these gates pass.
