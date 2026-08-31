# Chat MAESTRO / Native ZIP Stepwise Workflow Contract

Date: 2026-08-31

Status: OWNER-APPROVED — AUTHORITATIVE

## Purpose

This contract defines the economical and reviewable OPUS/OWASYS workflow.
It uses the MAESTRO ChatGPT conversation, GitHub as authority, native
differential ZIP delivery, and owner-controlled local validation.

## Authority and responsibility

- GitHub and `MAESTRO_WORKSPACE` remain contractual authorities.
- The MAESTRO chat owns architecture, scope, acceptance criteria, source review,
  specification, handoff, differential ZIP preparation and interpretation of
  returned evidence.
- The owner controls local runtime testing, VS Code, Git review, commits and
  pushes.
- The assistant never commits or pushes OPUS/OWASYS.
- The owner applies the ZIP, validates it, then commits and pushes OPUS/OWASYS.
- VS Code is an editor, integrated terminal and optional Git interface only.
  No Codex agent or Codex extension is used in this workflow.

## Standard delivery

Native differential ZIP delivery is the sole standard OPUS/OWASYS delivery
method. Each ZIP contains only complete final files at their final paths and is
attached directly to the conversation. It is accompanied by a separate CMD
block that applies it explicitly with:

`tar -xf "%USERPROFILE%\\Downloads\\<ZIP>" -C H:\\OPUS`

No Library link, raw GitHub link, external download, partial patch or direct
assistant mutation replaces this delivery method.

## Stepwise protocol

The MAESTRO chat guides one bounded owner action at a time:

1. the chat states the exact next action and expected evidence;
2. the owner executes it locally in VS Code terminal or CMD;
3. the owner returns the complete output or requested runtime evidence;
4. the chat validates it against the authoritative source and contract;
5. only then does the chat issue the next action.

An unexpected HEAD, dirty worktree, failed command, missing file, validation
error or runtime regression is a stop condition. No success, local state or
performance figure may be invented.

## ZIP acceptance and Git closure

After a ZIP is delivered, the owner:

1. verifies the required baseline and clean worktree;
2. applies the ZIP;
3. runs the specified syntax, diff and Composer/site validations;
4. performs the contracted OWASYS runtime test;
5. reviews the resulting diff in VS Code or Fork;
6. commits and pushes OPUS/OWASYS only after acceptance;
7. returns the pushed SHA and concise validation evidence.

The MAESTRO chat records accepted state and the next specification/handoff in
`MAESTRO_WORKSPACE`.

## Response-time discipline

When a runtime run is required, the owner supplies fresh front/back logs and
Profiler JSONL. The MAESTRO chat compares timings by request class (page,
accepted mutation, rejected mutation and geometry/layout) with the latest
accepted baseline. Absent measurements are reported as absent.

## Non-negotiable prohibitions

- No Codex VS Code or Codex CLI usage in this workflow.
- No assistant commit or push to OPUS/OWASYS.
- No silent baseline mismatch.
- No automatic deletion, reset or history rewrite.
- No replacement of GitHub/MAESTRO authority by chat memory.
- No replacement of native differential ZIP delivery.
