# P117W R45B2A4BZ2 R8B5D1 — View/Design intrinsic geometry scale repair — HANDOFF

State: FAILED POST-WRITE VALIDATION — ROLLED BACK — SUPERSEDED BY R8B5D2

## Source of truth

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Parent R8B5D is pushed and contains real `security.fsm.layout.json` persisted geometry.
- R8B5D1 spec commit: `63a46b4847ac5f02da41e402124cb10858390310`.

## Functional target

Owner clarified that persisted geometry returns when graph DESIGN is reopened. R8B5D storage therefore works. R8B5D1 targets visual parity between VIEW and DESIGN by removing SVG shrink-to-fit and forcing a CSS cache refresh.

## Attempted differential

Exactly two front files:

1. `sites/owasys-front/www/asset/css/fsm-native.css` — three FSM SVG `max-width: 100%` constraints become `max-width: none`; canvas overflow remains `auto`;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php` — FSM CSS cache-buster becomes `p117w-r45b2a4bz2r8b5d1`.

No FSM definition, layout data, REST route, Composer command, ACL, backend code or JS is changed.

## Failed applicator

- ZIP: `opus_p117w_r45b2a4bz2r8b5d1_view_design_intrinsic_geometry_scale_repair.zip`;
- ZIP SHA-256: `e2ab433bdbf09108c6c28204bd0fbf5ca172e19b7cfb05519a4965d1788e04c8`;
- applicator SHA-256: `ad04bc2a77bce8169fdac74959dffbd73f28b37cd5effff35e3326275566f12e`.

Owner execution reached `PREFLIGHT_OK` then failed post-write with:

`OWASYS_FRONT_VALIDATE_FAILED:Could not open input file: H:\OPUS\composer.phar`

The applicator rolled both source files back. Owner then showed empty `git status --short` and empty `git diff --check`; baseline remained unchanged.

## Runner root cause

The applicator launched bare `composer` through PHP `proc_open` from repository root. The current OPUS repository contains a tracked zero-byte root file named exactly `composer`. Bare command resolution from an applicator is therefore not a safe validation primitive on this baseline, even though the owner's interactive terminal Composer command works.

This is an applicator/tooling failure, not a functional R8B5D1 source failure.

## Supersession

R8B5D2 keeps the exact same two-file functional transformation but removes Composer execution from inside the applicator. Source application remains deterministic through Git SHA/blob gates, PHP lint, CSS contract, exact differential inventory and `git diff --check`. `composer opus:validate-site -- owasys-front` is executed explicitly by the owner after successful application in the known-good interactive terminal.

R8B5D1 MUST NOT be retried.
