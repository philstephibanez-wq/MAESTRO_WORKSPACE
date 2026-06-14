# ADR 2026-06-14 — Workspace always updated at every delivery

## Status

Accepted.

## Context

MAESTRO_WORKSPACE coordinates several sub-projects: OPUS, OPUS_REF_BOOK, OPUS_USER_GUIDE, MAESTRO_V5, MO_KB_DAEMON, MO_KB_FRONT and Log&Play.

The workspace must allow a new chat to resume work at any time without relying on hidden memory, implicit context, or stale conversation history.

## Decision

Every delivery must include a workspace update when it changes the architecture, packaging, licensing, project status, handoff state, next steps, or recovery path.

A delivery is not considered complete if the source repository was changed but the workspace handoff/context was not updated.

## Mandatory workspace update scope

At each delivery, update at least one of the following, as applicable:

- `README.md` for immediate 10-second orientation.
- `CONTEXT/PROJECTS/PROJECT_INDEX.md` for project map and priorities.
- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` for restart state.
- `CONTEXT/DECISIONS/*.md` for new architecture decisions.
- `CONTEXT/VERSIONS/*.md` for version identity changes.

## CURRENT_HANDOFF contract

`CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` is the canonical resume card for a fresh chat.

It must contain:

- current date/time or session marker;
- active priority;
- repositories touched;
- latest relevant commits;
- decisions made;
- current state by sub-project;
- next safe step;
- explicit blockers or unknowns;
- commands useful for local verification when needed.

## Delivery response contract

When a delivery is made, the assistant must report:

- repository name;
- branch when known;
- files changed;
- commit SHA(s);
- whether runtime code was changed or only documentation/contracts;
- whether local tests were executed or not;
- whether the workspace handoff was updated.

## Zero fallback rule

No delivery may rely on implicit chat memory as the only source of truth.

If the workspace could not be updated, the assistant must say so explicitly and the delivery must be treated as incomplete.

## Recovery goal

A new chat must be able to restart by reading:

1. `README.md`;
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`;
3. `CONTEXT/PROJECTS/PROJECT_INDEX.md`;
4. the relevant ADRs linked from those files.

## Non-goals

This ADR does not replace the source repositories of OPUS, MAESTRO, KB or Log&Play.

It only defines the workspace as the canonical coordination and handoff layer.
