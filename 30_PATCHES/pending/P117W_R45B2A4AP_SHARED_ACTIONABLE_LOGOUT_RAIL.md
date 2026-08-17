# P117W R45B2A4AP — Shared actionable logout rail

Status: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED
Date: 2026-08-17

## Baseline

Committed OPUS baseline:

`f23d1912cfb2163c409143d9915f6952d66f8379`

This is A4AO compact responsive FSM + wheel scroll.

## Owner finding

The compact diagram is acceptable, but the visible merged `logout` label is not clickable.

## Root cause

The logout FSM/route is correct:

- `logout` is a navigation signal with `menu:true`;
- global `g_logout` applies from all 16 canonical states and targets `login`;
- `routes.json` maps route `logout` to signal `logout`;
- `NavigationBuilder` marks the global action actionable for the current state when route/target availability allow it.

The defect is created by the visual projection:

1. `FsmDiagramBuilder` expands global logout into one visual clone per source state.
2. The exact current-state clone receives the current logout URL.
3. A4AN/A4AO merge only long `outer-forward` / `outer-return` clones into shared visual rails.
4. The normalizer chooses the visible label owner only among clones inside a given outer rail family.
5. When the current actionable clone is short/non-outer, the shared outer rail label is owned by a passive clone and has no `<a>`.

The drawing is merged but the semantic actionability is not propagated to the merged visual bus.

## A4AP contract

### 1. Generic semantic actionability map

Extend `Opus\Fsm\FsmDiagramGeometryNormalizer`.

Before outer-rail normalization, scan all actionable FSM transition groups, not only outer transitions.

For each actionable transition derive the semantic key:

`signal label + target state`

and retain the exact renderer-provided local `href`.

No route is synthesized by the normalizer.

### 2. Endpoint-to-target resolution

Generic target-state detection must accept both kinds of valid node entry:

- horizontal boundary (top/bottom);
- vertical boundary (left/right).

This allows short side-entering transitions and long top/bottom outer transitions to resolve to the same semantic target state.

### 3. Shared rail action promotion

For each visible shared outer rail label:

- if one transition anywhere in the diagram with the same semantic `signal + target` is actionable, the visible shared label inherits that exact URL;
- the shared label becomes a normal `fsm-signal-link` with keyboard focus and the existing actionable styling;
- duplicate passive labels remain hidden;
- paths/transitions remain present;
- no current-state, transition, signal or target semantics are changed.

Therefore a short actionable current `logout → login` transition can make the visible shared logout rail label clickable even though the visible rail owner itself originated from a passive clone.

### 4. Safety

The normalizer rejects:

- actionable transitions without an href;
- non-local/invalid href values;
- two different href values for the same semantic `signal + target` key.

### 5. Revisions/cache

- routing identity becomes `bounded-orthogonal-v7-shared-action`;
- `OwasysFsmDiagramBuilder::REVISION = P117W_R45B2A4AP`;
- FSM CSS cache id becomes `p117w-r45b2a4ap`.

No CSS semantics change is required.

## Smoke tests

### Case 1 — exact owner defect reproduction

Synthetic topology:

- current `logout → login` is a short non-outer actionable edge with `/fr-FR/logout`;
- a different passive logout clone owns an outer merged rail to the same `login` target.

After A4AP:

- routing identity: OK;
- passive outer owner promoted to actionable: OK;
- shared rail contains exact `/fr-FR/logout`: OK;
- keyboard `focusable=true`: OK;
- visible merged logout label is linked: OK.

### Case 2 — actionable outer owner already exists

Two outer logout clones, one already actionable.

After A4AP:

- no duplicate wrapping/link injection;
- exactly one visible owner label;
- existing actionable href retained;
- duplicate passive label remains hidden.

## Delivery

Artifact:

`opus_p117w_r45b2a4ap_shared_actionable_logout_rail.zip`

SHA-256:

`6df7b5171b967698937f77170a551a2c2d9209700ec19a14b94bc6afbca80ccd`

Three complete files:

1. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
2. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`

No patcher. No deletion.

## Acceptance

1. On every authenticated current state, the visible shared `logout` rail label is clickable when logout is actionable.
2. Hover/focus uses the existing actionable signal styling.
3. Clicking the shared label uses the exact current logout route supplied by the renderer.
4. Logout still returns to `login` through the canonical FSM.
5. Shared logout rail geometry remains merged.
6. A4AO compact height, responsive width, wheel scrolling and regular-weight signal labels remain unchanged.
7. No new route, fallback, JS, REST, ACL or backend behavior is introduced.
8. Owner alone applies, validates, commits and pushes OPUS/OWASYS.
