# P117W R45B2A4BB — Handoff

State: OWNER COMMITTED/PUSHED — PARTIAL RUNTIME VALIDATION — A4BC FOLLOW-UP

## Owner commit

OPUS owner commit/push:

`0f1356ee479336202518b253836f5a48bdc098af` — `opus_p117w_r45b2a4bb_application_fsm_resource_surface`

A4BB is therefore the exact owner baseline for A4BC.

## Accepted architecture

The governing definition remains:

**workflow = FSM**.

- OWASYS FSM = workflow of the developer operating OWASYS.
- Selected application FSM = workflow of the application being developed.
- These are two distinct machines.
- A standalone OWASYS module named `Workflows` is semantically wrong.
- The selected application's FSM must be visible in OWASYS and in the generated application's development environment.

Generated applications already receive `config/application.fsm.json` and the generated runtime already renders that FSM, so A4BB reuses the existing OPUS FSM architecture.

## A4BB delivered behavior

`Workflows` became **FSM**:

- module `fsm`;
- canonical route `fsm`;
- label/title `FSM`;
- signal `open_fsm`;
- transition `g_open_fsm`;
- ACL resource `fsm`.

The internal state id `workflows` was intentionally retained temporarily for compatibility with existing `OPUS_FSM_RUNTIME_SNAPSHOT_V1` sessions. It is only a migration identifier; the visible semantic is FSM.

The old localized Workflows paths remain compatibility aliases to the canonical `/fsm` route.

A4BB also added the selected-application FSM read surface through the existing secured path:

`owasys-front -> REST -> owasys-back -> Composer/source-read -> response -> owasys-front`.

No direct target-application filesystem read was added to `owasys-front`.

## Runtime evidence received after owner commit

Owner screenshot confirms that `FSM` now replaces `Workflows` in the top navigation.

The same screenshot exposes a separate menu-projection defect:

- internal creation states remain permanent menu items (`Application`, creation `Sécurité`, `Récapitulatif`, `Créer l'application`, `Création impossible`, `Résultat généré`);
- current-app modules are rendered disabled while no current application exists instead of being absent;
- `Connexion` remains a permanent item after authentication.

This is not an A4BB FSM-resource defect. It is the next projection defect and is handled by A4BC.

No claim is made here that every A4BB FSM-resource runtime acceptance point has been exercised; only owner commit/push and the visible `FSM` replacement are evidenced.

## Original A4BB delivery

Artifact:

`opus_p117w_r45b2a4bb_application_fsm_resource_surface.zip`

SHA-256:

`6bd7eb8a80c05761b8688018f601821898d53c0b15b3f1accf5641a8e0b6e7e8`

Exactly 33 complete files were delivered, including the FSM model/template, 25 locale catalogs, and required front configuration/routing/ACL changes.

## Follow-up

A4BC corrects only the navigation projection:

- internal workflow/result states stay in the canonical FSM and diagram but leave the permanent menu;
- modules requiring a current application are absent until one exists;
- after application selection or creation, every ACL-allowed permanent application module is visible;
- login is not a permanent item once authenticated.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
