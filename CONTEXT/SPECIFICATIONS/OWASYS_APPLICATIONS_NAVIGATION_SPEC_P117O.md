# OWASYS P117O — APPLICATIONS PAGE AND GLOBAL NAVIGATION SPECIFICATION

## 1. Scope

This specification governs the OWASYS Applications page and the common authenticated navigation stack.

It applies to:

- `sites/owasys/application/default/templates/layout.score`;
- `sites/owasys/application/default/templates/partials/navigation.score`;
- `sites/owasys/application/default/services/NavigationBuilder.php`;
- `sites/owasys/application/registry/templates/index.score`;
- OWASYS theme and application CSS.

## 2. Common navigation source of truth

Navigation items are derived from FSM states where `navigation.visible` is true.

Each item must contain:

- FSM state id;
- module id;
- route URL generated for the active regional locale;
- i18n label key;
- ACL `module:open` decision;
- active-state flag;
- navigation order.

The SCORE template displays only items allowed by the server-side ACL decision. Hiding a link never replaces the server authorization check.

## 3. Sticky layout contract

The global header height is variable and must never be encoded as a fixed navigation offset.

Required structure:

```text
ow-global-chrome (sticky, top 0)
  ow-global-header
  ow-global-nav (authenticated requests only)
```

Forbidden:

- an independently sticky navigation with `top: 72px` or any other assumed header height;
- negative margins used to compensate for header height;
- JavaScript measurement used solely to position the navigation;
- a navigation rendered inside the page body or a module template.

The sticky container owns the page-level stacking context. Locale options may use a higher z-index inside that container.

At narrow viewport widths, the whole chrome may become non-sticky. The header must wrap without clipping current application, locale or SSO controls. The navigation remains horizontally scrollable.

## 4. Applications route and FSM

Canonical route mapping:

```text
applications -> change_app
```

Canonical FSM target:

```text
state: registry
module: registry
route: applications
requires_auth: true
```

The `change_app` event must transition to `registry`.

No route may render the Registry template directly. Every request passes through locale resolution, SSO, ACL and FSM before ViewModel construction.

## 5. Registry visual selector

The Applications page presents the synchronized Registry as a visual tree.

Required structure:

- Registry root node;
- one child node per Registry entry;
- responsive branch layout;
- explicit empty state;
- current application emphasis;
- keyboard-focusable application buttons;
- application selection through a POST form.

Required POST fields:

```text
owasys_action=select-app
owasys_app_id=<registry id>
```

The current application selector is disabled and identified as current.

## 6. Registry data displayed

The page may display these Registry data fields:

- id;
- name;
- root path;
- kind;
- role;
- default locale;
- theme;
- status.

These are data values and are not translated by the presentation layer.

Interface labels, instructions, actions, empty states and accessibility labels must use SCORE i18n directives.

## 7. Registry responsibilities

The template must not:

- discover sites;
- read seed files;
- open SQLite;
- construct Registry entries;
- update session context;
- invoke repositories or controllers;
- infer FSM transitions.

Those responsibilities remain in the existing Registry repository, model, controller, FSM action handlers and RuntimeController ViewModel adapter.

## 8. SCORE-only rendering

The Applications page and common layout use `.score` templates only.

Forbidden:

- PHP view files;
- UI-producing `echo`;
- HTML concatenation in controllers;
- `<script>` inside the Registry template;
- pretranslated visible strings from the controller;
- silent template fallback.

## 9. Runtime panels

The page retains:

- current application context;
- create-application FSM action;
- clear-current-context FSM action;
- Registry synchronization details;
- recent Registry events.

These panels must consume the existing ViewModel and must not define a second source of truth.

## 10. Structured configuration

Routes, FSM, site configuration and ACL remain structured configuration files read through `Opus\File\File` and parsed through the selected JSON, YAML/YML or XML parser via `StructuredFileLoader`.

No direct configuration read through `file_get_contents()` is permitted in corrected OWASYS runtime components.

## 11. Security

The ACL policy remains deny-by-default.

SSO identity is resolved before protected navigation and Registry actions. Future Auth0 proxy or bastion providers remain behind OPUS SSO interfaces and do not alter this page contract.

## 12. OPUS class contract

P117O introduces no concrete OPUS framework class.

Any future concrete OPUS class must implement its homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive audit remains mandatory.

## 13. Validation gates

Before commit:

- PHP lint of all changed PHP files;
- balanced SCORE control blocks;
- no PHP or script block in the Registry template;
- common sticky chrome present;
- no fixed navigation top offset;
- `applications -> change_app` route mapping;
- Registry state/module/route contract;
- ACL default `deny`;
- 37 selectable regional locales retained;
- current application selection performed through FSM action;
- P117M-R1 component-contract audit;
- `git diff --check`;
- browser test at desktop and narrow viewport widths.
