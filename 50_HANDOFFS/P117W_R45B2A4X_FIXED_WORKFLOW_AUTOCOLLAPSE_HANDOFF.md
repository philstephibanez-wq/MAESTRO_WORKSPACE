# P117W R45B2A4X — Handoff

State: OWNER REJECTED — SUPERSEDED BY A4Y

A4X was rejected before OPUS commit because its diagram was linearized. The owner requires the previous branched FSM character, but with a fixed geometry rooted at the logical beginning of the FSM.

Do not use A4X as an OPUS baseline.

Valid OPUS baseline remains:

`fcffa3c16c75126208a480382f9efb36be170110` — A4W.

Requirements carried forward to A4Y:

- classic readable branched FSM, not a linear sequence;
- fixed graph geometry on every page;
- root is canonical `initial_state` (`login` / Connexion);
- current state only changes highlight;
- real canonical states/transitions only;
- existing OPUS graphical theme/lane renderer retained;
- native menu autocollapse retained;
- A4W `change_app -> clear_current_app` remains baseline behavior.

Owner alone commits/pushes OPUS/OWASYS.