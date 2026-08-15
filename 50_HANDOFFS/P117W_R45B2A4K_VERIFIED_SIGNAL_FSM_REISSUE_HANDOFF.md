# P117W R45B2A4K — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Attested OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`
Supersedes failed A4J artifact.

## A4J owner failure

Owner command:

```cmd
php tools\apply_p117w_r45b2a4j_verified_signal_fsm.php
```

failed during pre-write lint with:

```text
PHP Parse error: syntax error, unexpected token "," ... line 848
OPUS_P117W_R45B2A4J_LINT_FAILED:Opus/Fsm/Diagram.class.php
```

No OPUS source/config write should have occurred because A4J performs all patched-PHP lints before its write phase.

Root cause: one malformed A4J runner nowdoc terminator in `diagram.raw_transition_id`: opened as `NEW`, accidentally terminated as `OLD`, causing the following replacement program to be embedded into generated `Diagram.class.php`.

A4K fixes that exact construction defect. Static runner audit: `NOWDOC_BLOCKS=58`, `NOWDOC_SUSPICIOUS=[]`. The A4K runner itself passes `php -l`.

## Delivery

Artifact: `opus_p117w_r45b2a4k_verified_signal_fsm.zip`
SHA-256: `3e485c28f93adaf20d1071ba9ea65e08917089a23fab3d3b3fb01fb2b1b56662`

Entries:

- `tools/apply_p117w_r45b2a4k_verified_signal_fsm.php`
- `tools/VERIFY_P117W_R45B2A4K_APPLIED.cmd`

## Owner commands — first gate only

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4k_verified_signal_fsm.zip"
php tools\apply_p117w_r45b2a4k_verified_signal_fsm.php
```

Stop on any error. On success the output must include:

```text
OPUS_P117W_R45B2A4K_APPLY_OK
PATCH_ROOT=H:/OPUS
FSM_INTERACTION=SIGNAL_DRIVEN
FSM_TARGET_STATES=PASSIVE
FSM_SIGNAL_CONTROLS=CURRENT_STATE_OUTGOING_GET_SIGNALS
FSM_EDGE_SIGNAL_LINKS=ENABLED
FSM_STATE_DOMAIN=FINITE_DECLARED_ONLY
FSM_GLOBAL_SOURCE=NMI_ONLY
FSM_UI_REVISION=P117W_R45B2A4K
CSS_CACHE_KEY=p117w-r45b2a4k
GIT_REQUIRED_DIFFS=11/11
GIT_WORKTREE=DIRTY_AS_EXPECTED
```

The runner must print a non-empty `GIT_STATUS_BEGIN ... GIT_STATUS_END` block. At that point Fork must show the tracked changes.

Only after that gate passes:

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

Then stop the previous OWASYS process and start:

```cmd
composer opus:dev-server -- owasys-front
```

Second terminal:

```cmd
tools\VERIFY_P117W_R45B2A4K_APPLIED.cmd
```

Visible acceptance remains signal-driven: current state is context; destination states are passive; outgoing GET-backed signals are controls; no normal `*` pseudo-state; NMI remains out-of-band.

Assistant does not commit or push OPUS/OWASYS. Owner validates, removes temporary tools, then commits/pushes.
