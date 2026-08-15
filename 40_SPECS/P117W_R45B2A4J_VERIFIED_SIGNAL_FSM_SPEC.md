# P117W R45B2A4J — Verified signal-driven FSM application

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Attested OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96` (`opus_p117w_r45b2a4e_fsm_signal_preview`)
Previous diagnostic gate: R45B2A4I

## A4I finding

Owner-side attestation proved the real checkout at `H:\OPUS` is a clean R45B2A4E tree:

- `HEAD_SHA=11e62f9d84622b08729b03a2f679f2fffd8e7e96`;
- no local commits versus `origin/master`;
- no changed files versus `origin/master`;
- A4F finite-source marker absent;
- A4G signal-control markers absent;
- A4H revision markers absent;
- A4E renderer cache key present;
- attested SHA-256 values match the A4E working files.

Therefore R45B2A4F/R45B2A4G/R45B2A4H were not present in the checkout that rendered OWASYS. No further functional diagnosis may assume those deliveries were applied.

The A4I PowerShell listener subsection contained one diagnostic-only defect: it attempted to assign to reserved `$PID`. This made the reported process identity unreliable. It does not invalidate the Git/source attestation above.

## A4J delivery rule

A4J is cumulative from the exact attested A4E source and refuses any other HEAD/source fingerprint.

The apply runner validates before write:

- exact Git HEAD `11e62f9d84622b08729b03a2f679f2fffd8e7e96`;
- exact owner-attested SHA-256 for `FsmProcessor.php`, OWASYS FSM partial, builder, renderer and FSM CSS;
- CWD equals resolved OPUS root;
- all targeted PHP results lint before write.

After write, success is forbidden unless all 11 mandatory tracked files are visible in `git diff --name-only` and the worktree is dirty. The runner prints the resulting `git status --short` between explicit markers.

## Functional correction

A4J applies the previously specified semantic and UI corrections directly from A4E:

- finite declared FSM states only;
- normal `from:"*"` forbidden;
- explicit `interrupt:"nmi"` is the sole global-source exception;
- OWASYS front/back global normal transitions are migrated to finite explicit sources;
- already-generated `application.fsm.json` files present locally are migrated to finite explicit sources so previews remain executable;
- future scaffolds generate finite explicit source relations;
- target state boxes are passive in the OWASYS principal FSM surface;
- current finite state is the command context;
- outgoing route-backed GET signals are the clickable controls;
- SVG signal labels may be linked to the same localized GET route;
- non-navigation/internal signals remain canonical in the signal inventory and Profiler;
- NMI remains out-of-band and is not a navigation control;
- visible revision is `P117W_R45B2A4J` / `signal-driven · A4J`;
- CSS cache key becomes `p117w-r45b2a4j`.

## Runtime/source attestation

The generic OPUS dev-server additionally reports resolved root/site/public/router and a source fingerprint. OWASYS development responses expose the corresponding source fingerprint and `X-Owasys-Fsm-Ui-Contract: signal-driven-a4j`.

A corrected verifier is included. Its port-listener PowerShell uses `$ownerPid` rather than reserved `$PID`. It also verifies the actually served static `fsm-native.css`, which does not require an authenticated OWASYS session.

## Mandatory observable acceptance

Immediately after the apply runner succeeds, before restarting any server:

1. `GIT_REQUIRED_DIFFS=11/11`;
2. `GIT_WORKTREE=DIRTY_AS_EXPECTED`;
3. `GIT_STATUS_BEGIN ... GIT_STATUS_END` contains the expected modified files;
4. Fork must therefore show local changes.

After server restart:

- `X-Owasys-Fsm-Ui-Contract: signal-driven-a4j` must be returned;
- served `asset/css/fsm-native.css` must contain `ow-fsm-signal-control`;
- principal FSM surface must show `signal-driven · A4J`;
- state boxes must not be the command surface;
- outgoing signals from the current state must be the command surface;
- no normal `*` pseudo-state may appear.

Artifact: `opus_p117w_r45b2a4j_verified_signal_fsm.zip`
SHA-256: `abcfb7cbeeb571566649e3ff1a2970e8333b857315ec7da3d199907f4ab655a6`

ZIP entries:

- `tools/apply_p117w_r45b2a4j_verified_signal_fsm.php`
- `tools/VERIFY_P117W_R45B2A4J_APPLIED.cmd`
