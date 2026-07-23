# OPUS CURRENT STATE

Last updated: 2026-07-24.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head reviewed: `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- Owner local repo: `H:/OPUS`

## Active milestone

P117U canonical OWASYS REST + Composer backend with mandatory HF1, HF2, HF3 and HF4.

Canonical resume point:

`CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`

HF4 specification:

`CONTEXT/SPECIFICATIONS/OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_SPEC.md`

HF4 handoff:

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_P117U_HF4_LOGGER_PROFILER_EXITCODE_2026-07-24.md`

## Immutable separation

```text
OPUS = generic framework
OWASYS = OPUS application and SCORE frontend
REST + Composer = OWASYS backend
Created sites = independent OPUS applications
```

## Root contract

Only the owner-confirmed OPUS roots are admitted. Root `bin/`, lowercase root `config/`, root `public/` and new top-level directories remain forbidden.

## Artifact stack

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4
```

HF4:

- ZIP: `opus_owasys_p117u_hf4_logger_profiler_exitcode.zip`
- SHA-256: `2f48a42be49153a3c67186e26553f884c6401486e42a3747db9716d4fb1e1b07`
- files: 7
- payload bytes: 52,274

## HF4 framework evolution

HF4 modifies existing components only:

- `LoggerInterface`;
- `ProfilerInterface`;
- `TraceInterface`;
- `ComposerCommandExecutor`;
- `RcpRestClient`;
- `RcpRestServer`;
- OWASYS backend diagnostic configuration.

No new concrete framework class is introduced.

The Logger/Profiler/Trace interfaces now declare the public methods already implemented by their concrete classes while retaining the four standard marker extensions.

## Diagnostics

RCP server and Composer executor now use the existing OPUS Logger and Profiler.

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

The trace ID is included in REST records and appended to frontend backend-error exceptions.

No request parameters or secrets are logged. Failure excerpts are sanitized and bounded.

## Windows process correction

The former process boundary used only the observed `proc_get_status` code and discarded `proc_close`.

HF4 records and resolves both. A Windows observed `-1` with close code `0` is now recognized as success. If neither value is valid, execution fails explicitly with `OPUS_RCP_PROCESS_EXIT_CODE_UNAVAILABLE`.

## Runtime incidents addressed

1. FSM constant: HF1.
2. Missing backend process: two-process topology.
3. Composer PHAR discovery and HTML/JSON errors: HF2.
4. Prefixed/multiline result parsing: HF3.
5. Generic command failure without diagnostics: HF4.

## Security state

The tracked local environment file was removed from Git and pushed in OPUS commit `96884961248fc82bf5e13187a6ffcfffacb82d9f`.

Previously committed or pasted secret values must not be reused for nonlocal deployment.

## Validation

Green:

- modified PHP lint;
- backend JSON parse;
- Logger/Profiler/Trace implementation compatibility;
- structured log/profiler fixtures;
- secret redaction;
- Composer success/failure fixtures;
- Windows exit-code fixture;
- ZIP content and integrity.

## Pending

1. apply HF4 after HF3;
2. regenerate autoload;
3. restart backend then frontend;
4. reproduce Registry synchronization;
5. inspect log and trace;
6. validate remaining Registry/password/browser/Auth0 gates;
7. commit OPUS after owner acceptance.
