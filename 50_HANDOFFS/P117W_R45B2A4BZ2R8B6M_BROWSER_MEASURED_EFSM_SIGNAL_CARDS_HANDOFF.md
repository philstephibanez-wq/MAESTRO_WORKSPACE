# P117W R45B2A4BZ2 R8B6M — Browser-measured EFSM signal cards — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD: `c11357f4`.
- baseline `Opus/Fsm/Diagram.class.php` blob: `51025e42711b4c83612056933a2307d7a6a223c3`.

## Delivery

The generic renderer now reconciles each signal-card frame with the browser-measured union of its SVG text nodes. It applies explicit padding and updates the frame, POST hit area and drag dimensions before the interaction maps are built.

## Artifact

- ZIP: `R8B6M.zip`
- ZIP SHA-256: `2c22201008cf1953876c2955229dedc1b1b1b1b30b345b5ffc35051da869cf56`
- size: `32459` bytes
- exact content:
  - `Opus/Fsm/Diagram.class.php`
- file SHA-256: `9f0f51d8bc8acdbd49f71b55b314b2ea36eb46af2a95b9c6a35ba22723d8d949`
- delivered blob: `86c56e0d1d59e604064f491b392ce7890ea194ae`
- embedded JavaScript syntax: PASS
- `git diff --check`: PASS
- ZIP round-trip: PASS

PHP is unavailable in the delivery environment; owner lint is mandatory.

## Commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\R8B6M.zip" -C H:\OPUS
php -l Opus\Fsm\Diagram.class.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime gate

Open the `essai` Navigation diagram in View and Conception. The complete `open_home [route_exists] / render_route()` text must be inside its card with visible padding. Move the signal card, reload, and confirm persistence.

Do not commit/push until these gates pass.
