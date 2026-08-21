# P117W R45B2A4BZ2R1 — EFSM graphical toolbar + state draft CRUD — HANDOFF

State: OWNER APPLY / VALIDATE

## What failed

The initial A4BZ2 applicator was defective before its write phase. It expected the stale builder revision `P117W_R45B2A4BI` instead of the actual A4BZ1 baseline `P117W_R45B2A4BZ1`.

Observed owner output:

`P117W_R45B2A4BZ2_PATCH_ANCHOR_INVALID:builder-revision`

`git status --short` remained empty and the UI remained A4BZ1/read-only.

## Reissue

Use A4BZ2R1 only. It carries the same A4BZ2 feature payload and corrects the baseline anchor.

Do not apply the original A4BZ2 applicator again.

## Expected first markers

- `P117W_R45B2A4BZ2_APPLIED`
- `toolbar=graphical`
- `admin_fsm_update=enabled`
- `state_draft_crud=create,edit,rename,delete`
- `canonical_fsm_write=disabled_until_publish`
- `flow=owasys-front->REST->owasys-back->Composer`

## Immediate validation

After successful application:

- `git status --short` must no longer be empty;
- searching `A4BZ2` in the modified frontend tree must return matches;
- PHP lint all new/modified PHP files;
- `composer dump-autoload -o`;
- validate owasys-front and owasys-back;
- start back then front;
- admin enters Design mode and verifies `fsm:update` capability badge and State CRUD.

## Parent contract

All functional and architectural acceptance rules remain in:

`40_SPECS/P117W_R45B2A4BZ2_EFSM_STATE_DRAFT_CRUD_GRAPHICAL_TOOLBAR_SPEC.md`

Reissue specification:

`40_SPECS/P117W_R45B2A4BZ2R1_EFSM_STATE_DRAFT_CRUD_REISSUE_SPEC.md`

## Next slice

Only after A4BZ2 owner validation: P117W R45B2A4BZ3 — transition + signal + condition CRUD/refactor.