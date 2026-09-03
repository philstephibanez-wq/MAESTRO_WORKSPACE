# P117W R8B7K — Horizontal Registry Layout Handoff

Date: 2026-09-03
Status: READY FOR OWNER APPLY/VALIDATE
OPUS baseline: `ec3586496acdac83f155a248c46013e3001cbef4`

## Delivery

Native ZIP: `R8B7K.zip`

Archive scope:

- `sites/owasys-front/application/registry/templates/index.score`

No other OPUS/OWASYS file is included.

## Intent

Keep the R8B7J semantic split between OWASYS/system applications and generated applications, but render the two groups horizontally using the existing `ow-grid ow-runtime-grid` presentation classes.

## Owner gates

Follow `00_COMMON_CONTRACTS/CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md` exactly.

1. Verify OPUS HEAD and clean worktree.
2. Apply the native ZIP with rooted `tar -xf` extraction.
3. Verify the one-file diff and `git diff --check`.
4. Run the existing OWASYS front validation/runtime path.
5. Confirm visually that system applications occupy the left column and generated/deletable applications the right column at desktop width, with responsive fallback controlled by existing grid CSS.
6. Confirm selection, current state, and deletion behavior are unchanged.
7. Owner commits and pushes only after acceptance.

Any unexpected HEAD, dirty worktree, extra modified file, validation error or runtime/UI regression is a stop condition.

## Package verification

Expected ZIP SHA-256:

`75e43521d864d926e169d25018b4347f8fa38d600a9f6987f84d54dfc3b87b5b`

The archive contains exactly one complete file at its final repository path.
