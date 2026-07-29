# OPUS P117W R35 — Restore in-process Composer dispatch

Date: 2026-07-29

## Status

R35 corrects the performance regression observed after applying R34. R31, R32, R33 and R34 remain prerequisites.

## Evidence

The same backend produced two distinct execution modes:

```text
09:26 source.list script.succeeded execution_mode=in_process duration_ms=239.437
09:26 source.read script.succeeded execution_mode=in_process duration_ms=38.572
09:50 source.list command.succeeded duration_ms=3655.189
09:51 source.read command.succeeded duration_ms=3228.223
```

REST, authentication, FSM and response handling remained below approximately 110 ms. The regression is the return to one external Composer process for each REST resource request.

## Contract

OWASYS keeps the required chain:

```text
owasys-front -> secured OPUS REST -> owasys-back -> allow-listed Composer script -> provider
```

The backend resolves the public Composer script from its allow-list and dispatches it through the already-loaded OPUS console runtime. It must not start a new `composer.phar` process for every local REST request.

The explicit backend configuration is:

```json
"composer_command": ["@in-process"]
```

There is no silent fallback to external process execution.

## Scope

The differential changes only:

```text
sites/owasys-back/config/backend.rest.json
```

R35 does not modify the R34 FSM, Source controller, REST resources, ACL, SSO, Logger, Profiler or SCORE.

## Expected result

```text
source.list: script.succeeded + execution_mode=in_process
source.read: script.succeeded + execution_mode=in_process
external command.succeeded: absent for Source requests
```

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
