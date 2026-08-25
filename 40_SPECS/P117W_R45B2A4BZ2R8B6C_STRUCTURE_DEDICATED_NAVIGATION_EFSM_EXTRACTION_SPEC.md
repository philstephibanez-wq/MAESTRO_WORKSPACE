# P117W R45B2A4BZ2 R8B6C — Structure dedicated Navigation EFSM extraction — SPEC

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST revalidated immediately before delivery: blob `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS accepted baseline/master revalidated immediately before delivery: `d3a6cfc53e021dba0d5c2c60b9b9761b421dd76d` (`opus_p117w_r45b2a4bz2r8b6b4_layout_companion_inventory_gate_repair`).
- R8B6B4 is owner runtime accepted and pushed.
- Applicable MAESTRO development, patch-delivery and Git/branch contracts were reread.

## Problem

After R8B6B4, Applications, Application, Data, Source/Git, Build and Security render dedicated contextual EFSMs. Structure is the remaining view that resolves `navigation` to `sites/owasys-front/config/fsm.json`, which is still the legacy host dispatch/orchestration FSM.

`site.json` currently points both:

- `navigation.fsm` -> `config/fsm.json`;
- `efsms.navigation` -> `config/fsm.json`.

The two pointers have different responsibilities and must no longer share the same source.

## Framework separation already available

`Opus\Fsm\FsmSiteLoader::resolve()` resolves the host dispatch source from `site.json.navigation.fsm`.

`Opus\Fsm\FsmSiteLoader::resolveEfsm(..., 'navigation')` resolves the contextual Navigation EFSM from `site.json.efsms.navigation`.

Therefore this slice does not modify `FsmSiteLoader` and does not change host dispatch.

## Target architecture

Keep:

`site.json.navigation.fsm = config/fsm.json`

Change:

`site.json.efsms.navigation = config/navigation.fsm.json`

Add:

`sites/owasys-front/config/navigation.fsm.json`

The dedicated Navigation EFSM is a pure application-structure machine for the seven OWASYS front contexts:

- registry;
- application;
- data;
- structure;
- security;
- source;
- build.

It does not duplicate CRUD, Source editor, Git, Build execution, Security authentication, creation wizard or account/password implementation workflows from the host dispatch FSM.

## Navigation EFSM signals

Navigation signals:

- `open_applications`;
- `open_application`;
- `open_data`;
- `open_structure`;
- `open_security`;
- `open_source`;
- `open_build`;
- `change_app`.

Cross-EFSM readiness events preserved in the structural model:

- `registry_context_ready`;
- `application_context_ready`;
- `data_context_ready`;
- `security_context_ready`;
- `source_context_ready`;
- `git_context_ready`;
- `build_context_ready`.

The ready events are same-state acknowledgement transitions on their owning navigation context (`git_context_ready` acknowledges the `source` context).

## Runtime boundary

This slice is an extraction of the canonical Structure/Navigation definition only.

The legacy `config/fsm.json` remains the runtime dispatch/orchestration authority. Existing COMMAND/EVENT context handshakes are not rewired in R8B6C.

Moving bus/runtime Navigation authority from the legacy dispatch FSM to the dedicated Navigation EFSM is explicitly deferred to a later slice after Structure VIEW/DESIGN acceptance.

## Exact OPUS source surface

Modified:

- `sites/owasys-front/config/site.json`.

New:

- `sites/owasys-front/config/navigation.fsm.json`.

No PHP, CSS, JS, backend, layout or generated-application source modification.

## Delivery verification

Applicator replay A: pre-existing tracked `fsm.layout.json` runtime companion.

- preflight PASS;
- layout companion preserved byte-for-byte;
- dispatch `config/fsm.json` preserved byte-for-byte;
- final source inventory exact;
- `git diff --check` PASS.

Applicator replay B: tracked `fsm.layout.json` plus untracked `security.fsm.layout.json` runtime companion.

- preflight PASS;
- both layout companions preserved byte-for-byte;
- final source inventory exact;
- `git diff --check` PASS.

Artifact:

- ZIP `opus_p117w_r45b2a4bz2r8b6c_structure_dedicated_navigation_efsm_extraction.zip`;
- ZIP SHA-256 `9f9bcd3bd158ae722ca37b0877b36e2654c9daa43f44180da283847bd211813c`;
- applicator `apply_a4bz2r8b6c.php`;
- applicator SHA-256 `d5cc80567e1b195c1a2415f6a80a2f086ab6cbb56af369e9b31de41d2b7a38dc`;
- applicator PHP lint PASS;
- ZIP re-extraction byte comparison PASS;
- extracted applicator PHP lint PASS;
- ZIP contains exactly one applicator;
- no internal Composer invocation.

## Runtime acceptance

1. `composer opus:validate-site -- owasys-front` passes.
2. `composer opus:validate-site -- owasys-back` passes.
3. `composer opus:validate-site -- essai` passes.
4. Structure on selected `owasys-front` renders `owasys-front / navigation` from `config/navigation.fsm.json`, not `config/fsm.json`.
5. The Structure graph has seven dedicated states and fifteen transitions.
6. Applications/Application/Data/Source-Git/Build/Security remain on their existing dedicated EFSMs.
7. Normal navigation/dispatch remains functional because `site.json.navigation.fsm` is unchanged.
8. Structure DESIGN edits/persists only `config/navigation.fsm.layout.json`; it must not modify `config/fsm.layout.json`.
9. No commit/push until runtime acceptance.
