# P117A2 — OPUS Public Route MVC Smoke Runtime Validated

Date: 2026-06-16
Status: runtime validated by user on `H:/OPUS`

## Gate

```text
P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
```

## User runtime command result

The user ran the public MVC smoke through the official OPUS entry point and `Opus\Runtime\PublicRouteMvcSmoke::run(__DIR__)`.

Observed output:

```text
ok=true
gate=P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
normal_status=200
blocked_status=503
blocked_body=Site temporairement bloqué.
Contactez le support.
```

## Validation

P117A2 is validated at runtime.

The following expectations are confirmed:

```text
- official OPUS boot succeeds before smoke execution;
- public MVC smoke returns ok=true;
- normal public route returns HTTP 200;
- blocked public response returns HTTP 503;
- public blocked body remains opaque and contains no technical detail;
- public blocked body exposes only the neutral support message.
```

## Security note

The observed blocked public body follows the public error opacity rule:

```text
Site temporairement bloqué.
Contactez le support.
```

No FSM, ACL, route, class, token, file path, stack trace, configuration or tool detail is exposed to the public response.

Administrator diagnostics remain internal/admin-only and must never be rendered to public users.

## Next gate

```text
P117A3_FSM_BLOCKED_STATE_EVENT_MODEL
```

Purpose:

```text
Model blocked-state events so OPUS can:
- block publicly with an opaque response;
- preserve admin diagnostics separately;
- feed the future administrator dashboard;
- notify operations when configured;
- maintain strict layer separation.
```
