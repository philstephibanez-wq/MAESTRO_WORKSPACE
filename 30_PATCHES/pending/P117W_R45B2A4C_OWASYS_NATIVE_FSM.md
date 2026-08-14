# P117W R45B2A4C — OWASYS native FSM activation

Status: PENDING OWNER VALIDATION
Date: 2026-08-14
Scope: repair the defective R45B2A4B framework application, then make `owasys-front` consume OPUS's native semantic FSM renderer. No local repair of a generated test site.

## Owner observation

After R45B2A4B was applied and committed to OPUS as `87c4ec39d3dd331e1d507187fb15c181cde046ec`, OWASYS still displayed the same horizontal `OWASYS_FSM_MERMAID_V1` projection.

## Audited causes

Two independent blockers were found.

1. `sites/owasys-front` does not use `GeneratedSiteRuntime` for its application shell. Its SCORE renderer still instantiates `OwasysFsmMermaidBuilder`, which reads the canonical FSM but then creates a separate Mermaid-only visual projection, filters on `visual=true`, honors `visual_from`, emits route JSON, and requires Mermaid JavaScript. The layout still includes `fsm-mermaid.score` and loads Mermaid scripts. This is why the generic generated-site correction could not visibly change OWASYS.

2. The R45B2A4B patcher partially injected its own patch source into `OPUS_FSM_Diagram::svgDefinitions()` inside the SVG heredoc. PHP lint can still pass because the injected text is inside the string. The same failed anchor also left the `GeneratedSiteRuntime::renderPage()` call without its new `$acl` argument while the method signature already requires it. The native renderer therefore must be repaired before OWASYS can safely consume it.

## Root correction

Artifact: `opus_p117w_r45b2a4c_owasys_native_fsm.zip`

SHA-256: `599cf01e4f3649cc1397298e7e60d81579c190085150496def6778e3635d91de`

The delivery:

- restores the complete audited `OPUS_FSM_Diagram::svgDefinitions()` body from the R45D2A29 semantic renderer and keeps the intended state-link CSS;
- repairs the missing `$acl` argument at the generated runtime call site;
- introduces `OwasysFsmDiagramBuilder`, which loads the one canonical FSM through `StructuredFileLoader`, filters states by the same deny-by-default OWASYS security perspective, preserves real transitions/wildcards/runtime operations, and feeds them directly to `OPUS_FSM_Diagram`;
- uses existing localized OWASYS navigation URLs as optional SVG state links;
- removes the Mermaid-only `visual`/`visual_from` projection metadata from canonical `config/fsm.json`;
- replaces the Mermaid SCORE partial with a native FSM SCORE partial;
- removes Mermaid FSM JavaScript and the obsolete OWASYS Mermaid FSM CSS/JS/builder/partial;
- keeps SCORE as the only OWASYS UI composition surface.

No `visual_from` rewrite is allowed in the native schema: the graph represents the real FSM transition source, including `*` wildcard transitions.

## Files added by the ZIP

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/templates/partials/fsm-diagram.score`
- `sites/owasys-front/www/asset/css/fsm-native.css`
- `tools/apply_p117w_r45b2a4c_native_fsm.php`

The apply script patches the current OPUS/OWASYS files fail-closed, lints every PHP result before replacement, rewrites the FSM configuration only after contract validation, uses the OPUS `File` atomic boundary for writes, and removes the four obsolete Mermaid projection files only after successful replacement.

## Acceptance

After application and restart:

- the OWASYS card must no longer display `OWASYS_FSM_MERMAID_V1`;
- its description must identify `OPUS_FSM_Diagram` and `OWASYS_NAVIGATION_FSM_V1`;
- SVG must be emitted server-side without Mermaid JavaScript;
- the current FSM state must be highlighted;
- authorized/available state links must navigate using the current localized URLs;
- unauthorized states must be absent;
- real wildcard `from: "*"` transitions must remain wildcard transitions and must not be rewritten through `visual_from`;
- `config/fsm.json` must contain neither `diagram.contract=OWASYS_FSM_MERMAID_V1` nor `visual`/`visual_from` transition projection metadata;
- the generated OPUS runtime must receive `$acl` at the `renderPage()` call;
- `Diagram.class.php` must no longer contain the patcher sentinel `diagram.state_link_css` or patch-program source inside `svgDefinitions()`.

Do not mark APPLIED until the owner validates the UI/runtime and commits/pushes OPUS. The assistant does not commit or push OPUS/OWASYS.