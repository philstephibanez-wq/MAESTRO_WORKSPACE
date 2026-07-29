# OPUS P117W R34 — FSM runtime ASAP compliance

Date: 2026-07-29

## Status

R34 replaces the abandoned JavaScript locale-link workaround. R32 and R33 remain prerequisites for fast in-process Composer dispatch and the corrected PHP scope.

## Contract

The OPUS FSM is the sole owner of navigation state. Controllers and JavaScript may transport signals and render projections, but may not own or duplicate the current FSM state.

The generic OPUS FSM runtime provides:

- current state;
- named memory with `peek` and `poke`;
- FIFO stack by default, configurable as LIFO;
- `push` and `pop`;
- explicit snapshot persistence;
- wildcard priority derived from ASAP: exact signal for current state, `__any__` for current state, declared global transition, then declared `__default__`;
- explicit failure when no declared transition exists.

## OWASYS Source flow

```text
GET /<locale>/source/<path>
-> FSM open_source
-> FSM open_source_file
-> push(path)
-> poke(source_path, path)
-> poke(locale, locale)
-> persist FSM snapshot
-> REST OPUS
-> owasys-back
-> Composer
-> SCORE
```

On locale change, `/<new-locale>/source` is resolved from FSM memory:

```text
FSM peek(source_path)
-> FSM change_locale
-> poke(locale, new-locale)
-> redirect GET /<new-locale>/source/<remembered-path>
```

The source browser no longer intercepts file links with `fetch()` and no longer calls `history.pushState()`. Native GET navigation makes the URL, FSM transition, REST response and SCORE rendering one atomic server-controlled exchange.

## Persistence

`Opus\Fsm\FsmSessionStore` persists the versioned `OPUS_FSM_RUNTIME_SNAPSHOT_V1` snapshot. OWASYS controllers no longer write the scalar `opus_fsm_state_owasys`.

## Delivery

The differential ZIP contains only nine complete files at their final paths. It must be applied after R31, R32 and R33.

Base OPUS:

```text
47c5bb1d667a43a61ae35ec3465accc29d42f54c
```

