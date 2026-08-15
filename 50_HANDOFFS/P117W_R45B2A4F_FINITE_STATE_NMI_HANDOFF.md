# P117W R45B2A4F — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96`

## Delivery

Artifact: `opus_p117w_r45b2a4f_finite_state_nmi.zip`
SHA-256: `e2594b33b7e7881b3586a613af538adc490c9e89c35530910759a18fe4a737df`

ZIP entry:

- `tools/apply_p117w_r45b2a4f_finite_state_nmi.php`

## Semantic result

- `states[]` is the only FSM state domain;
- `*` cannot be a state;
- normal `from:"*"` is forbidden;
- only `from:"*", interrupt:"nmi"` is accepted;
- NMI is explicit, guardless and preemptive;
- OPUS diagram shows an NMI rail labelled `NMI`, never a star/state;
- new generated sites contain only finite explicit normal sources;
- existing generated application FSMs are migrated locally from legacy global sources to finite explicit source transitions;
- OWASYS front: `auth_required` = NMI;
- OWASYS back: `fail` = NMI;
- OWASYS principal graph shows outgoing transitions from the current state rather than a fake global source.

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4f_finite_state_nmi.zip"
php tools\apply_p117w_r45b2a4f_finite_state_nmi.php
composer dump-autoload -o

php -l Opus\Fsm\FsmProcessor.php
php -l Opus\Fsm\Diagram.class.php
php -l Opus\Scaffold\SiteScaffoldPlan.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
```

Expected runner output:

```text
OPUS_P117W_R45B2A4F_APPLY_OK
FSM_STATE_DOMAIN=FINITE_DECLARED_ONLY
FSM_GLOBAL_SOURCE=NMI_ONLY
FSM_NMI=EXPLICIT_NON_MASKABLE_PREEMPTIVE
FSM_NORMAL_NAVIGATION=FINITE_SOURCE_RELATION
OWASYS_DIAGRAM=CURRENT_STATE_OUTGOING_TRANSITIONS
OWASYS_FRONT_NMI=auth_required
OWASYS_BACK_NMI=fail
MIGRATED_GENERATED_SITES=<list-or-none>
```

Then validate:

```cmd
composer opus:dev-server -- owasys-front
```

and the generated preview already in use, for example:

```cmd
composer opus:dev-server -- essai2 --port=8002
```

## Acceptance

OWASYS principal FSM must no longer display a star pseudo-state or a global wildcard bus. Every visible edge must originate from the currently highlighted finite state and carry a real signal id. NMI must not appear as a navigation state.

Existing generated application preview must remain functional after migration.

After validation remove the temporary runner before OPUS commit:

```cmd
del tools\apply_p117w_r45b2a4f_finite_state_nmi.php
git status --short
```

No OPUS/OWASYS commit or push is performed by the assistant.
