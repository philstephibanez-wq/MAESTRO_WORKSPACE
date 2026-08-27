# P117W R45B2A4BZ2 R8B6P — Dependency-safe transition delete — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- README-FIRST: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- OPUS owner HEAD: `23be733f401ff526ff4d32a64277e6af1778f024`.
- baseline blobs:
  - definition editor: `5ada4494822041bd7b1cb28b4f382c99c9a8180a`;
  - back provider: `544aff1dabcee88bb27b2706b40950e48ba62b62`;
  - diagram builder: `2e392a98b64b26a0fdd29de9402f493680335bca`;
  - SCORE renderer: `6d50d596fd3723db15588adcf983c080bf83d5ae`;
  - SCORE partial: `9966f0dbed6738bfb71591da7c4775a26b8752d3`;
  - designer JavaScript: `d4fd7f15f447b20acb290c579c2ce79e4f813728`.

## Delivery

R8B6P activates dependency-safe TRANSITION deletion. Exact typed confirmation
is validated by generic OPUS, the canonical source write remains optimistic and
atomic, and an unused signal is reported without being deleted. STATE deletion
now exposes and preflights its exact dependent transition IDs.

All graphical designer fetches record browser response duration. The accepted
input-log baseline is class-separated in the SPEC; fresh runtime logs are
mandatory before closure.

## Artifact

- ZIP: `R8B6P.zip`.
- ZIP SHA-256: `fd3430192a746f171b96af6705d8a8261ecc981ae090ec5dcfd5da8ba7431b04`.
- size: `35797` bytes.
- exact contents:
  - `Opus/Fsm/Definition/FsmDefinitionEditor.php`;
  - `sites/owasys-back/application/fsm/services/OwasysFsmDraftCommandProvider.php`;
  - `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
  - `sites/owasys-front/application/default/services/ScorePageRenderer.php`;
  - `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`;
  - `sites/owasys-front/www/asset/js/fsm-designer.js`.
- delivered blobs:
  - definition editor: `bf83683fb2caefef258c7252f363d3a2f868c87d`;
  - back provider: `21fdf1509e2ffc4af7ebdf01e0b4cc366724ec38`;
  - diagram builder: `332c02b58b9cc926705d28a3184a3e4f60d26aea`;
  - SCORE renderer: `57c72db939dab23e22c937f5bdaaa9c7205c60fd`;
  - SCORE partial: `5fca386a27b725d671bf6b346d6562dd9adeb835`;
  - designer JavaScript: `f3d9512b3f415f9229f654605da7ba1fb6d72cf4`.

## Delivery-environment verification

- external designer JavaScript syntax: PASS;
- `git diff --check`: PASS;
- backend-JavaScript exclusion: PASS;
- ZIP integrity, exact six-file inventory and extraction round trip: PASS;
- full PHP lint and Composer/site validation: owner gate because PHP is not
  available in the delivery environment.

## Owner runtime gate

Apply the native ZIP only on the exact clean baseline. Delete `transac`, confirm
that `test` becomes deletable, and verify that unrelated transition geometry
and R8B6O handles remain stable. Return fresh front/back JSONL and logs so the
four response-time classes can be compared before acceptance.
