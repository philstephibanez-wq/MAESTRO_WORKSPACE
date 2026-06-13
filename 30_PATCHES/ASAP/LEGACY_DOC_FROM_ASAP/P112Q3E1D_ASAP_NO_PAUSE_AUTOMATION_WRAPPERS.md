# P112Q3E1D — ASAP no-pause automation wrappers

## Purpose

Make ASAP test, audit and recipe wrappers automation-friendly and observable.

## Contract

Runtime validation wrappers must not block with `pause`.
They must:

- execute the target PHP script;
- print the target marker emitted by PHP;
- print `ExitCode=<value>`;
- exit with the exact PHP exit code.

Interactive pauses are reserved for explicitly named interactive wrappers only.

## Scope

This patch updates only `.cmd` wrappers. It does not change ASAP runtime PHP code.
