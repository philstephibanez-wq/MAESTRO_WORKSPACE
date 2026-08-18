# P117W R45B2A4AX — Handoff

State: DESIGN/AUDIT DELIVERY — OWNER REVIEW REQUIRED BEFORE TOPOLOGY CHANGE

## Owner baseline

OPUS HEAD:

`892f4f389bede3fb55312b5fb4e88f14174c3818` — `opus_p117w_r45b2a4aw_fsm_signal_origin_and_diagram_actionability`

A4AW is therefore the current owner commit/push baseline.

## Runtime evidence received

Owner report on 2026-08-18:

- A4AW is visually "Mieux";
- after choosing an application, runtime lands on Sources de données (`data`);
- owner observes `open_data` as the immediate visible/useful signal and it loops;
- owner states that the development workflow is not yet 100% efficient;
- owner requires a complete textual FSM workflow graph before the next topology/code change.

## Canonical graph audit

Source audited:

`sites/owasys-front/config/fsm.json`

Blob:

`5595cd8be05f01e6d8f2b8a1dd519e6ea9675c3c`

The canonical FSM contains:

- 16 states;
- 50 signals with explicit `origin=user|automatic`;
- 55 transition definitions;
- initial state `login`.

The full textual graph and analysis are stored in:

`40_SPECS/P117W_R45B2A4AX_CANONICAL_FSM_TEXT_GRAPH_AND_DEV_WORKFLOW_AUDIT.md`

## Structural finding

`t_select_app` is explicitly:

`registry --select_app [app_exists] / set_current_app--> data`

After that, the six application workspaces:

- `data`;
- `structure`;
- `security`;
- `workflows`;
- `source`;
- `build`;

are not modeled as an ordered development workflow. They are a guarded global navigation mesh. Every one of those six states can navigate to all six targets, including itself.

Consequently the canonical FSM explicitly contains six pure-navigation self-loops:

- `data --open_data--> data`;
- `structure --open_structure--> structure`;
- `security --open_security--> security`;
- `workflows --open_workflows--> workflows`;
- `source --open_source--> source`;
- `build --open_build--> build`.

These must not be confused with legitimate same-state source/Git operations, which mutate editor/Git/profiler context.

## Projection finding

Current `NavigationBuilder` hosts the global rail once under `registry`/Applications.

Current `FsmDiagramBuilder` draws each ordinary global transition once from a representative source in order to keep the fixed graph finite.

This finite projection is valid as a visualization technique, but it does not define a sequential developer journey and can make current-state actionability visually non-obvious.

## No code in A4AX

A4AX deliberately changes no OPUS/OWASYS code and no FSM topology. The owner requested the textual graph, and changing the development semantics before owner review would invent business/workflow intent.

The next code delivery must treat the selected semantic model at the cause level. It must not hide a loop only in CSS or invent a REST route.

## Candidate development progression for owner review

Not canonical yet:

`registry -> data -> structure -> security -> workflows -> source -> build`

The owner must decide whether this is:

- a strict sequential workflow;
- only a preferred path while peer navigation remains possible;
- or whether the six screens are intentionally unordered workspaces.

All A4AW contracts remain mandatory, in particular:

- color = user vs automatic signal origin only;
- transport is orthogonal to FSM semantics;
- actionability is independent of color and transport;
- Menu = FSM;
- diagram derived from the same canonical FSM;
- fixed topology and geometry invariants remain unless the canonical workflow itself is deliberately changed.
