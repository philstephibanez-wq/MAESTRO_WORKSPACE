# OPUS P117SITE23 Status — Front / Middle / Back FSM Contract

Status: CONTRACT-UPDATED
Date: 2026-06-21
Scope: OPUS secure-by-design and clean-by-design architecture direction

## Decision

The OPUS architecture direction is now Front / Middle / Back with the FSM as the mandatory processor at every level.

## Core rule

```text
No processing path bypasses the FSM.
```

This applies to:

- frontend navigation intents,
- middle routing and security gates,
- API request/response transport,
- backend actions,
- services,
- runners,
- jobs,
- workers,
- external process calls,
- validation,
- authorization,
- error paths,
- cleanup paths.

## Target framework namespaces

```text
framework/Opus/Front/
framework/Opus/Middle/
framework/Opus/Back/
```

## Target application layout

```text
sites/<application_id>/
├── frontend/
├── middle/
└── backend/
```

## End-to-end flow

```text
Front View / Section / Component / Form
  -> Front ApiClient
    -> Middle Route / ApiGateway
      -> Middle security pipeline
        -> ACL / SSO / CSRF / FSM gate / rate limit / audit
          -> FSM signal
            -> FSM transition / guard / action
              -> Back Action
                -> Back Service / Validator / Policy / Repository / Job / Adapter
                  -> Response DTO or ViewModel
                    -> Front representation
```

## Updated workspace contract

`CONTEXT/CONTRACTS/OPUS_FULLSTACK_FRONTEND_BACKEND_CONTRACT.md` was upgraded into an active Front / Middle / Back FSM contract.

Workspace commit:

```text
00e7c70b3bf2aa00e5fb666d6ef68f83ba02cb83
P117SITE23_UPDATE_OPUS_FULLSTACK_FSM_CONTRACT
```

## Next implementation target

P117SITE23 should now implement the OPUS framework namespace split and generated application `middle/` space:

- `Opus\Front`
- `Opus\Middle`
- `Opus\Back`
- `sites/<application>/middle/routes`
- `sites/<application>/middle/api`
- `sites/<application>/middle/security`
- `sites/<application>/middle/contracts`
- `sites/<application>/middle/fsm`

No business logic may be added outside the FSM-governed backend processing path.
