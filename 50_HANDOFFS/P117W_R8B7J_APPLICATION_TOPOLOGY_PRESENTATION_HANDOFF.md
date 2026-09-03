# P117W R8B7J — Applications topology presentation handoff

Status: NATIVE ZIP PREPARED — OWNER BASELINE GATE REQUIRED
Date: 2026-09-03

## Authoritative baseline

OPUS GitHub master: `ec3586496acdac83f155a248c46013e3001cbef4` (`R8B7I`).

## Root cause and bounded correction

The Applications SCORE template currently renders every registry entry as a peer branch below one OWASYS root. This makes generated applications look like internal OWASYS components.

R8B7J changes presentation only. OWASYS is rendered as one containing card whose non-generated/protected registry entries are its internal application cards; generated Composer applications are rendered in a separate applications area outside that OWASYS card.

Current registry projection already marks generated Composer `generated-opus-application` entries as `deletable` while explicitly excluding `owasys-front` and `owasys-back`. R8B7J reuses that existing projection; no business registry, REST, backend or PHP code is changed.

Expected current screen semantics:

`OWASYS = owasys-front + owasys-back`

and separately:

`Applications generated/managed by OWASYS = essai, ...`

## Native ZIP

Filename: `R8B7J.zip`

SHA-256:

`15e15b1660f8e153f1e76ca517bd807b4f7fd509ae72105109d68c349ec994ed`

Archive contains exactly one complete file at its final OPUS path:

`sites/owasys-front/application/registry/templates/index.score`

## Assistant-side validation

- source baseline reconstructed exactly to Git blob `77de59c341bb62c0dc294dff949a4203795aa655`;
- content before and after the bounded Applications-tree block remains the authoritative baseline content;
- SCORE directive counts are balanced: 32 `if` / 32 `endif`, 4 `foreach` / 4 `endforeach`;
- system/internal and generated render branches both preserve the application-selection form and current-app disabling semantics;
- generated branch preserves deletion form and `registry.can_delete` ACL gate;
- no new i18n key or literal application ID is introduced;
- ZIP listing and archived bytes verified;
- ZIP contains one file only.

## Owner stepwise acceptance

First gate, before extraction:

- `git rev-parse HEAD` must equal `ec3586496acdac83f155a248c46013e3001cbef4`;
- `git status --porcelain=v1 -uall` must be empty.

Any mismatch is a stop condition.

After baseline acceptance, the chat provides the single extraction step. Runtime acceptance then verifies `/fr-FR/applications` visually and functionally before owner commit/push.
