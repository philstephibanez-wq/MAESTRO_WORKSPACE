# P117W R45B2A4BZ2R5 — Developer-programmed EFSM guard runtime handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## Purpose

Remove application guard semantics from the generic OPUS EFSM processor and move the current OWASYS guards into real application-programmed handlers.

## Delivery

Artifact: `opus_p117w_r45b2a4bz2r5_developer_programmed_guards.zip`

ZIP SHA-256: `c4de8805f55061c37a8a7816a623994c75a60fea7c699335b022080fea04e358`

Applicator: `apply_a4bz2r5.php`

Applicator SHA-256: `1ad67f6b61d7b5c0c448b08d97e701a4a584e3b7785733eda6a85d8b5ae12054`

## Files changed by applicator

- `Opus/Fsm/FsmProcessor.php`
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`

No OWASYS backend JavaScript is introduced.

## Applicator behavior

- requires execution from OPUS repository root;
- preflights both target baselines before the first write;
- refuses already-applied state;
- applies atomic per-file writes;
- preserves CRLF/LF policy of each existing file;
- emits `P117W_R45B2A4BZ2R5_APPLIED` on success.

## Test evidence before delivery

Applicator syntax: PHP lint OK.

Fixture application: OK.

Generated `FsmProcessor.php`: PHP lint OK.

Generated `FsmGuardHandlers.php`: PHP lint OK.

Functional fixture: a caller-provided `dev_guard` callable executes successfully; an unknown guard fails with `OPUS_FSM_GUARD_HANDLER_MISSING: missing`.

Reapplication: refused with `P117W_R45B2A4BZ2R5_ALREADY_APPLIED`, exit code 20.

## Owner validation

Run the applicator, then lint both changed PHP files, rebuild Composer autoload, validate owasys-front and owasys-back, and inspect `git status --short` before committing OPUS.

Expected semantic result:

- no named OWASYS/application guards remain hard-coded in generic `FsmProcessor::evaluateGuard()`;
- OWASYS provides its named guards from `OwasysFsmGuardHandlers`;
- ACL guards remain dynamically registered application handlers;
- actions remain developer-programmed through `FsmActionDispatcher`;
- native runtime operations remain EFSM primitives.

## Next slice after owner validation

Expose the real registered guard/action developer surface to the graphical EFSM designer and add source-authoring integration through the required OWASYS front -> secured REST -> back -> allow-listed Composer path. Do not implement handler names without real PHP code.
