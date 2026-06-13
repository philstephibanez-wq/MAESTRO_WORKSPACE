# P112Q3E3B — ASAP RefBook Routing self return type test fix

## Target

`H:\ASAP`

## Scope

Correct the P112Q3E3 Routing contract test expectations for Reflection scanner return-type normalization.

## Contract

The scanner output is the technical truth consumed by the RefBook snapshot. In this runtime, methods declared with `self` are exposed by the scanner as their fully-qualified class names:

- `ASAP\Routing\RouteCompilerException::because()` => `ASAP\Routing\RouteCompilerException`
- `ASAP\Routing\Router::fromXml()` => `ASAP\Routing\Router`

No routing runtime logic is modified.
