# P112Q3E3A — ASAP RefBook Routing live-symbol fix

Target root: `H:\ASAP`

## Role

Align the P112Q3E3 Routing RefBook metadata contract with the real ROUTING domain discovered at runtime.

## Scope

This patch annotates the five ROUTING symbols detected by the strict report but not covered by the initial P112Q3E3 baseline:

- `ASAP\Routing\AttributeRouteProvider`
- `ASAP\Routing\ClassIndex`
- `ASAP\Routing\Route`
- `ASAP\Routing\RouteCompilerException`
- `ASAP\Routing\RouteManifestCompiler`

It also updates the Routing contract test and smoke to cover the real live surface.

## Contract

- Reflection remains the technical source of truth.
- Attributes remain the functional RefBook source of truth.
- No silent fallback is introduced.
- No generated `var/` artifact is included.
