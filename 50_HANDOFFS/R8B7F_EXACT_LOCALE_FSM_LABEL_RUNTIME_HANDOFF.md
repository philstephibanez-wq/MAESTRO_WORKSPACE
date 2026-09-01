# R8B7F — Handoff

## Objective

Restore OWASYS front after R8B7E without reintroducing any fallback.

## Change

`FsmDiagramBuilder::applicationCatalogMessages()` must resolve exactly one locale catalog and never call `fallbackChain()`.

## Preservation gate

The existing local change in `sites/owasys-front/config/navigation.fsm.layout.json` is user-authored diagram geometry and must remain unchanged.

## Validation

After applying R8B7F:
1. migration reports `R8B7F_OK`;
2. `php -l` passes on `FsmDiagramBuilder.php`;
3. `git diff --check` passes;
4. OWASYS front no longer fails because of missing `fallbackChain()`;
5. audit no longer finds runtime fallback callers in this path;
6. the layout diff is still present and identical.

No OPUS/OWASYS commit is performed by the assistant.
