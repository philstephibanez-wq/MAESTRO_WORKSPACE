# P112Q2C Fix — Recipe Forbidden Token False Positive

## Cause

The P112Q2C migration correctly normalized runtime references from uppercase namespace segments to PascalCase namespace segments.

However, the recipe itself contained the forbidden-token list as plain text. The migration updated that list too, causing the recipe to search for valid modern tokens such as `ASAP\Template`.

## Fix

The recipe now builds forbidden legacy tokens dynamically:

- `ASAP\HELPER`
- `ASAP\MENU`
- `ASAP\TEMPLATE`

The valid modern tokens are no longer flagged.

## Contract

- No fallback path.
- No legacy namespace alias.
- The recipe still scans runtime files for the old uppercase tokens.
