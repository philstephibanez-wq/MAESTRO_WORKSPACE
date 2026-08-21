# P117W R45B2A4BZ2 — EFSM graphical toolbar + state draft CRUD — HANDOFF

State: DELIVERY PREPARED — OWNER VALIDATION REQUIRED

## User feedback resolved

The A4BZ1 toolbar was too textual and its disabled mutation controls were ambiguous. In A4BZ1 they were disabled because the slice was intentionally read-only, not because an administrator lacked `fsm:update`.

A4BZ2 makes authorization explicit and begins real state semantic editing on a non-authoritative validated draft.

## Permission truth

- owasys-front admin: `*:*` => `fsm:update` allowed;
- owasys-front developer: `fsm:*` => `fsm:update` allowed;
- viewer: no `fsm:update`;
- owasys-back admin: `*:*`;
- A4BZ2 adds `fsm:*` to owasys-back developer for the new autonomous backend command path.

Design mode displays a visible `🔓 fsm:update` capability badge only after server-side authorization.

## UX delivered

Graphical/icon-oriented toolbar:

- View;
- Select;
- State: Create / Edit / Rename / Delete;
- Transition controls present but pending;
- Condition controls present but pending;
- Validate / Publish present but pending.

At smaller widths textual captions collapse while icons remain.

State Create is available immediately in Design mode. Edit/Rename/Delete are enabled contextually after state selection; their disabled state with no selection is not an ACL denial.

## State draft CRUD

### Create

State + -> click empty diagram canvas -> SCORE inspector -> submit -> distributed backend validation -> dashed draft state projection.

### Edit

Select state -> Edit -> SCORE inspector -> backend validated draft command -> inspector/diagram refresh.

### Rename

Select state -> Rename -> new ID -> semantic refactor in generic OPUS editor.

References migrated in the same draft command:

- state ID;
- initial/final state when applicable;
- transition source;
- transition target;
- finite global `from_states`.

No blind text replacement.

### Delete

Select state -> Delete -> explicit typed ID confirmation.

Refused for initial/final/referenced states. No cascade.

## Mandatory distributed command path

Every semantic state command follows:

`owasys-front -> secured REST -> owasys-back -> allow-listed Composer -> generic OPUS editor/validator -> response -> owasys-front`

REST:

`POST /api/v1/applications/{site_id}/fsm/drafts/commands`

Operation:

`fsm.draft.edit`

Composer alias:

`owasys:fsm-draft-edit`

Resolved command:

`owasys:fsm:draft-edit`

Roles at REST operation layer: admin, developer.

## Generic OPUS components

A4BZ2 introduces:

- `Opus\Fsm\Definition\FsmDefinitionValidatorInterface`;
- `Opus\Fsm\Definition\FsmDefinitionValidator`;
- `Opus\Fsm\Definition\FsmDefinitionEditorInterface`;
- `Opus\Fsm\Definition\FsmDefinitionEditor`.

The two concrete classes implement homonymous interfaces. Each interface directly extends the four README-FIRST framework interfaces.

## Canonical safety

A4BZ2 DOES NOT write canonical `config/fsm.json`.

Design-mode snapshot carries the exact live `base_sha256`. Every backend command re-reads the canonical FSM via OPUS File/StructuredFileLoader and rejects a mismatch with:

`OWASYS_FSM_DRAFT_BASE_HASH_CONFLICT`

The browser draft is non-authoritative and current-page scoped.

Publish remains disabled until the dedicated secure publish slice.

## Profiler

Real measured events only:

- front `designer.draft_command.forwarding`;
- front `designer.draft_command.failed`;
- back `designer.draft_command.received`;
- back `designer.draft_command.validated`.

`draft_json` and `command_json` are added to RestClient sensitive profiler keys so full draft contents are not copied to profiler payloads.

Designer JSON responses do not generate a false SCORE-rendered event.

## Backend purity

No JavaScript/TypeScript/Node/package file is added to owasys-back.

Frontend designer interaction remains in owasys-front only.

## Owner validation sequence

1. Apply A4BZ2 on top of a local A4BZ1 installation.
2. Lint all new/modified PHP files.
3. Run optimized Composer autoload.
4. Validate both autonomous applications.
5. Run owasys-back and owasys-front.
6. Log in as admin and open Design mode.
7. Verify `🔓 fsm:update` is visible.
8. Verify State + is enabled immediately.
9. Select a state and verify Edit/Rename/Delete enable.
10. Create a draft state and confirm it appears dashed without changing `config/fsm.json`.
11. Rename an unreferenced draft state and confirm the projected ID changes.
12. Delete an unreferenced draft state with typed confirmation.
13. Confirm deleting the initial or a referenced state is rejected.
14. Verify View mode remains unchanged.
15. Verify transition/condition mutation remains disabled.
16. Inspect Profiler front -> REST -> back -> Composer correlation for a state draft command.

## Expected applicator markers

- `P117W_R45B2A4BZ2_APPLIED`
- `toolbar=graphical`
- `admin_fsm_update=enabled`
- `state_draft_crud=create,edit,rename,delete`
- `canonical_fsm_write=disabled_until_publish`
- `flow=owasys-front->REST->owasys-back->Composer`

## Workspace specification

`40_SPECS/P117W_R45B2A4BZ2_EFSM_STATE_DRAFT_CRUD_GRAPHICAL_TOOLBAR_SPEC.md`

Specification commit:

`c6b7ad72db09970039ac1a99e5b0469da09934cb`

## Next slice after validation

P117W R45B2A4BZ3 — transition + signal + condition CRUD/refactor, including signal rename and explicit `Dans le menu utilisateur` mutation.

Bézier control-point editing remains A4BZ3B.