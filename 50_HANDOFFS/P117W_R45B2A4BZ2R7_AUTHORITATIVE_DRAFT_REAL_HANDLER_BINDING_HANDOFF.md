# P117W R45B2A4BZ2R7 — Authoritative draft + real handler binding handoff

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## OPUS baseline

`6a5926f2fccb0cbaa5bacba803bdfd18af1cf40e`

## Artifact

`opus_p117w_r45b2a4bz2r7_authoritative_handler_binding.zip`

ZIP SHA-256:

`72b311a35252ab73eefbe4ee1abeadaca6ef3d9366833bc5b19abe51b6e47072`

Applicator SHA-256:

`f066e48d162f53df67ba843b111a38823b82dfc61c0aaf927dd1626f8aaf93c1`

The ZIP contains one differential applicator script: `apply_a4bz2r7.php`.

The applicator requires exactly the clean OPUS baseline above and never commits/pushes OPUS/OWASYS.

## Result after application

Ten paths change:

- `Opus/Fsm/Definition/FsmDefinitionEditor.php`
- `sites/owasys-front/application/default/bootstrap.php`
- `sites/owasys-front/application/default/services/FsmActionHandlers.php`
- `sites/owasys-front/application/default/services/FsmGuardHandlers.php`
- `sites/owasys-front/application/default/services/FsmHandlerCatalog.php` (new)
- `sites/owasys-front/application/default/services/FsmDesignerGateway.php`
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/js/fsm-designer.js`
- `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`

No JavaScript is added to the backend.

## Root-cause correction

R6 still transported the browser-held full draft definition. R7 removes that authority.

The backend now reconstructs every non-persistent draft from:

`canonical fsm.json + semantic command history + current semantic command`.

`draft_json` remains only as an empty `{}` transport sentinel for compatibility with the existing REST operation catalog and is rejected if it contains any browser definition.

This prevents arbitrary browser-side definition mutation from being carried into an otherwise valid semantic command.

## Handler semantics delivered

The designer receives a server-derived catalog of the real PHP guard/action registrations.

`FsmActionHandlers::handlerNames()` and `dispatcher()` use the same internal handler map, so the displayed action catalog and runtime dispatcher cannot silently diverge.

`FsmGuardHandlers::handlerNamesForConfig()` derives names from the same `forConfig()` map used at runtime, including dynamically registered ACL guards.

The generic editor adds `transition.handlers.update` and accepts only ordered guard/action IDs present in the authoritative catalog. Unknown handlers and duplicates are rejected. NMI guards remain forbidden. Source, signal, target and native runtime operations are untouched.

The browser can select/reorder/remove real registered guards/actions on an existing transition. It cannot create a dangling handler string.

Real PHP handler authoring is deliberately the next slice; R7 does not pretend that binding an ID creates developer code.

## Validation performed before delivery

- `php -l` passed for every final PHP target;
- `node --check` passed for final `fsm-designer.js`;
- generic editor runtime test: ordered guards/actions preserved;
- generic editor runtime test: unknown guard rejected;
- generic editor runtime test: unknown action rejected;
- generic editor runtime test: duplicate handler rejected;
- generic editor runtime test: NMI guard rejected;
- R6 state-field restriction retested: injected `route` rejected;
- backend provider integration fixture: canonical + semantic history replay rebuilt the draft correctly;
- backend provider integration fixture: browser-authored non-empty `draft_json` rejected;
- backend provider integration fixture: state-field smuggling through history rejected;
- actual handler-map fixture: action catalog names come from the dispatcher handler map;
- actual handler-map fixture: guard catalog names come from application + dynamic ACL handler map;
- static test: browser JS contains no `draft_json` submission and uses `history_json`;
- static test: transition editor contains GUARD/ACTION binding and no module/route state fields;
- applicator fixture: exactly ten changed paths produced;
- applicator fixture: all generated PHP preflight lints passed;
- applicator fixture: generated JS passed `node --check`;
- applicator fixture: second application refused with exit code 20.

These checks exercise the transformation and the critical semantic/security path but do not replace owner validation on the real `H:\OPUS` checkout.

## Expected applicator marker

`P117W_R45B2A4BZ2R7_APPLIED`

Additional markers:

- `draft_authority=canonical_plus_semantic_replay`
- `handler_catalog=real_php_registrations`
- `transition_handlers=ordered_guard_action_binding`
- `handler_authoring=pending_next_slice`
- `changed_files=10`

## Owner validation

After application:

1. lint changed PHP files;
2. `node --check` the designer JS;
3. regenerate Composer autoload;
4. validate `owasys-front` and `owasys-back`;
5. verify designer opens and handler catalog loads;
6. select an existing transition and edit ordered GUARD/ACTION bindings;
7. verify only real handlers are selectable;
8. verify NMI guards cannot be assigned;
9. verify STATE remains R6-pure;
10. verify draft edits do not modify canonical `config/fsm.json`;
11. inspect `git status --short` and commit/push only after owner validation.

## Next slice

Implement real developer PHP authoring for GUARD/ACTION from the designer, with registration and validation through front -> REST -> back -> Composer, without adding application semantics to the generic EFSM processor.
