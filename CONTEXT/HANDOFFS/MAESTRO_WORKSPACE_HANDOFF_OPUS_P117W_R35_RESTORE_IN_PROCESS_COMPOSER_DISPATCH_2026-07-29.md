# MAESTRO WORKSPACE handoff — OPUS P117W R35

Date: 2026-07-29

## Decision

R35 restores the R32 in-process Composer dispatch configuration that was no longer active after the R34 restart. The FSM R34 remains unchanged and authoritative.

## Source of truth

```text
Repository: philstephibanez-wq/OPUS
Branch: master
Base: 47c5bb1d667a43a61ae35ec3465accc29d42f54c
Prerequisites: R31 + R32 + R33 + R34
```

## Runtime evidence

```text
Before regression:
source.list 239–255 ms in_process
source.read 39 ms in_process

After regression:
source.list 3.48–3.66 s external process
source.read 3.11–3.23 s external process
one Source page with a selected file: approximately 6.8–7.2 s
```

## Delivery

```text
ZIP: opus_p117w_r35_restore_in_process_composer_dispatch.zip
SHA-256: 81613a0b14ed8d0df55393ff4ceac2abca14bf44bbef0ac74f57c3762a83c92c
Files: 1
```

The only delivered file is `sites/owasys-back/config/backend.rest.json`. Its contract is `OPUS_REST_API_SERVER_CONFIG_V1`, it declares 14 REST resources, and `composer_command` is exactly `["@in-process"]`.

## Validation

Restart owasys-back after extraction. A Source request must log `script.succeeded` with `execution_mode: in_process`; `command.succeeded` must not appear for that request.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
