# ADR 2026-06-14 — OPUS license authority, usage meter, royalties and RGPD

## Status

Accepted.

## Context

OPUS is intended to be source-available and free for non-commercial use, while commercial use requires a paid commercial license with royalties for Philippe Stéphane Ibanez / Log&Play.

The user also wants a professional way to detect the usage made of OPUS, similar to commercial software vendors, through login, license activation and traffic signals.

The user explicitly knows and cares about RGPD/GDPR compliance. Therefore OPUS must not implement hidden tracking, spyware-like telemetry or uncontrolled analytics.

## Decision

OPUS may include a professional license and usage detection system, but only under a clear RGPD-by-design contract:

```text
OPUS_LICENSE_AUTHORITY
OPUS_USAGE_METER
OPUS_ROYALTY_ENGINE
```

Those services must verify commercial rights and royalty obligations. They must not spy on user projects, user files, private code, musical data, business secrets or personal content.

## Product tiers

OPUS licensing must support at least three product modes:

```text
OPUS Free Non-Commercial
- no mandatory login;
- offline-first;
- manual update check only;
- no mandatory telemetry;
- commercial use not granted.

OPUS Registered
- optional login;
- user account for updates, packages, support or published RefBook access;
- clear privacy notice;
- no commercial rights unless a commercial license exists.

OPUS Commercial
- login and license activation required;
- signed local license token;
- periodic heartbeat or renewal when online;
- offline grace period allowed;
- usage reporting limited to license, activation and royalty-relevant metrics;
- royalties calculated from the commercial agreement.
```

## Data minimization

Allowed license and usage signals must be minimal and purpose-bound:

```text
- account_id;
- organization_id;
- license_id;
- product_package: OPUS / OPUS_REF_BOOK / OPUS_USER_GUIDE;
- opus_version;
- install_id or device_id, preferably pseudonymized;
- activation_date;
- last_seen_at;
- declared usage_mode: personal / educational / commercial;
- commercial feature flags used;
- royalty-relevant counters defined by contract;
- checksum/signature of the local license token.
```

Forbidden by default:

```text
- user project content;
- user source code;
- musical/audio/MIDI/project files;
- client/customer data;
- full filesystem scans;
- hidden fingerprinting;
- hidden analytics;
- advertising tracking;
- traffic inspection unrelated to OPUS licensing;
- automatic upload of private logs without explicit action or contract.
```

## Commercial usage detection

Commercial usage detection must be based on declared and contractual signals, not on invasive surveillance.

Examples of allowed detection:

```text
- commercial license activation;
- organization account;
- package channel: commercial / enterprise / studio;
- online service usage by authenticated account;
- explicit commercial feature enablement;
- published site domain tied to a commercial license;
- royalty counters agreed in the commercial contract.
```

Examples of prohibited detection without explicit legal basis and explicit contract:

```text
- scanning user projects to infer business usage;
- collecting customer names from files;
- monitoring unrelated network traffic;
- identifying third-party projects or clients;
- covert telemetry while advertised as offline-only.
```

## Offline-first compatibility

OPUS must remain usable offline for non-commercial use.

Commercial mode may use:

```text
- signed local license files;
- activation tokens;
- heartbeat windows;
- offline grace periods;
- delayed reporting queue;
- explicit sync when online.
```

No commercial license check may silently degrade into unauthorized commercial permission. If a commercial license is missing, expired or unverifiable, OPUS must display a clear status and keep the behavior contractual.

## User transparency

Every OPUS package that includes licensing or metering must expose:

```text
- what is collected;
- why it is collected;
- whether login is mandatory;
- whether telemetry is optional or contractual;
- where data is sent;
- retention period;
- account/licensing contact;
- commercial reporting terms;
- privacy/legal documents.
```

## No silent fallback

RGPD, licensing and royalty logic must follow the global MAESTRO/OPUS contract:

```text
0 fallback silencieux
0 hidden telemetry
0 spyware behavior
0 commercial permission without license
0 destructive enforcement
clear error/status when license state is invalid
```

## Required future components

Before public commercial release, OPUS must define or implement:

```text
OPUS_IDENTITY_AUTHORITY
OPUS_LICENSE_AUTHORITY
OPUS_LICENSE_TOKEN
OPUS_USAGE_EVENT
OPUS_USAGE_METER
OPUS_ROYALTY_ENGINE
OPUS_PRIVACY_NOTICE
OPUS_COMMERCIAL_TERMS
OPUS_LICENSE_DASHBOARD
```

Those components must remain separate from unrelated framework responsibilities. OPUS core must not become a hidden tracking engine.

## Package impact

```text
OPUS core
- may include license client primitives;
- must stay clean and non-invasive;
- no mandatory login for non-commercial offline use.

OPUS_REF_BOOK
- may check updates and package versions explicitly;
- published mode may use analytics only under documented privacy terms;
- local offline mode must not require login.

OPUS_USER_GUIDE
- must document licensing, privacy, commercial activation and offline behavior.
```

## Legal note

This ADR records architecture and product intent only. It is not a final legal license, privacy policy or commercial contract.

A lawyer-reviewed LICENSE, COMMERCIAL_TERMS and PRIVACY_NOTICE are required before public commercial enforcement.
