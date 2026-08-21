# P117W R45B2A4BW — Registry compaction and FSM height reduction — HANDOFF

State: DELIVERABLE READY — OWNER APPLY + RUNTIME VALIDATION REQUIRED

## What this fixes

Two presentation causes are corrected together, without changing FSM business semantics.

### Registry

The application-tree CSS was applying full-height selection-card rules to every nested form/button, including `.ow-delete-form`. This pushed the deletion confirmation field and button below the useful viewport.

A4BW scopes full-card behavior to the selection form only and gives `.ow-delete-form` its own compact layout.

### FSM diagram

The current persisted vertical FSM geometry is too tall. The generic renderer intentionally follows that geometry, so CSS clipping/zoom would be the wrong layer.

A4BW reduces persisted vertical geometry by exactly `2/3`, i.e. approximately one third shorter. A 2970 px canvas becomes 1980 px. X positions and FSM semantics are unchanged.

## Preconditions

Apply A4BV first if it is not already applied locally.

A4BW refuses to run unless it detects the A4BV deletion contract in the current local `fsm.json`:

- `begin_application_deletion` user signal;
- `t_delete_begin` registry self-loop;
- `t_delete_app / clear_deleted_app_context`;
- `g_delete_current_application -> registry`.

It also refuses a stale layout whose `definition_sha256` does not match the exact current FSM bytes.

## Changed final OPUS paths

- `sites/owasys-front/www/asset/css/owasys.css`
- `sites/owasys-front/config/fsm.layout.json`

No backend, JavaScript, template, REST, Composer, ACL or SSO file changes.

## Artifact

`opus_p117w_r45b2a4bw_registry_compaction_and_fsm_height.zip`

SHA-256:

`31a4c5e42fb3182b4d0534a44e37b34a2e5328029441e2a034175343d7825ddc`

ZIP content:

- `apply_a4bw.php`

Applicator SHA-256:

`f3d66a932deaa9160d4536a4f54052ce9857fbc4e8f69f5c263c25b29768a8f4`

PHP lint: OK under PHP 8.4.23.

## Owner commands

```cmd
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bw_registry_compaction_and_fsm_height.zip" -C "%USERPROFILE%\Downloads"
cd /d H:\OPUS
php "%USERPROFILE%\Downloads\apply_a4bw.php"
php -l "%USERPROFILE%\Downloads\apply_a4bw.php"
composer opus:validate-site -- owasys-front
composer opus:dev-server -- owasys-front
```

Expected applicator first line:

`P117W_R45B2A4BW_APPLIED`

On the current geometry, the applicator should also report:

`fsm_canvas_height 2970 -> 1980`

## Browser acceptance

1. Open Applications.
2. A generated application tile must have a normal compact selection surface, not a vertically stretched card.
3. The delete confirmation label, input and delete button must be immediately visible below that selection surface.
4. Verify A4BV deletion behavior still works for both current and non-current generated applications.
5. Open FSM.
6. Diagram height must be roughly one third lower than before, with no clipping and no inner vertical scroll viewport.
7. Existing horizontal/manual positioning must remain proportionally intact.
8. Signal colors, actionability, guards, actions and topology must be unchanged.

## Workspace specification

`40_SPECS/P117W_R45B2A4BW_REGISTRY_COMPACTION_AND_FSM_HEIGHT_SPEC.md`

Specification commit:

`9275f14d3dc634cbff537e31acb4cf59bb80eb81`

## Next

After owner acceptance, inspect the new live diagram rather than deriving the next topology change from the pre-A4BW geometry.
