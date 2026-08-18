# P117W R45B2A4AY — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Owner baseline

OPUS HEAD:

`892f4f389bede3fb55312b5fb4e88f14174c3818` — `opus_p117w_r45b2a4aw_fsm_signal_origin_and_diagram_actionability`

A4AW is committed/pushed by the owner and is the source baseline.

## Owner design decision

On 2026-08-18 the owner approved moving to a conditional/guarded FSM:

`state + signal -> evaluate security/other guards -> target state only if guards pass`

This is the governing model for the next FSM work.

## Existing OPUS capability found

The generic `Opus\Fsm\FsmProcessor` already had real guard execution. Before A4AY it:

- resolved the transition;
- evaluated `guards[]`;
- emitted `guard.evaluated` profiler events;
- rejected on the first false guard;
- then moved state and applied runtime operations.

The missing generic capability was a non-mutating transition inspection usable by Menu = FSM, diagram and other actionability projections.

## A4AY implementation

Exactly two generic OPUS files are delivered:

1. `Opus/Fsm/FsmProcessor.php`
2. `Opus/Fsm/FsmProcessorInterface.php`

No OWASYS file is changed in A4AY.

### New inspection API

`FsmProcessor::inspectTransition(state, signal, context)` returns contract:

`OPUS_FSM_TRANSITION_INSPECTION_V1`

with transition existence, enabled state, decision reason, target, scope, guard list, per-guard results, failed guards, actions and target-state definition.

Inspection is side-effect free for FSM state/memory/stack and does not emit execution profiler events.

### Single guard authority

`transition()` now consumes `inspectTransition()` for guard evaluation. There is no longer one guard path for execution and a different future path for UI inspection.

Existing execution error compatibility is retained:

- missing transition -> `OPUS_FSM_TRANSITION_NOT_FOUND:<state>:<signal>`;
- denied guard -> `OPUS_FSM_GUARD_FAILED:<guard>`.

### Pure guards

A guard handler that mutates FSM runtime state is rolled back and rejected:

`OPUS_FSM_GUARD_MUTATED_RUNTIME:<guard>`

This makes guards conditions only. Runtime operations/actions remain the mutation phase.

## Determinism intentionally preserved

A4AY does not yet allow several target transitions for the same `(state, signal)` pair. Existing local/global/NMI precedence and duplicate protection remain unchanged.

The accepted conditional model does not require multi-target ambiguity to begin simplifying OWASYS.

## Source baseline

Exact A4AW source blobs audited before delivery:

- `Opus/Fsm/FsmProcessor.php` -> `5d273a5d669f3b462a1eb5f171b784440c2a46fb`
- `Opus/Fsm/FsmProcessorInterface.php` -> `2d9dacb9e31531c482286118fb4083447b59550b`

Delivered blobs:

- `Opus/Fsm/FsmProcessor.php` -> `8edac7216cb24e1eda58fcb24ce8347c1147a6ac`
- `Opus/Fsm/FsmProcessorInterface.php` -> `b52fbcf92af4c3e89d638f7027e92a05b1c3b6af`

## Delivery

Artifact:

`opus_p117w_r45b2a4ay_guarded_fsm_transition_inspection.zip`

SHA-256:

`46e4240967b00c306dae577e880c44bffe2d95522c39cd110adbd82e9275c80e`

Exactly two complete files at final paths. No patcher, no deletion, no generated report.

## Pre-delivery validation

- PHP lint: 2/2 OK;
- ZIP contains exactly the two delivered files plus directory entries;
- smoke `A4AY_SMOKE_OK`;
- denied guard inspection returns disabled without mutation;
- accepted guard inspection returns enabled without mutation;
- missing transition inspection returns not found without mutation;
- global transition inspection works;
- real transition reuses the same guard decision;
- mutating guard is rolled back and rejected;
- no trailing whitespace.

## Owner acceptance

1. Apply ZIP over owner HEAD A4AW.
2. Lint both files.
3. Run existing OPUS/OWASYS smoke/validation suite if available.
4. Confirm no OWASYS runtime regression.
5. Commit/push OPUS only after validation.

## Next delivery after owner validation

Migrate OWASYS Menu = FSM and FSM diagram actionability to the generic `inspectTransition()` decision, using one canonical runtime context including authentication, roles, current application and ACL/business guard handlers. Only after that migration add development-readiness guards to the canonical OWASYS workflow.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
