# OPUS Fullstack Front / Middle / Back FSM Contract

Status: ACTIVE CONTRACT FOR P117SITE23+
Date: 2026-06-21
Scope: OPUS framework, generated OPUS applications, future Composer authoring commands, security pipeline, runtime processing

## 1. Fundamental definition

An OPUS application is a standalone fullstack site/project built on the shared OPUS framework.

Every OPUS application is composed of mandatory and clearly separated spaces:

- `frontend`: representation layer.
- `middle`: routing, transport, security and orchestration boundary.
- `backend`: business/data processing layer.

Fullstack does not mean mixed responsibilities. Fullstack means the application owns a representation side and a processing side, with a strict, secure and traceable boundary between them.

## 2. OPUS framework responsibility

OPUS is the shared framework. OPUS provides contracts, loaders, routing, rendering, configuration, validation, Composer authoring tools, API plumbing, request/response conventions, FSM orchestration, security gates and the standard component library.

OPUS must not force a blog/CMS vocabulary into generated applications. Blog/news/catalog/support/admin/etc. are optional domain presets, not the neutral application model.

OPUS must force clean-by-design and secure-by-design development through explicit architecture boundaries, typed contracts, FSM-driven processing and no silent fallback.

## 3. Application responsibility

A generated application is a fullstack OPUS application. It may be used as a public website, intranet, extranet, backoffice, documentation portal, business application, API application, or hybrid application.

The application owns:

- its identity and configuration,
- its frontend views and composition,
- its middle routing/security/contracts configuration,
- its backend business modules and processing,
- its data contracts,
- its custom components when needed,
- its resources and documentation.

## 4. Front definition

The OPUS Front layer is the representation layer. It displays data and triggers requests. It does not own business logic.

Framework namespace target:

```text
Opus\Front\
```

The framework Front layer owns standard representation classes such as:

- View
- Layout
- Section
- Component
- FormComponent
- InputComponent
- MenuComponent
- Renderer
- Theme

Application frontend contains:

- `views`: screens/routes of representation.
- `layouts`: visual composition structures; layouts may be nested.
- `sections`: pieces of a view placed in layout slots/regions.
- `custom-components`: application-specific components only.
- `navigation`: menu/navigation data or view models consumed by OPUS standard menu components.
- `api-clients`: frontend clients/adapters for middle/backend APIs.
- `assets`: CSS, JS, images and theme-level assets.
- `theme`: application visual customization.

The frontend may perform local UX checks, but all sovereign validation, security, authorization, workflow, persistence and business decisions belong beyond the Front layer.

## 5. Middle definition

The OPUS Middle layer is the routing, transport, security and orchestration boundary. It is not business logic and it is not view rendering.

Framework namespace target:

```text
Opus\Middle\
```

The Middle layer owns framework classes such as:

- Router
- Route
- Request
- Response
- ApiGateway
- MiddlewarePipeline
- FsmGate
- AccessControl
- SessionBoundary
- SsoBoundary
- CsrfGuard
- RateLimiter
- AuditTrail
- TransportContract

The application middle space contains app-specific configuration and contracts:

- `routes`: frontend and API route declarations.
- `api`: API endpoint declarations and transport contracts.
- `security`: ACL, SSO, CSRF, policy binding and gate configuration.
- `contracts`: request/response schema definitions.
- `fsm`: application-specific state machine bindings and transition declarations.

Middle is where requests are routed, checked, authorized, audited, normalized and dispatched to the FSM-backed backend processing path.

## 6. Back definition

The OPUS Back layer is the business/data processing layer. It does not render HTML and does not own visual composition.

Framework namespace target:

```text
Opus\Back\
```

The framework Back layer owns processing classes such as:

- Module
- Action
- Service
- Repository
- Validator
- Policy
- Runner
- Job
- Worker
- Adapter
- ExternalProcess
- Dto
- ViewModel

The backend may be driven by:

- API endpoints,
- runners,
- CLI commands,
- jobs,
- workers,
- schedulers,
- internal services.

Application backend contains:

- `modules`: business domains.
- `services`: business logic.
- `actions`: executable business operations.
- `repositories`: data access.
- `validators`: backend validation.
- `policies`: authorization and access rules.
- `api-endpoints`: request entry points for frontends or external clients.
- `runners`: backend execution entry points.
- `jobs`: background/asynchronous tasks.
- `dto`: request/response contracts.
- `viewmodels`: representation-ready data produced by backend for frontend views.

## 7. FSM processor rule

The FSM is the processor of OPUS at every level.

This is mandatory and non-negotiable:

```text
No processing path bypasses the FSM.
```

All meaningful execution must pass through a declared FSM state, signal, transition, gate or action pipeline.

The FSM applies to:

- frontend navigation intents,
- middle request routing and security gates,
- API request/response transport,
- backend actions,
- runners,
- jobs,
- workers,
- external process calls,
- long-running workflows,
- validation and authorization gates,
- error paths and cleanup paths.

No controller, service, repository, runner, worker, command, API endpoint or UI action may directly bypass the FSM for business-relevant processing.

The correct model is:

```text
Intent / Request / Runner / Job
  -> Middle transport and security gates
    -> FSM signal
      -> FSM transition / guard / action
        -> Back processing
          -> Response / Event / ViewModel
```

