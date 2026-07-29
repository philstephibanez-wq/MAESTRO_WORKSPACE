# MAESTRO WORKSPACE handoff — OPUS P117W R34

Date: 2026-07-29

## Decision

The rejected JavaScript R34 approach is not delivered. The active R34 restores the original ASAP FSM responsibilities in the generic OPUS runtime and connects OWASYS navigation to it.

## Source of truth

```text
Repository: philstephibanez-wq/OPUS
Branch: master
Base: 47c5bb1d667a43a61ae35ec3465accc29d42f54c
Prerequisites: R31 + R32 + R33
```

## Result

- `FsmProcessor` owns current state, memory and stack.
- `peek`, `poke`, `push`, `pop`, FIFO and LIFO are contractual.
- `FsmSessionStore` persists a versioned complete snapshot.
- OWASYS default, Creation and Source controllers no longer own a scalar FSM state.
- Source selection is emitted as `open_source_file`.
- Locale change is emitted as `change_locale`.
- Source path and locale are FSM memory.
- Source history is the FSM stack.
- No `history.pushState()` or asynchronous source-navigation ownership remains.
- SCORE remains the only UI renderer.
- REST to owasys-back and Composer remains unchanged.

## Validation

Validate PHP syntax for all changed PHP files, JSON syntax for `fsm.json`, JavaScript syntax, OPUS site contracts, Composer autoload, `git diff --check`, and the following scenario:

```text
open source A
open source B
change locale
expected URL: /<new-locale>/source/<source-B>
expected FSM memory source_path: <source-B>
expected FSM stack: [..., <source-A>, <source-B>]
```

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
