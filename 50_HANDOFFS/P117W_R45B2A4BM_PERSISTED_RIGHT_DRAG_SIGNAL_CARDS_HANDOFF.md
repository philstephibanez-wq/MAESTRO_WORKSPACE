# P117W R45B2A4BM — Handoff

State: CODE DELIVERY PRODUCED — OWNER RUNTIME VALIDATION REQUIRED

## Baseline

- OPUS GitHub `master`: `974217ee14b14ab7b7980a8d74d0df34daf08f9a` — A4BJ.
- A4BM is delivered as complete replacements for the FSM diagram renderer and layout store and includes the A4BL strict-anchor/self-heal behavior.
- Menu work remains frozen.

## Owner request

In addition to state nodes, signal cards must be manually movable in DEV.

The complete technical card moves as one unit: signal + guards + effects + scope badge. This is presentation-only and does not alter canonical FSM semantics.

## A4BM behavior

### Right-button signal drag

Every rendered transition card receives a DEV-only draggable presentation wrapper.

Right-button drag:

- moves the whole signal card;
- preserves normal left-click GET/POST actionability;
- updates the dashed leader live;
- does not move or mutate canonical source/target FSM semantics;
- saves asynchronously on pointer release;
- does not reload or replace the document.

### Local transitions

A4BL strict path anchoring is preserved. Local persisted path geometry is reused only if its endpoints still touch the current source/target state boxes.

Signal-card x/y is handled independently from local path validity, so repairing a stale edge no longer destroys a manually positioned signal card.

### Global and self transitions

A4BM now persists signal-card center coordinates for global and self transitions as presentation geometry. These cards are no longer forced to lose a manual placement on reload.

Their canonical target/scope semantics remain exclusively in the FSM definition.

### Leader geometry

Persisted `leader_path` is not blindly trusted at render time. The visible leader is rebuilt from the current transition topology/current target anchor to the current signal-card position.

This prevents a moved card from leaving a stale leader in empty canvas space.

### Layout V3

Companion contract becomes:

`OPUS_FSM_DIAGRAM_LAYOUT_V3`

V1 and V2 companions remain readable and are migrated in writable DEV mode.

The layout remains presentation-only.

### Save protocol

Existing `save-state` remains for state drags.

A4BM adds `save-signal` for signal-card drags. It persists the validated geometry snapshot without requiring or mutating a state ID.

CSRF rotation and no-reload repeated saves remain unchanged.

## Artifact

`opus_p117w_r45b2a4bm_persisted_right_drag_signal_cards.zip`

SHA-256:

`920e50129e6e5754d0385140c05f7afac16387370b8277b92b4aa4f76676d012`

Exactly 2 complete files:

- `Opus/Fsm/Diagram.class.php`
- `Opus/Fsm/FsmDiagramLayoutStore.php`

No menu file. No `owasys-back` file.

## Validation performed

- PHP lint: 2/2 OK;
- extracted inline interaction JavaScript: `node --check` OK;
- no trailing whitespace;
- `window.location.reload()` absent;
- render smoke with local + global + self transitions: three draggable signal cards emitted;
- persisted global/self signal coordinates restored by renderer;
- `save-signal` emitted by DEV interaction;
- V3 store normalization smoke keeps known local/global/self transition presentation entries and drops unknown transition IDs;
- V3 contract constant verified;
- ZIP contains exactly the two expected complete framework files.

## Owner application

Apply A4BM only while `H:` is present and stable.

The A4BM files include the A4BL behavior, so if A4BL was not successfully extracted during the earlier storage interruption, A4BM still supplies the current `Diagram.class.php` and `FsmDiagramLayoutStore.php` implementations expected for runtime validation.

Do not delete `sites/owasys-front/config/fsm.layout.json` before the first run; V2-to-V3 migration and preservation of existing geometry are part of acceptance.

Validation sequence:

1. load FSM without moving anything and confirm detached local arrows self-heal;
2. right-drag one local signal card;
3. right-drag one global/self card;
4. confirm leaders follow and no reload occurs;
5. move a state, then another signal, without F5;
6. perform one deliberate F5 and confirm all manual state/signal positions persist;
7. inspect the companion contract: `OPUS_FSM_DIAGRAM_LAYOUT_V3`.

Owner alone applies, validates, commits and pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
