# MAESTRO WORKSPACE — Handoff 2026-06-14 — P116B5 / P117 Security

## Scope

This handoff records the current OPUS / RefBook / KB / Security orientation discussed on 2026-06-14.

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

Execution priority remains RefBook before resuming KB work and before implementing the full security layer.

Reason:

- RefBook rendering is still unstable / incomplete.
- RefBook is the documentation surface expected to reflect OPUS live state.
- KB work should not resume on top of an unclear documentation/reference layer.
- Security should be designed now, but not implemented deeply on a UI/documentation surface that is still moving.
- Avoid mixing three problem layers: RefBook rendering migration + KB work + cross-cutting security enforcement.

Recommended next sequence:

```text
P116C3_REAL_SCORE_REFBOOK
↓
P116C4_LIVE_REFBOOK_RECIPE
↓
Stable RefBook handoff
↓
Resume KB / MO_KB work
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

Security must be designed immediately, then implemented after RefBook is stable and KB resume state is clear.

The user validated the direction: secure-by-design, with a self-hosted trust authority and bastions to minimize the attack surface.

### Core components

```text
OPUS_IDENTITY_AUTHORITY
OPUS_API_GATEWAY
OPUS_POLICY_ENGINE
OPUS_PUBLIC_BASTION
OPUS_ADMIN_BASTION
OPUS_WORKER_BASTION
LSTSAR
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
- SSO-like user flow direction.
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

### Physical Linux bastion target

The user confirmed that a dedicated HP Elite 8300 Linux server is ready and Webmin is already installed.

This changes the deployment target:

```text
Internet
  ↓ HTTPS 443 only when public
HP_ELITE_8300_LINUX_BASTION
  ↓ controlled reverse proxy / firewall / gateway path
Windows H: internal services
  OPUS / OPUS_REF_BOOK / MO_KB / Maestro / KB / development data
```

Target role:

```text
HP_ELITE_8300_LINUX_BASTION
- physical bastion host
- reverse proxy
- TLS termination
- firewall boundary
- security logs
- fail2ban / rate limiting candidate
- future API gateway host candidate
- future Identity Authority host candidate, if isolation and backup policy are validated
```

Strict rule for Webmin:

```text
Webmin must remain LAN/VPN/admin-only.
Webmin must not be exposed directly to the public Internet.
```

### VM decision

VMs are not mandatory for dev/local work.

The dedicated HP Elite 8300 Linux server can serve as the first real bastion without requiring an initial VM layer.

Development/local minimum remains:

```text
single Windows host
internal services bound to 127.0.0.1
Apache/UwAmp or gateway as local reverse proxy
Windows firewall / Bitdefender rules
no direct daemon/public DB exposure
```

Recommended first serious public exposure model is now:

```text
HP_ELITE_8300_LINUX_BASTION
+
internal OPUS / RefBook / MO_KB services kept behind it
+
no business data or KB stored on the bastion
+
Webmin LAN/VPN only
```

Longer-term stronger model remains possible:

```text
PHYSICAL_PUBLIC_BASTION or VM_PUBLIC_BASTION
VM_API_GATEWAY or dedicated gateway service
VM_IDENTITY_AUTHORITY or dedicated authority service
VM_APP_SERVICES
protected DATA / KB storage
```

### LSTSAR orientation

`LSTSAR` is retained as a future secure data-flow layer, not as the immediate priority.

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

- not a catch-all engine,
- no silent fallback,
- strict input/output contracts,
- typed validation,
- explicit transformation policy,
- auditable execution,
- replay protection where relevant,
- no direct bypass of the API gateway / trust authority model.

## Proposed P117 sequence

```text
P117A_IDENTITY_AUTHORITY_CONTRACT
  Written security contract: identities, clients, scopes, tokens, signatures, errors, audit.

P117B_BASTION_SECURITY_MODEL
  Zones, allowed flows, forbidden ports, public/user/service/worker/admin profiles.
  Include HP Elite 8300 Linux bastion deployment notes.

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

P117H_LSTSAR_CONTRACT
  Secure Load / Store / Transform / Security / Audit / Replay-control contract.

P117I_SECURITY_RECIPES
  Recipes proving rejection of expired tokens, replayed nonces, missing scopes, invalid ownership, direct access, and unsigned sensitive requests.
```

## Immediate recommendation

Proceed with:

```text
1. P116C3_REAL_SCORE_REFBOOK
2. P116C4_LIVE_REFBOOK_RECIPE
3. Stable RefBook handoff
4. Resume KB / MO_KB work
5. P117A_IDENTITY_AUTHORITY_CONTRACT
```

Security is conceptually first, and the Linux bastion target is now known, but RefBook should be finished first in execution to avoid securing an unstable rendering layer.
