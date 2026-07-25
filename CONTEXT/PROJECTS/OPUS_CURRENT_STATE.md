# OPUS CURRENT STATE

Last updated: 2026-07-25.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `41f77ad7187c0facb125a5737b62d10928809e66`
- Owner local repo: `H:/OPUS`
- Current committed milestone: P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8 + HF9 + HF9R1
- HF10A direct differential: produced, owner installation pending

## Framework identity

OPUS is a generic framework. OWASYS is an OPUS application whose UI is SCORE and whose business writes cross secured REST then allow-listed Composer commands.

## Canonical architecture

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` is forbidden.

## Delivery contract

The active code delivery is a direct differential ZIP, superposed at `H:/OPUS`.

It contains only complete new or replaced files at final repository paths. It contains no installer, payload directory, patch directory, staging area, report, log or full repository copy.

## Active differential

```text
ZIP     : opus_p117v_hf10a_shared_front_back_direct_differential.zip
SHA-256 : a775f25bd71588d77079f3bc7c430f71ea0ad1a511abc50a720c3c0e7ee165ca
BASE    : 41f77ad7187c0facb125a5737b62d10928809e66
FILES   : 12
```

The former `opus_p117u_hf10_application_surfaces_runtime_modes.zip` is superseded because its installer/payload packaging was not the contracted delivery mode.

## HF10A framework classes

```text
LayeredGeneratedSiteRuntime
LayeredSiteCommandService
LayeredApplicationTranslationRuntime
LayeredSiteScaffoldPlan
```

Each class directly implements its homonymous interface. Each interface extends the four standard markers:

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

All PHP files in the direct differential pass `php -l`. The homonymous-interface marker checks pass for all new concrete framework classes.

## Runtime modes

```text
front
back
```

The process role is defined by `--mode`, never by the port. Local defaults remain conventional and configurable:

```text
front : 127.0.0.1:8000
back  : 127.0.0.1:8792
```

Production remains HTTPS 443 through a reverse proxy with distinct internal front and back processes/pools.

## Application contracts

- Singleton;
- FSM-module-first;
- browser-locale I18n with explicit diagnosed fallback;
- ACL deny-by-default;
- SSO/Auth0 proxy and bastion ready;
- SCORE-only UI;
- no UI-producing echo;
- no mixed PHP/HTML;
- configuration through `File` and `StructuredFileLoader` to `Json`, `Xml` or `Yaml`;
- Logger and Profiler mandatory;
- no silent fallback.

## OWASYS diagnostics

HF10A instruments OWASYS dispatch with correlated Logger/Profiler events and `trace_id` while enforcing front/back route isolation.

Current owner evidence before installation:

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HTTP 500
runtime log             : absent
```

After installation, the HTTP 500 must be reproduced to collect `request.failed` and its `trace_id`. No cause is declared without this trace.

## Physical OWASYS migration

HF10A does not perform an unverified destructive move of the existing OWASYS tree. New generated applications use the layered contract. The physical OWASYS migration remains a subsequent differential after runtime evidence.

## Installation

```text
tar -xf opus_p117v_hf10a_shared_front_back_direct_differential.zip -C H:\OPUS
```

Then run Composer autoload, PHP lint and the contractual audit from `H:\OPUS`.

## Pending

1. verify clean owner worktree at the exact base;
2. extract the direct differential at repository root;
3. run Composer, lint and contract audit;
4. start back and front with explicit modes;
5. reproduce `/fr-FR/applications`;
6. collect `request.failed` and `trace_id`;
7. build the next corrective/migration differential from that evidence;
8. run exhaustive P117M tokenizer gate;
9. owner commit and push after acceptance;
10. decide separately on `sites/owasys_old`.
