# R8NMI17D — Generated application dev surface

## Scope

Make the generated-application development surface conform to the OPUS/OWASYS separation:

- OWASYS owns FSM authoring, visualization and administration tools.
- A generated application executes its FSM internally but does not render a FSM diagram/tool surface.
- In development, generated applications expose only Logger and Web Profiler diagnostics.
- Production Web Profiler remains forbidden by the existing environment contract.

## Root cause

`SiteScaffoldPlan` still emits FSM presentation artifacts, while `ProfilerEnvironmentScaffoldPolicy` is already the canonical post-scaffold normalization layer that removes Profiler route/FSM coupling and materializes `config/environment.yaml`.

The policy is therefore extended to:

1. remove `common.fsm_diagram` from generated layouts;
2. blank the generated FSM diagram component;
3. remove FSM-only CSS from generated application assets;
4. remove the scaffold-only `route_exists` guard from generated application FSM transitions, because GeneratedSiteRuntime resolves the route before executing the transition and does not register that guard handler;
5. preserve Logger + environment-controlled Profiler only.

## Delivery

Native ZIP: `R8NMI17D.zip`

Changed file only:

- `Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php`

Owner applies, validates, then commits/pushes OPUS.
