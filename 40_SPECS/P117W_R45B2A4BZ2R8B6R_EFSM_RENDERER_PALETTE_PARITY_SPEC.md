# P117W R45B2A4BZ2R8B6R — EFSM renderer palette parity

Status: READY FOR OWNER APPLICATION
Date: 2026-09-05

## Contract authority

This slice is governed by `README-FIRST.md`, `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md` and `00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

The assistant updates MAESTRO_WORKSPACE directly. OPUS/OWASYS is never committed or pushed by the assistant: the owner applies the native ZIP locally, validates, then commits and pushes.

## Owner clarification

The NMI danger color is correct and MUST remain red. The defect concerns the visual colors of ordinary EFSM states and transitions in OWASYS: they must use the same generic OPUS renderer palette seen in `sites/essai`.

## Source evidence and root cause

`sites/essai/application/default/templates/components/fsm-diagram.score` renders the generic `fsm.diagram` without a local FSM palette adapter. `sites/essai/www/asset/css/default.css` styles the containing card but does not remap the generic OPUS state/transition palette.

By contrast, `sites/owasys-front/www/asset/css/fsm-native.css` remaps generic OPUS variables (`--opus-fsm-node-*`, `--opus-fsm-current-*`, `--opus-fsm-edge`, `--opus-fsm-label`, marker/focus/loop roles) to OWASYS theme tokens and additionally recolors transition edges/labels according to `signal-origin-user` / `signal-origin-automatic`. Those OWASYS-specific overrides are the cause of the visual divergence from `essai`.

The generic-first requirement from P117W R45B2A4L is already satisfied: `OPUS_FSM_Diagram` exposes semantic CSS variables with fallbacks. Therefore this repair removes the OWASYS diagram palette remapping and lets the generic renderer fallbacks be authoritative, while preserving OWASYS-only designer/menu interaction styling and the explicit red NMI mapping.

## Required correction

Target: `sites/owasys-front/www/asset/css/fsm-native.css`.

1. Keep `--opus-fsm-nmi-bg` and `--opus-fsm-nmi` mapped to OWASYS danger colors.
2. Stop overriding ordinary OPUS state, current-state, marker, edge, label, focus, loop and signal palette variables on `.ow-fsm-native-panel`.
3. Stop forcing ordinary transition edge/label colors and passive opacity from OWASYS signal-origin classes.
4. Let generic `OPUS_FSM_Diagram` CSS determine ordinary state and transition colors exactly as it does in `sites/essai`.
5. Where OWASYS-specific interaction CSS still needs a fallback color for label leaders or vertical signal text, use generic OPUS renderer transition/label variables, not OWASYS accent/muted colors.
6. Do not change EFSM topology, semantics, geometry, persisted layout, routes, ACL, I18n, SCORE structure, NMI semantics or the NMI red color.

## Local cleanup gate

The previously delivered experimental `R8NMI.zip` modified `sites/owasys-front/application/fsm/models/ApplicationFsmModel.php`. That experiment is rejected and must be restored from Git before this palette slice is applied. `R8NMI2.zip` must not be applied.

Pre-existing local layout edits are owner work and MUST remain untouched:

- `sites/owasys-back/config/fsm.layout.json`
- `sites/owasys-front/config/data.fsm.layout.json`

## Acceptance

After application and front restart:

- ordinary EFSM states visually use the same generic renderer palette as `sites/essai`;
- ordinary transitions and their labels visually use the same generic renderer palette as `sites/essai`;
- NMI remains red;
- no topology/geometry/semantic change is observed;
- only the expected CSS file is new in the slice diff, in addition to the owner's pre-existing layout files.
