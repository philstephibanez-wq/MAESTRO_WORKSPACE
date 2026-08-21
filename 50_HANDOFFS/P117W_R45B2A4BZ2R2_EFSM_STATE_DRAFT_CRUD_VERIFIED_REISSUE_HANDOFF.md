# P117W R45B2A4BZ2R2 — EFSM state draft CRUD verified reissue — HANDOFF

State: OWNER APPLY / VALIDATE

## Baseline

Owner reported:

- A4BZ1 UI active;
- `git status --short` clean;
- old A4BZ2 execution stopped before write on `builder-revision`.

Current GitHub OPUS master confirms A4BZ1 anchors.

## Do not use superseded applicators

- `apply_a4bz2.php` — obsolete builder baseline anchor.
- `apply_a4bz2r1.php` — latent applicator-variable interpolation defect discovered by end-to-end fixture execution.

Use only:

`apply_a4bz2r2.php`

## R2 verification status

Verified before delivery:

- complete applicator execution on LF A4BZ1 fixture;
- complete applicator execution on CRLF A4BZ1 fixture;
- no-write behavior on forced late preflight failure;
- generated/modified PHP lint;
- frontend JS syntax;
- JSON parsing;
- front/back REST route parity;
- backend JS/Node purity;
- generic state create/rename/delete semantic behavior and dependency refusal.

Full Composer/site validation is intentionally left to the owner against the real `H:\OPUS` tree.

## Expected first output

`P117W_R45B2A4BZ2R2_PREFLIGHT_AND_INTERPOLATION_FIXED`

followed by:

`P117W_R45B2A4BZ2_APPLIED`

If either is absent, stop and return the exact output. Do not continue to Composer validation.

## Immediate source check

After successful apply, `git status --short` must no longer be empty and the source must contain A4BZ2 markers.

## Runtime acceptance

With both autonomous dev servers restarted:

- designer revision = A4BZ2;
- explicit authorized `fsm:update` indicator visible for admin;
- toolbar visually icon-oriented/graphical;
- State + enabled;
- Edit/Rename/Delete enabled only after state selection;
- state create/edit/rename/delete operates on draft only;
- canonical `config/fsm.json` stays unchanged;
- profiler shows actual front -> REST -> back -> Composer correlation for draft commands.

## Next delivery only after acceptance

P117W R45B2A4BZ3:

- transition CRUD/rename;
- signal CRUD/rename;
- condition/guard CRUD/rename;
- explicit `Dans le menu utilisateur` signal mutation.

Bézier control-point editing remains A4BZ3B.

## Workspace spec

`40_SPECS/P117W_R45B2A4BZ2R2_EFSM_STATE_DRAFT_CRUD_VERIFIED_REISSUE_SPEC.md`

Specification commit:

`c60701f6400b0c08805ab56c9031a087829f5579`