## 8. OPUS standard component library

Standard components belong to OPUS, not to each generated application.

Examples of OPUS standard components:

- TextBlock
- Button
- Link
- Menu
- Breadcrumb
- Tabs
- Card
- List
- Table
- Form
- Input
- Select
- Checkbox
- Textarea
- ErrorMessage
- Alert
- Modal

An application uses OPUS standard components. If an application needs a custom component, it places it in `frontend/custom-components`. A custom component remains application-owned until it is explicitly promoted into OPUS.

## 9. Form and menu definitions

A Form is a standard OPUS component. A form is placed in a section and contains inputs, buttons, errors and submit bindings.

A Menu is a standard OPUS component. The application owns navigation data/configuration, not the standard component itself.

Therefore:

- `Form` is not a top-level architecture pillar. It is a component type.
- `Menu` is not a top-level architecture pillar. It is a component type.
- Navigation data may be static configuration or a backend-produced MenuViewModel filtered by rights.

## 10. View / layout / section composition

A view is not a backend module. A view is frontend representation.

A view uses one or more layouts. A layout provides slots/regions. Sections are placed into layout slots. Sections contain text and components.

HTML output is a composition result:

```text
HTML page = Layout(s) + View + Sections + Components + ViewModel/Response data
```

A typical view contract:

```text
View: contact
Route: /contact
Layout: public
Slots:
  header -> Section site-header
  main   -> Section contact-main
  footer -> Section site-footer
```

A typical section contract:

```text
Section: contact-main
Components:
  - TextBlock
  - Form(ContactRequest)
```

## 11. Backend is not backoffice

Backend and backoffice must never be confused.

- Backend = business/data processing layer.
- Backoffice = a frontend/interface for administration or management.

A backoffice has its own frontend views/layouts/sections/components and consumes backend processing through the Middle/API boundary just like a frontoffice, extranet or intranet frontend.

## 12. End-to-end secure and clean flow

The OPUS end-to-end path is:

```text
Front View / Section / Component / Form
  -> Front ApiClient
    -> Middle Route / ApiGateway
      -> Middle security pipeline
        -> ACL / SSO / CSRF / FSM gate / rate limit / audit
          -> FSM signal
            -> FSM transition / guard / action
              -> Back Action
                -> Back Service / Validator / Policy / Repository / Job / Adapter
                  -> Response DTO or ViewModel
                    -> Front representation
```

Rules:

- The frontend represents and triggers requests.
- The middle routes, secures, validates transport and dispatches through FSM gates.
- The backend processes business/data only.
- The FSM is the mandatory processor across the whole path.
- No business logic in views, sections, components, forms or layouts.
- No HTML representation in backend services, actions, repositories, validators or policies.
- No direct frontend-to-repository access.
- No direct API-to-service bypassing the FSM.
- No runner/job/worker bypassing the FSM.
- No silent fallback.

## 13. Canonical generated application structure

Target structure for a new OPUS fullstack application:

```text
sites/<application_id>/
├── application.opus.json
├── public/
│   └── index.php
├── frontend/
│   ├── views/
│   ├── layouts/
│   ├── sections/
│   ├── custom-components/
│   ├── navigation/
│   ├── api-clients/
│   ├── assets/
│   └── theme/
├── middle/
│   ├── routes/
│   ├── api/
│   ├── security/
│   ├── contracts/
│   └── fsm/
├── backend/
│   ├── modules/
│   ├── services/
│   ├── actions/
│   ├── repositories/
│   ├── validators/
│   ├── policies/
│   ├── api-endpoints/
│   ├── runners/
│   ├── jobs/
│   ├── dto/
│   └── viewmodels/
├── resources/
│   └── i18n/
└── docs/
```

Compatibility note: existing `sites/<id>/application/...` structures may remain supported during migration, but the canonical target for P117SITE23+ is explicit `frontend/`, `middle/` and `backend/` separation.

## 14. Composer command direction

The existing `opus:create-site` command may remain as a practical alias for site-oriented applications.

The target vocabulary is:

- `opus:create-application`
- `opus:create-view`
- `opus:create-layout`
- `opus:create-section`
- `opus:create-component`
- `opus:create-form-component`
- `opus:create-api-endpoint`
- `opus:create-action`
- `opus:create-service`
- `opus:create-runner`
- `opus:create-fsm-flow`

Historical `create-page` may remain as a compatibility alias for `create-view`, but `View` is the official frontend term.

## 15. Neutral skeleton rule

The standard OPUS skeleton must not impose blog/CMS vocabulary.

Forbidden as mandatory standard skeleton concepts:

- Articles
- Rubriques
- Blog
- News

These may exist as optional presets or user-created modules/components, not as the neutral default model.

## 16. Non-negotiable invariants

- An OPUS application is fullstack.
- Front, Middle and Back are clearly separated.
- Front represents data only.
- Middle secures, routes, transports and gates requests.
- Back processes business/data only.
- FSM is the mandatory processor at every level.
- No processing path bypasses the FSM.
- API request/response contracts are the boundary.
- OPUS owns standard components.
- Applications own custom components only.
- Backoffice is a frontend, not the backend.
- Forms and menus are components, not architecture roots.
- Views are frontend concepts; backend modules are business concepts.
- No silent fallback.
