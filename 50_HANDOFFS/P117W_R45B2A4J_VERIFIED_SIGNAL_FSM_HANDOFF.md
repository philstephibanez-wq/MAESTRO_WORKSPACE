# P117W R45B2A4J — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Attested OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`

## Root cause established by A4I

The owner checkout actually executing OWASYS is a clean R45B2A4E tree. A4F/A4G/A4H markers are absent from source, while the A4E renderer marker is present. Therefore the previously reported unchanged UI was not evidence against the signal-driven design; the relevant source changes were simply not present in the executed checkout.

The A4I `$PID` PowerShell assignment is a diagnostic-only bug in the listener subsection. A4J verifier fixes it with `$ownerPid`.

## Delivery

Artifact: `opus_p117w_r45b2a4j_verified_signal_fsm.zip`
SHA-256: `abcfb7cbeeb571566649e3ff1a2970e8333b857315ec7da3d199907f4ab655a6`

Entries:

- `tools/apply_p117w_r45b2a4j_verified_signal_fsm.php`
- `tools/VERIFY_P117W_R45B2A4J_APPLIED.cmd`

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4j_verified_signal_fsm.zip"
php tools\apply_p117w_r45b2a4j_verified_signal_fsm.php
```

Do not continue if the runner reports any `HEAD_INVALID`, `ATTESTED_SHA_MISMATCH`, `ANCHOR_INVALID`, `REQUIRED_DIFF_MISSING` or other failure.

Expected successful prefix:

```text
OPUS_P117W_R45B2A4J_APPLY_OK
PATCH_ROOT=H:/OPUS
FSM_INTERACTION=SIGNAL_DRIVEN
FSM_TARGET_STATES=PASSIVE
FSM_SIGNAL_CONTROLS=CURRENT_STATE_OUTGOING_GET_SIGNALS
FSM_EDGE_SIGNAL_LINKS=ENABLED
FSM_STATE_DOMAIN=FINITE_DECLARED_ONLY
FSM_GLOBAL_SOURCE=NMI_ONLY
FSM_UI_REVISION=P117W_R45B2A4J
CSS_CACHE_KEY=p117w-r45b2a4j
GIT_REQUIRED_DIFFS=11/11
GIT_WORKTREE=DIRTY_AS_EXPECTED
```

The runner must then print a non-empty status block:

```text
GIT_STATUS_BEGIN
...
GIT_STATUS_END
```

At that point Fork must show local changes. If Fork remains clean despite `GIT_WORKTREE=DIRTY_AS_EXPECTED`, stop immediately and report both the runner output and Fork screenshot.

Then:

```cmd
composer dump-autoload -o
php -l Opus\Fsm\FsmProcessor.php
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Scaffold\SiteScaffoldPlan.php
php -l Opus\Console\Service\SiteCommandService.php
php -l sites\owasys-front\application\default\bootstrap.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
```

Stop the previous OWASYS server, then start the patched checkout:

```cmd
composer opus:dev-server -- owasys-front
```

In a second terminal:

```cmd
tools\VERIFY_P117W_R45B2A4J_APPLIED.cmd
```

Required verifier markers:

```text
FSM_FINITE_SOURCE=PRESENT
FSM_UI_REVISION=PRESENT
FSM_SIGNAL_CONTROL=PRESENT
FSM_TRANSITION_LINKS=PRESENT
FSM_CSS_REVISION=PRESENT
FSM_SIGNAL_CONTROL_CSS=PRESENT
FSM_HTTP_CONTRACT=PRESENT
HTTP_SIGNAL_CONTROL_CSS=PRESENT
```

The HTTP header section should include:

```text
X-Owasys-Fsm-Ui-Contract: signal-driven-a4j
```

## Visible acceptance

On `/fr-FR/applications` or another authenticated principal page:

- visible badge `signal-driven · A4J`;
- state rectangles passive;
- current state is displayed as context;
- outgoing route-backed signals are rendered as controls, for example `open_data → Sources de données`;
- SVG edge signal labels are clickable when route-backed;
- no normal `*` pseudo-state;
- NMI remains outside the principal navigation controls;
- signal inventory remains auditable.

Generated preview such as `essai2` must remain executable because legacy generated FSM global normal transitions found locally are migrated to finite explicit sources.

After owner validation only:

```cmd
del tools\apply_p117w_r45b2a4j_verified_signal_fsm.php
del tools\VERIFY_P117W_R45B2A4J_APPLIED.cmd
git status --short
```

The assistant does not commit or push OPUS/OWASYS. Owner validates and then commits/pushes.
