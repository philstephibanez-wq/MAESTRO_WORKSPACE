# ADR 2026-06-15 — OPUS RefBook sidebar and seasons themes

## Status

Accepted.

## Context

The OPUS RefBook is now stabilized enough to continue UI work.

Validated state before this ADR:

- Twig templates removed from the RefBook target.
- Composer no longer requires `twig/twig`.
- Runtime I18N no longer crashes on `lang=cs`.
- Header brand changed to `OPUS FRAMEWORK` with `Reference Book` subtitle.

The remaining UX issue is the navigation model. A horizontal documentation menu is not appropriate for a RefBook that will grow. The user prefers a left documentation sidebar, rebuilt cleanly and professionally.

## Decision

The OPUS RefBook layout must follow this rule:

- Header: global tools only.
- Sidebar: documentation navigation.
- Main: reading content.

The header keeps:

- OPUS FRAMEWORK / Reference Book brand.
- Search.
- Theme selector.
- Language selector.

The sidebar contains:

- Search.
- API Reference.
- Documentation assets.
- Legal information.
- Download / install.
- Guides.
- Domains.

The sidebar must be readable, sticky on desktop, and responsive on smaller screens.

## Theme decision

The visible theme family becomes four low-glare seasons:

| Theme | Contract |
|---|---|
| `winter` | Equivalent to the current Night theme. |
| `summer` | Equivalent to the current Ocean theme. |
| `spring` | New pastel mauve / dark lavender theme. |
| `autumn` | Warm amber / copper / soft brown theme. |

`paper` must not remain exposed as a visible UI theme because it is too white and too contrasted for the desired OPUS RefBook identity.

Legacy theme aliases may exist only as explicit compatibility mapping if needed.

## Consequences

- P116C5H updates `OPUS_REF_BOOK` layout and CSS, not OPUS core.
- ScoreTemplate remains the official view template layer.
- Twig must not return.
- The RefBook remains transitional until migrated into `OPUS/packages/opus-refbook`.
- After P116C5H, the next step is content quality and migration preparation.
