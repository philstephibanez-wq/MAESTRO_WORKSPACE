# MAESTRO WORKSPACE — Handoff 2026-06-14 — P116B5 / P117 Security

## Scope

This handoff records the current OPUS / RefBook / Security orientation discussed on 2026-06-14.

It is documentation only. No source code, runtime configuration, database schema, secret, key, or infrastructure file is modified by this handoff.

## Source of truth for this handoff

- User-confirmed conversation state on 2026-06-14.
- Public GitHub target: `philstephibanez-wq/MAESTRO_WORKSPACE`.
- Contract reminder: strict MAESTRO_WORKSPACE rules remain active: source-of-truth first, no silent fallback, explicit errors, strict responsibilities, separation between data / processing / representation, cleanup discipline.

## P116B5 — Live ScoreTemplate status

P116B5 `LIVE_SCORE_RECIPE` is considered validated by the user on browser-rendered output.

Observed / accepted state:

- Historical live OPUS recipe made evolutive.
- `ScoreTemplate`: OK.
- Mail flow: `DELIVERED_TO_MAILPIT`.
- UTF-8 rendering corrected and visually accepted:
  - `Invité`
  - `Éditeur`
  - `édition autorisée`
  - forms tested
- The live recipe is independent from RefBook.
- It now acts as a living OPUS baseline for:
  - browser rendering,
  - mail delivery,
  - ScoreTemplate rendering,
  - UTF-8 checks.

## RefBook status and next execution priority

Execution priority remains RefBook before implementing the full security layer.

Reason:

- RefBook rendering is still unstable / incomplete.
- Security should be designed now, but not implemented deeply on a UI/documentation surface that is still moving.
- Avoid mixing two problem layers: RefBook rendering migration + cross-cutting security enforcement.

Recommended next sequence:

```text
P116C3_REAL_SCORE_REFBOOK
↓
P116C4_LIVE_REFBOOK_RECIPE
↓
Stable handoff
↓
P117A_IDENTITY_AUTHORITY_CONTRACT
↓
P117B_BASTION_SECURITY_MODEL
↓
P117C_API_GATEWAY_PEP
```

## P116C3 — RefBook target

Target: convert `OPUS_REF_BOOK` into a real `.score` RefBook.

Expected work:

- Real `layout.score` with visible structure:
  - header,
  - left menu,
  - content zone,
  - footer.
- Real `pages/*.score` pages.
- Remove residual Twig/Symfony dependency from the active RefBook rendering path.
- Remove hardcoded renderer approach such as `ReferenceScorePageRenderer` once true `.score` templates are active.
- Keep FR / EN / ES clean.
- Make the version visible in the rendered site.
- Ensure RefBook reflects OPUS live/runtime catalog instead of stale class references.
- No fake dynamic documentation: classes that no longer exist in OPUS must not remain visible as live API references.

## P117 — Security orientation

Security must be designed immediately, then implemented after RefBook is stable.

The user validated the direction: secure-by-design, with a self-hosted trust authority and bastions to minimize the attack surface.

### Core components

```text
OPUS_IDENTITY_AUTHORITY
OPUS_API_GATEWAY
OPUS_POLICY_ENGINE
OPUS_PUBLIC_BASTION
OPUS_ADMIN_BASTION
OPUS_WORKER_BASTION
```

### Trust Authority

`OPUS_IDENTITY_AUTHORITY` is the future self-hosted trust authority.

Responsibilities:

- identities,
- service clients,
- worker clients,
- user sessions,
- token issuing,
- token verification,
- token revocation,
- key rotation,
- scopes,
- roles,
- permissions,
- audit,
- anti-replay data.

Target compatibility:

- OAuth/OIDC-compatible design.
- Do not build a full homemade SSO first.
- Start with a strict OPUS contract and progressively implement only what is needed.

### API Gateway

All APIs, including public APIs, must pass through an official gateway.

A public API is not an insecure API. It is:

```text
anonymous allowed
rate limited
schema checked
cached when relevant
CORS controlled
audited minimally
read-only unless explicitly approved
free of secrets
```

