# P117W R45B2A4AX — Canonical FSM text graph and development-workflow audit

State: DESIGN/AUDIT DELIVERY — OWNER REVIEW REQUIRED BEFORE TOPOLOGY CHANGE

## Baseline

OPUS owner HEAD:

`892f4f389bede3fb55312b5fb4e88f14174c3818` — `opus_p117w_r45b2a4aw_fsm_signal_origin_and_diagram_actionability`

Canonical source:

`sites/owasys-front/config/fsm.json`

Contract: `OWASYS_NAVIGATION_FSM_V1`

Initial state: `login`

The canonical FSM contains 16 states, 50 signals and 55 transition definitions (43 local/NMI definitions plus 11 global definitions; a global definition applies to multiple source states).

## Legend

- `[STATE]` = FSM state.
- `U:` = signal with `origin=user`.
- `A:` = signal with `origin=automatic`.
- `[guard]` = FSM guard.
- `/ action` = FSM action.
- `{runtime: ...}` = runtime stack/context operation.
- `GLOBAL` = one canonical transition definition with a finite `from_states` set.
- `NMI` = interrupt transition from `*`.

HTTP GET/POST is intentionally absent from this semantic graph. Transport does not define FSM meaning or signal color.

## 1. Authentication / session

```text
[*]
  -- A:auth_required / clear_session [NMI] ------------------------> [login]

[login]
  -- U:open_login -------------------------------------------------> [login]
  -- A:login_failed -----------------------------------------------> [login]
  -- A:login_success / start_session ------------------------------> [registry]
  -- A:password_change_required [must_change_password]
       / start_session, redirect_password_change ------------------> [password]

[password]
  -- A:password_change_failed -------------------------------------> [password]
  -- A:password_changed
       / update_runtime_password_hash,
         clear_must_change_password -------------------------------> [registry]
```

## 2. Registry / application selection

```text
[registry]
  -- U:select_app [app_exists] / set_current_app ------------------> [data]
  -- U:clear_app_context / clear_current_app ----------------------> [registry]
  -- U:create_new_app / clear_current_app -------------------------> [creation_basics]
  -- A:application_deleted / clear_current_app --------------------> [registry]
  -- A:registry_action_failed -------------------------------------> [registry]
```

The canonical entry point after choosing an existing application is therefore **always `data`**.

## 3. Application creation workflow

```text
[creation_basics]
  -- U:continue_security ------------------------------------------> [creation_security]
  -- U:cancel_creation --------------------------------------------> [registry]

[creation_security]
  -- U:return_basics ----------------------------------------------> [creation_basics]
  -- U:continue_review --------------------------------------------> [creation_review]
  -- U:cancel_creation --------------------------------------------> [registry]

[creation_review]
  -- U:return_security --------------------------------------------> [creation_security]
  -- U:begin_application_creation ---------------------------------> [application_creating]
  -- U:cancel_creation --------------------------------------------> [registry]

[application_creating]
  -- A:application_created [app_exists] / set_current_app ---------> [application_created]
  -- A:application_creation_failed -------------------------------> [application_creation_failed]

[application_creation_failed]
  -- U:return_security --------------------------------------------> [creation_security]
  -- U:begin_application_creation ---------------------------------> [application_creating]
  -- U:cancel_creation --------------------------------------------> [registry]

[application_created]
  -- GLOBAL U:open_data [current_app_required] --------------------> [data]
  -- GLOBAL U:open_structure [current_app_required] ---------------> [structure]
  -- GLOBAL U:open_security [current_app_required] ----------------> [security]
  -- GLOBAL U:open_workflows [current_app_required] ---------------> [workflows]
  -- GLOBAL U:open_source [current_app_required] ------------------> [source]
  -- GLOBAL U:open_build [current_app_required] -------------------> [build]
```

## 4. Current application workspace — canonical graph

Application-aware screen set:

```text
W = {
  data,
  structure,
  security,
  workflows,
  source,
  build
}
```

For **every state X in W**, the canonical FSM currently exposes the same six guarded global navigation transitions:

```text
[X]
  -- U:open_data       [current_app_required] ---------------------> [data]
  -- U:open_structure  [current_app_required] ---------------------> [structure]
  -- U:open_security   [current_app_required] ---------------------> [security]
  -- U:open_workflows  [current_app_required] ---------------------> [workflows]
  -- U:open_source     [current_app_required] ---------------------> [source]
  -- U:open_build      [current_app_required] ---------------------> [build]
```

