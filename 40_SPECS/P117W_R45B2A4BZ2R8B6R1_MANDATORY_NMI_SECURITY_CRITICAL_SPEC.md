# P117W R45B2A4BZ2R8B6R1 — Mandatory NMI for security and critical runtime interruption

Status: OWNER CORRECTION RECORDED — CODE DELIVERY BLOCKED ON LOCAL PREFLIGHT
Date: 2026-09-05

## Authority

This specification records the owner correction and is governed by:

- `README-FIRST.md`;
- `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md`;
- `00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`;
- `40_SPECS/P117W_R45B2A4F_FINITE_STATE_NMI_SPEC.md`.

## Owner correction

A non-maskable interrupt is not an optional backend-only convention. Every OPUS application must provide an out-of-band NMI path for conditions that must preempt the normal FSM relation, specifically security violations and critical runtime failures.

The exact signals and recovery targets remain application-specific, but the existence and semantics of the NMI mechanism are architectural requirements wherever such conditions can occur.

## Canonical NMI semantics

- NMI is out-of-band and is never a state.
- `from:"*"` is legal only with `interrupt:"nmi"`.
- NMI carries an explicit signal.
- NMI has no guard because it is non-maskable.
- NMI preempts normal state transitions.
- Security violation and critical runtime failure are canonical NMI use cases.
- Normal transitions remain finite and explicitly sourced from declared states.

## Application implications

### OWASYS front

The existing A4F contract identifies `auth_required` as the front NMI. If the current canonical front FSM no longer contains that NMI, this is a regression to repair at the FSM source/architecture level, not with presentation CSS.

### OWASYS back

The existing A4F contract identifies `fail -> api` as the backend emergency NMI.

### Generated OPUS applications / essai

Generated applications must not rely on absence of NMI as a valid steady-state design. The scaffold/runtime contract must provide or require an application-level NMI strategy for security violation and critical runtime failure. The concrete signal names and destinations must be derived from the application contract rather than invented by presentation code.

## Visual semantics

NMI remains visually distinct and out-of-band. Palette work on ordinary states/transitions must not remove, recolor into normal-flow semantics, or obscure the NMI rail.

## Delivery rule

No OPUS/OWASYS code ZIP is produced until the owner preflight establishes the exact local HEAD and worktree state. Dirty or unexpected baselines are stop conditions under the stepwise workflow contract.
