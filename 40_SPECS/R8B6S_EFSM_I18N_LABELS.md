# R8B6S — I18n labels for EFSM diagrams

Date: 2026-08-31

Status: SPECIFIED — IMPLEMENTATION IN PROGRESS

## Baseline

OPUS: `a8c49e0c3d2ab93f37c3a75eae9d2082884fa8b7` (accepted R8B6R).

## Owner decision

Technical IDs remain ASCII. Visible labels may contain Unicode and accented
characters. They use OPUS I18n, not browser-only text or raw diagram geometry.

## Required behavior

- State, signal and transition retain their canonical IDs.
- Each visible label resolves from an I18n message key.
- The active locale displays its exact translated UTF-8 message.
- If the active locale has no message, the UI explicitly reports
  `traduction à renseigner`; it must never silently fall back to another
  locale or to the technical ID.
- The diagram, inspector and label editor use the same resolved value.
- Translation changes do not modify IDs, routing, guards, actions, FSM runtime
  semantics or layout geometry.

## Scope boundary

This slice adds the generic label/I18n model and secure authoring path. It
must preserve SCORE-only rendering and the front → REST → back authority chain.
The backend remains PHP-only. No owner FSM/configuration data is packaged.

## Response-time evidence

A fresh accepted label mutation and a normal diagram load must be returned as
separate request classes with front/back Profiler evidence.