### Request security for sensitive APIs

Sensitive API calls should require:

```text
Authorization: Bearer <access_token>
X-Opus-Client: <client_id>
X-Opus-Timestamp: <UTC timestamp>
X-Opus-Nonce: <unique nonce>
X-Opus-Body-SHA256: <body hash>
X-Opus-Signature: <request signature>
```

Mandatory checks:

- token valid,
- audience valid,
- scope sufficient,
- client active,
- timestamp inside a short allowed window,
- nonce never seen before,
- body hash matches,
- signature valid,
- rate limit OK,
- business policy OK,
- audit written.

Timestamp alone is insufficient. Use timestamp + nonce + signature + anti-replay store.

### Access profiles

```text
PUBLIC  = anonymous allowed, limited, read-focused
USER    = logged-in user, SSO/OIDC-compatible
SERVICE = internal app / backend service
WORKER  = Maestro / MO_KB workers / slaves
ADMIN   = critical operations, short token, full audit, extra confirmation
```

### Authorization model

Do not rely only on roles.

Use layered decisions:

```text
identity
client
scope
role
resource ownership
context
route policy
business policy
```

A scope such as `project:read` does not mean read every project. It means read a project only when the resource policy confirms ownership or explicit grant.

### Bastion model

Target data flow:

```text
Internet
  ↓
OPUS_PUBLIC_BASTION
  ↓
OPUS_API_BASTION / OPUS_API_GATEWAY
  ↓
internal services
  ↓
data / KB / databases
```

Rules:

- No business service directly exposed to the public Internet.
- No direct public exposure of RefBook internals, MO_KB internals, workers, KB, database, or daemon ports.
- No public exposure of internal ports such as `8787` / `8788`.
- Workers/slaves should preferably call outward to the master/gateway; they should not expose public inbound ports.
- Bastions expose only the minimum required ports, ideally HTTPS `443` when public.
- Bastions contain minimal code and no business data.
- Bastions must fail closed.

### VM decision

VMs are not mandatory for dev/local work.

Development/local minimum:

```text
single Windows host
internal services bound to 127.0.0.1
Apache/UwAmp or gateway as local reverse proxy
Windows firewall / Bitdefender rules
no direct daemon/public DB exposure
```

Recommended for serious public exposure:

```text
one lightweight public bastion VM
+
internal OPUS services kept behind it
+
no business data on the bastion
```

Longer-term stronger model:

```text
VM_PUBLIC_BASTION
VM_API_GATEWAY
VM_IDENTITY_AUTHORITY
VM_APP_SERVICES
protected DATA / KB storage
```

## Proposed P117 sequence

```text
P117A_IDENTITY_AUTHORITY_CONTRACT
  Written security contract: identities, clients, scopes, tokens, signatures, errors, audit.

P117B_BASTION_SECURITY_MODEL
  Zones, allowed flows, forbidden ports, public/user/service/worker/admin profiles.

P117C_API_GATEWAY_PEP
  OPUS middleware/gateway as Policy Enforcement Point.

P117D_SIGNED_REQUESTS
  Token + timestamp + nonce + body hash + signature + anti-replay.

P117E_PUBLIC_API_PROFILE
  Public APIs: anonymous allowed but rate limited, CORS-controlled, cached, schema-checked.

P117F_USER_SSO_PROFILE
  User SSO profile compatible with Authorization Code + PKCE / OIDC direction.

P117G_WORKER_ENROLLMENT
  Workers/slaves: machine identity, keys, rotation, revocation, signed leases.

P117H_SECURITY_RECIPES
  Recipes proving rejection of expired tokens, replayed nonces, missing scopes, invalid ownership, direct access, and unsigned sensitive requests.
```

## Immediate recommendation

Proceed with:

```text
1. P116C3_REAL_SCORE_REFBOOK
2. P116C4_LIVE_REFBOOK_RECIPE
3. Stable handoff
4. P117A_IDENTITY_AUTHORITY_CONTRACT
```

Security is conceptually first, but RefBook should be finished first in execution to avoid securing an unstable rendering layer.
