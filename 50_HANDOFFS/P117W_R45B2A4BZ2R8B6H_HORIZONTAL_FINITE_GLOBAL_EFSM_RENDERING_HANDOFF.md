# P117W R45B2A4BZ2 R8B6H — Horizontal finite-global EFSM rendering — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS exact baseline/master: `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Target baseline blob: `Opus/Fsm/Diagram.class.php` = `1c307116bd6da961f9afcab62b47bc1a87131c64`.
- R8B6D is owner-applied and pushed. Do not reapply R8B6C or R8B6D.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6H_HORIZONTAL_FINITE_GLOBAL_EFSM_RENDERING_SPEC.md`.

## Runtime evidence reconciled

The owner proved state-position persistence after rejecting the earlier experimental geometry. The remaining runtime defect is isolated: horizontal Navigation diagrams omit all finite global `open_*` transitions while still rendering the seven local `*_context_ready` self-loops.

The cause is the missing horizontal `scope=global` rendering branch after canonical normalization to `from=@global`.

## Delivered correction

R8B6H changes only the generic shared renderer `OPUS_FSM_Diagram`.

For every horizontal finite-global transition it now renders:

- one canonical transition group with the original `data-transition-id`;
- the canonical signal name;
- a visible finite source-set line;
- one compact card directly associated with the canonical target;
- one short target-attached arrow recomputed after persisted card coordinates are loaded.

It does not derive IDs, explode global transitions into source edges, introduce a fake source, alter state layout, or change persistence schemas.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6h_horizontal_finite_global_efsm_rendering.zip`;
- ZIP SHA-256: `90f4e468a2d5c392a334572d99fbc62d5868fca063f29f28cb7ef353e1cdc912`;
- ZIP size: `30354` bytes;
- ZIP contains exactly `Opus/Fsm/Diagram.class.php`;
- delivered file SHA-256: `c3bdde73ea0068bbe19608b5ba9d37e4854dd681c82468b1bb682ea755986773`;
- ZIP re-extraction byte comparison: PASS;
- `git diff --check`: PASS;
- changed source paths: 1.

PHP is not installed in the delivery environment. PHP lint and runtime validation are therefore explicitly owner acceptance gates and are not claimed as locally executed.

## Owner apply

Apply only on clean HEAD `1f94204116ad4ea26df6a040ad9a37b8134fb745` by extracting the ZIP at `H:\\OPUS`.

Then run:

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bz2r8b6h_horizontal_finite_global_efsm_rendering.zip"
php -l Opus\Fsm\Diagram.class.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime acceptance

In `owasys-front` Navigation:

- all seven states remain at their persisted coordinates in View and Conception;
- all seven context-ready self-loops remain attached;
- `open_applications`, `open_application`, `open_data`, `open_navigation`, `open_security`, `open_source`, and `open_build` are visible;
- every global card states `from: {all 7 states}` and points to its target;
- reload and View/Conception switching preserve geometry;
- saving a moved transition card writes only its canonical `navigation.open.*` key.

Do not commit or push OPUS until these runtime gates pass.
