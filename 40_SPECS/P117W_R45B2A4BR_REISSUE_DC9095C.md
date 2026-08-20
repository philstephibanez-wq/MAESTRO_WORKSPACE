# P117W R45B2A4BR — Reissue on OPUS dc9095c

## Status

CODE DELIVERY REISSUED — OWNER APPLICATION AND RUNTIME VALIDATION REQUIRED

## Reason

The canonical A4BR behavior remains unchanged. This is not a new functional milestone.

Current OPUS `master` is `dc9095c108842931bbfad184d88f5ae1c2480ee2` (`fsm`). Its direct parent is `5fa113426e44f1c9f8489f8317affa34b755fe6d`, and the commit changes only `sites/owasys-front/config/fsm.layout.json`.

`Opus/Scaffold/SiteScaffoldPlan.php` on current master still has Git blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1`, therefore the original A4BR generator correction is not present in OPUS master.

## Cause treated

Generated applications can still be born with the pre-canonical application FSM startup model:

- frontend/fullstack: `initial_state = home`;
- backend: `initial_state = api`.

The generic runtime already supports the canonical real entry-state model. The correction belongs in generation, not in an existing generated application and not in OWASYS layout data.

## Canonical behavior

Frontend/fullstack generation:

- real state `begin`, `type=entry`;
- `module=home`, `route=/`;
- `initial_state=begin`;
- `begin` is included in the ordinary source-state transition matrix;
- explicit `open_home`, optional `open_login`, and `open_profiler` transitions can originate from `begin`;
- no `application/begin` directory.

Backend generation:

- real state `begin`, `type=entry`, mapped to module `api`;
- `initial_state=begin`;
- explicit `begin --dispatch_api--> api`;
- existing `api --dispatch_api--> api` preserved;
- REST internal request FSM unchanged.

Contract stays `OPUS_APPLICATION_FSM_V1`.

## Differential delivery

Artifact:

`opus_p117w_r45b2a4br_generated_application_canonical_begin_scaffold_reissue_dc9095c.zip`

SHA-256:

`27d1f0b99791f264be86312b616df27665d6a618c0e0c9715b4c5065d98caaf6`

ZIP content, exactly one complete script at its final path:

- `tools/p117w_r45b2a4br_apply.php`

The script:

- refuses execution unless `Opus/Scaffold/SiteScaffoldPlan.php` has exact Git blob `bac0a8387fef34dbb2ea987b6fd6070b8ba357a1`;
- modifies only that framework source file;
- uses exact single-occurrence anchors;
- writes atomically;
- runs PHP lint after replacement;
- self-removes after successful application;
- creates no backup, report, log, generated-site override or OWASYS modification.

## Owner acceptance

1. Apply the ZIP at OPUS root and run the delivery script.
2. Run Composer optimized autoload generation.
3. Generate a fresh frontend/fullstack application.
4. Confirm `config/application.fsm.json`: `initial_state=begin`, real `type=entry` begin state, and explicit transition from begin to the requested functional state.
5. Confirm no `application/begin` directory exists.
6. Open the fresh application's DEV FSM diagram and confirm `begin` is an ordinary real draggable state.
7. Generate and validate a fresh backend application; confirm `begin --dispatch_api--> api` and preserved `api --dispatch_api--> api`.
8. Commit/push OPUS only after owner validation.

Assistant does not commit or push OPUS/OWASYS.