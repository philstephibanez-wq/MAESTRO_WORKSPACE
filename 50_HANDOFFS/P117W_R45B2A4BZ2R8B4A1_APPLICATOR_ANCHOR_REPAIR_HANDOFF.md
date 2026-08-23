# P117W R45B2A4BZ2R8B4A1 — Applicator anchor repair handoff

State: BLOCKED ON APPLICATOR REPAIR — OWNER WORKTREE CLEAN

## Baseline

OPUS owner/master exact baseline remains:

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

The owner confirmed immediately before execution:

- `git rev-parse HEAD` = exact baseline above;
- `git status --short` = empty.

## Failed R8B4A applicator evidence

The owner executed:

`php "%USERPROFILE%\Downloads\apply_a4bz2r8b4a.php"`

Observed output:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4A_REPLACEMENT_ANCHOR_INVALID:sites/owasys-front/www/asset/js/fsm-designer.js:remove-late-handler-editor-declaration:2`

Immediately after the failure:

- `git status --short` remained empty.

Therefore no OPUS/OWASYS tracked file was modified. No rollback or cleanup is required.

## Root cause

This is an applicator-construction defect, not a repository-baseline mismatch and not an OPUS runtime failure.

R8B2 `fsm-designer.js` contains the known temporal-dead-zone defect: `handlerSourceEditor` is referenced by the surface validation before its later declaration. The R8B4A transformation attempts to move that declaration earlier. Its staging order first creates an early declaration and then invokes a uniqueness-checked removal against a staged buffer that now contains two matching declarations. The applicator therefore reports count `2` and aborts during preflight before any write.

The correction must change the applicator transformation itself so the source declaration is moved atomically or the original late declaration is removed before inserting the early declaration. Merely weakening the expected occurrence count would be unsafe because it could remove both declarations.

## R8B4A1 invariant

Do not alter the intended R8B4A architecture or the exact OPUS baseline.

R8B4A1 is only the corrected delivery applicator for the same 15-path R8B4A differential. It must:

- preserve exact baseline/head/blob preflight;
- preserve clean-worktree requirement;
- stage all transformations before writes;
- fix the `handlerSourceEditor` TDZ by a deterministic one-source/one-target transformation;
- keep every prior PHP/JSON/runtime validation gate;
- keep atomic writes and rollback;
- verify actual repository changes before success markers;
- introduce no JS/Node artifact under `sites/owasys-back`.

## Owner acceptance

A corrected R8B4A1 applicator must first reach:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_OK`

then:

`P117W_R45B2A4BZ2R8B4A_REPO_CHANGES_VERIFIED`

and finally:

`P117W_R45B2A4BZ2R8B4A_APPLIED`

Only after those markers may the normal PHP lint, JS syntax, Composer autoload, site validation and runtime Security/Navigation checks proceed.

Do not commit/push OPUS/OWASYS until all R8B4A runtime gates pass.