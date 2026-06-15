# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P116C5H — OPUS RefBook professional documentation layout.

## Current OPUS RefBook state

Validated runtime state:

- P116C5C: Twig templates removed; MVC + ScoreTemplate direction restored.
- P116C5D: obsolete `twig/twig` Composer/vendor/lock residue purged.
- P116C5F: runtime I18N no longer crashes on `lang=cs`; source metadata language state is explicit.
- P116C5G: boxed `O` removed; visible brand is now `OPUS FRAMEWORK` with subtitle `Reference Book`.

Current UX decision:

- Header must be slim: brand, search, theme selector, language selector.
- Main documentation navigation must move back to a left sidebar.
- Main content must stay readable and centered.
- The horizontal menu is not the final UX.

Theme decision:

- `winter` = current Night.
- `summer` = current Ocean.
- `spring` = mauve pastel / dark lavender.
- `autumn` = warm amber / copper / soft brown.
- `paper` must not remain exposed as a visible theme.

## Active repositories

| Repository | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Canonical coordination layer |
| OPUS | Framework core | Active implementation target |
| OPUS_REF_BOOK | Transitional RefBook repository | Runtime stabilized; P116C5H UX next |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Next safe step

Implement P116C5H in `OPUS_REF_BOOK`:

```text
Header = global tools.
Sidebar = documentation navigation.
Main = reading area.
Themes = winter / summer / spring / autumn.
ScoreTemplate remains the only view template system.
No Twig return.
No silent fallback.
```

After P116C5H is validated, continue toward the controlled migration into `OPUS/packages/opus-refbook`.

## Explicit blockers / unknowns

- Sidebar and seasons themes are not implemented yet.
- OPUS_REF_BOOK remains transitional until migrated into OPUS.
- OPUS_REF_BOOK GitHub metadata still contains old ASAP wording and should be corrected later if repository metadata write access is available.
- Final legal license texts are still not drafted.

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. Priorité : P116C5H — OPUS RefBook pro sidebar + themes saisons. État validé : zéro Twig attendu, Composer purgé, lang=cs OK, branding OPUS FRAMEWORK / Reference Book. GO.
