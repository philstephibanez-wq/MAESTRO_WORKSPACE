# P117W R45B2A4BZ2 R8B5 — SecurityContext + inter-EFSM COMMAND/EVENT foundation

State: DESIGN FROZEN — CODE DELIVERY GATED BY POST-R8B4C OPUS GITHUB HEAD

## Source-of-truth gate

This specification was written only after re-reading in the same work cycle:

- `README-FIRST.md`;
- `00_COMMON_CONTRACTS/ZERO_FALLBACK_CONTRACT.md`;
- `00_COMMON_CONTRACTS/GIT_AND_BRANCH_CONTRACT.md`;
- active architecture `40_SPECS/P117W_MICRO_EFSM_APPLICATION_SKELETON_ARCHITECTURE_SPEC.md`;
- current OPUS `FsmProcessor`, `FsmProcessorInterface`, `FsmActionDispatcher`, `FsmSiteLoader`, `FsmSessionStore`;
- current OWASYS-front `SecurityController`, `RuntimeController`, `FsmActionHandlers`, secured REST source model;
- current generated runtime `GeneratedSiteRuntime` and current `essai` Navigation/Security definitions.

At specification time OPUS GitHub `master` still points to:

`4043702f4bc6b190fd51f2acc1fe6d939e3c19c1`

`opus_p117w_r45b2a4bz2r8b4b1_security_sso_localized_route_committed_baseline_repair`

R8B4C has been reported `réglé` by the owner, but its accepted four-path differential has not yet appeared on OPUS GitHub. Therefore R8B5 code generation is intentionally blocked until the owner commits/pushes R8B4C and the assistant can re-read the resulting exact HEAD.

## Architectural authority

The active micro-EFSM architecture requires:

- each EFSM current state is private to that EFSM;
- one EFSM never mutates another EFSM state directly;
- inter-EFSM cooperation occurs through signals on an EFSM network/bus;
- COMMAND and EVENT are distinct semantic categories;
- the generic target includes `FsmSignalBusInterface`, bounded delivery, explicit addressing, message/correlation/causation identifiers, context bounds, TTL/hop count and Logger/Profiler instrumentation;
- Security may be the writer authority of `SecurityContext`, while other EFSMs receive a read-only view.

## Current runtime gap

R8B4/R8B4C established canonical contextual **definition authority** for Navigation and Security, including dedicated Security sources.

Runtime ownership is not yet aligned.

Current OWASYS-front `OwasysSecurityController` still:

- loads `FsmSiteLoader::processorForSiteRoot($this->siteRoot)` — the OWASYS host Navigation FSM;
- restores/persists session key `opus.fsm.owasys-front` — the Navigation runtime key;
- enters the `security` navigation state with signal `open_security`;
- uses that Navigation state as the controller's only FSM runtime state.

Therefore the screen now **displays** the contextual Security micro-EFSM correctly, but the Security workspace itself does not yet own an independent Security runtime.

This is the cause R8B5 treats.

## Required generic OPUS evolution

R8B5 introduces the first in-process generic EFSM signal network foundation.

### `FsmSignalBusInterface` / `FsmSignalBus`

A new concrete framework component and homonymous interface are required.

The interface must extend directly:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The bus is not allowed to guess a target, source, file or route.

First-slice transport is bounded in-process unicast. The message contract contains at least:

- contract/version;
- semantic category: `command` or `event`;
- `message_id`;
- `source_fsm`;
- `target_fsm`;
- `signal`;
- `correlation_id`;
- optional `causation_id`;
- bounded context;
- TTL/hop count.

Unknown target, invalid category, invalid signal, exhausted TTL or malformed envelope fails explicitly.

Each dispatch is instrumented with real Logger/Profiler events. No secret, password, token, CSRF value or provider secret may enter the bus context or diagnostics.

Multicast/broadcast and network transport are architectural target items, not falsely claimed by this first vertical slice.

### Processor interface alignment

`FsmProcessorInterface` currently exposes inspection/state access but does not declare the existing concrete `transition()` operation required by a generic bus target.

R8B5 must add the existing transition signature to the interface rather than coupling the bus to an undeclared concrete-only method.

No behavior change to `FsmProcessor::transition()` is required unless the post-R8B4C source proves otherwise.

## OWASYS-front SecurityContext ownership

R8B5 introduces an explicit OWASYS-front SecurityContext runtime service, with a read-only interface consumed outside Security and a writer owned by Security.

The Security runtime is **OWASYS-front's own `security` EFSM**, not the currently selected application's EFSM.

This distinction is mandatory:

- the selected application Security EFSM remains the canonical design/diagnostic subject displayed and edited by OWASYS;
- OWASYS-front runtime Security state belongs to `owasys-front/security`;
- no target-application filesystem access is introduced in OWASYS-front;
- selected-application definitions/data continue to cross the existing secured REST boundary.

