# P117W R45B2A4BZ2R6 — Pure EFSM state designer handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## OPUS baseline

`5b9d9835a864215725d849d8d3d318103192a75c`

## Delivered files

The differential ZIP contains exactly three final-path files:

- `Opus/Fsm/Definition/FsmDefinitionEditor.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/js/fsm-designer.js`

No OPUS/OWASYS commit or push is performed by the assistant.

## Semantic result

STATE editing is now EFSM-only:

- create: ID only;
- rename: identity refactor;
- delete: dependency-safe deletion;
- no generic mutable module/route/template/auth/navigation/diagram fields;
- `state.update` is explicitly rejected as non-semantic.

Existing compatibility metadata already present in legacy OWASYS state records is preserved during rename but is no longer editable from the generic state designer.

The graphical STATE inspector displays only identity/machine-role information plus derived transition connectivity. It no longer displays application routing/module metadata.

## Validation performed before delivery

- `php -l` on final `FsmDefinitionEditor.php`: OK;
- `node --check` on final `fsm-designer.js`: OK;
- unit fixture: pure state create succeeds;
- unit fixture: state create containing `module` is rejected with `OPUS_EFSM_STATE_FIELD_FORBIDDEN:module`;
- unit fixture: legacy `state.update` rejected with `OPUS_EFSM_STATE_UPDATE_NOT_SEMANTIC`;
- unit fixture: rename preserves pre-existing legacy metadata and refactors local/global transition references;
- static check: final STATE form/inspector contains no module/route/template/auth/navigation/diagram editor fields.

These checks do not replace owner validation against the real OPUS checkout.

## Owner validation

After extraction into `H:\OPUS`:

1. lint `FsmDefinitionEditor.php`;
2. regenerate Composer autoload;
3. validate `owasys-front` and `owasys-back`;
4. open the EFSM designer and select a state;
5. verify STATE shows only EFSM identity/role/connectivity;
6. verify Create asks only for ID;
7. verify Rename and Delete still work in draft mode;
8. verify transition selection still displays signal, guards, developer actions and native runtime operations;
9. verify canonical `config/fsm.json` is not modified by draft operations.

## Next slice after owner validation

Proceed to the actual developer EFSM tooling: real guard/action handler catalog and authoring workflow, without putting application semantics back into `FsmProcessor` or STATE records.
