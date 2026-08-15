# P117W R45B2A4E — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS base: `554a8ed90ebf51c87632c173223bfabb6b5c6e56`
Previous delivery: R45B2A4D

## Validated observations

R45B2A4D is present in OPUS master as `554a8ed90ebf51c87632c173223bfabb6b5c6e56`.

Owner validation reports:

- native navigation FSM is now translated/menu-synchronized but too large;
- visible edge labels do not prove canonical signal completeness;
- generated application preview fails with `OPUS_GENERATED_RUNTIME_FAILED`.

Repository audit establishes two concrete data/runtime defects in addition to geometry:

1. OWASYS `config/fsm.json` has 42 declared signals but 44 distinct transition signals; `open_source_file` and `change_locale` are used by transitions but absent from `signals[]`.
2. versioned `sites/essai2` has neither `application/default/templates/components/fsm-diagram.score` nor the `common.fsm_diagram` layout slot, while the current generic runtime attempts to render the site-owned component before page composition.

## Delivery

Artifact: `opus_p117w_r45b2a4e_fsm_signal_preview.zip`

SHA-256: `536c1d89b8e116e735d86b6bb29aa6579467398a7fc9e72861d8fd22a1edec85`

ZIP entry:

- `tools/apply_p117w_r45b2a4e_fsm_signal_preview.php`

## Root corrections

- generic `OPUS_FSM_Diagram` receives an opt-in compact geometry mode; default OPUS geometry remains unchanged;
- OWASYS opts into compact mode for the seven-state principal-navigation projection;
- real canonical signal ids become the visible transition labels; translated state labels remain unchanged;
- OWASYS signal registry is corrected to 44/44 by declaring `open_source_file` and `change_locale`;
- `OwasysFsmDiagramBuilder` validates declared/referenced signal equivalence fail-closed;
- SCORE exposes a collapsed `Σ 44/44` canonical signal inventory so internal signals remain auditable without redrawing every state-preserving source/Git transition;
- generated runtime detects the explicit FSM layout slot;
- old generated layouts without the slot skip diagram composition rather than failing;
- FSM-aware generated layouts use the new framework-owned `Opus/Application/Runtime/templates/fsm-diagram.score` wrapper;
- `sites/essai2` itself is not modified.

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4e_fsm_signal_preview.zip"
php tools\apply_p117w_r45b2a4e_fsm_signal_preview.php
composer dump-autoload -o

php -l Opus\Fsm\Diagram.class.php
php -l Opus\Application\Runtime\GeneratedSiteRuntime.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
```

Expected runner output:

```text
OPUS_P117W_R45B2A4E_APPLY_OK
FSM_LAYOUT=COMPACT_EXPLICIT
FSM_EDGE_LABELS=REAL_SIGNAL_IDS
FSM_SIGNAL_REGISTRY=44/44
GENERATED_PREVIEW=FRAMEWORK_OWNED_FSM_COMPONENT
LEGACY_LAYOUT=CAPABILITY_DETECTED
```

Then validate OWASYS:

```cmd
composer opus:dev-server -- owasys-front
```

Validate the selected generated app preview through OWASYS again. If a direct independent check is required:

```cmd
composer opus:dev-server -- essai2 --port=8002
```

## Acceptance

OWASYS graph:

- same translated menu nodes/order/current state as before;
- materially smaller than R45B2A4D and approximately desktop-width;
- visible edge labels are `change_app`, `select_app`, `open_data`, `open_structure`, `open_security`, `open_workflows`, `open_source`, `open_build` as applicable to the principal navigation projection;
- description reports `Σ 44/44`;
- expanding the signal inventory exposes all canonical signal ids, including internal source/Git signals;
- `open_source_file` and `change_locale` are present in the registry.

Generated preview:

- `essai2` returns its application UI instead of `OPUS_GENERATED_RUNTIME_FAILED` caused by missing historical FSM SCORE component;
- no file under `sites/essai2` is added or edited by the delivery.

After successful validation, remove the temporary runner before committing OPUS:

```cmd
del tools\apply_p117w_r45b2a4e_fsm_signal_preview.php
git status --short
```

Assistant does not commit or push OPUS/OWASYS. Owner validates, commits and pushes.