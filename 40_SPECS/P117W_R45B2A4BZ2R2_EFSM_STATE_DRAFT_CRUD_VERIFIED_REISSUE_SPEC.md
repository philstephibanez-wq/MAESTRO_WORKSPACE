# P117W R45B2A4BZ2R2 — EFSM state draft CRUD verified reissue

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Purpose

Reissue A4BZ2 after two applicator defects were identified before any OPUS/OWASYS source mutation occurred on the owner's clean A4BZ1 baseline.

## Defects treated at the cause

### A4BZ2 initial defect

The `FsmDiagramBuilder.php` revision patch expected the obsolete pre-designer marker:

`P117W_R45B2A4BI`

The actual A4BZ1 baseline is:

`P117W_R45B2A4BZ1`

The owner execution therefore stopped with:

`P117W_R45B2A4BZ2_PATCH_ANCHOR_INVALID:builder-revision`

before any write. `git status --short` remained empty.

### A4BZ2R1 latent defect

The first reissue corrected the builder revision but retained PHP double-quoted applicator needles containing `$httpSpanEnded`, `$responseStatus` and `$dataResponse`.

Those values were interpolated by the applicator itself before matching the target source, making the anchors invalid and producing PHP undefined-variable warnings in an end-to-end applicator test.

A4BZ2R1 is therefore superseded and must not be used.

## A4BZ2R2 corrections

- builder baseline is explicitly A4BZ1;
- patch strings containing PHP target variables are now nowdoc literals, so the applicator cannot interpolate them;
- textual source reads normalize CRLF/CR/LF to LF before matching, making the differential robust to Windows Git line-ending policy;
- all transformations and configuration preconditions complete in memory before the first source write;
- a late preflight failure leaves earlier target files unchanged.

## Source-of-truth baseline checks

Current OPUS master was re-read before delivery. The live A4BZ1 source contains the exact required anchors:

- `OwasysFsmDiagramBuilder::REVISION = P117W_R45B2A4BZ1`;
- `OWASYS_EFSM_DESIGNER_SNAPSHOT_V1`;
- A4BZ1 SCORE designer revision/labels block;
- existing front application routing tuple with `OwasysFsmMenuSignalGateway`;
- existing SCORE response profiler condition;
- A4BZ1 bootstrap service ordering;
- generic REST sensitive-key `diff` anchor;
- A4BZ1 template, JS and CSS designer markers.

## Functional scope remains A4BZ2

No scope is added or removed from the A4BZ2 contract:

- graphical/icon-oriented EFSM toolbar;
- explicit authorized `fsm:update` capability;
- state draft Create/Edit/Rename/Delete;
- atomic semantic state rename refactor;
- dependency-safe delete;
- generic `FsmDefinitionEditor` + `FsmDefinitionValidator` with homonymous mandatory OPUS interfaces;
- state draft command path `owasys-front -> secured REST -> owasys-back -> allow-listed Composer`;
- canonical `config/fsm.json` remains untouched until the later Publish slice;
- transition/condition mutation remains pending A4BZ3;
- editable Bézier persistence remains pending A4BZ3B.

## Verification performed before ZIP generation

A4BZ2R2 applicator was executed to completion against a controlled A4BZ1 fixture containing every current patch anchor and required configuration contract.

The same applicator was executed successfully against both:

- LF source files;
- CRLF source files.

Verified after application:

- applicator PHP syntax;
- every generated/modified PHP file syntax via `php -l`;
- frontend `fsm-designer.js` syntax via `node --check`;
- all mutated JSON files parse successfully;
- front/back REST resource catalogs receive identical draft routes;
- no JS/TS/Node/package artifact is introduced under `sites/owasys-back`;
- generic state editor behavior: create, semantic rename including transition/global-source references, initial-state deletion refusal, unreferenced-state deletion;
- forced late anchor failure proves no earlier target source write occurs.

This verification validates the differential applicator and generated slice. Full application integration remains owner-side because it requires the actual `H:\OPUS` runtime, Composer autoload and both autonomous dev servers.

## Applicator markers

Successful execution begins with:

- `P117W_R45B2A4BZ2R2_PREFLIGHT_AND_INTERPOLATION_FIXED`
- `P117W_R45B2A4BZ2_APPLIED`

then:

- `toolbar=graphical`
- `admin_fsm_update=enabled`
- `state_draft_crud=create,edit,rename,delete`
- `canonical_fsm_write=disabled_until_publish`
- `flow=owasys-front->REST->owasys-back->Composer`

## Owner acceptance

After applying R2 on the clean A4BZ1 working tree:

1. `git status --short` must show the A4BZ2 differential.
2. all listed PHP lints must pass.
3. optimized autoload must complete.
4. `composer opus:validate-site -- owasys-front` must pass.
5. `composer opus:validate-site -- owasys-back` must pass.
6. after both dev servers restart, Design mode must display A4BZ2, explicit `fsm:update`, the graphical toolbar, and functional state draft CRUD.
7. canonical `sites/owasys-front/config/fsm.json` must remain unchanged while only draft operations are exercised.

## Supersession

Do not use:

- `apply_a4bz2.php`;
- `apply_a4bz2r1.php`.

Only A4BZ2R2 is the current A4BZ2 delivery candidate.