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
ScoreTemplate .score templates / view layer
resources / content / i18n / theme
public front controller
optional FSM / transition contract when present
```

If these layers are missing or inconsistent, the next step is an audit and alignment plan, not a visual or runtime patch.

## OPUS ScoreTemplate obligation

For OPUS applications and OPUS-owned sites, every HTML representation must go through ScoreTemplate `.score` templates.

This is mandatory, not optional.

```text
NO .score TEMPLATE, NO CONFORMING OPUS PAGE.
```

Forbidden in OPUS applications/sites:

- page HTML concatenated in PHP;
- business or page rendering in `public/index.php`;
- business or page rendering inside controllers;
- active Twig rendering;
- templates scattered outside the module/application contract;
- visual components hardcoded in services;
- isolated public pages that bypass modules and ScoreTemplate.

Required rendering pipeline:

```text
Controller -> Service -> ViewModel -> ScoreTemplateRenderer -> .score -> HTML Response
```

Required site/application structure principle:

```text
application/config or manifest
application/<Module>/Module
application/<Module>/Controller
application/<Module>/Service
application/<Module>/ViewModel
application/<Module>/templates/*.score
application/<Module>/templates/pages/*.score
application/<Module>/templates/partials/*.score
application/<Module>/templates/components/*.score
resources/content
resources/i18n
resources/themes
public/index.php as front controller only
```

Every page belongs to a module. Every module owns its `.score` templates. FSM/transitions must be declared through the official OPUS contract when present, never hidden in controllers, templates, or JavaScript.

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

## Repository write policy

No commit, push, or direct repository mutation may be performed without explicit user validation.

MAESTRO_WORKSPACE may be written only after explicit validation from the user.

OPUS write access is revoked for the assistant: OPUS work is read-only for audit/proposal, and implementation must be delivered as a local runner or patch proposal for the user to apply and validate.

## Consequences

The assistant must pause and ask for, search for, or create the missing contract before continuing when a requested patch would otherwise be bricolage.

The assistant must prefer telling the user that a contract/audit is required over delivering a rushed patch.

This ADR supersedes any informal tendency toward quick visual fixes, ad hoc runtime fixes, isolated page work, or non-ScoreTemplate rendering when a framework/application contract is involved.
