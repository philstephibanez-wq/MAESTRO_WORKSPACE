# P117W R45B2A4BZ2 R8B6Q — Transactional state-layout identity refactor — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS exact owner HEAD: `3c67eeeec81ae0a1fb9c057308d43a6eb17cf604`.
- baseline blobs:
  - source workspace: `4b3378179375c9bbf20164e3435cc12b9d03b327`;
  - source workspace interface: `a045930d10a74dcbf2abcbf4d136254ef6540fe2`;
  - layout store: `b6c7261c054113321ee340798e88a472ebc51649`;
  - layout store interface: `a78931acb67dd3b31267065d5226c0c9832fe0b0`;
  - back provider: `21fdf1509e2ffc4af7ebdf01e0b4cc366724ec38`;
  - diagram builder: `332c02b58b9cc926705d28a3184a3e4f60d26aea`;
  - SCORE renderer: `57c72db939dab23e22c937f5bdaaa9c7205c60fd`;
  - SCORE partial: `5fca386a27b725d671bf6b346d6562dd9adeb835`.

## Delivery

R8B6Q migrates a renamed state's persisted layout identity in the backend,
before normal layout pruning can discard the old coordinate. Canonical FSM and
layout files are applied through one bounded optimistic batch with deterministic
locking, verification and rollback. Transition IDs and their persisted Bézier
geometry remain stable; finite-global marker identities are migrated when
their state-set hash changes.

## Artifact

- ZIP: `R8B6Q.zip`.
- ZIP SHA-256: `a70b8f59caf8b487163c20ea8a3b172476163a9d1f6ae4afc6300ec922fafbcf`.
- size: `35648` bytes.
- exact eight-file contents:
  - `Opus/Application/Source/SiteSourceWorkspace.php`;
  - `Opus/Application/Source/SiteSourceWorkspaceInterface.php`;
  - `Opus/Fsm/FsmDiagramLayoutStore.php`;
  - `Opus/Fsm/FsmDiagramLayoutStoreInterface.php`;
  - `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
  - `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
  - `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
  - `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`.
- delivered blobs:
  - source workspace: `62b6a589f6899fbed03ffb0c2c076385d8feb555`;
  - source workspace interface: `fc7fcb329cf10089e6893c36c3ce424d993a4331`;
  - layout store: `072e0ed782edcdb956a266bc3c743b891ee2d89a`;
  - layout store interface: `b4f1ef66e9bba8b1abd16b0402f9ebb39bc49540`;
  - back provider: `98a69e48c2c0b84e5242cc8d33d622ab211615d1`;
  - diagram builder: `4c8a8389c73e5f61fb4712d70ab23d6d59598520`;
  - SCORE renderer: `8ac72122b4388f5c700aeec9855c8c5e1c09a860`;
  - SCORE partial: `cb6c19370552b400415cdc5c2193617122cb8e4f`.

## Delivery-environment verification

- fresh GitHub owner baseline and README/contracts: PASS;
- `git diff --check`: PASS;
- backend-JavaScript exclusion: PASS;
- ZIP integrity, exact file inventory and extraction round trip: PASS;
- concrete OPUS classes retain their homonymous framework interfaces: PASS;
- PHP lint and Composer/site validation: owner gate because PHP/Composer are
  unavailable in the delivery environment.

## Owner runtime gate

Apply only on the exact clean baseline. Rename a manually positioned state and
verify exact coordinate identity under its new key after reload, with related
transition paths, cards and handles unchanged in View and Design. Validate all
three sites. Return fresh front/back Profiler JSONL and correlated logs; record
n/min/p50/p95/max by request class and compare with the SPEC baseline before
declaring response-time acceptance.
