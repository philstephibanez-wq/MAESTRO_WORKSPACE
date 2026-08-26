# P117W R45B2A4BZ2 R8B6M — Browser-measured EFSM signal cards — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS exact baseline/master: `c11357f4` (owner-pushed R8B6L).
- R8B6L menu and explicit initial marker are runtime accepted.
- Remaining defect: signal text still overflows or touches its estimated frame.

## Root cause

PHP estimated SVG text width from character count. The browser's actual font metrics, weight, underscores, scaling and zoom differ from that estimate. Increasing a fixed width cannot establish a correct invariant.

## Contract

The shared OPUS renderer measures every rendered signal-card text node with native SVG geometry before interaction state is initialized. It computes the union of signal, guard, effect and scope text bounds, then applies a real frame with 14 units horizontal and 8 units vertical padding.

The measured dimensions update the rectangle, POST hit area and signal drag bounds. PHP layout coordinates and EFSM semantics remain unchanged.

## Compatibility

- applies to vertical and horizontal diagrams;
- covers linked and POST-action cards;
- preserves R8B6K/L marker, routing and persistence behavior;
- no layout schema change;
- no OWASYS-local workaround;
- no OWASYS-back source or JavaScript.

## Exact surface

- `Opus/Fsm/Diagram.class.php`.

## Acceptance

Every complete signal label must remain enclosed with visible padding in View and Conception, including `open_home [route_exists] / render_route()`. Right-button movement and reload persistence must remain functional.
