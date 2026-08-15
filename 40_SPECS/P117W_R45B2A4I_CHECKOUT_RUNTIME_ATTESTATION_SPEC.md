# P117W R45B2A4I — Checkout/runtime attestation gate

Status: OWNER EVIDENCE REQUIRED BEFORE NEXT FUNCTIONAL PATCH
Date: 2026-08-15
Published OPUS master: `11e62f9d84622b08729b03a2f679f2fffd8e7e96` (`opus_p117w_r45b2a4e_fsm_signal_preview`)

## Trigger

Owner screenshots after R45B2A4F/R45B2A4G/R45B2A4H still show the A4E-style FSM surface with the `*` global source and no A4H revision marker. Fork shows a clean working tree while the visible commit label is `opus_p117w_r45b2a4f_finite_state_nmi`.

GitHub `master` remains A4E, so GitHub alone cannot identify the owner's current local commit contents.

## Root-cause rule

No additional functional FSM patch may be issued until the checkout actually executed by Composer and the HTTP process serving port 8000 are attested.

This is required by README-FIRST rule 3: treat cause, never effect.

## Attestation deliverable

Artifact: `opus_p117w_r45b2a4i_checkout_runtime_attestation.zip`

Entry:

- `tools/VERIFY_P117W_R45B2A4I_CHECKOUT_RUNTIME.cmd`

The script is read-only. It must not edit OPUS/OWASYS.

## Evidence collected

- resolved script/root path;
- Git top-level path;
- local HEAD SHA and subject;
- `git status --short`;
- local commits/files differing from `origin/master` without fetching;
- presence/absence of A4F finite-state marker in `FsmProcessor.php`;
- presence/absence of A4H signal-driven marker in `fsm-diagram.score`;
- CSS cache/revision marker in `ScorePageRenderer.php`;
- SHA-256 of the current FSM partial, builder and renderer;
- PID/command line listening on TCP 8000;
- HTTP response headers from `127.0.0.1:8000`;
- HTML markers `P117W_R45B2A4H`, `signal-driven`, `ow-fsm-signal-control`.

## Decision gate

- If A4H markers are absent in files: prior delivery was not applied to this checkout; next functional delivery must be based on the proven local HEAD.
- If A4H markers exist in files but not HTTP: the running server/process serves another checkout or stale process; fix dev-server/runtime root before FSM UI work.
- If A4H markers exist in HTTP but visual surface is unchanged: only then continue with renderer/SCORE behavior.

No generated site is manually repaired. No OPUS/OWASYS commit or push is performed by the assistant.