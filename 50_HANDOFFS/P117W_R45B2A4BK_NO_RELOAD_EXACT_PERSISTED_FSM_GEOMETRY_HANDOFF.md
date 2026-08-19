# P117W R45B2A4BK — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

Owner OPUS HEAD:

`974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.

A4BK is a differential over that owner commit. Menu work remains frozen.

## Owner runtime evidence

A4BJ right-button drag moves states correctly, but pointer release reloads the page. The owner observed:

- the diagram changes routing after the reload;
- the menu loses its current collapsed/open visual state;
- the page refresh is unnecessary for a presentation-only save.

Inspection confirmed the exact cause in A4BJ: the interaction script executes `window.location.reload()` after `await persist(state)`.

## A4BK correction

### No document reload

Pointer release now performs only an asynchronous save. The current DOM is retained.

Therefore:

- no navigation occurs;
- no menu state is rebuilt;
- scroll position and surrounding UI state remain untouched;
- the diagram stays visually exactly as it was at pointer release.

### Exact displayed local-transition geometry

The save payload now contains the geometry visible in the live SVG:

- moved state x/y;
- canvas width/height;
- each local state-to-state transition path `d`;
- transition label x/y;
- label-leader path.

The server validates and atomically persists this presentation geometry.

On the next real page load, persisted local transition geometry overrides automatic routing. This prevents server rerouting from changing the diagram after a manual edit.

Global ingress and self-operation cards remain deterministically anchored to their persisted target state rather than being stored as independent semantic objects.

### Layout V2 and migration

Portable contract becomes:

`OPUS_FSM_DIAGRAM_LAYOUT_V2`

Existing V1 files are accepted. In writable DEV mode they are migrated automatically while retaining known-state manual x/y positions.

Missing/new transition geometry is completed from the server-rendered diagram. Existing persisted geometry is not overwritten during normal rendering.

### CSRF without reload

CSRF remains session-bound and single-use.

After a successful save, A4BK reads the returned HTML only to obtain the freshly issued layout CSRF token and updates the current diagram card dataset. It does not replace the document.

This allows multiple right-button drags and saves on the same page.

### Security

Posted geometry is validated as untrusted input:

- payload maximum size;
- known transition IDs;
- bounded finite coordinates;
- bounded SVG paths;
- strict permitted SVG path characters;
- layout key;
- CSRF;
- atomic `File::writeAtomic()` persistence.

## Artifact

`opus_p117w_r45b2a4bk_no_reload_exact_persisted_fsm_geometry.zip`

SHA-256:

`8c680ea5974c2fe793868aaf9da6d202e4f5eba512676dc3dcd7435dbbb26a43`

Exactly 3 complete files:

- `Opus/Fsm/Diagram.class.php`;
- `Opus/Fsm/FsmDiagramLayoutStore.php`;
- `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`.

No menu file. No `owasys-back` file.

## Validation performed

- PHP lint: 3/3 OK;
- extracted interaction JavaScript: `node --check` OK;
- no trailing whitespace;
- exact ZIP file count: 3;
- `window.location.reload()` absent;
- geometry POST payload present;
- CSRF response-token rotation present;
- persisted renderer smoke: exact path / label / leader restored;
- store V2 smoke: state and displayed geometry persisted;
- end-to-end smoke: bootstrap -> persisted render -> POST manual geometry -> no reload -> fresh CSRF -> real next render restores exact posted local path;
- result: `A4BK_END_TO_END_NO_RELOAD_EXACT_GEOMETRY_OK`.

## Owner validation sequence

Apply A4BK over owner A4BJ.

1. Start `owasys-front` normally in DEV.
2. Load the EFSM page and leave a resource menu in its current collapsed/open state.
3. Right-drag one state and release.
4. Confirm there is no browser/page refresh.
5. Confirm the menu state does not change.
6. Confirm the arrows remain exactly as visible at release.
7. Right-drag a second state without refreshing and confirm persistence succeeds again.
8. Inspect `sites/owasys-front/config/fsm.layout.json`: it should migrate to `OPUS_FSM_DIAGRAM_LAYOUT_V2` and contain transition presentation geometry.
9. Perform one deliberate browser refresh.
10. Confirm state positions and local transition paths/labels return with the same persisted geometry.
11. Repeat in a generated application; its companion remains `config/application.fsm.layout.json`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
