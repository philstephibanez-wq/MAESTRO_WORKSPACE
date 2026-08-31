# Handoff R8B6S — I18n labels in EFSM diagrams

Date: 2026-08-31

Baseline OPUS: `a8c49e0c3d2ab93f37c3a75eae9d2082884fa8b7`

## Delivered scope

The differential ZIP contains one front-only file:

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

The contextual EFSM diagram now resolves state and transition `label_key` values through the selected application's `application/default/local/<locale>.json` catalog. For states, existing `title_key` is also accepted as the label key.

Technical FSM IDs remain canonical ASCII identifiers. They are never used as an I18n fallback.

A missing key in the active locale is rendered explicitly as:

`traduction à renseigner · <key>`

No fallback language and no browser-authored catalog write are introduced.

## Explicit limit

This is the rendering foundation only. The next slice must provide a secured authoring operation for `label_key` and catalog messages through the existing OWASYS REST/back-end path. It must not write catalogs directly from the browser.

## Owner validation

1. Apply the ZIP to a clean OPUS checkout at the stated baseline.
2. Run PHP lint, `git diff --check`, Composer autoload and the three site validations.
3. In an EFSM definition, set a state or transition `label_key` to an existing message containing an accented French string.
4. Reload OWASYS: the diagram must show that string while its DOM identity remains the technical ID.
5. Switch to a locale without the key: it must show the explicit missing-translation marker.
6. Capture fresh profiler logs for the page load; do not reuse prior timing data.