Expanded explicitly:

```text
[data] ------open_data-------> [data]          SELF LOOP
[data] ------open_structure--> [structure]
[data] ------open_security----> [security]
[data] ------open_workflows---> [workflows]
[data] ------open_source------> [source]
[data] ------open_build-------> [build]

[structure] --open_data-------> [data]
[structure] --open_structure--> [structure]    SELF LOOP
[structure] --open_security----> [security]
[structure] --open_workflows---> [workflows]
[structure] --open_source------> [source]
[structure] --open_build-------> [build]

[security] ---open_data-------> [data]
[security] ---open_structure--> [structure]
[security] ---open_security----> [security]     SELF LOOP
[security] ---open_workflows---> [workflows]
[security] ---open_source------> [source]
[security] ---open_build-------> [build]

[workflows] --open_data-------> [data]
[workflows] --open_structure--> [structure]
[workflows] --open_security----> [security]
[workflows] --open_workflows---> [workflows]    SELF LOOP
[workflows] --open_source------> [source]
[workflows] --open_build-------> [build]

[source] -----open_data-------> [data]
[source] -----open_structure--> [structure]
[source] -----open_security----> [security]
[source] -----open_workflows---> [workflows]
[source] -----open_source------> [source]        SELF LOOP
[source] -----open_build-------> [build]

[build] ------open_data-------> [data]
[build] ------open_structure--> [structure]
[build] ------open_security----> [security]
[build] ------open_workflows---> [workflows]
[build] ------open_source------> [source]
[build] ------open_build-------> [build]         SELF LOOP
```

This is a complete directed navigation mesh between the six application screens, including six navigation self-loops. It is **not an ordered development workflow**.

The same six guarded global entries are also declared from `login`, `registry`, `application_created`, `account` and `password`; guard `current_app_required` decides whether they can fire.

## 5. Source + Git local submachine

All source/Git operations currently remain in state `source`.

```text
[source]
  -- U:open_source_file [current_app_required]
       {runtime: push source_path; poke source_path; poke locale} --> [source]

  -- U:change_locale [current_app_required]
       {runtime: poke locale} -------------------------------------> [source]

  -- U:preview_source [current_app_required] ----------------------> [source]
  -- A:source_previewed [current_app_required] --------------------> [source]

  -- U:write_source [current_app_required] ------------------------> [source]
  -- A:source_written [current_app_required] ----------------------> [source]
  -- A:source_conflict [current_app_required] ---------------------> [source]
  -- A:source_action_failed [current_app_required] ----------------> [source]

  -- U:stage_source [current_app_required]
       {runtime: poke git_action; poke git_path} ------------------> [source]
  -- A:source_staged [current_app_required] -----------------------> [source]

  -- U:unstage_source [current_app_required]
       {runtime: poke git_action; poke git_path} ------------------> [source]
  -- A:source_unstaged [current_app_required] ---------------------> [source]

  -- U:commit_source [current_app_required]
       {runtime: poke git_action} ---------------------------------> [source]
  -- A:source_committed [current_app_required] --------------------> [source]

  -- U:restore_source [current_app_required]
       {runtime: poke git_action; poke git_path} ------------------> [source]
  -- A:source_restored [current_app_required] ---------------------> [source]
  -- A:git_action_failed [current_app_required] -------------------> [source]

  -- U:open_profiler [current_app_required]
       {runtime: push return_url; poke profiler_open;
                 poke profiler_trace_id} --------------------------> [source]

  -- U:close_profiler [current_app_required]
       {runtime: pop profiler_return_url; poke profiler_open} -----> [source]
```

These same-state transitions are legitimate technical/workbench transitions because they mutate source/Git/profiler context. They are semantically different from a pure navigation self-loop such as `data --open_data--> data`, which performs no workflow progress.

## 6. Global account / application / session rails

The following finite global transitions are declared from all 16 canonical states:

```text
ANY_CANONICAL_STATE
  -- U:open_account -----------------------------------------------> [account]
  -- U:open_password_change ---------------------------------------> [password]
  -- U:open_creation ----------------------------------------------> [creation_basics]
  -- U:change_app / clear_current_app -----------------------------> [registry]
  -- U:logout / clear_current_app, clear_session ------------------> [login]
```

And independently:

```text
* -- A:auth_required / clear_session [NMI] ------------------------> [login]
```

## 7. Complete high-level canonical graph

