# ADR 2026-06-14 — OPUS Identity Authority and Bastion Security Model

## Status

Accepted as architecture direction.

Implementation is deferred until after the RefBook `.score` migration is stabilized and the KB / MO_KB resume point is clear.

## Context

The workspace is moving toward public and semi-public surfaces:

- OPUS RefBook,
- public documentation APIs,
- future secure API access,
- MO_KB front/backoffice,
- Maestro / workers / slaves,
- possible public or subscription-oriented services.

The user wants a secure-by-design architecture with minimal attack surface.

On 2026-06-14, the user confirmed that a dedicated HP Elite 8300 Linux server is ready and Webmin is already installed. This server can become the first physical bastion target, reducing the need for an initial bastion VM in the first deployment profile.

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
LSTSAR
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

## Physical Linux bastion target

The first concrete bastion target is the user's dedicated HP Elite 8300 Linux server.

Target name:

```text
HP_ELITE_8300_LINUX_BASTION
```

Initial role:

```text
Internet
  ↓ HTTPS 443 only when public
HP_ELITE_8300_LINUX_BASTION
  ↓ controlled reverse proxy / firewall / gateway path
Windows H: internal services
  OPUS / OPUS_REF_BOOK / MO_KB / Maestro / KB / development data
```

Accepted responsibilities:

- public edge / bastion host,
- reverse proxy,
- TLS termination,
- firewall boundary,
- access/security logs,
- fail2ban / rate limiting candidate,
- future API gateway host candidate,
- future Identity Authority host candidate only if isolation, backup, secret-storage and restore policy are validated first.

Webmin rule:

```text
Webmin is admin-only.
Webmin must remain LAN/VPN-only.
Webmin must not be exposed directly to the public Internet.
```

## VM / physical host decision

VMs are not mandatory for local development.

A dedicated physical Linux bastion is now available, so the first serious public exposure model should prefer:

```text
HP_ELITE_8300_LINUX_BASTION
+
OPUS services behind it
+
no business data or KB on the bastion
+
Webmin LAN/VPN only
```

Local/dev can still start with:

```text
single Windows host
internal services bound to 127.0.0.1
reverse proxy / local gateway
Windows firewall and Bitdefender rules
no direct public daemon/database exposure
```

Long-term stronger model remains possible:

```text
PHYSICAL_PUBLIC_BASTION or VM_PUBLIC_BASTION
VM_API_GATEWAY or dedicated gateway service
VM_IDENTITY_AUTHORITY or dedicated authority service
VM_APP_SERVICES
protected DATA / KB storage
```

## LSTSAR

`LSTSAR` is accepted as a future secure data-flow layer and must not become a catch-all engine.

Working meaning:

```text
Load
Store
Transform
Security
Audit
Replay-control
```

Constraints:

- strict contracts,
- typed validation,
- explicit transformation policy,
- auditable execution,
- replay protection where relevant,
- no silent fallback,
- no direct bypass of `OPUS_API_GATEWAY`, `OPUS_IDENTITY_AUTHORITY`, or policy decisions.

## Consequences

Positive:

- smaller public attack surface,
- centralized trust decisions,
- consistent audit,
- revocable clients and tokens,
- clear separation between public gateway and internal services,
- physical Linux bastion available without waiting for VM setup,
- worker/slave security model can grow cleanly.

Costs:

- more infrastructure concepts,
- more recipes required,
- token/key lifecycle must be maintained,
- local dev, LAN, bastion and public deployment profiles must be documented separately,
- HP Linux bastion hardening must be done carefully before public exposure.

## Execution order

Do not implement the full security layer before the RefBook rendering migration is stable.

Recommended order:

```text
P116C3_REAL_SCORE_REFBOOK
P116C4_LIVE_REFBOOK_RECIPE
stable RefBook handoff
resume KB / MO_KB work
P117A_IDENTITY_AUTHORITY_CONTRACT
P117B_BASTION_SECURITY_MODEL
P117C_API_GATEWAY_PEP
P117H_LSTSAR_CONTRACT
```
