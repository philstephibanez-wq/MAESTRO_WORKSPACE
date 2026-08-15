# P117W R45B2A4I — Handoff

Status: OWNER ATTESTATION REQUIRED
Date: 2026-08-15

## Why A4I exists

The owner still observes the A4E-style FSM after later deliveries. Fork shows no uncommitted changes. GitHub master remains R45B2A4E. Therefore the next root cause to establish is not SVG geometry but which local checkout/commit/process is actually serving OWASYS.

## Delivery

Artifact: `opus_p117w_r45b2a4i_checkout_runtime_attestation.zip`

ZIP entry:

- `tools/VERIFY_P117W_R45B2A4I_CHECKOUT_RUNTIME.cmd`

The script is read-only with respect to OPUS/OWASYS source. It creates only a temporary HTTP body file under `%TEMP%` and deletes it before exit.

## Owner sequence

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4i_checkout_runtime_attestation.zip"
tools\VERIFY_P117W_R45B2A4I_CHECKOUT_RUNTIME.cmd
```

Return the complete console output.

## Required decision

Do not issue another functional FSM patch before reading this output.

A4I distinguishes three cases:

1. local source has no A4H markers -> the prior functional delivery never reached this checkout;
2. local source has A4H markers but HTTP does not -> server/process/root mismatch;
3. local source and HTTP both have A4H markers -> renderer/SCORE behavior remains the real defect.

Only case 3 justifies another FSM UI implementation patch.

No manual generated-site correction is allowed. The assistant does not commit or push OPUS/OWASYS.