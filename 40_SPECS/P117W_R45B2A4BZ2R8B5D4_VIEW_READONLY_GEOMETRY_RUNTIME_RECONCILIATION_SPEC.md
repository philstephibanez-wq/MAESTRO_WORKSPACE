# P117W R45B2A4BZ2 R8B5D4 — VIEW read-only geometry runtime reconciliation — SPEC

State: ACTIVE — DELIVERY BUILD/OWNER RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`.
- Generic renderer target: `Opus/Fsm/Diagram.class.php` blob `255ce381932be8796f6a80d1a09228c001255d80`.
- Contextual caller: `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` blob `0f17ee29537603b09911fe0f7acd7fb136b46128`.

Applicable architecture invariant: the same canonical graph is used in diagnostic VIEW and DESIGN; DESIGN only adds editing capability.

## Runtime defect

For the same contextual Security EFSM and the same persisted layout:

- DESIGN renders STATE, SIGNAL, transition arrows/paths and label leaders correctly;
- VIEW preserves STATE geometry but several transition arrows/paths and leaders differ or are stale.

## Proven cause

`OPUS_FSM_Diagram::renderHtml()` currently emits `layoutInteractionScript()` only when layout persistence is writable.

That script is overloaded: before any editing handler is installed, it also performs presentation reconciliation using current SVG/state geometry:

- `repairLocalTransition()` validates and self-heals local transition paths;
- `updateLabelLeader()` reconstructs signal-card leader lines;
- `updateInitialMarker()` reconciles the initial marker.

Because VIEW is read-only, it does not execute this reconciliation. DESIGN does.

`FsmDiagramBuilder::buildSelectedApplicationEfsm()` already proves that both modes instantiate the same `OPUS_FSM_Diagram`, load the same definition and apply the same persisted state/canvas/transition/marker layout. Only DESIGN calls `setLayoutPersistence(... writable=true)`.

## Required generic correction

Change only `Opus/Fsm/Diagram.class.php`.

1. Emit the existing diagram geometry runtime when either:
   - layout is writable; or
   - persisted state/canvas/transition/marker geometry is present.
2. Do not return early merely because `writable=false`.
3. Build runtime STATE/SIGNAL/marker registries from rendered geometry attributes, not from draggable-only selectors.
4. Always execute the existing transition/leader/initial-marker reconciliation.
5. Immediately after that reconciliation, return when `writable=false`.
6. Keep CSRF rotation, persistence POST, context-menu suppression, pointer handlers and right-button drag strictly after the writable gate.

## Safety/non-regression invariants

R8B5D4 must not modify:

- `sites/owasys-front/www/asset/css/fsm-native.css`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
- any `*.fsm.layout.json` file;
- any EFSM definition;
- OWASYS REST/back/Composer code;
- ACL/security rules;
- SignalBus/SecurityContext;
- DESIGN drag/persistence behavior.

R8B5D3 local CSS/cache-buster changes and any local presentation layout changes are explicitly preserved byte-for-byte if present.

## Delivery gate

The applicator must:

- require HEAD `f053f5693e0e65fe807564a2bfd6d52fc28ba4e2`;
- require target HEAD blob `255ce381932be8796f6a80d1a09228c001255d80` and an unmodified target worktree file;
- require a clean Git index;
- tolerate only known local R8B5D3 files and `sites/*/config/*.fsm.layout.json` presentation companions outside the target;
- snapshot every tolerated dirty/untracked file and prove it remains byte-for-byte unchanged;
- stage the transformed renderer in a temporary file and run `PHP_BINARY -l` before writing;
- apply atomically to the single target;
- require exact target-only new differential in addition to pre-existing tolerated local state;
- run `git diff --check`;
- rollback only the target on post-write failure;
- never invoke Composer internally.

## Runtime acceptance

Using the same application, EFSM and persisted layout:

1. open DESIGN and note the complete graph, especially SIGNAL arrows and leader lines;
2. switch to VIEW;
3. VIEW must be pixel-equivalent in graph geometry to DESIGN: STATE, SIGNAL cards, transition paths/arrows, leader lines and initial marker;
4. VIEW must expose no right-button drag/persistence capability;
5. return to DESIGN and confirm right-button drag/persistence still works;
6. F5 in VIEW and DESIGN must preserve the same geometry;
7. no layout/REST/backend/security regression is acceptable.

Canonical contract: `VIEW = DESIGN - modification capability`.
