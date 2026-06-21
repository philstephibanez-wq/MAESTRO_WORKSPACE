# OPUS P117SITE23 Status — Front / Middle / Back FSM Skeleton

Status: DELIVERED
Date: 2026-06-21
Scope: OPUS secure-by-design and clean-by-design framework layer skeleton

## Decision

The OPUS architecture direction is now represented in the framework tree:

```text
framework/Opus/FRONT/
framework/Opus/MIDDLE/
framework/Opus/MIDDLE/FSM/
framework/Opus/BACK/
```

## Core rule

```text
Every operation path is represented by the FSM contract.
```

## Delivered OPUS files

```text
framework/Opus/FRONT/README.md
framework/Opus/FRONT/FrontLayer.php
framework/Opus/MIDDLE/README.md
framework/Opus/MIDDLE/MiddleLayer.php
framework/Opus/MIDDLE/FsmKernel.php
framework/Opus/MIDDLE/FSM/README.md
framework/Opus/MIDDLE/FSM/FsmProcessorInterface.php
framework/Opus/BACK/README.md
framework/Opus/BACK/BackLayer.php
DOC/P117SITE23_FRONT_MIDDLE_BACK_FSM_SKELETON.md
tools/smoke_p117site23_front_middle_back_fsm_skeleton.py
```

## Test

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\smoke_p117site23_front_middle_back_fsm_skeleton.py
python tools\smoke_p117site22_rich_fullstack_starter_app.py
git status --short
```

Expected markers:

```text
CHECK_FRAMEWORK_FRONT_LAYER=OK
CHECK_FRAMEWORK_MIDDLE_LAYER=OK
CHECK_FRAMEWORK_FSM_PROCESSOR=OK
CHECK_FRAMEWORK_BACK_LAYER=OK
CHECK_CONTRACT_DOC=OK
P117SITE23_FRONT_MIDDLE_BACK_FSM_SKELETON_SMOKE_OK
P117SITE22_RICH_FULLSTACK_STARTER_APP_SMOKE_OK
```

## Next target

P117SITE24 must implement a real end-to-end operation using FRONT intent, MIDDLE route/API/FSM gate, BACK action and generated app proof through the internal server.
