# P117W R45B2A4D — FSM readability, I18n and menu synchronization

Status: PENDING OWNER VALIDATION
Date: 2026-08-15
OPUS base: `394b810248ffb31f4a71fc6f539204afd917c260` (`opus_p117w_r45b2a4c_owasys_native_fsm`)
Scope: generic OPUS FSM presentation correction first, then OWASYS navigation projection. No generated-site local repair.

## Owner validation of R45B2A4C

R45B2A4C is now committed in OPUS as `394b810248ffb31f4a71fc6f539204afd917c260` and the native `OPUS_FSM_Diagram` is visibly active in OWASYS.

The owner reports three remaining defects:

1. diagram too compressed and poorly readable;
2. graphical labels are not translated;
3. graphical order/content is not synchronized with the SCORE navigation menu.

## Root causes

### 1. Generic SVG compression

`OPUS_FSM_Diagram::renderSvg()` emits only a `viewBox`, while the renderer's embedded CSS forces `.fsm-diagram { width:100%; height:auto; }`. A multi-rank FSM therefore gets scaled down to the container width instead of retaining its calculated layout width and becoming horizontally scrollable.

### 2. No generic presentation-label overlay

The generic renderer always renders canonical state identifiers and canonical technical transition notation. It has state-link presentation support, but no independent state-label or transition-label presentation overlay. OWASYS therefore cannot reuse its translated navigation labels without mutating FSM semantics.

### 3. OWASYS projects a different set/order than the menu

`navigation.score` consumes the already-built `pageData.navigation` projection: ACL-filtered, availability-aware, ordered by `navigation.order`, and later translated by `OwasysScorePageRenderer::normalizeI18nViewData()`.

R45B2A4C `OwasysFsmDiagramBuilder`, however, re-enumerates every ACL-accessible state directly from `config/fsm.json`. This admits internal states such as login/account/creation and state-internal source transitions. It is therefore not the same projection as the menu.

In addition, `OPUS_FSM_Diagram::fromDefinition()` builds transition-discovered states before merging definition states. Constructor insertion of current/initial/final states can also precede canonical state order. The visual order therefore need not equal the supplied definition order.

### 4. Wildcard fan-out amplifies clutter

Real OWASYS navigation transitions use `from:"*"`. Drawing each wildcard transition as a long Bézier from one source point across the graph creates overlapping lines and labels. This is semantically correct but visually inefficient.

## Generic OPUS correction

Before OWASYS specialization, `OPUS_FSM_Diagram` is evolved generically to:

- preserve the order of states supplied by a canonical FSM definition;
- support optional state presentation labels independently of canonical state IDs;
- support optional transition presentation labels independently of canonical `signal [guard] / effect` semantics;
- preserve the canonical technical transition label in an SVG `<title>` tooltip when a presentation label is used;
- emit explicit calculated SVG width/height and stop forcing `width:100%`, so large graphs retain readable natural dimensions;
- represent wildcard `from:"*"` transitions through one shared wildcard bus with one branch per real transition instead of repeated long fan-out curves;
- keep the component dependency-free and server-side SVG only.

No FSM state, signal, guard, action, runtime operation or wildcard semantic is rewritten in canonical configuration.

## OWASYS correction

`OwasysFsmDiagramBuilder` is changed so that the graphical navigation consumes the exact same normalized `pageData.navigation` array as `navigation.score`:

- only `item.allowed=true` menu states are projected;
- state order is exactly the menu order already produced by `OwasysNavigationBuilder`;
- state labels are exactly the translated `item.label` values already produced by `normalizeI18nViewData()`;
- state links are exactly the menu URLs for available items;
- ACL is rechecked fail-closed and any divergence throws `OWASYS_FSM_NAVIGATION_ACL_DIVERGENCE`;
- only real state-changing transitions whose visible endpoints belong to the menu projection are drawn;
- state-preserving source/Git workflow transitions remain canonical and remain available to the Profiler, but are not dumped into the principal-navigation card;
- when the canonical initial/final state is outside this partial navigation projection, no fake initial/final state is invented;
- visible transition labels reuse the translated destination menu label; canonical technical semantics remain available in SVG tooltips;
- the inner generic toolbar, legend, untranslated `current` tag and generic subtitle are hidden only in the OWASYS application CSS; the translated SCORE heading remains the UI heading.

This is synchronization by shared data source, not by duplicated ordering or hand-maintained visual metadata.

## Artifact

`opus_p117w_r45b2a4d_fsm_readability_i18n_sync.zip`

SHA-256: `d2cbf069f3b9da0739f81eb8b8280fe86311dc7046c579a61add196249b408b9`

The ZIP contains one fail-closed apply script at its final temporary tool path:

- `tools/apply_p117w_r45b2a4d_fsm_readability_i18n_sync.php`

The script verifies the exact four R45B2A4C Git blob bases before changing anything, lints all resulting PHP files, writes through the OPUS `File` atomic boundary, and rolls back every written source file if a later write fails.

It updates:

- `Opus/Fsm/Diagram.class.php`;
- `sites/owasys-front/application/default/services/ScorePageRenderer.php` (asset cache-bust only);
- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`;
- `sites/owasys-front/www/asset/css/fsm-native.css`.

The apply script itself is temporary delivery material and must be removed from the OPUS source root after successful application/validation before commit.

## Acceptance

After application and OWASYS restart:

- the FSM diagram must use the same visible states as the main SCORE menu;
- state order must equal menu order;
- state labels must equal the current locale's translated menu labels;
- active/current state border must correspond to the menu's active state;
- available state links must equal menu links and preserve locale;
- no login/account/creation state may appear in the principal-navigation diagram unless it is explicitly part of the menu projection;
- source/Git state-preserving internal transitions must no longer saturate the principal-navigation graph;
- the graph must retain natural readable dimensions with horizontal scrolling instead of being compressed to fit;
- wildcard navigation transitions must remain real wildcard transitions and be represented through the shared `*` bus;
- canonical technical transition semantics must remain accessible in SVG tooltips;
- no Mermaid JavaScript or alternate graphical FSM source may be reintroduced;
- `config/fsm.json` remains the sole canonical OWASYS FSM source;
- PHP lint must pass for Diagram, ScorePageRenderer and FsmDiagramBuilder;
- the temporary apply script must not be committed with OPUS/OWASYS.

Do not mark APPLIED until owner UI validation and OPUS commit/push.