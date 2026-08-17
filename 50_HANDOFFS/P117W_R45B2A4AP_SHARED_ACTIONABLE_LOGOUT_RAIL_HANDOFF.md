# P117W R45B2A4AP — Handoff

State: OWNER COMMITTED IN OPUS — PERFORMANCE FOLLOW-UP A4AQ

Owner OPUS commit:

`ce7348c87c8b2bf9e7ef6643a1df4d4fd313ad9e`

## Baseline

Owner-committed OPUS baseline before A4AP:

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

## Follow-up after owner commit

After committing A4AP, the owner reports that OWASYS has again become extremely slow, with several seconds of lag. The supplied front/back logs and profiler journals establish a separate profiler persistence/distributed-trace performance regression. That issue is owned by A4AQ and does not reopen the A4AP FSM rendering scope.

Owner alone commits/pushes OPUS/OWASYS. Assistant writes MAESTRO_WORKSPACE only.