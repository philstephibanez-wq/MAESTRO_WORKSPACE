# P117W R45B2A4Y — Fixed branched FSM + native menu autocollapse

State: OWNER REJECTED — SUPERSEDED BY R45B2A4Z

## Rejection reason

Owner visual validation rejected A4Y because, although fixed and branched, it still read too much like a ranked workflow/org-chart and not enough like a classic state-machine diagram.

The required visual grammar is now explicit:

- classic 2D FSM readability;
- canonical beginning at `initial_state = login` / Connexion;
- stable geometry independent of runtime current state;
- current state highlighted only;
- forward branches, backward returns and representative self-loops visible;
- signal labels attached to real transitions;
- no linearization;
- no current-state-centered fan-out;
- OPUS/OWASYS visual charter retained.

A4Z supersedes A4Y with a denser classic FSM projection containing real loops and long returns in addition to the forward branches.

Do not commit A4Y.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.