```text
                                      +----------------------+
                                      |      password        |
                                      +----------------------+
                                      ^   | changed
                         required     |   v
+-------+ login_success +----------+  | +----------+
| login |-------------> | registry |--+-| account  |
+-------+                +----------+    +----------+
  ^  |                       |
  |  |                       | select_app [app_exists]
  |  |                       | / set_current_app
  |  |                       v
  |  |                 +-----------+
  |  |                 |   data    |
  |  |                 +-----------+
  |  |                       |
  |  |                       | CURRENT CANONICAL APP WORKSPACE
  |  |                       v
  |  |       +---------------------------------------------------+
  |  |       | complete directed mesh + self loops               |
  |  |       |                                                   |
  |  |       | data <-> structure <-> security <-> workflows     |
  |  |       |   ^          ^           ^            ^           |
  |  |       |   |          |           |            |           |
  |  |       |   +----------+----- source ------------+           |
  |  |       |                    ^      |                         |
  |  |       |                    +-- build -----------------------+
  |  |       +---------------------------------------------------+
  |  |
  |  |              create_new_app
  |  |         +----------------------+
  |  |         v                      |
  |  |  creation_basics               |
  |  |      | continue_security       |
  |  |      v                         |
  |  |  creation_security             |
  |  |      | continue_review         |
  |  |      v                         |
  |  |  creation_review               |
  |  |      | begin_application_creation
  |  |      v
  |  |  application_creating
  |  |      |                 |
  |  |      | created         | failed
  |  |      v                 v
  |  |  application_created   application_creation_failed
  |  |      |                 | retry / return / cancel
  |  |      +--> app workspace+
  |  |
  +--+ logout / auth_required from global/NMI rails
```

## 8. Development-workflow audit

Owner runtime observation after A4AW:

- visual FSM semantics are improved;
- after selecting an application, runtime lands in `data` as declared by `t_select_app`;
- owner observes `open_data` as the immediate useful/visible action and it loops back to `data`;
- development navigation is therefore not yet efficient.

### Root cause A — topology is navigation mesh, not development workflow

The canonical FSM gives `data`, `structure`, `security`, `workflows`, `source`, and `build` equal global peer-navigation semantics. There is no canonical progression such as:

```text
data -> structure -> security -> workflows -> source -> build
```

No signal presently means `continue_to_next_development_step` or equivalent. Such a progression must not be invented by the renderer.

### Root cause B — pure navigation self-loops are canonical

Each of the six global `open_*` transitions includes its target state in its own `from_states` list. Therefore the FSM explicitly contains:

```text
data       --open_data-------> data
structure  --open_structure--> structure
security   --open_security---> security
workflows  --open_workflows--> workflows
source     --open_source-----> source
build      --open_build------> build
```

These loops are different from source/Git technical self-loops because they do not represent an operation or workflow progress.

### Root cause C — projection compounds the usability problem

`OwasysNavigationBuilder` currently emits the global rail once and anchors it under `registry` (`Applications`) instead of the current state's submenu. `OwasysFsmDiagramBuilder` renders each ordinary global transition only once using a representative source state. That keeps the drawing finite, but means the visual owner of a global edge is not necessarily the actual current source state.

The next code delivery must therefore preserve the canonical topology unless/until the owner approves a topology redesign, but make current-state actionability explicit and non-misleading.

## 9. Proposed target workflow for owner review — NOT YET CANONICAL

The UI ordering strongly suggests the following efficient developer journey after selecting an application:

```text
[registry]
   |
   | U:select_app [app_exists] / set_current_app
   v
[data / Sources de données]
   |
   v
[structure]
   |
   v
[security]
   |
   v
[workflows]
   |
   v
[source / Sources et Git]
   |
   v
[build / Construction et validation]
```

This is a **proposal for discussion**, not a change applied by A4AX. The owner must decide whether these screens are:

1. true sequential FSM workflow stages;
2. independent peer workspaces reachable in arbitrary order;
3. a hybrid model with a preferred forward path plus explicit peer navigation.

No OPUS/OWASYS code or FSM topology is changed by A4AX.

## 10. Next implementation constraint

Do not fix the symptom by hiding `open_data` only in CSS or by inventing a route. The next code delivery must follow the owner-selected semantic model and maintain:

- FSM as source of truth;
- color = signal origin only;
- actionability independent from transport and color;
- exact ACL/guard enforcement;
- fixed diagram topology derived from the same canonical FSM;
- no false GET/POST interpretation as FSM semantics;
- no manual generated-site patch.
