# Handoff R8B6S — EFSM I18n label authoring

Date: 2026-08-31

Baseline OPUS: `a8c49e0c3d2ab93f37c3a75eae9d2082884fa8b7`

Status: REBUILD REQUIRED

## Owner correction

The rendering-only scope is incomplete for R8B6S.

The state action `Modifier le nom` must modify the human/localizable label, not the technical ID. The technical state ID remains canonical and unchanged. The existing `state.rename` operation remains reserved for technical identity refactoring and is not used for label editing.

## Required delivery

The replacement differential ZIP provides the secure state-label authoring path. State identity, transition references, initial/final references and layout identities remain unchanged. The editor displays and edits the active-locale human label through OPUS I18n. Persistence follows `owasys-front -> REST secured -> owasys-back`; the browser does not write translation catalogs directly. Missing active-locale translations are explicit, with no silent fallback to another locale or to the technical ID. Diagram and inspector use the same resolved label. Profiler evidence distinguishes an accepted label mutation from a normal diagram load.

## Baseline gate

The replacement ZIP is applicable only to a clean OPUS checkout based on `a8c49e0c3d2ab93f37c3a75eae9d2082884fa8b7`.
