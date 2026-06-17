# LOGANDPLAY — Public Identity Project

## Role

LOGANDPLAY is the public identity project for the Log&Play ecosystem.

It is not the OPUS framework core and must not introduce Log&Play business content inside the OPUS core.

## Public entry point

```text
Target public host : logandplay.org
Public role        : official identity card and ecosystem entry point
Renderer           : OPUS-generated site/page
Exposure status    : not public yet
```

The future `logandplay.org` home page must be generated through OPUS, but the content belongs to the LOGANDPLAY project/site layer, not to OPUS framework internals.

## Content contract

The public home page must present the ecosystem without exposing server internals.

Allowed public content:

```text
Log&Play identity and vision
OPUS project card
MAESTRO project card
KB / Maestro Knowledge Engine project card
Public status labels such as PROCHAINEMENT
```

Forbidden public content:

```text
Server paths
Webmin links
Admin links
Preproduction URLs
Private LAN names
Firewall/DNS/internal service details
Stack traces or runtime diagnostics
```

## Initial public page structure

```text
Hero
  Log&Play
  Creative music tools, OPUS framework and controlled musical intelligence.

Cards
  OPUS
    Framework web libre d'utilisation personnelle / non commerciale selon licence OPUS.
    Status: PROCHAINEMENT
    Link: disabled placeholder until official publication.

  MAESTRO
    Assistant musical REAPER/Lua for composition, analysis, orchestration and musician workflow.
    Status: PROCHAINEMENT
    Link: disabled placeholder until official publication.

  KB / Maestro Knowledge Engine
    Private musical knowledge engine for ingestion, analysis, references and workers.
    Status: PROCHAINEMENT
    Link: disabled placeholder until an explicit public surface exists.
```

## Exposure contract

Current state:

```text
OPUS      : not publicly exposed yet
MAESTRO   : not publicly exposed yet
KB        : not publicly exposed yet
LOGANDPLAY: public identity page planned, not yet exposed
```

Future exposure path:

```text
Cloudflare Access / Tunnel
-> gateway / OPUS public site
-> explicit public routes only
```

No Freebox port opening is planned by default.

## Current milestone

```text
P117SITE1_LOGANDPLAY_PUBLIC_IDENTITY_HOME
```

Goal:

```text
Create the first OPUS-generated Log&Play identity page with OPUS, MAESTRO and KB cards marked PROCHAINEMENT.
```
