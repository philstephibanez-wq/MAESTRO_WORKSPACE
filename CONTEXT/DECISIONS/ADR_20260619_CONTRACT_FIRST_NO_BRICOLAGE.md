# ADR 20260619 — Contract-first delivery, no bricolage

## Status

ACCEPTED — permanent workspace rule.

## Context

The user has explicitly rejected fast, improvised deliveries that appear helpful in the short term but break architecture, create inconsistent project structures, and waste development time.

This rule applies to MAESTRO_WORKSPACE, OPUS, OPUS integrated sites, ASAP-derived structures, MAESTRO_V5, MO_KB projects, and every future sub-project handled from this workspace.

## Decision

Every future delivery must be contract-first.

Speed is not a valid reason to bypass architecture. A slower contractual delivery is preferred to a fast patch that must later be repaired.

The assistant must not try to "please" the user by delivering quick fixes, visual tweaks, ad hoc runners, isolated pages, or local hacks when the correct work is architectural or contractual.

## Non-negotiable rules

```text
NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
SLOWER IS ACCEPTABLE; WASTING USER TIME IS NOT.
```

Before proposing code, a runner, a migration, or a structural change, the assistant must:

1. identify the source of truth repository and branch;
2. inspect the real current structure, not memory and not assumptions;
3. read the relevant contract, ADR, README, handoff, module/app framework documentation, or explicitly state that the contract is missing;
4. define the target contract before changing implementation;
5. separate audit, decision, migration, and visual/runtime correction;
6. update MAESTRO_WORKSPACE handoff/context for every significant validated milestone.

## OPUS / ASAP application rule

OPUS and ASAP-style projects must be treated as applications with contracts, not as isolated pages.

A site or app must be aligned with its official architecture before patching visible behavior:

```text
application/config or manifest
application module
router / route contract
controller
domain service / content service
view model
template / ScoreTemplate / view layer
resources / content / i18n / theme
public front controller
optional FSM / transition contract when present
```

If these layers are missing or inconsistent, the next step is an audit and alignment plan, not a visual or runtime patch.

## Delivery rule

A delivery must be:

- small enough to test;
- grounded in the contract;
- explicit about changed files;
- rollbackable by Git;
- free of hidden fallbacks;
- free of temporary scories;
- documented in the workspace when it changes architecture, state, priority, or recovery context.

Runnable deliverables for Windows development must follow the user's established workflow:

```text
ZIP uploaded by the user/assistant
CMD commands for VS Code integrated terminal
no surprise browser launch
no intrusive profile/session creation
no PowerShell unless explicitly requested
```

## Consequences

The assistant must pause and ask for, search for, or create the missing contract before continuing when a requested patch would otherwise be bricolage.

The assistant must prefer telling the user that a contract/audit is required over delivering a rushed patch.

This ADR supersedes any informal tendency toward quick visual fixes, ad hoc runtime fixes, or isolated page work when a framework/application contract is involved.
