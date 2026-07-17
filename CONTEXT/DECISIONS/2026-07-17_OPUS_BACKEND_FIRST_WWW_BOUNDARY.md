# Decision — OPUS backend-first and public www boundary

Date: 2026-07-17
Status: BINDING
Decision contract: OPUS_BACKEND_FIRST_WWW_BOUNDARY_V1

## Decision

All OPUS sites, including OWASYS, are backend-first PHP applications with server-rendered HTML.

JavaScript is progressive enhancement only. It must not own or reconstruct navigation, layout, application context, permissions, business state, validation, Git operations, build or export.

## Public boundary

`sites/<site>/www` is restricted to:

- a minimal `index.php` public entry point;
- public assets under `www/asset`.

The public entry point calls the OPUS application bootstrap and contains no application composition.

## Application ownership

Shared bootstrap, layouts, navigation, templates, views and I18N belong under `application/default`.

Controller-specific behavior belongs under `application/<controller>`.

Menus are declarative, server-rendered and use I18N keys.

## No-JavaScript requirement

Navigation and core forms must remain functional with JavaScript disabled.

CodeMirror, Mermaid and similar browser enhancements are allowed only when a functional backend/HTML fallback exists.

## I18N requirement

The canonical missing-key fallback is `[[cle.i18n]]`.

A raw key such as `menu.source` indicates an I18N bypass and is a blocking defect.

## OWASYS consequence

OWASYS delivery acceptance is suspended until:

1. misplaced application code is removed from `www`;
2. navigation and layout are rendered by PHP at their final location;
3. DOM relocation of required UI components is removed;
4. structural smokes enforce this decision;
5. the owner validates the remediated architecture.

## Enforcement

NO CONTRACT, NO PATCH.
NO BRICOLAGE DELIVERY.
BACKEND FIRST.
SERVER-RENDERED HTML FIRST.
JAVASCRIPT IS PROGRESSIVE ENHANCEMENT ONLY.
WWW IS PUBLIC ENTRY POINT AND PUBLIC ASSETS ONLY.