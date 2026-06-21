# OPUS P117SITE25 — Physical FRONT / MIDDLE / BACK / COMMON boundaries

Status: DELIVERED

## Goal

Physically reorganize the OPUS framework source tree so the boundary is visible at the root of `framework/Opus`:

```text
framework/Opus/
├── FRONT/
├── MIDDLE/
├── BACK/
└── COMMON/
```

## Non-negotiable architecture

- FRONT = representation only.
- MIDDLE = routing, transport, security, contracts, FSM gates.
- BACK = business/data processing, jobs, runners, workers, external adapters.
- COMMON = strict shared language only; never a catch-all.
- FSM = mandatory processor for every operation path.
- Mermaid UML diagrams are mandatory.
- FSM transition diagrams are mandatory.
- Architecture must be documented and auto-documented.

## OPUS commits

- `401169ba1aca1236b7d759b2b6944800d8e2b159` — P117SITE25 documentation
- `36672b3e1823bc8ff1ed5f0e8d9b97176c6ece17` — physical boundary refactor runner
- `6cc9857e52e26d4b086b9d503c156cee5e709cc1` — physical boundary smoke

## Local application procedure

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\refactor_p117site25_front_middle_back_common_tree.py --write
python tools\smoke_p117site25_front_middle_back_common_tree.py
git status --short
```

## Expected smoke markers

```text
CHECK_BOUNDARY_ROOT_DIRS=OK
CHECK_ONLY_BOUNDARY_ROOTS=OK
CHECK_NO_LEGACY_ROOT_DIRS=OK
CHECK_ROOT_FILES_LIMITED=OK
CHECK_FRONT_MAPPED=OK
CHECK_MIDDLE_MAPPED=OK
CHECK_MIDDLE_FSM_ENGINE_MAPPED=OK
CHECK_BACK_MAPPED=OK
CHECK_COMMON_MAPPED=OK
CHECK_COMMON_NOT_CATCH_ALL=OK
CHECK_BOUNDARY_MAP_EXISTS=OK
CHECK_BOUNDARY_MAP_SCHEMA=OK
CHECK_FSM_MANDATORY_RULE=OK
CHECK_COMPOSER_CLASSMAP=OK
CHECK_MERMAID_UML_DOC=OK
CHECK_FSM_TRANSITION_DOC=OK
CHECK_COMMON_NOT_CATCH_ALL_DOC=OK
P117SITE25_FRONT_MIDDLE_BACK_COMMON_TREE_SMOKE_OK
```

## Validation note

P117SITE25 is delivered, not validated until the local physical move and smoke pass on `H:\OPUS`.
