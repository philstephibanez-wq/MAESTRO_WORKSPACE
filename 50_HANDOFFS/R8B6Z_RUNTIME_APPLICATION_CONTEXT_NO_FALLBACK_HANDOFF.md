# Handoff — R8B6Z Runtime Application Context / NO FALLBACK

Baseline OPUS: `86c40c9bf1a782fc7d5d76e2436298c40c2e82c4` plus owner-applied R8B6Y.

Blocking evidence:
- `/fr-FR/application` -> 500.
- `OWASYS_CONTEXT_RUNTIME_EFSM_UNKNOWN` in front log, `ContextRuntimeCoordinator.php:35`, trace `bcccfe4938f164d6d02cd6b3d18cf49a`.
- Menu labels collapse to missing markers after strict exact-locale mode because `application/default/local/fr-FR.json` contains only a sparse overlay.

R8B6Z scope:
1. Make Application a selected-application navigation context in the runtime coordinator, never an OWASYS host EFSM.
2. Materialize a complete exact `fr-FR` default catalog so French UI needs no base-language fallback.
3. Preserve R8B6Y ownership isolation and exact-only locale behavior.

Do not commit/push OPUS until owner runtime acceptance.
Next global slice after acceptance: complete exact regional catalogs for every active locale; remove all fallback declarations/policies/resolvers and add blocking audit gates.
