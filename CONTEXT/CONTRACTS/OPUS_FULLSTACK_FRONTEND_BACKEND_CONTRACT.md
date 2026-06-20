# OPUS Fullstack Frontend / Backend Contract

Status: DRAFT-LOCKED FOR P117SITE19
Date: 2026-06-21
Scope: OPUS framework, generated OPUS applications, future Composer authoring commands

## 1. Fundamental definition

An OPUS application is a standalone fullstack site/project built on the shared OPUS framework.

Every OPUS application is composed of two mandatory and clearly separated spaces:

- `frontend`: representation layer.
- `backend`: business/data processing layer.

Fullstack does not mean mixed responsibilities. Fullstack means the application owns both a frontend and a backend, with a strict contract boundary between them.

## 2. OPUS framework responsibility

OPUS is the shared framework. OPUS provides contracts, loaders, routing, rendering, configuration, validation, Composer authoring tools, API plumbing, request/response conventions, and the standard component library.

OPUS must not force a blog/CMS vocabulary into generated applications. Blog/news/catalog/support/admin/etc. are optional domain presets, not the neutral application model.

## 3. Application responsibility

A generated application is a fullstack OPUS application. It may be used as a public website, intranet, extranet, backoffice, documentation portal, business application, API application, or hybrid application.

The application owns:

- its identity and configuration,
- its frontend views and composition,
- its backend business modules and processing,
- its data contracts,
- its custom components when needed,
- its resources and documentation.

## 4. Frontend definition

The frontend is the representation layer. It displays data and triggers requests. It does not own business logic.

The frontend contains:

- `views`: screens/routes of representation.
- `layouts`: visual composition structures; layouts may be nested.
- `sections`: pieces of a view placed in layout slots/regions.
- `custom-components`: application-specific components only.
- `navigation`: menu/navigation data or view models consumed by OPUS standard menu components.
- `api-clients`: frontend clients/adapters for backend APIs.
- `assets`: CSS, JS, images and theme-level assets.
- `theme`: application visual customization.

The frontend may perform local UX checks, but all sovereign validation, security, authorization, workflow, persistence and business decisions belong to the backend.

## 5. OPUS standard component library

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

## 6. Form and menu definitions

A Form is a standard OPUS component. A form is placed in a section and contains inputs, buttons, errors and submit bindings.

A Menu is a standard OPUS component. The application owns navigation data/configuration, not the standard component itself.

Therefore:

- `Form` is not a top-level architecture pillar. It is a component type.
- `Menu` is not a top-level architecture pillar. It is a component type.
- Navigation data may be static configuration or a backend-produced MenuViewModel filtered by rights.

## 7. View / layout / section composition

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

## 8. Backend definition

The backend is the business/data processing layer. It does not render HTML and does not own visual composition.

The backend may be driven by:

- API endpoints,
- runners,
- CLI commands,
- jobs,
- workers,
- schedulers,
- internal services.

The backend contains:

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

## 9. Backend is not backoffice

Backend and backoffice must never be confused.

- Backend = business/data processing layer.
- Backoffice = a frontend/interface for administration or management.

A backoffice has its own frontend views/layouts/sections/components and consumes the backend through APIs just like a frontoffice, extranet or intranet frontend.

## 10. Request/response boundary

The API boundary separates frontend representation from backend processing.

```text
Frontend View/Component/Form
  -> ApiClient
    -> Request DTO
      -> Backend ApiEndpoint/Action/Service
        -> Response DTO or ViewModel
          -> Frontend representation
```

Rules:

- The frontend sends requests.
- The backend processes requests.
- The backend returns responses or view models.
- The frontend represents results.
- No business logic in views, sections, components, forms or layouts.
- No HTML representation in services, actions, repositories, validators or policies.

## 11. Canonical generated application structure

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

Compatibility note: existing `sites/<id>/application/...` structures may remain supported during migration, but the canonical target for P117SITE19+ is explicit `frontend/` and `backend/` separation.

## 12. Composer command direction

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

Historical `create-page` may remain as a compatibility alias for `create-view`, but `View` is the official frontend term.

## 13. Neutral skeleton rule

The standard OPUS skeleton must not impose blog/CMS vocabulary.

Forbidden as mandatory standard skeleton concepts:

- Articles
- Rubriques
- Blog
- News

These may exist as optional presets or user-created modules/components, not as the neutral default model.

## 14. Non-negotiable invariants

- An OPUS application is fullstack.
- Frontend and backend are mandatory and clearly separated.
- Frontend represents data only.
- Backend processes business/data only.
- API request/response contracts are the boundary.
- OPUS owns standard components.
- Applications own custom components only.
- Backoffice is a frontend, not the backend.
- Forms and menus are components, not architecture roots.
- Views are frontend concepts; backend modules are business concepts.
- No silent fallback.
