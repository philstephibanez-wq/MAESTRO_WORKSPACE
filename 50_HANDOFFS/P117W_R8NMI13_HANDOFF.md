# P117W R8NMI13 — Handoff

Status: awaiting owner validation
Date: 2026-09-07

## Evidence

- `owasys-front/config/fsm.json` contains canonical NMI transitions including `critical_error -> fault` and `security_violation -> security_quarantine`.
- `owasys-back/config/fsm.json` contains canonical NMI transitions including `fail -> fault` and `security_violation -> security_quarantine`.
- The current host projection in `OwasysFsmDiagramBuilder::build()` explicitly skipped all `interrupt: nmi` transitions and projected only menu-visible states.

## R8NMI13 change

The host projection now:

1. validates canonical NMI transitions;
2. adds pure NMI target states to the projected state set;
3. includes NMI transitions in the diagram;
4. preserves all ordinary transition filtering/routing;
5. keeps backend rendering/UI prohibited: visualization remains front-side.

## Owner validation gate

Before runtime testing:

- verify ZIP SHA-256;
- verify exact ZIP contents;
- extract to `H:\OPUS`;
- PHP lint the changed file;
- run `git diff --check` and inspect the exact diff/status.

Stop on any unexpected pre-existing change or SHA mismatch.

Runtime acceptance after the gate:

- OWASYS front host diagram shows NMI source and target control states;
- normal transitions remain present;
- application-context diagrams such as `essai` remain unchanged;
- backend source continues to contain no JavaScript/UI changes.

No OPUS/OWASYS commit/push until acceptance.
