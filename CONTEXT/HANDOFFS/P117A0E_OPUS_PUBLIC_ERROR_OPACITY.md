# P117A0E — OPUS Public Error Opacity Handoff

Date: 2026-06-16
Status: delivered

## Delivered commits

```text
2f1cb0e P117A0E_ADD_PUBLIC_ERROR_OPACITY_CONTRACT
```

## Delivered document

```text
20_TECHNICAL_FOUNDATIONS/OPUS/DOC/P117_OPUS_PUBLIC_ERROR_OPACITY_CONTRACT.md
```

## Decision

The FSM-bastion must block internally and provide useful diagnostics to protected operators, but the public user must never receive exploitable technical information.

## Public rule

```text
Site temporairement bloqué.
Contactez le support.
```

This is the only kind of message a public user should see when a site is blocked.

## Forbidden public information

The public surface must not reveal:

```text
- SQL errors
- stack traces
- filesystem paths
- class names
- route internals
- config keys
- token details
- scope names
- ACL rule names
- FSM state names
- FSM transition names
- blocked state identifiers
- cache/log paths
- dependency/autoload details
```

## Protected admin surface

The admin dashboard may expose actionable diagnostics, but only behind OPUS control:

```text
Admin dashboard
-> protected OPUS application
-> FSM/ACL/SSO-like controlled
-> explicit route / intention / transition / permission
-> audited action
```

## Operational split

```text
PUBLIC USER VIEW
- neutral support message only

ADMIN DASHBOARD
- actionable protected diagnostics

INTERNAL LOGS / REPORTS
- technical investigation details
```

## Security formula

```text
Fail closed publicly.
Explain privately.
Audit internally.
```

## Impact on next implementation gate

P117A2 must implement the first public route smoke with this rule already in mind:

```text
- normal public page may render normally;
- unknown route / blocked route / bad configuration must not expose details publicly;
- the runtime must preserve protected internal diagnostics for future dashboard/log usage.
```

## Next gate

```text
P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
```
