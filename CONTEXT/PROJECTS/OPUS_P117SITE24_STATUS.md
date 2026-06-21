# OPUS P117SITE24 — FRONT / MIDDLE / BACK / COMMON boundaries

Status: DELIVERED

## Direction

OPUS must be end-to-end secure and clean by design. The framework tree itself must visibly mark architecture boundaries:

```text
framework/Opus/
├── FRONT/
├── MIDDLE/
│   └── FSM/
├── BACK/
└── COMMON/
```

## Non-negotiable rules

- Mermaid UML diagrams are mandatory for architecture-bearing documentation.
- FSM transition diagrams are mandatory when a runtime path exists.
- The FSM is the processor at every level.
- No FRONT to BACK path may bypass MIDDLE/FSM.
- COMMON is strict shared language only, never a catch-all folder.

## Delivered in OPUS

- `framework/Opus/FRONT/FrontLayer.php`
- `framework/Opus/FRONT/README.md`
- `framework/Opus/MIDDLE/MiddleLayer.php`
- `framework/Opus/MIDDLE/README.md`
- `framework/Opus/MIDDLE/FSM/FsmSignal.php`
- `framework/Opus/MIDDLE/FSM/FsmResult.php`
- `framework/Opus/MIDDLE/FSM/FsmTransition.php`
- `framework/Opus/MIDDLE/FSM/FsmTransitionRegistry.php`
- `framework/Opus/MIDDLE/FSM/fsm.transitions.json`
- `framework/Opus/BACK/BackLayer.php`
- `framework/Opus/BACK/README.md`
- `framework/Opus/COMMON/CommonLayer.php`
- `framework/Opus/COMMON/README.md`
- `framework/Opus/COMMON/Contract/*`
- `framework/Opus/COMMON/Dto/*`
- `framework/Opus/COMMON/Error/*`
- `framework/Opus/COMMON/Result/*`
- `framework/Opus/COMMON/ValueObject/*`
- `DOC/P117SITE24_FRONT_MIDDLE_BACK_COMMON_BOUNDARIES.md`
- `tools/smoke_p117site24_front_middle_back_common_boundaries.py`

## Runtime validation command

```cmd
cd /d H:\OPUS
python tools\smoke_p117site23_front_middle_back_fsm_skeleton.py
python tools\smoke_p117site24_front_middle_back_common_boundaries.py
```

Expected markers:

```text
P117SITE23_FRONT_MIDDLE_BACK_FSM_SKELETON_SMOKE_OK
P117SITE24_FRONT_MIDDLE_BACK_COMMON_BOUNDARIES_SMOKE_OK
```

## Next step

P117SITE25 must implement the real end-to-end runtime path:

```text
FRONT intent -> MIDDLE route/API/request contract -> MIDDLE FSM gate -> BACK action -> response contract -> FRONT rendering
```
