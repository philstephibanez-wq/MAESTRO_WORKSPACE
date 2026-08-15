# P117W R45B2A4G — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS committed base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`
Runner accepts: R45B2A4E or locally-applied R45B2A4F

## Owner observation incorporated

The FSM interaction must be driven by signals attached to the current state, not by clicking destination state boxes.

## Delivery

Artifact: `opus_p117w_r45b2a4g_signal_driven_fsm_ui.zip`
SHA-256: `35c5ec12e2bd5e7ae6fc82f8f4c5f8dc7a24dcee98a5ac9cedf07f8c55f79939`

ZIP entry:

- `tools/apply_p117w_r45b2a4g_signal_driven_fsm_ui.php`

## Resulting interaction contract

- finite states are passive;
- current state is the context;
- outgoing route-backed signals are the clickable controls;
- technical signal ids remain visible;
- translated destination labels remain visible as consequences, not commands;
- SVG transition signal labels are clickable;
- destination state boxes are not linked by OWASYS;
- non-GET/internal signals remain canonical in the 44/44 inventory and Profiler;
- explicit NMI is out-of-band and never a navigation control;
- no JavaScript is introduced.

## Cumulative finite-state contract

The delivery also enforces the previous R45B2A4F semantic correction even if it was not committed:

- normal `from:"*"` is forbidden;
- `from:"*", interrupt:"nmi"` is the sole global exception;
- normal legacy global transitions are expanded across finite declared sources;
- generated application FSMs already present locally are migrated;
- new scaffolds generate finite source relations;
- `auth_required` front and `fail` back are the explicit OWASYS NMIs.

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4g_signal_driven_fsm_ui.zip"
php tools\apply_p117w_r45b2a4g_signal_driven_fsm_ui.php
composer dump-autoload -o

php -l Opus\Fsm\FsmProcessor.php
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Scaffold\SiteScaffoldPlan.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
```

Expected runner output:

```text
OPUS_P117W_R45B2A4G_APPLY_OK
FSM_INTERACTION=SIGNAL_DRIVEN
FSM_TARGET_STATES=PASSIVE
FSM_SIGNAL_CONTROLS=CURRENT_STATE_OUTGOING_GET_SIGNALS
FSM_EDGE_SIGNAL_LINKS=ENABLED
FSM_STATE_DOMAIN=FINITE_DECLARED_ONLY
FSM_GLOBAL_SOURCE=NMI_ONLY
CSS_CACHE_KEY=p117w-r45b2a4g
MIGRATED_GENERATED_SITES=<list-or-none>
```

Then restart OWASYS front:

```cmd
composer opus:dev-server -- owasys-front
```

Existing generated preview can be validated independently:

```cmd
composer opus:dev-server -- essai2 --port=8002
```

## Visual acceptance

For the current state `Construction et validation` / `build`:

- state box `Applications`, `Sources de données`, etc. must not be the click targets;
- a signal-control strip must appear above the graph;
- each control is a signal such as `change_app`, `open_data`, `open_structure`, `open_security`, `open_workflows`, `open_source` followed by its translated destination;
- clicking a signal must navigate through the existing localized GET route, which resolves back to that FSM signal;
- edge signal labels must also be clickable;
- no `*` pseudo-state may appear;
- NMI is not shown as a navigation state/control;
- signal inventory remains complete.

The stylesheet URL must carry `?v=p117w-r45b2a4g`, preventing the old R45B2A4E visual from surviving through browser cache.

After validation:

```cmd
del tools\apply_p117w_r45b2a4g_signal_driven_fsm_ui.php
git status --short
```

The assistant does not commit or push OPUS/OWASYS. Owner validates, removes the runner, then commits/pushes OPUS.