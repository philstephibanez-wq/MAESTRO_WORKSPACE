# P117W R45B2A4BZ2 R8B5D2 — External Composer validation runner repair — SPEC

State: READY FOR OWNER APPLY

## Baseline

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Functional parent: R8B5D1 view/design intrinsic geometry repair.

## Problem

R8B5D1 passed preflight and source generation but its post-write validation invoked bare `composer` through PHP `proc_open`. On the current OPUS baseline the repository root contains a tracked zero-byte file named `composer`; the validation resolved incorrectly and failed with `Could not open input file: H:\OPUS\composer.phar`.

The applicator rolled back cleanly. This is a runner/environment command-resolution failure, not a failure of the two-file functional transformation.

## Decision

Do not add platform-specific Composer discovery or a hidden fallback. The applicator must be deterministic and source-focused.

R8B5D2 therefore:

- preserves exactly the R8B5D1 functional transformation;
- performs no Composer subprocess from inside the applicator;
- keeps exact HEAD and blob gates;
- keeps generated PHP lint before and after write;
- keeps fixed-geometry CSS contract validation;
- keeps exact two-path repository inventory, clean index, zero untracked files, unchanged HEAD and `git diff --check`;
- emits `composer_validation=external_terminal` after success;
- requires the owner to execute `composer opus:validate-site -- owasys-front` explicitly after application from the interactive terminal where Composer is known to work.

## Exact source differential

Exactly two modified front files, no new files:

1. `sites/owasys-front/www/asset/css/fsm-native.css`;
2. `sites/owasys-front/application/default/services/ScorePageRenderer.php`.

The source output is identical to R8B5D1:

- three FSM SVG shrink constraints change from `max-width: 100%` to `max-width: none`;
- canvas keeps `overflow: auto`;
- FSM CSS cache-buster becomes `p117w-r45b2a4bz2r8b5d1`.

No backend, FSM semantics, layout data, REST, ACL, Composer registry or JavaScript change.

## Validation contract

Applicator success is necessary but not sufficient. Owner then runs:

`composer opus:validate-site -- owasys-front`

and validates runtime DESIGN -> VIEW -> DESIGN plus F5 in both modes. Persisted STATE/SIGNAL geometry must retain the same intrinsic scale; wide diagrams scroll inside their canvas.
