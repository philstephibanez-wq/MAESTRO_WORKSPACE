# ADR 2026-06-14 — OPUS source-available free non-commercial and commercial royalties

## Status

Accepted.

## Context

The user clarified the intended public licensing model for OPUS.

OPUS must be usable freely in non-commercial contexts, while the author keeps his rights and commercial use must generate royalties.

The legal identity to mention in copyright and ownership notices is:

```text
Philippe Stéphane Ibanez
```

The Log&Play name may be used as project, product, publication or business identity where appropriate, but the personal authorship/copyright notice must mention Philippe Stéphane Ibanez explicitly.

## Decision

OPUS must not be described as OSI open-source under the current intent.

The intended model is:

```text
source-available
free for personal / non-commercial use
commercial use requires a paid commercial license
commercial license must include royalties for Philippe Stéphane Ibanez / Log&Play
```

## Mandatory public wording

Until a lawyer-approved final license text replaces this ADR, OPUS public wording must use a form equivalent to:

```text
OPUS is source-available and free for non-commercial use.
Commercial use requires a paid commercial license with royalties.
Copyright © Philippe Stéphane Ibanez. All rights reserved except as expressly granted.
```

French wording:

```text
OPUS est disponible en code source consultable et libre d'utilisation non commerciale.
Tout usage commercial nécessite une licence commerciale payante avec royalties.
Copyright © Philippe Stéphane Ibanez. Tous droits réservés sauf autorisation expresse.
```

## Package impact

This applies to the OPUS delivery family unless a later ADR defines package-specific exceptions:

```text
OPUS core        source-available, free non-commercial, commercial royalties
OPUS_REF_BOOK    official optional documentation website package, same ownership rules
OPUS_USER_GUIDE  optional future guide package, same ownership rules
```

Documentation may be freely readable, but reproduction, redistribution, commercial embedding or commercial publishing must follow the explicit license terms.

## Commercial use

Commercial use is not granted by default.

Commercial use requires a separate agreement that defines at least:

```text
- licensed party;
- authorized commercial scope;
- duration;
- territory if needed;
- royalty base;
- royalty rate or fee schedule;
- payment cadence;
- reporting/audit rights;
- attribution obligations;
- prohibited competitive redistribution;
- trademark/name/logo rules;
- termination conditions.
```

## Required files before public release

Before public release, each applicable package must include clean legal files:

```text
LICENSE
NOTICE
COPYRIGHT.md
TRADEMARKS.md
COMMERCIAL_LICENSE.md or COMMERCIAL_TERMS.md
```

Those files must be lawyer-reviewed before publication.

## Non-goals

This ADR does not grant anyone the right to:

```text
- redistribute OPUS publicly;
- publish forks;
- sell OPUS;
- remove copyright or authorship notices;
- use OPUS / Log&Play names as their own brand;
- provide OPUS as a competing commercial service;
- bypass commercial royalties.
```

## Consequences

- OPUS must be called source-available, not open-source, unless a later ADR changes the license model.
- Public pages must not imply MIT / Apache / GPL / MPL style permissions.
- Package manifests and release pages must display Philippe Stéphane Ibanez as copyright holder.
- Any future installer, RefBook About page, User Guide and published website must expose the license status clearly.
- Commercial licensing must be explicit and traceable.

## Implementation notes

This ADR records licensing intent only. It is not a final legal license.

A lawyer-approved license text must be produced before public release or commercial enforcement.
