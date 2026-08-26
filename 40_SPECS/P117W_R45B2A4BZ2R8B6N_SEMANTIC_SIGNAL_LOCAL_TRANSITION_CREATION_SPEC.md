# P117W R45B2A4BZ2 R8B6N — Semantic signal and local transition creation — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS exact baseline/master: `40b28ad8c939236b2af4f9bec77b242ed4325eed`.
- R8B6M signal-card framing is owner runtime accepted and pushed.

## Missing capability

State creation is persistent and functional, but the designer exposes no SIGNAL creation surface and deliberately disables TRANSITION creation. The generic OPUS definition editor likewise rejects both semantic operations as unknown.

## Contract

R8B6N adds two atomic semantic operations:

- `signal.create`: unique canonical signal ID, mandatory origin `user|automatic`, and mandatory type `navigation|command|outcome|event|system`;
- `transition.create`: unique local-transition ID, existing source state, existing canonical signal and existing target state.

Both commands:

- are authored through SCORE and the existing designer JavaScript;
- send only bounded semantic commands, never a browser-authored FSM definition;
- pass through owasys-front → secured REST → owasys-back;
- are applied and fully validated by `FsmDefinitionEditor`;
- are persisted atomically through `SiteSourceWorkspace`;
- require empty draft history and optimistic canonical source hash;
- reload from the resulting canonical FSM after success.

The transition form lists only canonical states and signals. Global/NMI transition creation, rename and delete remain outside this increment.

## Exact surface

- `Opus/Fsm/Definition/FsmDefinitionEditor.php`;
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
- `sites/owasys-front/www/asset/js/fsm-designer.js`.

## Acceptance

In `essai` Navigation Conception:

1. create a signal such as `open_test` with origin `user` and type `navigation`;
2. create a transition from `home` using `open_test` to `test`;
3. confirm reload renders the transition and card;
4. confirm `config/application.fsm.json` contains exactly one new signal and transition;
5. confirm site validation for owasys-front, owasys-back and essai.
