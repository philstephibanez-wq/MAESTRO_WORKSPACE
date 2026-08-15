# P117W R45B2A4F — Finite FSM state domain + NMI exception

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`
Previous delivery: R45B2A4E

## Owner correction

A normal FSM transition must never use an implicit `from:"*"` source. The FSM state domain is finite and explicitly declared in `states[]`.

The only permitted global interruption is an explicit non-maskable interrupt (NMI) used for emergency/security/runtime interruption. NMI is not a state and must never be rendered as one.

## Canonical semantics

- every normal transition has one explicit `from` state present in `states[]`;
- state id `*` is forbidden;
- `from:"*"` is rejected unless `interrupt:"nmi"` is present;
- NMI signal must be explicit: no `__any__`, no `__default__`;
- NMI cannot carry guards because it is non-maskable;
- NMI is resolved before the normal state transition relation;
- normal state wildcard behavior is removed from `FsmProcessor`;
- signal wildcard behavior remains separate from the state domain;
- diagram NMI is rendered as an out-of-band `NMI` rail, never as a `*` state node.

## OWASYS classification

Front:

- normal navigation transitions are expanded over finite explicit source states;
- `auth_required` is the sole front NMI;
- logout remains a normal explicit transition, not an NMI;
- principal FSM card shows only outgoing normal transitions from the current visible state;
- NMI is excluded from the principal navigation card and remains visible/auditable in runtime FSM/profiler semantics.

Back:

- `receive` becomes `api -> api`;
- `fail` is classified as NMI because it is the emergency return path to `api`;
- no other global source is accepted.

## Generated applications

`SiteScaffoldPlan` no longer generates `from:"*"` for normal frontend/fullstack navigation or backend API dispatch.

The delivery runner also migrates already-generated `sites/*/config/application.fsm.json` files found locally by expanding each legacy normal global transition over the finite declared state list. Existing applications therefore remain executable after the processor becomes strict.

## Validation

The runner is fail-closed against the exact R45B2A4E Git blobs, lints every patched PHP file before write, validates all migrated FSMs, rolls back on failure, then performs runtime proofs:

1. a normal `from:"*"` FSM is rejected;
2. a valid NMI is accepted;
3. NMI preempts a normal same-signal transition;
4. OWASYS front/back FSM definitions instantiate under the strict processor.

Artifact: `opus_p117w_r45b2a4f_finite_state_nmi.zip`
SHA-256: `e2594b33b7e7881b3586a613af538adc490c9e89c35530910759a18fe4a737df`
