# P117W R45B2A4BZ2 R8B6J — Movable finite-global transition rerouting — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- OPUS HEAD: `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Expected R8B6I working file blob: `d7ebe8d4b31a062d8afcee43e5f1177d95432002`.
- R8B6I must remain applied; R8B6J overwrites its complete `Diagram.class.php`.

## Delivered correction

Finite-global transition groups are no longer translated with target states. Each group carries its fixed finite-source port as numeric SVG data. The shared editor recomputes its Bézier path to the live target boundary during state movement and again before geometry persistence.

Signal cards remain independently draggable. Their canonical `navigation.open.*` identities remain unchanged. R8B6I source nodes and all non-global rendering behavior are preserved.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6j_movable_finite_global_transition_rerouting.zip`
- ZIP SHA-256: `94d101645575c617ac5a5090868a85efc33c79a6fffd8671524747499d1ec6f6`
- size: `31277` bytes
- contains exactly `Opus/Fsm/Diagram.class.php`
- file SHA-256: `e9b30a4b5cadf9fcc7fdc0a4c01de30650eb4ead2237ffec7e9891524fdbbec5`
- delivered blob: `7a365a1c522b0d0e0fee08414aa1bd7d61c6e6d8`
- JavaScript syntax check: PASS
- `git diff --check`: PASS
- ZIP byte round-trip: PASS

PHP is unavailable in the delivery environment; owner PHP lint remains mandatory.

## Commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bz2r8b6j_movable_finite_global_transition_rerouting.zip"
php -l Opus\Fsm\Diagram.class.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime acceptance

Move each state while observing its global transition. Both endpoints must remain connected throughout the drag. Then move at least one signal card, reload, switch View/Conception, and verify that state/card positions persist and paths remain attached. Do not commit OPUS before these gates pass.
