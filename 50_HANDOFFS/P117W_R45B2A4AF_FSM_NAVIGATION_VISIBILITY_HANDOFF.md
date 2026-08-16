# P117W R45B2A4AF — Handoff

State: OWNER VALIDATION REQUIRED

## Purpose

Restore the OWASYS development workflow menu after the Account/Password FSM split without deleting or bypassing real FSM states.

## Required baseline

Apply after the current A4AD + A4AE working tree.

A4AF does not replace A4AE renderer/CSS work. It changes only the FSM navigation visibility metadata and the OWASYS menu projection that consumes it.

## Artifact

`opus_p117w_r45b2a4af_fsm_navigation_visibility.zip`

SHA-256:

`368d959635cbafc33bbed32c72e900c3042c6c42c1dc07b644a31e859fe1ed08`

Files:

- `sites/owasys-front/application/default/services/NavigationBuilder.php`
- `sites/owasys-front/application/default/templates/partials/navigation.score`
- `sites/owasys-front/config/fsm.json`

## Resulting projection contract

Top-level OWASYS development menu is exclusively:

- Applications (`registry`)
- Sources de données (`data`)
- Structure (`structure`)
- Sécurité (`security`)
- Workflows (`workflows`)
- Sources et Git (`source`)
- Construction et validation (`build`)

The following remain canonical FSM states but are not top-level development-menu entries:

- Connexion (`login`)
- Compte (`account`)
- Changer le mot de passe (`password`)
- Création d’une application (`creation`)

NavigationBuilder still returns hidden states internally, so FsmDiagramBuilder and current-state actionability retain complete FSM information.

## Validation already executed

- PHP lint NavigationBuilder: success;
- FSM JSON decode: success;
- effective visible order exactly `registry,data,structure,security,workflows,source,build`;
- hidden set exactly `account,creation,login,password`;
- account/password/creation canonical transitions retained;
- SCORE top-level projection checks `item.visible`;
- native exclusive autocollapse retained.

## Owner validation sequence

1. Extract A4AF at `H:\OPUS`.
2. Lint NavigationBuilder.
3. Validate JSON and diff check.
4. Rebuild Composer autoload.
5. Restart owasys-front.
6. Open `/fr-FR/applications`.
7. Confirm the top menu contains only the seven development workflow states.
8. Confirm `Compte`, `Changer le mot de passe`, `Connexion` and `Création` are absent from the top-level development menu.
9. Confirm header `Compte` still opens `/fr-FR/compte`.
10. Confirm Account can still navigate to Password.
11. Confirm diagram still displays the real system/auxiliary states and their transitions.
12. Confirm change_app, logout, cyan actionability, focus and autocollapse remain operational.

Do not mark A4AF complete before owner runtime validation.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.
