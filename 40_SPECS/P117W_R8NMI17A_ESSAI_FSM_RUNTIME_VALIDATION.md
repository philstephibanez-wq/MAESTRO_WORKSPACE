# P117W R8NMI17A — ESSAI FSM runtime validation

Date: 2026-09-08

## Symptom

`essai` returns `OPUS_FSM_ENTRY_STATE_ID_INVALID` on `/`.

## Root cause

The semantic editor validates through `FsmDefinitionValidator`, but that validator does not enforce the runtime entry-state invariants enforced later by `FsmProcessor`. Therefore an application FSM could be persisted with an entry state renamed from canonical `begin` to another id and remain accepted by the editor while being rejected by the runtime. The same persisted ESSAI definition also contains ambiguous duplicate local state/signal pairs because two test transitions reuse `open_home` from the entry state.

## Required correction

1. Align `FsmDefinitionValidator` with `FsmProcessor` for canonical entry-state invariants: at most one entry state; entry must be the initial state; canonical entry id is `begin`; if `begin` exists it must be type `entry` and initial.
2. Reject duplicate local `(from, signal)` relations at semantic-validation time so the editor cannot persist a definition the runtime will reject as nondeterministic.
3. Repair `sites/essai/config/application.fsm.json` without deleting the user's semantic objects: rename the entry state back to `begin`, update references, and bind the two added self-loop transitions to their own declared signals (`new`, `transac1`) instead of duplicating `open_home`.
4. Do not change the already-correct scaffold: current `SiteScaffoldPlan::fsmConfig()` already generates `begin` as the unique entry/initial state.

## Acceptance

- `php -l` passes on the validator.
- `FsmDefinitionValidator` accepts repaired ESSAI and rejects the previous `connexion` entry form.
- `FsmProcessor` can instantiate repaired ESSAI.
- `composer opus:validate-site -- essai` passes locally.
- `composer opus:dev-server -- essai --port=8001` serves `/` without `OPUS_FSM_ENTRY_STATE_ID_INVALID`.
