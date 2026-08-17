# P117W R45B2A4AP — Handoff

State: CODE DELIVERY PRODUCED — OWNER VALIDATION REQUIRED

## Baseline

Owner-committed OPUS baseline:

`f23d1912cfb2163c409143d9915f6952d66f8379`

This is A4AO compact responsive FSM + wheel scroll.

## Owner report

A4AO presentation is retained, but the merged `logout` signal label is not clickable.

## Root cause confirmed

This is not a missing FSM transition and not a missing route.

Canonical facts:

- `logout` is a global navigation signal;
- `g_logout` targets `login` from all canonical states;
- `routes.json` maps route `logout` to signal `logout`;
- `NavigationBuilder` produces an actionable global logout item for the current state when allowed/available;
- `FsmDiagramBuilder` attaches the URL to the current-state logout clone.

A4AN/A4AO then merge only `outer-*` clones. If the exact current clone is a short/non-outer edge, the visible shared outer label is owned by another passive clone and therefore has no link.

## A4AP implementation

A4AP extends the generic OPUS `FsmDiagramGeometryNormalizer`.

Before rail merging it builds an actionability map over all actionable transition groups keyed by semantic:

`signal label + target state`

The exact renderer-provided href is retained.

Target resolution now recognizes both top/bottom and left/right state boundaries, so a short current transition and a long shared rail can resolve to the same target.

When a visible shared outer rail label has a semantic match in the actionability map, it inherits that exact href and is emitted as `fsm-signal-link` with keyboard focus. The containing visual transition receives the existing `actionable` styling class.

No route is created or guessed. Conflicting hrefs for the same semantic key are rejected.

Duplicate passive rail labels remain hidden, and every transition/path remains in the diagram.

## Delivery

Artifact:

`opus_p117w_r45b2a4ap_shared_actionable_logout_rail.zip`

SHA-256:

`6df7b5171b967698937f77170a551a2c2d9209700ec19a14b94bc6afbca80ccd`

Exactly three complete files:

1. `Opus/Fsm/FsmDiagramGeometryNormalizer.php`
2. `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
3. `sites/owasys-front/application/default/services/ScorePageRenderer.php`

No patcher. No deletion. No CSS file because A4AO styles already contain the required actionable/focus behavior.

## Pre-delivery validation

PHP lint passes for all three files.

No trailing whitespace in delivered files.

Synthetic defect reproduction passes:

- current short actionable logout + passive shared outer logout;
- outer shared owner promoted to actionable;
- exact href preserved;
- keyboard focus preserved;
- routing identity `bounded-orthogonal-v7-shared-action` present.

Second smoke passes when an actionable outer owner already exists:

- no double wrapping;
- exactly one visible owner label;
- original href retained;
- passive duplicate hidden.

## Browser acceptance

After applying A4AP over committed A4AO and hard-refreshing:

1. click the visible merged `logout` label from the current page;
2. it must show the same cyan actionable hover/focus treatment as other actionable signals;
3. keyboard focus must reach it;
4. activation must execute the canonical logout route and return to Connection/login;
5. merged logout rails must remain merged;
6. A4AO compact height, width fit, mouse-wheel page scrolling and regular-weight signal labels must remain unchanged;
7. no menu, REST, ACL, session or backend regression.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.
