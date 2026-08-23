# P117W R45B2A4BZ2R8B4A1 — Applicator anchor repair handoff

State: PROVENANCE RESOLVED — R8B4A1 NOT YET APPLIED; OWNER APPLY GATE OPEN

## Baseline

OPUS owner/master exact baseline remains:

`76b59191492f4efabf343e85be841f4832fe0ced`

`opus_p117w_r45b2a4bz2r8b2_actual_graphical_handler_authoring`

The owner confirmed immediately before the failed R8B4A execution:

- `git rev-parse HEAD` = exact baseline above;
- `git status --short` = empty.

The failed applicator wrote nothing, so the same exact clean baseline remained the required R8B4A1 input.

## Failed R8B4A evidence

The owner executed:

`php "%USERPROFILE%\Downloads\apply_a4bz2r8b4a.php"`

Observed output:

`P117W_R45B2A4BZ2R8B4A_PREFLIGHT_BEGIN`

`P117W_R45B2A4BZ2R8B4A_REPLACEMENT_ANCHOR_INVALID:sites/owasys-front/www/asset/js/fsm-designer.js:remove-late-handler-editor-declaration:2`

Immediately after the failure, `git status --short` remained empty. No OPUS/OWASYS tracked file was modified and no rollback was required.

## Root cause

This was an applicator-construction defect, not a repository-baseline mismatch and not an OPUS runtime failure.

R8B2 `fsm-designer.js` contains the known temporal-dead-zone defect: `handlerSourceEditor` is referenced by surface validation before its later declaration. R8B4A intends to move that declaration earlier.

The failed R8B4A applicator staged those two operations in the wrong order:

1. insert the early declaration;
2. remove the late declaration with a uniqueness check.

After step 1 the staged buffer contained two identical declarations, so step 2 correctly rejected occurrence count `2` before any write.

R8B4A1 fixes the cause by reversing only those two transformations:

1. remove the unique late declaration from the exact R8B2 source;
2. insert that declaration at the earlier surface-validation location.

The expected occurrence count remains exactly `1`; it is not weakened.

## Artifact

`opus_p117w_r45b2a4bz2r8b4a1_applicator_anchor_repair.zip`

ZIP SHA-256:

`2efc13ecc201cfae2b3cce31ce968fa15879d3435021758460985ddfcb71b4b2`

Contents exactly:

- `apply_a4bz2r8b4a1.php`

Applicator SHA-256:

`5bea0c21d78db31ca0eacea96eb311f93152f7e6577252efc8029aaada5a8538`

The assistant does not commit/push OPUS or OWASYS.

## Differential against failed applicator

The corrected applicator has the same byte length (`81561`) as the failed applicator and preserves all R8B4A functional transformations, expected Git blobs, baseline, validation gates, write/rollback logic and success markers.

Its only semantic diff is the ordering of the two `fsm-designer.js` transformations named:

- `remove-late-handler-editor-declaration`;
- `tdz-declaration`.

No R8B4A product behavior or 15-path target differential is changed.

## Assistant-side validation

Completed before delivery:

- original R8B4A applicator SHA matched the recorded handoff SHA `3ef0de4793ae1e39fbd591da6eea04756589a46500454f9fa9709e87df76d999`;
- corrected applicator PHP lint: OK;
- exact applicator diff inspected: only operation ordering changed;
- deterministic TDZ move simulation from one late declaration to one early declaration: `R8B4A1_TDZ_MOVE_SIMULATION_OK`;
- ZIP inspection: exactly one file, the corrected applicator.

Windows execution against the owner's private checkout remains the owner gate and is not claimed as run by the assistant.

## Preserved R8B4A1 invariants

R8B4A1 preserves:

- exact HEAD R8B2 requirement;
- exact tracked Git blob verification;
- clean tracked worktree/index requirement;
- all transformations staged before writes;
- every prior PHP/JSON/EFSM runtime validation gate;
- atomic writes and rollback;
- actual repository-change verification before success markers;
- same 14 modified tracked paths + 1 new path;
- no JavaScript/TypeScript/Node artifact under `sites/owasys-back`.

## Owner site-validation evidence — 2026-08-23

The owner ran site validations before R8B4A1 had actually been applied:

- `composer opus:validate-site -- owasys-front` -> valid `true`, routes `12`, modules `10`, singleton `true`, dispatch `fsm-module-first`, role `standard-opus-application`, FSM `config/fsm.json`;
- `composer opus:validate-site -- owasys-back` -> valid `true`, routes `2`, modules `3`, singleton `true`, dispatch `fsm-module-first`, role `standard-opus-application`, FSM `config/fsm.json`;
- `composer opus:validate-site -- essai` -> valid `true`, routes `1`, modules `1`, singleton `true`, dispatch `fsm-module-first`, role `generated-opus-application`, profile `frontend`, FSM `config/application.fsm.json`.

These results prove only that the R8B2 baseline sites remain structurally valid. They are not R8B4A1 acceptance evidence and must be rerun after application.

## Provenance resolution — 2026-08-23

The owner then executed the non-destructive provenance gate from `H:\OPUS`.

Observed facts:

- repository root: `H:/OPUS`;
- local HEAD: `76b59191492f4efabf343e85be841f4832fe0ced`;
- local branch and `origin/master` both point to R8B2;
- unstaged diff: empty;
- staged diff: empty;
- `76b5919..HEAD` diff: empty;
- `sites/essai/config/security.fsm.json`: missing;
- `sites/essai/config/site.json`: no `efsms` registry;
- `fsm-designer.js`: `handlerSourceEditor` surface validation is at line 50 while the declaration remains later at line 79.

One command was mistyped as `t status --short --branch`; that typo is immaterial because all other independent provenance checks are conclusive.

Conclusion: **R8B4A1 has not been applied to the current `H:\OPUS` checkout.** There is no local commit, no uncommitted differential, no alternate-state ambiguity, and no need for a new patch.

The exact clean R8B2 baseline required by R8B4A1 is still present, so the existing corrected applicator is the correct next action.

## Immediate owner apply gate

From `H:\OPUS`, apply the existing R8B4A1 artifact and require, in order:

- `P117W_R45B2A4BZ2R8B4A_PREFLIGHT_OK`
- `P117W_R45B2A4BZ2R8B4A_REPO_CHANGES_VERIFIED`
- `P117W_R45B2A4BZ2R8B4A_APPLIED`

Then `git status --short` must expose the expected 14 tracked modifications plus new `sites/essai/config/security.fsm.json` before any commit.

If the applicator fails, capture the exact output and leave OPUS uncommitted/unpushed. If it succeeds, proceed to lint, JS syntax, Composer autoload and all three site validations again.

## Runtime acceptance sequence after successful application

Only after the 15-path differential is visible and CLI validation passes:

1. Restart OWASYS front and back.
2. Select `essai`.
3. Security must project `essai / security` from `config/security.fsm.json`, not the OWASYS host monolith.
4. Structure must project `essai / navigation` from `config/application.fsm.json`.
5. Security Conception STATE create must persist and survive reload.
6. SSO view must expose real provider/default-provider metadata without secrets.
7. Sources + Git must remain functionally unchanged.

Do not commit/push OPUS/OWASYS until all R8B4A runtime gates pass.

## Next slice after acceptance

After R8B4A runtime acceptance, continue with the actual runtime cooperation layer already locked by R8B4A: SecurityContext ownership plus first Security/Navigation inter-EFSM COMMAND/EVENT transport, then generic generated-application PHP ACTION/GUARD source authoring from the contextual diagram.