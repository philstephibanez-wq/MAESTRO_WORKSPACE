# P117W R45B2A4BR — Handoff

State: OWNER RUNTIME VALIDATION IN PROGRESS

## Current committed baseline

- OPUS committed `master`: `dc9095c108842931bbfad184d88f5ae1c2480ee2` — owner commit `fsm` dated 2026-08-20.
- Its direct parent is `5fa113426e44f1c9f8489f8317affa34b755fe6d` — A4BQ.
- `dc9095c...` changes only `sites/owasys-front/config/fsm.layout.json`.
- `Opus/Scaffold/SiteScaffoldPlan.php` therefore remained on committed blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1` before A4BR application.
- Menu behavior remains frozen.

## Cause treated

A4BO deliberately left one propagation boundary for a subsequent milestone: `SiteScaffoldPlan` still generated new applications with `home` or `api` directly as `initial_state`.

That would allow newly created applications to reintroduce the old semantic model. A4BR corrects generation itself; it does not synthesize or rewrite FSMs at runtime.

## A4BR behavior

### Frontend/fullstack

Generated `config/application.fsm.json` starts with a real state:

`begin (type=entry, module=home) -> explicit open_<route> signal -> requested functional state`

The source-state matrix includes `begin`, so `open_home`, optional `open_login` and `open_profiler` are real transitions from the entry state.

No `application/begin` directory is created; `begin` uses the existing `home` module as its execution surface.

### Backend

Generated backend application FSM contains:

`begin (type=entry, module=api) --dispatch_api--> api`

The existing `api --dispatch_api--> api` relation is preserved. The REST internal request FSM is not altered.

### Contract compatibility

The application FSM contract stays `OPUS_APPLICATION_FSM_V1`. Legacy generated applications without a real entry state remain untouched/readable; newly generated applications are born with the canonical A4BO entry form.

## Reissue application evidence — 2026-08-20

Owner extracted:

`opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold_reissue_dc9095c.zip`

with `tar -xf` directly over `H:\OPUS`.

After extraction, `Opus/Scaffold/SiteScaffoldPlan.php` was already replaced by the delivered complete target file. Running the auxiliary `tools/p117w_r45b2a4br_apply.php` afterwards therefore reported:

`OPUS_A4BR_SOURCE_BASELINE_MISMATCH:c1832750c05642c8639f7ce8ed32676842cb7a79`

This is an application-order mismatch, not a framework patch failure: the applicator expected committed source blob `bac0a838...`, while the direct ZIP extraction had already transformed the file to working-tree blob `c1832750...`.

Owner evidence after extraction:

- `composer dump-autoload -o`: OK, 552 classes;
- `php -l Opus\Scaffold\SiteScaffoldPlan.php`: no syntax errors;
- `git status --short`: only `M Opus/Scaffold/SiteScaffoldPlan.php`;
- visible diff confirms frontend/fullstack real `begin`, `begin` added to the transition source matrix, and `initial_state` changed from `home` to `begin`;
- backend section is part of the same delivered complete target file and remains subject to runtime/generation acceptance below.

The canonical OPUS/OWASYS delivery rule remains: differential ZIPs contain complete files at final paths. A direct complete-file delivery does not require a second patch/applicator pass after extraction. Auxiliary application scripts must not be treated as an additional mandatory transformation once the target file has already been installed.

## Acceptance still required

Do not re-extract, reapply or restore `SiteScaffoldPlan.php` before acceptance.

1. Confirm the working-tree diff contains no file other than `Opus/Scaffold/SiteScaffoldPlan.php` for A4BR.
2. Generate a fresh frontend or fullstack application; do not modify an existing generated application.
3. Inspect its `config/application.fsm.json` and confirm `initial_state=begin`, a real `type=entry` state mapped to `home`, and explicit transitions from `begin`.
4. Start the fresh generated application and confirm its first functional page is reached through a real transition from `begin`.
5. Inspect its DEV FSM diagram and confirm `begin` is a draggable ordinary state.
6. Generate a fresh backend application and confirm `initial_state=begin`, real entry state mapped to `api`, `begin --dispatch_api--> api`, and preserved `api --dispatch_api--> api`.
7. Confirm no generated `application/begin` directory exists.
8. Validate the fresh generated sites through the normal OPUS validation path.
9. Owner commits/pushes OPUS only after runtime acceptance.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
