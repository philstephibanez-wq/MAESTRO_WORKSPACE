# OWASYS P117O-R1 — SYNCHRONIZED MENU AND FSM NAVIGATION SPECIFICATION

## 1. Navigation definition

OWASYS navigation consists of two representations of one FSM-derived navigation model:

1. the horizontal SCORE menu;
2. the interactive Mermaid FSM diagram.

Neither representation owns routes, permissions or state transitions. The navigation FSM remains the source of truth.

## 2. Canonical pipeline

The required pipeline is:

FSM states and transitions
-> SSO identity
-> ACL authorization
-> FSM guard availability
-> regional route URL
-> canonical navigation ViewModel
-> SCORE menu and Mermaid FSM diagram.

The menu and diagram must never build independent route or authorization models.

## 3. Navigation item contract

Each visible FSM navigation state produces one item with at least:

- `id` — FSM state identifier;
- `module` — FSM module;
- `label_key` — strict i18n key;
- `label` — translated label before representation rendering;
- `url` — route URL containing the active regional locale;
- `allowed` — ACL result for `<module>:open`;
- `available` — `allowed` plus all navigation-level FSM prerequisites;
- `requires_current_app` — projection of the FSM guard declaration;
- `active` — current FSM state;
- `order` — FSM navigation order.

`available` must not replace `allowed`. ACL authorization and FSM guard availability are separate security/runtime facts.

## 4. ACL behavior

The OWASYS ACL policy remains deny-by-default.

- `allowed=false`: the state is not represented in either navigation UI.
- `allowed=true`: the state may be represented.

No client-side code may infer or broaden permissions.

## 5. Current-application FSM guard

For a state declaring `requires_current_app=true`:

- `available=false` when the authenticated session has no current application;
- `available=true` when a current application exists and ACL permits the state.

The following states require an application context:

- Structure;
- Data;
- Workflows;
- Security;
- Source.

Registry/Applications and Build remain available without an application context.

## 6. SCORE menu representation

The horizontal menu is rendered exclusively through SCORE.

### Available item

An available item is an `<a>` with:

- the canonical regional URL;
- state metadata;
- `aria-current="page"` when active.

### Guard-blocked item

An ACL-authorized but guard-blocked item is a non-interactive element with:

- the same visible translated label;
- `aria-disabled="true"`;
- state metadata;
- explicit current-application-required metadata;
- no `href`.

A disabled item must not submit, redirect or simulate a route.

## 7. Mermaid FSM representation

All ACL-authorized states remain visible in the FSM diagram.

- `available=true`: the node is included in `routes_json` and becomes a native SVG link after Mermaid rendering.
- `available=false`: the node uses the Mermaid `blocked` class and is omitted from `routes_json`.

The diagram client must continue using the existing OPUS Mermaid runtime. P117O-R1 does not modify `MermaidDiagram`, duplicate Mermaid assets or introduce a second diagram engine.

## 8. Shared route invariant

For every available state, the menu URL and Mermaid URL must be byte-for-byte identical.

Examples:

- `/fr-FR/applications`;
- `/fr-BE/build`;
- `/de-CH/structure`;
- `/uk-UA/data`.

Changing the interface language regenerates both representations using the selected regional locale while preserving the target FSM state route.

## 9. Active-state invariant

The current FSM state must be represented consistently:

- menu item: active class and `aria-current="page"`;
- Mermaid node: active Mermaid class.

A guard-blocked state cannot be active because the server-side FSM rejects entry before rendering.

## 10. Configuration access

OWASYS configuration consumers must use the OPUS structured-file boundary.

`OwasysFsmMermaidBuilder` reads `site.json` and the configured FSM with `Opus\File\StructuredFileLoader`.

Direct `file_get_contents()` configuration reads are forbidden.

The developer-selected extension continues to choose the OPUS JSON, YAML/YML or XML parser.

## 11. SCORE and presentation constraints

Required:

- SCORE templates only;
- no PHP/HTML mixed view;
- no UI-producing `echo`;
- no client-side router;
- no duplicated navigation state model;
- no translated hardcoded labels in PHP;
- no silent i18n fallback.

## 12. FSM, SSO and security

The request path remains:

request
-> locale resolution/browser negotiation
-> SSO identity
-> ACL decision
-> route signal
-> FSM transition and guards
-> ViewModel
-> SCORE rendering.

The disabled UI representation is not a substitute for server enforcement. `assertTargetStateAccess()` and the FSM guards remain authoritative for direct URL requests.

Auth0 proxy and bastion providers remain behind the OPUS SSO boundary and are outside this corrective milestone.

## 13. OPUS component contract

P117O-R1 adds and changes no concrete framework class.

Any future concrete OPUS framework class must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The exhaustive P117M-R1 component-contract audit remains a release gate.

## 14. Acceptance criteria

### No current application

- seven ACL-authorized states are visible for an administrator;
- only Applications and Build are interactive in the menu;
- only Applications and Build are interactive in the FSM diagram;
- Structure, Data, Workflows, Security and Source are visibly disabled in both;
- direct requests to guarded routes remain rejected by the FSM and return to Applications.

### Current application selected

- all seven states are interactive in both representations;
- menu and diagram URLs are identical for every state;
- selecting any state reaches the corresponding FSM state;
- active state highlighting matches in both representations.

### Regionalization

Acceptance must be repeated at minimum for:

- `fr-FR`;
- `fr-BE`;
- `de-CH`;
- `en-IE`;
- `uk-UA`.

### Technical gates

- PHP lint passes;
- audit script reports the expected state counts;
- P117M-R1 component-contract audit passes;
- `git diff --check` passes;
- no browser console error from Mermaid binding;
- no OPUS commit before live browser acceptance.

## 15. Supersession

This specification supersedes the navigation behavior described by the initial P117O delivery where ACL-authorized, current-application-guarded states remained clickable without an application context.
