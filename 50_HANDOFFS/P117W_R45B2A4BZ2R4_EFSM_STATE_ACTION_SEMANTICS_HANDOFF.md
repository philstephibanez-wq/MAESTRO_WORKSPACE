# P117W R45B2A4BZ2R4 — EFSM state action semantics — HANDOFF

State: NEXT IMPLEMENTATION = ACTION-FIRST STATE CONTRACT

## Correction to apply

The graphical designer must stop presenting `module` as a semantic property of an FSM state.

The semantic concept is **state action**.

## State inspector target

Primary state model:

- ID;
- state role/type;
- initial/final role;
- `entry_actions`;
- `do_actions`;
- `exit_actions`;
- incoming transitions;
- outgoing transitions;
- self transitions.

`module`, route/template/auth/navigation are application integration metadata, not the state semantics presented by the EFSM designer.

## Generic OPUS work required before further cosmetic designer work

1. add state-action lists to the generic FSM contract;
2. validate action IDs against registered handlers/catalog;
3. execute state exit / transition effect / target entry in deterministic order;
4. preserve runtime atomicity;
5. expose registered state actions to the SCORE designer;
6. begin decoupling `FsmSiteLoader` from `states[].module`.

Do not solve this as a local JavaScript/form rename.

## Compatibility

Current OWASYS still carries `states[].module` because `FsmSiteLoader` derives application modules from it. Keep that field only as compatibility metadata until generic dispatch/module discovery is decoupled.

It must not appear as the central editable state concept.

## Next deliverable

P117W R45B2A4BZ2R5 — generic OPUS state-action contract + designer projection.

The R5 slice must introduce and validate state action semantics before transition/condition CRUD continues.