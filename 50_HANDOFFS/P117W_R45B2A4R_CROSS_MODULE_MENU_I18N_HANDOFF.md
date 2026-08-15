# P117W R45B2A4R — Handoff

State: OWNER VALIDATION REQUIRED

## Context

R45B2A4Q removed the constructor TypeError and exposed the next real failure: `OPUS_I18N_MESSAGE_MISSING` on `/fr-FR/applications`.

Static audit of OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093` shows the cross-module cause:

- current page module: `registry`;
- FSM state `creation`: `navigation.label = creation.title`;
- `creation.title` exists in `application/creation/local`, not in `default + registry`;
- `ScorePageRenderer` translated every menu/target label through the active `registry` runtime.

## R45B2A4R

Artifact: `opus_p117w_r45b2a4r_cross_module_menu_i18n.zip`

SHA-256: `4359ae62234abfa43f4429b49966a889ea94455882cdd75a59791cfea2c59bfe`

Tracked correction:

- `sites/owasys-front/application/default/services/ScorePageRenderer.php`

Behavior:

- page title/summary: active module translator unchanged;
- state menu labels: state module translator;
- signal destination labels: target state module translator;
- module translators cached for the request;
- no global-catalog duplication workaround;
- Menu = FSM remains unchanged.

## Owner validation

1. Apply R45B2A4Q first if its three call-site changes are not already present.
2. Apply R45B2A4R.
3. Runner must report `A4Q_CALLSITES=4/4` and complete all FSM-state/locale translation proofs.
4. Lint `ScorePageRenderer.php`.
5. Restart `owasys-front`.
6. Validate `/fr-FR/applications` first.
7. Validate menu states and signal target labels in at least French plus one additional selectable locale.
8. Validate that states remain contexts and only signals are transition commands.
9. Validate the diagram consumes the same FSM/menu projection.
10. Delete the one-shot runner before OPUS commit.

Do not mark complete before owner validation and OPUS commit/push.