# R8NMI17D — Generated application development surface contract

## Contract

OWASYS is the construction and administration environment. Generated applications are autonomous OPUS applications, not embedded OWASYS workbenches.

A generated presentation application:

- executes its canonical application FSM internally;
- does not render or expose FSM diagram/designer UI;
- exposes Logger and Profiler diagnostics in `dev` only;
- relies on `config/environment.yaml` for Profiler collection/web/link policy;
- must remain fail-closed in production, where Web Profiler is forbidden.

## Normalization authority

`Opus\Scaffold\ProfilerEnvironmentScaffoldPolicy` is the post-scaffold normalization authority for generated presentation sites. It must strip construction-only surfaces from generated apps while preserving runtime semantics.

Required normalization:

- no `common.fsm_diagram` layout slot;
- no rendered FSM component;
- no FSM-only presentation CSS;
- no `profiler` route/state/signal coupling in the application FSM;
- no scaffold-only `route_exists` guard when route resolution is already enforced by `GeneratedSiteRuntime` before FSM transition execution;
- Logger + Profiler remain the only development diagnostics.

## Acceptance

For a newly generated frontend/fullstack app:

1. application home renders without FSM diagram;
2. application FSM still drives route state transitions;
3. no `OPUS_FSM_GUARD_HANDLER_MISSING: route_exists` occurs;
4. Web Profiler is available in `dev` according to environment configuration;
5. OWASYS can still select the application and render/edit its canonical FSM.
