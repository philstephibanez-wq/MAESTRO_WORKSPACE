# P117A3 — FSM Blocked-State Event Model Handoff

Date: 2026-06-16
Status: delivered, pending user runtime validation

## Previous validated gate

P117A2 was validated by user on `H:/OPUS`:

```text
ok=true
gate=P117A2_OPUS_PUBLIC_ROUTE_MVC_SMOKE
normal_status=200
blocked_status=503
blocked_body=Site temporairement bloqué.
Contactez le support.
```

A runtime validation handoff was added:

```text
CONTEXT/HANDOFFS/P117A2_RUNTIME_VALIDATED_PUBLIC_ROUTE_MVC_SMOKE.md
```

## Decision added in P117A3

The FSM-bastion blocked state must generate an internal blocked-state event.

Public users must receive only an opaque support message.

Administrators, logs and future dashboard screens receive the structured internal diagnostics.

## Delivered OPUS classes

```text
framework/Opus/Security/BlockedStateEvent.php
framework/Opus/Security/PublicControlDecision.php
framework/Opus/Security/PublicRouteControlPlane.php
framework/Opus/Security/PublicBlockedResponseRenderer.php
framework/Opus/Runtime/BlockedStateEventSmoke.php
framework/Opus/Runtime/PublicRouteMvcSmoke.php
DOC/P117A3_FSM_BLOCKED_STATE_EVENT_MODEL.md
```

## Public opacity rule preserved

The public blocked response remains exactly:

```text
Site temporairement bloqué.
Contactez le support.
```

No FSM, ACL, route, token, class, file path, stack trace, configuration, database or tool diagnostic may be exposed publicly.

## Admin-only diagnostics introduced

The blocked-state event carries:

```text
- event_id
- site
- route_key
- blocked_state
- reason
- admin_action
- severity
```

These diagnostics are reserved for protected administrator dashboard, logs, reports and notification bridges.

## Runtime validation command

```cmd
cd /d H:\OPUS
git pull
git status --short --branch
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\BlockedStateEventSmoke::run(); foreach (['ok','gate','public_status'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'public_body='.str_replace("\n", ' | ', $r['public_body']).PHP_EOL; echo 'blocked_state='.$r['blocked_state_event']['blocked_state'].PHP_EOL; echo 'reason='.$r['blocked_state_event']['reason'].PHP_EOL; echo 'admin_action='.$r['blocked_state_event']['admin_action'].PHP_EOL;"
```

Expected output:

```text
ok=true
gate=P117A3_FSM_BLOCKED_STATE_EVENT_MODEL
public_status=503
public_body=Site temporairement bloqué. | Contactez le support.
blocked_state=PUBLIC_REQUEST_BLOCKED
reason=UNKNOWN_PUBLIC_ROUTE
admin_action=ADMIN_VIEW_BLOCKED_STATES
```

## Next gate after runtime validation

```text
P117A4_PUBLIC_SITE_CONFIG_DECLARATION
```

Purpose:

```text
Move the public route declaration out of hardcoded smoke setup toward a validated site configuration model.
```
