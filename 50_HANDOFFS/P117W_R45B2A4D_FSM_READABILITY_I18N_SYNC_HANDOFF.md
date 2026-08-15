# P117W R45B2A4D — Handoff

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
OPUS base: `394b810248ffb31f4a71fc6f539204afd917c260`
Previous delivery: R45B2A4C native FSM activation

## Owner observation

R45B2A4C successfully replaced the Mermaid projection with native `OPUS_FSM_Diagram`, but validation shows the native graph is too compressed, uses technical non-I18n labels, and does not match the SCORE menu's state set/order.

## Root correction

R45B2A4D first evolves generic `OPUS_FSM_Diagram`, then makes OWASYS consume the exact already-normalized menu projection.

Generic OPUS changes:

- canonical definition state order is preserved;
- state and transition presentation labels are supported without rewriting FSM semantics;
- technical transition semantics remain in SVG tooltips;
- calculated SVG width/height become natural render dimensions instead of `width:100%` compression;
- wildcard `from:"*"` transitions use a shared wildcard bus.

OWASYS changes:

- graph state list/order/labels/links come directly from the same `pageData.navigation` array used by `navigation.score`;
- labels therefore reuse the current locale's existing I18n translations;
- ACL divergence fails closed;
- only state-changing principal-navigation transitions are projected; internal state-preserving workflow transitions are not dumped into the navigation card;
- no fake initial state is created when canonical initial state is outside the menu projection;
- application CSS hides generic non-localized diagram chrome while keeping the localized SCORE heading;
- FSM CSS asset version advances to R45B2A4D.

## Delivery

Artifact: `opus_p117w_r45b2a4d_fsm_readability_i18n_sync.zip`

SHA-256: `d2cbf069f3b9da0739f81eb8b8280fe86311dc7046c579a61add196249b408b9`

ZIP entry:

- `tools/apply_p117w_r45b2a4d_fsm_readability_i18n_sync.php`

The runner requires the exact R45B2A4C Git blob bases, applies fail-closed, lints patched PHP before writing, writes via `Opus\File\File`, and rolls back changed source files on write failure.

## Owner commands

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4d_fsm_readability_i18n_sync.zip"
php tools\apply_p117w_r45b2a4d_fsm_readability_i18n_sync.php
composer dump-autoload -o
php -l Opus\Fsm\Diagram.class.php
php -l sites\owasys-front\application\default\services\FsmDiagramBuilder.php
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer opus:dev-server -- owasys-front
```

Expected apply output:

```text
OPUS_P117W_R45B2A4D_APPLY_OK
FSM_VIEW=MENU_SYNCHRONIZED
FSM_LABELS=I18N_NAVIGATION_LABELS
FSM_LAYOUT=NATURAL_WIDTH_SCROLLABLE
FSM_WILDCARD=SHARED_BUS
```

After successful UI validation, remove the temporary runner before committing OPUS:

```cmd
del tools\apply_p117w_r45b2a4d_fsm_readability_i18n_sync.php
```

## Visual acceptance

The principal-navigation FSM must now:

- show exactly the same permitted navigation states as the menu;
- show them in the exact same order;
- display the same translated labels as the menu;
- highlight the same current state;
- use the same localized links for available states;
- stay readable at natural scale with horizontal scrolling instead of shrinking the complete graph;
- show one `*` wildcard bus with readable per-destination branches;
- omit internal source/Git self-transition noise from this navigation projection;
- retain real technical FSM semantics in transition tooltips.

No OPUS/OWASYS commit or push is performed by the assistant. Owner validates, removes the temporary runner, commits and pushes OPUS.