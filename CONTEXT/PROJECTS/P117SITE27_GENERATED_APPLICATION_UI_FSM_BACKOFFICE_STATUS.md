# P117SITE27 — Generated application UI FSM backoffice status

Status: DELIVERED

Repository: `philstephibanez-wq/OPUS`

## Delivered OPUS commits

- `e16187ee0a8baaaca1cf49adf30298b6b0270f3d` — `P117SITE27_ADD_GENERATED_APPLICATION_UI_FSM_BACKOFFICE_RUNNER`
- `f52eb10060cd0e7e48166b49746e3b9fd3f0865e` — `P117SITE27_ADD_GENERATED_APPLICATION_UI_FSM_BACKOFFICE_SMOKE`
- `cccd0ae925e841cabd2484f8e5a6a7ae052c2756` — `P117SITE27_ADD_GENERATED_APPLICATION_UI_FSM_BACKOFFICE_DOC`

## Contract captured

- FRONT is UI.
- VIEW is an FSM state.
- ACTION is an FSM signal.
- COMMON/FSM/Engine is the shared processor only.
- FRONT owns UI View states and UI action transitions.
- MIDDLE owns REST + SSO + ACL + FSM gate transitions.
- BACK owns business execution transitions.
- Application modules can own their own transition fuel.
- Backoffice dashboard is FRONT admin UI, not BACK.
- Any transgression must create an explicit blocked FSM state and must be administrable from the backoffice dashboard.

## Validation command

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\refactor_p117site27_generated_application_ui_fsm_backoffice.py --write
python tools\smoke_p117site27_generated_application_ui_fsm_backoffice.py
```

Expected final marker:

```text
P117SITE27_GENERATED_APPLICATION_UI_FSM_BACKOFFICE_SMOKE_OK
```
