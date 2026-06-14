# ADR 2026-06-14 — OPUS Identity Authority and Bastion Security Model

## Status

Accepted as architecture direction.

Implementation is deferred until after the RefBook `.score` migration is stabilized.

## Context

The workspace is moving toward public and semi-public surfaces:

- OPUS RefBook,
- public documentation APIs,
- future secure API access,
- MO_KB front/backoffice,
- Maestro / workers / slaves,
- possible public or subscription-oriented services.

The user wants a secure-by-design architecture with minimal attack surface.

## Decision

Introduce a self-hosted trust authority and bastion-oriented security model.

Main components:

```text
OPUS_IDENTITY_AUTHORITY
OPUS_API_GATEWAY
OPUS_POLICY_ENGINE
OPUS_PUBLIC_BASTION
OPUS_ADMIN_BASTION
OPUS_WORKER_BASTION
```

## OPUS_IDENTITY_AUTHORITY

The Identity Authority is the self-hosted trust anchor.

It is responsible for:

- identities,
- API clients,
- service clients,
- worker clients,
- token issuance,
- token verification,
- token revocation,
- key rotation,
- scopes,
- roles,
- permissions,
- authorization metadata,
- anti-replay nonce storage,
- audit logs.

It should remain compatible with an OAuth/OIDC direction, without prematurely implementing a full custom SSO stack.

## OPUS_API_GATEWAY

All API calls must pass through the gateway.

The gateway is responsible for:

- authentication enforcement,
- token validation,
- request signature validation,
- timestamp validation,
- nonce replay prevention,
- scope checks,
- route policy checks,
- rate limiting,
- CORS decisions,
- audit logging,
- fail-closed behavior.

## Access profiles

```text
PUBLIC  = anonymous allowed, limited, read-focused, rate-limited
USER    = authenticated human user
SERVICE = internal application or backend service
WORKER  = Maestro / MO_KB worker / slave / daemon client
ADMIN   = critical operations with strict audit and extra confirmation
```

## Sensitive request profile

Sensitive requests should use both bearer token and proof/signature material.

Required headers target:

```text
Authorization: Bearer <access_token>
X-Opus-Client: <client_id>
X-Opus-Timestamp: <UTC timestamp>
X-Opus-Nonce: <unique nonce>
X-Opus-Body-SHA256: <body hash>
X-Opus-Signature: <request signature>
```

A valid request requires:

- valid token,
- correct audience,
- sufficient scope,
- active client,
- valid timestamp window,
- unique nonce,
- valid body hash,
- valid signature,
- successful route policy decision,
- successful business/ownership policy decision,
- successful rate-limit decision,
- audit write.

## Authorization model

Authorization must not be role-only.

Decisions must combine:

- identity,
- client,
- scope,
- role,
- route policy,
- resource ownership,
- business context,
- environment context when needed.

Example: `project:read` does not grant access to all projects. It only allows project read when the project policy confirms ownership or an explicit grant.

## Bastion model

Public target flow:

```text
Internet
  ↓
OPUS_PUBLIC_BASTION
  ↓
OPUS_API_GATEWAY / API bastion
  ↓
internal services
  ↓
data / KB / databases
```

Rules:

- No business service directly exposed to the public Internet.
- No direct exposure of KB, database, worker, daemon, RefBook internals, or MO_KB internals.
- No public exposure of internal ports such as `8787` / `8788`.
- Public surface should ideally expose HTTPS `443` only.
- Bastions contain minimal code.
- Bastions store no business data.
- Bastions hold no master secrets in clear text.
- Bastions fail closed.
- Workers/slaves should call outward; they should not expose public inbound ports.

## VM decision

VMs are not mandatory for local development.

Local/dev can start with:

```text
single Windows host
internal services bound to 127.0.0.1
reverse proxy / local gateway
Windows firewall and Bitdefender rules
no direct public daemon/database exposure
```

For serious public exposure, the recommended first hardening step is:

```text
one lightweight public bastion VM
+
OPUS services behind it
+
no data or KB on the bastion
```

Long-term stronger model:

```text
VM_PUBLIC_BASTION
VM_API_GATEWAY
VM_IDENTITY_AUTHORITY
VM_APP_SERVICES
protected DATA / KB storage
```

## Consequences

Positive:

- smaller public attack surface,
- centralized trust decisions,
- consistent audit,
- revocable clients and tokens,
- clear separation between public gateway and internal services,
- worker/slave security model can grow cleanly.

Costs:

- more infrastructure concepts,
- more recipes required,
- token/key lifecycle must be maintained,
- local dev and public deployment profiles must be documented separately.

## Execution order

Do not implement the full security layer before the RefBook rendering migration is stable.

Recommended order:

```text
P116C3_REAL_SCORE_REFBOOK
P116C4_LIVE_REFBOOK_RECIPE
stable handoff
P117A_IDENTITY_AUTHORITY_CONTRACT
P117B_BASTION_SECURITY_MODEL
P117C_API_GATEWAY_PEP
```
