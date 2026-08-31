# Chat MAESTRO / Codex VS Code Stepwise Workflow Contract

Date: 2026-08-31

Status: OWNER-APPROVED — AUTHORITATIVE

## Purpose

This contract defines the owner-approved workflow between the MAESTRO ChatGPT
chat and the OpenAI Codex extension in VS Code. Its goals are to preserve the
MAESTRO authority chain, minimize duplicated model work, control ChatGPT Plus
usage, and keep every OPUS/OWASYS delivery and possible mutation reviewable.

## Authority and responsibility

- GitHub and `MAESTRO_WORKSPACE` remain the contractual authorities.
- The MAESTRO chat owns architecture, scope, acceptance criteria, run sequencing
  and final interpretation of evidence.
- Codex VS Code is the local diagnostic, validation and, only by an explicit
  owner exception, execution assistant in `H:\OPUS`.
- The owner controls runtime testing, Fork, commits and pushes.
- Codex VS Code never commits or pushes OPUS/OWASYS.
- The MAESTRO chat never claims to have observed a local result that the owner
  has not supplied.

## Standard delivery and controlled exception

Native differential ZIP delivery is the standard OPUS/OWASYS delivery method.
Codex VS Code normally works read-only before delivery and as a validation
assistant after owner application. This avoids repeating repository analysis in
the MAESTRO chat while preserving the proven ZIP application and owner Git
closure path.

A direct local mutation by Codex VS Code is exceptional. It requires an explicit
owner authorization that names the baseline, one bounded slice and the allowed
scope. It never follows implicitly from a diagnostic, audit, lint or validation
instruction. For such an exceptional run, do not also apply a ZIP that mutates
the same files from the same baseline. Switching to or from this exception
requires a new clean-baseline gate.

## Mandatory stepwise protocol

The MAESTRO chat guides every run one step at a time:

1. the chat gives one bounded step and its expected evidence;
2. the owner executes or delegates only that step to Codex VS Code;
3. the owner returns the complete output or requested evidence;
4. the chat validates the evidence;
5. only then may the chat give the next step.

No party may batch later steps in advance when an earlier result can change the
safe next action. An unexpected HEAD, dirty worktree, failed command, missing
file, validation error or runtime regression is a stop condition.

## Run 0 — read-only baseline gate

Every new Codex VS Code slice starts in a fresh focused chat and must:

1. work locally in the official `H:\OPUS` root;
2. read `H:\MAESTRO_WORKSPACE\README-FIRST.md` in full;
3. read the current handoff and every mandatory source designated by
   `README-FIRST.md`;
4. run the exact baseline commands supplied by the MAESTRO chat;
5. report HEAD, worktree status and recent history;
6. make no file change, commit or push.

The run stops unless the observed baseline and cleanliness match the execution
packet exactly. This is the normal Codex VS Code role for the standard ZIP
workflow.

## Execution packet from MAESTRO chat

Every mutating step must state:

- execution mode;
- required baseline SHA;
- one functional objective;
- authorized file or subsystem scope;
- forbidden changes;
- required validation commands;
- runtime acceptance criteria;
- response-time evidence required;
- exact return evidence.

Codex VS Code must not infer permission to broaden the slice, refactor adjacent
code, modify persisted owner data, commit or push.

## Codex VS Code rules

- Use `Work locally` with normal/default permissions unless the owner explicitly
  authorizes a narrower or broader profile.
- Use Terra with medium reasoning for normal targeted implementation.
- Use Luna for narrow mechanical checks or repetitive transformations.
- Use Sol only for complex architecture, ambiguous regressions, security or a
  documented Terra blocker.
- Do not use Fast mode by default.
- Keep one Codex chat for one coherent slice; start a new chat after acceptance
  instead of carrying unrelated historical context.
- Provide only relevant sources and logs. Do not inject the complete MAESTRO
  conversation when the authoritative files provide the required context.
- Treat any approval request, permission boundary or unexpected external access
  as a stop condition for owner review.

Model names are operational defaults, not architectural dependencies. If OpenAI
changes available model names, preserve the same capability tiers: mechanical,
everyday implementation, and complex/high-stakes reasoning.

## Mandatory validation evidence

Codex VS Code returns, as applicable:

- HEAD before the mutation;
- exact changed-file inventory;
- concise root cause and implemented solution;
- `git diff --check` result;
- syntax and Composer/site validation results;
- tests executed and tests not executable locally;
- concise diff summary;
- remaining owner runtime gates;
- fresh response-time measurements separated by request class;
- any blocker without invented success.

Runtime success belongs to the owner. A Codex static check or automated test
must never be presented as owner browser acceptance.

## Response-time discipline

The systematic response-time rules in
`00_COMMON_CONTRACTS/DEVELOPMENT_CONTRACT.md` remain mandatory. The owner sends
fresh front/back logs and Profiler JSONL when a runtime run is performed. The
chat compares the same request classes with the latest accepted baseline and
never invents absent timing data.

## Standard ZIP acceptance and Git closure

After the chat validates the diagnostic evidence, the MAESTRO chat delivers the
native differential ZIP and its CMD validation block. The owner then:

1. performs the requested OWASYS runtime test;
2. reviews the diff in Fork;
3. commits and pushes OPUS/OWASYS only after acceptance;
4. returns the pushed SHA and concise validation packet to the MAESTRO chat.

The MAESTRO chat then records the accepted state in `MAESTRO_WORKSPACE` and
opens the next bounded slice.

## Exceptional direct local execution

Only after the owner explicitly authorizes a direct local mutation may Codex VS
Code edit the named scope. It still never commits or pushes. The owner reviews
the resulting diff in Fork, runs the same required validation and runtime gates,
then commits and pushes only after acceptance. The MAESTRO chat must state this
exception in the execution packet before Codex receives a mutating instruction.

## Usage-efficiency rules

- Do not ask both the MAESTRO chat and Codex VS Code to perform the same full
  repository analysis.
- Keep the permanent project reasoning in the MAESTRO chat and the local code
  execution in Codex VS Code.
- Exchange bounded execution and result packets instead of whole chat histories.
- Prefer one complete implementation request plus its validations over many
  fragmented follow-ups.
- Reuse the authoritative README and handoff instead of pasting their complete
  contents into prompts.
- Send full logs only for a failure, regression or required performance audit;
  otherwise send the contracted summary and measurements.

## Non-negotiable prohibitions

- NO simultaneous writers on the same OPUS/OWASYS slice.
- NO Codex commit or push.
- NO direct Codex mutation without explicit owner authorization.
- NO silent baseline mismatch.
- NO continuation after an unexpected result.
- NO invented validation or performance figure.
- NO replacement of GitHub/MAESTRO authority by chat memory.
- NO automatic deletion, reset or history rewrite.
