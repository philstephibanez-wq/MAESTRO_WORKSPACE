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
3. assigns pure NMI target states an additional diagram rank rather than the ordinary missing-hint rank 0;
4. includes NMI transitions in the diagram with canonical `from = *` semantics;
5. preserves all ordinary transition filtering/routing and navigation action semantics;
6. keeps backend rendering/UI prohibited: visualization remains front-side;
7. leaves the generic OPUS renderer and `owasys-back` unchanged.

## Delivery integrity

Changed complete file only:

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Authoritative GitHub baseline blob SHA-1:

`dc23e0303bf95e8315a401058343798b83356706`

Baseline file SHA-256:

`9491b949b72695dbc637bd54a7cf674c062f4af0c599ea848a1224bcdd5c5dbf`

ZIP:

`R8NMI13.zip`

ZIP SHA-256:

`b316ec801195222ef0bb39edda8d747e2973201a70bf89de43a1bea13a12b51a`

Post-change file SHA-256:

`780175fa7cf71f30b844547c616db24364d3e8a127a0242bcde75c3dcc3f74d7`

Post-change file size: 39828 bytes.

Prepared validation:

- native ZIP contains exactly the complete file at its final repository path;
- ZIP integrity test: OK;
- PHP syntax validation: OK.

## Owner validation gate

Before runtime testing:

- require the local target file to match the authoritative baseline SHA-256;
- verify ZIP SHA-256;
- verify exact ZIP contents;
- extract to `H:\OPUS`;
- PHP lint the changed file;
- run `git diff --check`, site validation and inspect the exact diff/status.

Stop on any unexpected pre-existing change, SHA mismatch or failed validation.

Runtime acceptance after the gate:

- OWASYS front host diagram shows the canonical NMI transitions and their target control states;
- normal/global transitions remain present;
- application-context diagrams such as `essai` remain unchanged;
- backend source continues to contain no JavaScript/UI changes.

No OPUS/OWASYS commit/push until acceptance. Assistant does not commit or push OPUS/OWASYS.
