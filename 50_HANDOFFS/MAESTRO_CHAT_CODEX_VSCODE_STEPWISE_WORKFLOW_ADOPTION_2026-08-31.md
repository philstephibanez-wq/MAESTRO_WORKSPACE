# MAESTRO Chat / Codex VS Code Stepwise Workflow Adoption

Date: 2026-08-31

State: OWNER-APPROVED — RECORDED

## Owner decision

The owner approved a controlled Chat MAESTRO / Codex VS Code collaboration
workflow for OPUS/OWASYS:

- the MAESTRO chat remains the pilot and contractual interpreter;
- Codex VS Code performs local diagnosis, controls and validation;
- the native differential ZIP remains the standard delivery method;
- a Codex VS Code local script modification is exceptional and requires an
  explicit owner authorization for the exact slice and baseline;
- Fork remains the owner-controlled commit/push boundary;
- every run is guided one step at a time;
- each returned output is validated before the next instruction;
- ChatGPT Plus usage is protected by avoiding duplicated repository analysis and
  by selecting the lowest suitable model tier.

## Contract

`00_COMMON_CONTRACTS/CHAT_CODEX_VSCODE_STEPWISE_WORKFLOW_CONTRACT.md`

`README-FIRST.md` now pins this contract as mandatory rule 15.

## Compatibility with native ZIP delivery

Native differential ZIP delivery remains the default and is unchanged. Codex VS
Code is normally complementary: it reduces duplicated analysis before delivery
and helps validate the owner-applied result. A direct local mutation by Codex is
an explicit exception; it cannot coexist with a ZIP modifying the same files on
the same baseline.

## First observed gate

The first read-only Codex VS Code run was executed locally with Terra. It read
the designated MAESTRO instructions, checked the OPUS repository and reported:

`Aucun écart constaté.`

This observation proves only the read-only baseline gate shown by the owner. It
does not authorize a mutation, commit or push. The next instruction must be a
single bounded step issued after MAESTRO chat validation.

## Next-run rule

For every subsequent run, the MAESTRO chat must provide only the next safe step,
state the expected evidence, wait for the owner output, validate it, and then
continue. A mismatch or incomplete result pauses the run.
