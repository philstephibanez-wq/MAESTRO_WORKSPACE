# P117W R45B2A4BZ2 R8B6L — Closed menu, framed signals and explicit initial marker — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS exact baseline/master: `636b3cc9d98e33cfbac5dcea58a2188e4e77c8de`.
- R8B6K complete files are carried forward because owner push has not been reported.

## Reported defects

- the active resource operation menu is forced open after every view change;
- horizontal semantic signal labels overflow their visual frames;
- a canonical `entry` initial state suppresses the white initial pseudostate marker.

## Contract

R8B6L corrects the three causes at their shared authorities:

- SCORE no longer emits the native `details[open]` attribute from resource activity; resource selection and operation-menu disclosure are independent;
- horizontal signal cards are sized for the complete `signal [guard] / effect` semantic label, with a real padded frame and vertically centred text;
- every valid canonical `initial_state`, including a state of type `entry`, renders an independent white initial pseudostate and persists it through the V4 marker map.

An entry rectangle remains an actual EFSM state. The white point remains the UML/EFSM initial pseudostate and routes to that rectangle.

## Compatibility

- R8B6K finite-global source-marker persistence is preserved;
- no FSM definition or semantic transition changes;
- no layout schema/version change;
- existing layouts self-extend with the missing initial marker;
- no OWASYS-back source and no backend JavaScript.

## Exact surface

- `Opus/Fsm/Diagram.class.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`;
- `sites/owasys-front/application/default/templates/partials/navigation.score`.

## Acceptance

Across application, security and navigation views, operation menus start closed after navigation. Signal frames fully enclose long labels. The `essai` Navigation diagram renders a white point with an arrow to `begin`; moving and reloading preserve that marker without changing the canonical FSM.
