# P117W R45B2A4BR — Reissue handoff on OPUS dc9095c

State: CODE DELIVERY REISSUED — OWNER APPLICATION AND RUNTIME VALIDATION REQUIRED

## Live baseline

- OPUS `master`: `dc9095c108842931bbfad184d88f5ae1c2480ee2` (`fsm`).
- Direct parent: `5fa113426e44f1c9f8489f8317affa34b755fe6d`.
- The `fsm` commit changes only `sites/owasys-front/config/fsm.layout.json`.
- `Opus/Scaffold/SiteScaffoldPlan.php` remains Git blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1` and still emits pre-A4BR initial application states.

## Decision

Do not advance to a new functional milestone. Reissue A4BR against the live OPUS baseline because its generator correction has not been integrated.

No existing generated application is patched. No OWASYS file is changed. Persisted FSM layout from the owner `fsm` commit is frozen.

## Artifact

`opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold_reissue_dc9095c.zip`

SHA-256:

`27d1f0b99791f264be86312b616df27665d6a618c0e0c9715b4c5065d98caaf6`

Exactly one complete delivery script:

- `tools/p117w_r45b2a4br_apply.php`

The script is baseline-locked, exact-anchor based, atomic, PHP-linted, and self-cleans after success.

## Resulting generator contract

Frontend/fullstack:

`begin (type=entry, module=home) -> explicit open_<route> -> functional state`

Backend:

`begin (type=entry, module=api) --dispatch_api--> api`

Existing backend `api --dispatch_api--> api` remains.

No `application/begin` directory is generated. `OPUS_APPLICATION_FSM_V1` remains the contract.

## Owner commands

Extract the ZIP at `H:\OPUS`, execute the script, regenerate Composer autoload, then generate fresh validation applications. Do not validate A4BR by manually modifying an old generated site.

Owner alone commits and pushes OPUS/OWASYS after validation. Assistant writes MAESTRO_WORKSPACE only.

## Acceptance gate before next milestone

A new functional milestone is allowed only after owner runtime evidence confirms:

- fresh frontend/fullstack starts from real `begin` and reaches the requested functional state through an explicit transition;
- DEV FSM diagram renders `begin` as an ordinary draggable real state;
- fresh backend contains and executes `begin --dispatch_api--> api`;
- no `application/begin` directory;
- normal OPUS validation succeeds.