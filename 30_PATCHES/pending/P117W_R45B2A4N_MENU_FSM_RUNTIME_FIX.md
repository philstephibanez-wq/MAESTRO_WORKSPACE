# P117W R45B2A4N — Menu = FSM runtime fix

State: OWNER VALIDATION REQUIRED

## Context

R45B2A4M established the intended UI contract:

- one FSM state = one menu entry;
- outgoing signals of that state = its submenu entries;
- the state itself is context and does not perform a transition;
- only a signal performs the transition;
- the diagram is another projection of the same FSM/menu relation.

However A4M introduced `OWASYS_FRONT_RUNTIME_FAILED` before rendering.

## Root cause

A4M inverted the HTTP/FSM contract in `OwasysNavigationBuilder`.

`config/routes.json` contract `OPUS_SIGNAL_ROUTES_V2` means:

`HTTP route -> FSM signal`

It does **not** mean:

`HTTP route == route of transition next_state`

The target state is owned exclusively by the FSM transition. A valid example is a route such as `logout` emitting signal `logout` while the transition reaches state `login`. A4M compared the signal endpoint route with the target state's canonical route and threw `OWASYS_NAVIGATION_SIGNAL_ROUTE_TARGET_DIVERGENCE` during menu construction.

A4M also made the diagram perform a second ACL check after the menu projection had already normalized ACL/availability. This violated the single-projection contract and could create a second divergence/failure path.

## Required correction

1. `OwasysNavigationBuilder`
   - remove direct state URL from menu view data;
   - keep the FSM state as menu context only;
   - invert `OPUS_SIGNAL_ROUTES_V2` only to obtain the HTTP endpoint that emits a signal;
   - never compare that endpoint to `next_state.route`;
   - keep `next_state` exclusively transition-owned;
   - expose the signal trigger route only as audit data on the submenu signal;
   - a signal is actionable only when its source is the current state, target is available, and a GET signal endpoint exists.

2. `OwasysFsmDiagramBuilder`
   - consume the already normalized `pageData.navigation` projection;
   - do not re-run ACL decisions;
   - keep transition IDs, signals and links identical to the menu projection.

3. `OwasysScorePageRenderer`
   - instantiate the diagram builder without a second security dependency for FSM projection.

4. `fsm-diagram.score`
   - expose revision `P117W_R45B2A4N` so the corrected runtime surface is visible after successful rendering.

## Acceptance contract

- `/fr-FR` must no longer return `OWASYS_FRONT_RUNTIME_FAILED` because a signal endpoint differs from its target-state route.
- Menu remains `state -> submenu(signals)`.
- Clicking a state does not navigate.
- Clicking an actionable signal invokes that signal endpoint.
- The FSM transition alone determines `next_state`.
- Diagram consumes the same menu projection and does not recalculate ACL/navigation.
- NMI remains out-of-band.

## Deliverable

`opus_p117w_r45b2a4n_menu_fsm_runtime_fix.zip`

SHA-256:

`ee5db334f122072105a4a4aaef313c253b50ac7174e7859b853c3695e4d42b91`

Expected OPUS base:

`b51a0693355f9cc3074bb1fdeb111f1f60d98dd0` (`opus_p117w_r45b2a4m_menu_equals_fsm`)

The assistant does not commit or push OPUS/OWASYS. Owner applies, validates, commits and pushes.