The SecurityContext runtime must use the named-EFSM authority introduced by R8B4/R8B4C and a dedicated session snapshot key distinct from Navigation.

Navigation keeps its own current state and session persistence. Security keeps its own current state and persistence.

## First real Security/Navigation cooperation

R8B5 establishes a minimal real handshake proving two autonomous micro-EFSM runtimes can cooperate without direct state mutation.

### Navigation responsibility

Navigation continues to own route/screen transition `open_security -> security`.

After Navigation reaches its `security` state, it sends an explicit unicast **COMMAND** to the Security EFSM indicating entry into the Security context.

### Security responsibility

Security consumes that command through a declared Security signal/transition without changing its authentication state merely because a screen was opened.

The Security definition therefore receives a context-entry signal with state-preserving transitions for the applicable Security states.

Security then emits an explicit **EVENT** back to Navigation confirming that the Security context is ready.

Navigation consumes that event through a declared state-preserving transition while it remains in Navigation state `security`.

The handshake must use one correlation id; the EVENT causation id references the COMMAND message id.

No EFSM writes the other EFSM's state or memory directly.

## Security runtime synchronization

OWASYS-front already has a real authenticated management session before its Security workspace is accessible.

On first SecurityContext runtime creation in an authenticated session, Security may explicitly synchronize its own Security EFSM from `anonymous` through its existing authentication lifecycle to `authenticated` using real session facts as context. This synchronization must be explicit and profiled; it must not be a hidden state assignment.

Subsequent Security mutations must use the Security EFSM for the existing reauthentication lifecycle where applicable:

- `authenticated --reauth_required--> reauthenticating`;
- `reauthenticating --reauthentication_succeeded--> authenticated`;
- `reauthenticating --reauthentication_failed--> authenticated`.

Existing fresh-auth, ACL, CSRF, preview/commit/rollback and REST behavior remains authoritative and is not replaced by fake FSM outcomes.

A failed real reauthentication must emit the failure transition; a successful real reauthentication must emit the success transition.

## Runtime invariants

After R8B5:

- Navigation current state and Security current state are independently inspectable;
- entering `/fr-FR/sécurité` does not make Security state equal to the Navigation state name `security`;
- authenticated owner normally yields Navigation=`security`, Security=`authenticated`;
- reauthentication temporarily yields Navigation=`security`, Security=`reauthenticating`;
- Security mutations continue through front -> secured REST -> back -> Composer;
- selected-application Security graph authority remains application-specific and unchanged;
- no filesystem access from OWASYS-front into selected application roots;
- no JavaScript/Node artifact is added to `sites/owasys-back`.

## Expected implementation surface

Final exact paths and blobs are fixed only after post-R8B4C GitHub HEAD is re-read.

Expected concerns are limited to:

1. generic OPUS bus interface/component;
2. additive processor-interface transition contract;
3. OWASYS-front SecurityContext service/interface;
4. OWASYS-front Security controller/runtime integration;
5. OWASYS-front Navigation/Security definitions required for the handshake;
6. profiler/logger wiring and validation.

Do not broaden R8B5 into generated-application PHP ACTION/GUARD authoring.

Do not add multicast/broadcast/network transport merely to satisfy the future target architecture.

## Acceptance gates

### Repository / static

- exact post-R8B4C baseline verified before apply;
- no unexpected paths;
- PHP lint PASS for all changed PHP;
- `git diff --check` PASS;
- optimized Composer autoload PASS;
- OPUS framework concrete/interface rule PASS;
- `composer opus:validate-site -- owasys-front` PASS;
- `composer opus:validate-site -- owasys-back` PASS;
- `composer opus:validate-site -- essai` PASS;
- no forbidden JS/Node/package artifacts under `sites/owasys-back`.

### Runtime

From OWASYS-front:

1. normal login/session behavior remains valid;
2. select an application and open Security;
3. Navigation runtime state = `security`;
4. Security runtime state = `authenticated` for authenticated owner;
5. Profiler/Logger show one bounded COMMAND Navigation -> Security and one causally linked EVENT Security -> Navigation;
6. both messages share correlation id and contain no secrets;
7. Security selected-application diagram remains the selected application's `security` EFSM;
8. perform a Security mutation preview/commit requiring reauthentication;
9. Security runtime actually transitions through `reauthenticating` and returns to `authenticated` on success/failure;
10. Navigation remains `security` throughout that reauthentication;
11. Sources + Git remains unchanged functionally.

## Next slice

After R8B5 owner acceptance, continue with generic generated-application PHP ACTION/GUARD managed-source authoring unless runtime evidence exposes a blocking defect in this new EFSM network foundation.