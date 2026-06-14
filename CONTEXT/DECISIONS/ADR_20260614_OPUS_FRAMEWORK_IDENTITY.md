# ADR 2026-06-14 — OPUS Framework Identity

## Status

Accepted.

## Context

During the MAESTRO_WORKSPACE / OPUS / RefBook stabilization work, the user clarified that `ASAP` is no longer the active framework identity.

The active framework is OPUS, with target public version:

```text
OPUS 8.1.0 "Lysenko"
```

`Lysenko` refers to Mykola Lysenko, Ukrainian composer.

## Decision

Use **OPUS Framework** as the only active framework name.

`ASAP` is kept only as historical / legacy / migration wording when needed to explain old repositories, old paths, old packages, old namespaces or old handoffs.

## Rules

1. New documentation must use `OPUS`, `OPUS Framework`, `OPUS_REF_BOOK` and `OPUS 8.1.0 "Lysenko"`.
2. `ASAP` must not be used as an active product/framework name.
3. Any remaining `ASAP` mention must clearly be marked as legacy, historical or migration-only.
4. No silent fallback between `ASAP` and `OPUS` is allowed.
5. Compatibility layers, if any, must be explicit, documented, testable and removable.
6. RefBook work must document OPUS live/runtime state, not stale ASAP-era APIs.
7. ScoreTemplate remains an OPUS-consuming application/recipe, not the framework identity.

## Consequences

- `CONTEXT/VERSIONS/OPUS_VERSION.md` becomes the canonical version file.
- `CONTEXT/VERSIONS/ASAP_VERSION.md` is retained only as an obsolete pointer to avoid broken references.
- Future handoffs must start from OPUS terminology.
- The next execution priority remains unchanged: stabilize OPUS RefBook before deep security implementation.

## Canonical resume wording

```text
Framework actif : OPUS Framework
Version cible : OPUS 8.1.0 "Lysenko"
ASAP : ancien nom historique, legacy uniquement
Priorité : P116C3_REAL_SCORE_REFBOOK
```
