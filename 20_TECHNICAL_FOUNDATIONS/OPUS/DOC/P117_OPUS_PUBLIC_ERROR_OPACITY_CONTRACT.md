# P117 — OPUS Public Error Opacity Contract

Date: 2026-06-16
Status: active security addendum
Scope: OPUS, OPUS public release, FSM bastion, public rendering, API responses, admin dashboard, observability

## Purpose

This document fixes a non-negotiable security rule for OPUS:

```text
Public users must never receive explicit technical, security, configuration, routing, authentication, authorization, FSM, ACL, SSO-like, API, class, database, filesystem, stack trace, or tool error details.
```

OPUS may block, log, audit, report internally, notify operations, and expose diagnostics to authorized administrators through the admin dashboard, but the public user surface must remain opaque.

## Security principle

```text
Fail closed publicly.
Explain privately.
Audit internally.
```

French operational wording:

```text
Bloquer publiquement.
Expliquer côté admin.
Auditer en interne.
```

## Public user response rule

When OPUS enters a blocked state visible from a public site, the public response must be neutral and non-exploitable.

Allowed public wording:

```text
Site temporairement bloqué.
Contactez le support.
```

Acceptable variants may change the tone, but must not reveal cause, component, stack, path, class, rule, transition, token, table, route, or policy details.

Examples:

```text
Site temporairement indisponible.
Contactez le support.
```

```text
Votre demande ne peut pas être traitée pour le moment.
Contactez le support.
```

## Forbidden public disclosures

The public surface must never expose:

```text
- SQL errors
- stack traces
- filesystem paths
- class names
- namespaces
- method names
- route resolution details
- missing configuration names
- missing file names
- token validation details
- token expiration reason
- API scope names
- ACL rule names
- role names involved in a refusal
- FSM state names
- FSM transition names
- blocked state identifiers
- OPUS internal module names
- LSTSAR/TLSTSAR operation internals
- cache paths
- log paths
- database table names
- dependency names
- autoload details
- debug dumps
```

This rule applies to HTML pages, JSON API responses, CLI output intended for users, error pages, generated documentation examples, and default exception renderers.

## Admin dashboard rule

The administrator dashboard is the proper surface for operational diagnostics.

It may expose protected diagnostics such as:

```text
- site id / site name
- request id
- event id
- route requested
- public endpoint category
- authenticated actor when available
- anonymized or access-controlled actor data
- current FSM state
- refused transition
- ACL decision
- SSO-like identity / trust context
- token/scope category when applicable
- blocked state chosen
- severity
- timestamps
- IP / fingerprint when authorized by policy
- relevant report id
- recommended manual action
- operator acknowledgement status
```

The dashboard itself must be an OPUS application protected by the same FSM/ACL/SSO-like control plane. It is not a bypass.

## Log and report rule

Internal logs and reports may contain technical detail, but only in protected operational storage.

Rules:

```text
- public output: generic message only
- admin dashboard: controlled operational diagnostics
- internal logs: technical details for investigation
- reports: business or operational proof, never public by default
```

Reports may be referenced by public-facing messages only through a safe support reference, never through a raw filesystem path or implementation detail.

Allowed public support reference example:

```text
Référence support : OPUS-EVT-20260616-000123
```

Forbidden public support reference example:

```text
H:\OPUS\var\logs\opus_runtime.log:42
```

## FSM-bastion behavior

When an anomaly is detected, the FSM must enter a blocked state internally, but the public renderer must not expose the blocked state name.

Internal flow:

```text
Anomaly detected
-> FSM blocked state
-> protected event id
-> protected log/report
-> optional notification
-> admin dashboard visibility
-> manual intervention if required
```

Public flow:

```text
Anomaly detected
-> neutral blocked page or neutral API denial
-> support contact message
```

## API response rule

For public or unauthenticated API calls, OPUS must return a neutral error envelope.

Example:

```json
{
  "ok": false,
  "message": "Request temporarily blocked. Contact support.",
  "support_reference": "OPUS-EVT-20260616-000123"
}
```

For authorized administrator API calls, OPUS may return detailed diagnostics if the caller is authenticated, authorized, scoped, and in an allowed FSM state.

## Developer ergonomics rule

Developers must not need to implement this manually for every route.

OPUS must provide a default public error renderer that is opaque by contract.

Sensitive detail must require explicit protected admin context and must never be the default rendering path.

## Relation to LSTSAR/TLSTSAR

LSTSAR/TLSTSAR remains a secured data-driven utility class.

It may produce a detailed business report for an authorized operation.

It must not leak that report to public users.

If a LSTSAR/TLSTSAR operation fails during a public request, the public response still follows the same opaque rule:

```text
Site temporairement bloqué.
Contactez le support.
```

## Non-negotiable rule

```text
No explicit public error.
No public stack trace.
No public internal state.
No public security reason.
No public implementation detail.
```

Only the protected administrator surface receives actionable diagnostics.
