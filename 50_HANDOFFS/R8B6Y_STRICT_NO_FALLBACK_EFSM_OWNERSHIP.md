# R8B6Y — Handoff

Status: BLOCKER under active correction.

Authoritative OPUS baseline observed: `a227509d53c0296e01b698c0e6678420eb1128a1`.

## Evidence

- `ContextEfsmRegistry` currently classifies `application` among host EFSMs.
- `FsmDiagramBuilder` and `FsmDesignerGateway` use that classification to target `owasys-front` instead of the selected application.
- `sites/owasys-front/config/application.fsm.json` is contaminated by application-specific identities.
- Historical OWASYS canonical Application context used `unselected` and `selected`.
- `ApplicationFsmModel` contains source-resolution fallback logic.
- OPUS `CatalogLoader` and `Locale::fallbackChain()` implement locale fallback behavior.
- OWASYS front `site.json` still declares `fallback_locale` and other inheritance/mapping policy.

## Mandatory rule

NO FALLBACK. NO SILENT SUBSTITUTION.

Exact application + exact EFSM + exact source + exact locale, or explicit failure.

## Delivery workflow

The owner worktree is known dirty from preceding R8B6V/R8B6X validation. Before R8B6Y is assembled/applied against local work, obtain the exact `git status --short` and `git diff --name-only`. Do not overwrite unknown local modifications.

The R8B6Y native differential ZIP must be verified against the current GitHub baseline and preserve already validated local changes where files overlap.
