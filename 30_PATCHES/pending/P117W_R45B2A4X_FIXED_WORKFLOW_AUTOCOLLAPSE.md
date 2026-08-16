# P117W R45B2A4X — Fixed logical FSM workflow + native menu autocollapse

State: OWNER REJECTED — SUPERSEDED BY A4Y

## Rejection

Owner rejected A4X before OPUS commit because it flattened the FSM into a linear workflow. That presentation does not match the requested FSM semantics or the previously accepted branched visual model.

A4X must not be committed or used as a baseline.

The valid baseline remains OPUS A4W:

`fcffa3c16c75126208a480382f9efb36be170110` — `opus_p117w_r45b2a4w_direct_fsm_fanout_change_app`.

## Preserved requirement

The owner nevertheless confirmed two A4X intentions that remain required for the successor:

- geometry must be fixed and start from the canonical logical beginning (`initial_state = login` / Connexion), never from the current state;
- menu autocollapse is wanted.

The rejected part is specifically the linearization of the graph.

## Successor contract

A4Y restores a classic branched FSM graph derived only from real canonical FSM states/transitions, fixes its root at `initial_state`, leaves current state as highlight only, preserves OPUS visual theming, and retains native menu autocollapse.

Owner alone commits/pushes OPUS/OWASYS. Assistant updates MAESTRO_WORKSPACE only.