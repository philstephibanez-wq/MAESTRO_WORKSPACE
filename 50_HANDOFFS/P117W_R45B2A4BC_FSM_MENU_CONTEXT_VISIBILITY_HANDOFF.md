# P117W R45B2A4BC — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`0f1356ee479336202518b253836f5a48bdc098af` — A4BB.

A4BB is owner committed/pushed and is the exact source baseline.

## Owner runtime evidence

Authenticated Applications screen with no current application still shows internal FSM creation states in the permanent top menu, including `Création impossible`, and also shows current-app modules as disabled references.

Owner correction is explicit:

- creation workflow/result states do not belong in the permanent menu;
- after choosing or creating an application, all permanent application menu items must be available in the projection, subject to ACL.

## Root cause

The canonical FSM correctly contains creation workflow/result states, but those states were incorrectly marked `navigation.visible = true`.

In addition, `NavigationBuilder` used configured visibility without applying runtime menu context:

- `requires_current_app` controlled availability but not visibility;
- login stayed visible after authentication.

This is a projection issue, not a reason to delete states/transitions from the FSM or diagram.

## A4BC correction

### Internal FSM states remain canonical, but leave permanent menu

`navigation.visible = false` for:

- `creation_basics`
- `creation_security`
- `creation_review`
- `application_creating`
- `application_creation_failed`
- `application_created`

They remain fully present in the FSM runtime, diagram, profiler and creation controller flow.

### Contextual permanent menu

`NavigationBuilder` now projects configured visibility with runtime context:

- a state requiring current app is absent until a current app exists;
- after selection or creation, every configured-visible ACL-allowed current-app module is visible;
- login is absent after authentication;
- ACL remains authoritative;
- guarded transition actionability remains based on A4AY `inspectTransition()`;
- no transport/type/origin semantic is changed.

## Expected menu

### Not authenticated

`Connexion`

### Authenticated, no app

`Applications | Compte | Changer le mot de passe`

### During creation

Permanent menu remains:

`Applications | Compte | Changer le mot de passe`

The actual creation states remain in the FSM diagram and wizard body controls, not the top menu.

### App selected or just created

`Applications | Sources de données | Structure | Sécurité | FSM | Sources et Git | Construction et validation | Compte | Changer le mot de passe`

Subject only to ACL deny-by-default.

## Files

Exactly two complete files:

1. `sites/owasys-front/config/fsm.json`
2. `sites/owasys-front/application/default/services/NavigationBuilder.php`

## Artifact

`opus_p117w_r45b2a4bc_fsm_menu_context_visibility.zip`

SHA-256:

`93d1ee3c7f36e0adc940422cf1c33c083da32dcd20160840d22ade7678115a0c`

## Source integrity

A4BB Git blobs reproduced exactly before modification:

- FSM: `220b9f83bdd669cbf23e346ded0d94f4ebcb8d7c`;
- NavigationBuilder: `6995b099c7940e782441b7f9527cef2f8996c85d`.

## Pre-delivery validation

- PHP lint: OK;
- JSON parse: OK;
- no trailing whitespace;
- smoke: `A4BC_SMOKE_OK`;
- unauthenticated projection: login only;
- authenticated/no-app projection: registry/account/password only;
- active creation projection: no internal creation state in permanent menu;
- selected-app projection: all nine permanent ACL-allowed items present;
- application-created projection: same complete application menu present;
- no topology or diagram mutation;
- ZIP exactly two complete files plus directories.

## Owner acceptance

1. Apply A4BC on owner HEAD `0f1356ee...`.
2. Relaunch `owasys-front`.
3. On Applications with no current app, confirm no `Connexion`, no creation steps/results, and no disabled Data/Structure/Security/FSM/Source/Build entries.
4. Confirm only `Applications`, `Compte`, `Changer le mot de passe` remain for the authenticated user, subject to ACL.
5. Start the creation wizard and confirm `Application`, creation `Sécurité`, `Récapitulatif`, `Créer l'application`, `Création impossible`, `Résultat généré` never become permanent top-menu items.
6. Select an existing app and confirm the complete application menu appears immediately.
7. Create a new app successfully and confirm the same complete application menu appears immediately.
8. Confirm `FSM` remains the selected-application FSM resource surface introduced by A4BB.
9. Confirm the OWASYS FSM diagram still contains and highlights internal creation states when they are current.
10. Confirm guarded menu signal actionability, signal-origin colors, Security, Sources/Git, Build and Profiler are unchanged.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
