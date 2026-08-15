# P117W R45B2A4H — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Committed OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`
Runner accepts: R45B2A4E, locally-applied R45B2A4F, or locally-applied R45B2A4G

## Reason for this delivery

The owner reports no visible change after R45B2A4F/R45B2A4G. Because R45B2A4G rewrites the actual SCORE FSM partial, validation can no longer rely on visual observation alone. R45B2A4H makes the source tree and served tree attestable.

## Delivery

Artifact: `opus_p117w_r45b2a4h_source_attested_signal_fsm.zip`
SHA-256: `a35a2c229d12820a3c5246271fbca51caeb852165469e52b625f4c7df253520a`

ZIP entry:

- `tools/apply_p117w_r45b2a4h_source_attested_signal_fsm.php`

## Functional result

- FSM interaction is signal-driven;
- target states are passive;
- current state is the command context;
- outgoing route-backed signals are clickable;
- edge signal labels are clickable when backed by the same local GET route;
- normal global state source is forbidden;
- explicit NMI remains the sole global exception;
- current-state signal surface is always visible;
- visible revision badge: `signal-driven · A4H`;
- CSS cache key: `p117w-r45b2a4h`.

## Source attestation

The runner refuses a CWD/root mismatch and prints:

```text
PATCH_ROOT=<resolved OPUS root>
FSM_UI_REVISION=P117W_R45B2A4H
FSM_PARTIAL_SHA256=<sha256>
FSM_CSS_SHA256=<sha256>
FSM_RENDERER_SHA256=<sha256>
```

`composer opus:dev-server -- owasys-front` must additionally print:

```text
OPUS_DEV_SERVER_APPLICATION:owasys-front
OPUS_DEV_SERVER_ROOT:<root>
OPUS_DEV_SERVER_SITE_ROOT:<root>/sites/owasys-front
OPUS_DEV_SERVER_PUBLIC_ROOT:<root>/sites/owasys-front/www
OPUS_DEV_SERVER_ROUTER:<root>/sites/owasys-front/www/index.php
OPUS_DEV_SERVER_SOURCE_FINGERPRINT:<20 hex chars>
OPUS_DEV_SERVER_URL:...
```

HTTP page responses from that development server expose:

```text
X-Opus-Source-Fingerprint: <same 20 hex chars>
X-Owasys-Fsm-Ui-Contract: signal-driven-a4h
```

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4h_source_attested_signal_fsm.zip"
php tools\apply_p117w_r45b2a4h_source_attested_signal_fsm.php
composer dump-autoload -o

php -l Opus\Fsm\FsmProcessor.php
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Scaffold\SiteScaffoldPlan.php
php -l Opus\Console\Service\SiteCommandService.php
php -l sites\owasys-front\application\default\bootstrap.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
```

Expected runner prefix:

```text
OPUS_P117W_R45B2A4H_APPLY_OK
PATCH_ROOT=H:/OPUS
FSM_INTERACTION=SIGNAL_DRIVEN
FSM_TARGET_STATES=PASSIVE
FSM_SIGNAL_CONTROLS=CURRENT_STATE_OUTGOING_GET_SIGNALS
FSM_EDGE_SIGNAL_LINKS=ENABLED
FSM_STATE_DOMAIN=FINITE_DECLARED_ONLY
FSM_GLOBAL_SOURCE=NMI_ONLY
FSM_UI_REVISION=P117W_R45B2A4H
CSS_CACHE_KEY=p117w-r45b2a4h
```

Then stop any previously running development server on the intended port and start:

```cmd
composer opus:dev-server -- owasys-front
```

The output root must be `H:/OPUS` (Windows slash representation may vary) if `H:\OPUS` is the patched checkout.

From a second terminal, verify the response contract using the URL printed by the server, for example:

```cmd
curl -I http://127.0.0.1:8000/fr-FR/build
curl -s http://127.0.0.1:8000/fr-FR/build | findstr /c:"P117W_R45B2A4H" /c:"ow-fsm-signal-control" /c:"signal-driven"
```

Acceptance requires:

1. the Composer root and patch root identify the same checkout;
2. `X-Owasys-Fsm-Ui-Contract: signal-driven-a4h` is present;
3. the page contains `P117W_R45B2A4H`;
4. the visible FSM area shows the `signal-driven · A4H` badge;
5. target-state rectangles are not the command surface;
6. outgoing signals are the command surface.

If 1-3 fail, the problem is definitively the served checkout/process/root rather than SVG/CSS semantics.

After acceptance:

```cmd
del tools\apply_p117w_r45b2a4h_source_attested_signal_fsm.php
git status --short
```

The assistant does not commit or push OPUS/OWASYS. Owner validates, removes the runner, then commits/pushes OPUS.