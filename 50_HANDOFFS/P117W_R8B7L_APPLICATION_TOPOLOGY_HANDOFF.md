# P117W R8B7L — Applications topology handoff

Status: READY FOR OWNER APPLY / RUNTIME VALIDATION

## Baseline

GitHub OPUS authority before local presentation experiments:
`ec3586496acdac83f155a248c46013e3001cbef4` (R8B7I).

R8B7L supersedes the locally applied R8B7K presentation experiment by replacing the same complete SCORE file.

## Delivery

Native differential ZIP: `R8B7L.zip`

Contains exactly:
- `sites/owasys-front/application/registry/templates/index.score`

SHA-256:
`ab605cc22c5f07fab06981ded0771ad26995b3a71f5604f7834ac03698355d58`

## Intent

Applications view topology is presentation-only:
- OWASYS is the containing system card;
- OWASYS core row contains `owasys-front` and `owasys-back` side by side;
- generated applications render below, inside the same OWASYS card, so their generation relationship remains visible without classifying them as core;
- operational create/select/delete behavior is preserved;
- discovery/singleton/runtime/event diagnostic panels and singleton pills are removed from this operational view.

## Static validation completed before delivery

- ZIP contains one complete file at final path.
- Archive content reread and byte-matched against generated file.
- SCORE blocks: 21 `if` / 21 `endif`; 2 `foreach` / 2 `endforeach`.
- Required form contracts preserved: `create-new-app`, `clear-app-context`, `select-app`, `delete-app` and deletion confirmation.
- No `essai` hardcode.
- No PHP, backend, REST, FSM, ACL or persistence file changed.

## Owner gate

Apply using the native ZIP workflow, inspect the single-file diff, then validate `/applications` runtime before commit/push. Stop on unexpected HEAD, unrelated dirty files, extraction mismatch, diff-check failure or runtime regression.
