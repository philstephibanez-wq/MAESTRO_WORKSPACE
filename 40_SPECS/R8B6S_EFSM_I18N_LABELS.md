# R8B6S — I18n labels for EFSM diagrams

Date: 2026-08-31

Status: SPECIFIED — IMPLEMENTATION IN PROGRESS

## Baseline

OPUS: `a8c49e0c3d2ab93f37c3a75eae9d2082884fa8b7` (accepted R8B6R).

## Owner decision

Technical IDs remain ASCII and immutable under label editing. Visible labels may contain Unicode and accented characters and use OPUS I18n.

The state toolbar action previously presented as `Modifier le nom` must edit the human/localizable label, never the state ID. A technical identity refactor remains a distinct operation and must not be triggered by label editing.

## Required behavior

- State, signal and transition retain their canonical IDs.
- `state.rename` remains an identity refactor only; it is not the label-edit operation.
- Label editing leaves `state.id`, transition `from` / `next_state`, initial/final state references and persisted diagram geometry identities unchanged.
- Each visible label resolves from an I18n message key.
- The active locale displays its exact translated UTF-8 message.
- The state label editor is prefilled with the current human label for the active locale, not with the technical ID.
- Saving a state label writes through the secured `owasys-front -> REST -> owasys-back` authority path; the browser never writes a catalog directly.
- If the active locale has no message, the UI explicitly reports `traduction à renseigner`; it must never silently fall back to another locale or to the technical ID.
- The diagram, inspector and label editor use the same resolved value.
- Translation changes do not modify IDs, routing, guards, actions, FSM runtime semantics or layout geometry.

## Architectural requirement

The implementation must use or add a generic OPUS semantic label mutation rather than reinterpret `state.rename`. Any new concrete framework component must satisfy the framework interface contract from `README-FIRST.md`.

## Scope boundary

This slice adds the generic label/I18n model and secure authoring path needed by the state label editor, while keeping the model extensible to signal and transition labels. It preserves SCORE-only rendering and the front -> REST -> back authority chain. The backend remains PHP-only. No owner FSM/configuration data is packaged.

## Response-time evidence

A fresh accepted label mutation and a normal diagram load must be returned as separate request classes with front/back Profiler evidence.
