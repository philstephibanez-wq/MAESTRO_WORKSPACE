# MAESTRO Native ZIP Workflow Adoption

Date: 2026-08-31

State: OWNER-APPROVED — RECORDED

## Owner decision

The owner removed Codex VS Code from the OPUS/OWASYS workflow after local
Codex usage reached its plan limit during a read-only audit.

The operating method is now:

- MAESTRO ChatGPT performs contractual source review, specification and
  differential ZIP preparation;
- native differential ZIP remains the sole delivery method;
- the owner uses VS Code only as editor, terminal and optional Git interface;
- the owner applies the ZIP, validates runtime behavior, reviews the diff, then
  commits and pushes OPUS/OWASYS;
- each run is guided one owner step at a time;
- fresh response-time evidence remains mandatory whenever runtime work occurs.

## Contract

`00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`

`README-FIRST.md` rule 15 now pins this contract.

## Supersession

This record and its contract supersede the former Chat/Codex VS Code workflow.
The former contract and adoption record were removed; they must not be used to
request, recommend or require Codex VS Code or Codex CLI for OPUS/OWASYS.
