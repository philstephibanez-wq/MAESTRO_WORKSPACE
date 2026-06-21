# OPUS P117SITE25F — FSM engine versus layer transitions

## Status

DELIVERED.

## User correction

The user clarified the FSM architecture:

- the FSM engine is common;
- each boundary owns its own transition definitions;
- generated applications may define their own transitions;
- Link is also a FRONT component;
- the mandatory end-to-end flow is `FRONT -> MIDDLE -> BACK -> MIDDLE -> FRONT` through REST APIs, FSM, ACL and SSO;
- Mermaid UML diagrams are not optional;
- FSM transition diagrams are not optional;
- the architecture must be documented and auto-documented.

## Applied OPUS deliverables

- `DOC/P117SITE25F_FSM_ENGINE_LAYER_TRANSITIONS.md`
- `tools/refactor_p117site25f_fsm_engine_layer_transitions.py`
- `tools/smoke_p117site25f_fsm_engine_layer_transitions.py`

## Expected physical model

```text
framework/Opus/
├── FRONT/
│   ├── Component/
│   │   ├── Breadcrumb/
│   │   ├── Form/
│   │   ├── Link/
│   │   └── Menu/
│   └── FSM/
│       └── Transitions/
├── MIDDLE/
│   └── FSM/
│       └── Transitions/
├── BACK/
│   └── FSM/
│       └── Transitions/
└── COMMON/
    └── FSM/
        └── Engine/
```

## Mandatory runtime contract

```text
FRONT intent
  -> REST API through MIDDLE
    -> MIDDLE route/request contract
      -> ACL + SSO + security pipeline
        -> MIDDLE FSM transition gate
          -> BACK action if and only if FSM allows
            -> BACK FSM transition
              -> MIDDLE response contract
                -> FRONT view model / typed error
```

## OPUS commits

- `dd87b045f6edd67c80279d8e3ff5662bee3838e4` — P117SITE25F_DOC_FSM_ENGINE_LAYER_TRANSITIONS
- `63bc1ed997634b63c00da1ccaaf2a41ea389939e` — P117SITE25F_ADD_FSM_ENGINE_LAYER_TRANSITION_RUNNER
- `9c042685adf7fb21dbdbcfa14415852882c5f80a` — P117SITE25F_ADD_FSM_ENGINE_LAYER_TRANSITION_SMOKE

## Test command

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\refactor_p117site25f_fsm_engine_layer_transitions.py --write
python tools\smoke_p117site25f_fsm_engine_layer_transitions.py
git status --short
```

## Validation markers

```text
P117SITE25F_FSM_ENGINE_LAYER_TRANSITIONS_OK
P117SITE25F_FSM_ENGINE_LAYER_TRANSITIONS_SMOKE_OK
```
