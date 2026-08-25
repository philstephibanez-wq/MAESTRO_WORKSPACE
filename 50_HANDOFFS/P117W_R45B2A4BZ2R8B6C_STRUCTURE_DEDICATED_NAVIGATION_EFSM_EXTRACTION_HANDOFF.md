# P117W R45B2A4BZ2 R8B6C — Structure dedicated Navigation EFSM extraction — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob revalidated immediately before delivery: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master revalidated immediately before delivery: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`.
- R8B6B4 is owner runtime accepted and pushed.
- Spec: `40_SPECS/P117W_R45B2A4BZ2R8B6C_STRUCTURE_DEDICATED_NAVIGATION_EFSM_EXTRACTION_SPEC.md`.

## Root cause

Structure remained the only accepted OWASYS view rendering the legacy global host FSM because `sites/owasys-front/config/site.json` used `config/fsm.json` for both host dispatch and `efsms.navigation`.

OPUS already separates these concerns:

- `FsmSiteLoader::resolve()` follows `site.json.navigation.fsm`;
- `FsmSiteLoader::resolveEfsm(..., 'navigation')` follows `site.json.efsms.navigation`.

No framework change is needed.

## Delivered architecture

Host dispatch remains:

`site.json.navigation.fsm = config/fsm.json`

Structure contextual EFSM becomes:

`site.json.efsms.navigation = config/navigation.fsm.json`

New source:

`sites/owasys-front/config/navigation.fsm.json`

The dedicated definition contains seven application-structure states:

`registry, application, data, structure, security, source, build`

and fifteen transitions: eight navigation/context-selection transitions plus seven existing cross-EFSM readiness acknowledgement events.

The definition deliberately excludes CRUD internals, Source editor lifecycle, Git operations, Build execution, Security authentication internals, creation wizard internals and account/password workflows.

## Runtime boundary

R8B6C does not rewire the existing context SignalBus. `config/fsm.json` remains the runtime dispatch/orchestration authority for this slice.

The dedicated Navigation EFSM is the canonical Structure VIEW/DESIGN source. Runtime bus authority extraction is deferred until after Structure acceptance.

## Exact OPUS source surface

Modified:

- `sites/owasys-front/config/site.json`.

New:

- `sites/owasys-front/config/navigation.fsm.json`.

No PHP, backend, CSS, JavaScript, layout or generated-site source modification.

## Applicator gates

The runner requires:

- exact HEAD `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d`;
- canonical site blob `0df0e1de0f04d56509b27a382844532ad4d611b9`;
- canonical dispatch blob `c846dd6295dcaa7fc70d5a34513dc5059345aa80`;
- no staged changes;
- no unrelated dirty paths;
- `navigation.fsm.json` absent before application;
- current site pointers both still at `config/fsm.json` before extraction.

Existing layout runtime companions are allowed only under the established `sites/*/config/fsm.layout.json` or `sites/*/config/<efsm>.fsm.layout.json` forms. Each is JSON-validated, SHA-256 snapshotted and required byte-identical after application.

The runner validates the embedded Navigation EFSM identity, exact seven-state set, fifteen-signal registry, fifteen transitions and every state/signal reference before any write.

After writing it proves:

- `site.json.navigation.fsm` is still `config/fsm.json`;
- `site.json.efsms.navigation` is `config/navigation.fsm.json`;
- `config/fsm.json` SHA-256 is unchanged;
- every pre-existing layout companion is unchanged;
- final tracked/untracked inventory is exact;
- `git diff --check` passes for the tracked source change.

Rollback on post-write failure restores only `site.json` and removes only the newly created `navigation.fsm.json`.

## Replay validation

Replay A with one tracked runtime `fsm.layout.json` companion: PASS.

Replay B with one tracked runtime `fsm.layout.json` plus one untracked `security.fsm.layout.json`: PASS.

Both replays produced:

- `P117W_R45B2A4BZ2R8B6C_PREFLIGHT_OK`;
- `P117W_R45B2A4BZ2R8B6C_REPO_CHANGES_VERIFIED`;
- `changed_source_paths=2`;
- `navigation_states=7`;
- `navigation_signals=15`;
- `navigation_transitions=15`;
- `dispatch_fsm=preserved-byte-for-byte`;
- `runtime_bus_rewire=deferred`;
- `P117W_R45B2A4BZ2R8B6C_APPLIED`.

## Artifact

- ZIP: `opus_p117w_r45b2a4bz2r8b6c_structure_dedicated_navigation_efsm_extraction.zip`;
- ZIP SHA-256: `9f9bcd3bd158ae722ca37b0877b36e2654c9daa43f44180da283847bd211813c`;
- ZIP size: 4384 bytes;
- ZIP contains exactly `apply_a4bz2r8b6c.php`;
- applicator size: 19306 bytes;
- applicator SHA-256: `d5cc80567e1b195c1a2415f6a80a2f086ab6cbb56af369e9b31de41d2b7a38dc`;
- applicator PHP lint: PASS;
- ZIP re-extraction byte comparison: PASS;
- extracted applicator PHP lint: PASS;
- no internal Composer invocation.

## Owner validation

Apply from a temporary directory outside `H:\OPUS`.

Then validate `owasys-front`, `owasys-back` and `essai`, inspect `git status --short`, and run `git diff --check`.

Runtime acceptance requires:

1. Structure selected on `owasys-front` displays `owasys-front / navigation` with source `config/navigation.fsm.json`.
2. The graph contains seven states and fifteen transitions, not the historical global workflow.
3. Normal OWASYS navigation still works because dispatch remains `config/fsm.json`.
4. Applications/Application/Data/Source-Git/Build/Security remain unchanged on their dedicated EFSMs.
5. DESIGN persistence on Structure creates/updates only `config/navigation.fsm.layout.json`; existing `config/fsm.layout.json` must remain unchanged.
6. No commit/push until these gates pass.
