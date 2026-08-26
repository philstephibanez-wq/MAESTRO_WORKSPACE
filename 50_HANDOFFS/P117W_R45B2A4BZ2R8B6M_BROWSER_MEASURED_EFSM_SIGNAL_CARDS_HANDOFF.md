# P117W R45B2A4BZ2 R8B6M — Browser-measured EFSM signal cards — HANDOFF

State: OWNER RUNTIME ACCEPTED — PUSHED

## Baseline

- README-FIRST: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS HEAD: `c11357f4`.
- baseline `Opus/Fsm/Diagram.class.php` blob: `51025e42711b4c83612056933a2307d7a6a223c3`.

## Delivery

The generic renderer now reconciles each signal-card frame with the browser-measured union of its SVG text nodes. It applies explicit padding and updates the frame, POST hit area and drag dimensions before the interaction maps are built.

## Artifact

- ZIP: `R8B6M.zip`
- ZIP SHA-256: `2c22201008cf1953876c2955229dedc1b1b1b1b30b345b5ffc35051da869cf56`
- size: `32459` bytes
- exact content:
  - `Opus/Fsm/Diagram.class.php`
- file SHA-256: `9f0f51d8bc8acdbd49f71b55b314b2ea36eb46af2a95b9c6a35ba22723d8d949`
- delivered blob: `86c56e0d1d59e604064f491b392ce7890ea194ae`
- embedded JavaScript syntax: PASS
- `git diff --check`: PASS
- ZIP round-trip: PASS

## Owner acceptance

- owner report: “cartes Ok”;
- owner-pushed OPUS HEAD: `40b28ad8c939236b2af4f9bec77b242ed4325eed`;
- accepted Diagram blob: `86c56e0d1d59e604064f491b392ce7890ea194ae`.

R8B6M is closed. R8B6N continues with semantic signal and local-transition creation.
