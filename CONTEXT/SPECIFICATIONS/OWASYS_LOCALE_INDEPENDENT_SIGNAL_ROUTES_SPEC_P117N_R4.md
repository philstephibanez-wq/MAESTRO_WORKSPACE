# OWASYS P117N-R4 — LOCALE-INDEPENDENT SIGNAL ROUTES SPECIFICATION

## 1. Scope

This specification governs route-path to FSM-event resolution in OWASYS after regional locale support.

## 2. Core rule

Technical route paths are locale-independent signals.

Locale affects:

- catalog selection;
- native labels;
- regional variants;
- generated localized URLs;
- presentation.

Locale must not duplicate or partition the technical route-to-event map when route paths are identical.

## 3. Canonical route contract

`sites/owasys/config/routes.json` must declare:

```json
{
  "contract": "OPUS_SIGNAL_ROUTES_V2",
  "system_routes": {},
  "routes": {}
}
```

The `routes` object is a flat map:

```json
{
  "applications": "change_app",
  "structure": "open_structure"
}
```

Forbidden form:

```json
{
  "routes": {
    "fr": {
      "applications": "change_app"
    },
    "en": {
      "applications": "change_app"
    }
  }
}
```

The forbidden form creates duplicate configuration and cannot cover regional locales without unbounded repetition.

## 4. Exact route matrix

Required route-to-event pairs:

- `login` -> `open_login`;
- `account/password` -> `open_account`;
- `applications` -> `change_app`;
- `structure` -> `open_structure`;
- `data` -> `open_data`;
- `workflows` -> `open_workflows`;
- `security` -> `open_security`;
- `source` -> `open_source`;
- `build` -> `open_build`;
- `logout` -> `logout`.

No undeclared route may resolve by naming convention, string synthesis, locale fallback or controller fallback.

## 5. Runtime algorithm

`RuntimeController` resolves the request in this order:

1. normalize request path;
2. resolve explicit supported locale or negotiate browser locale;
3. retain the remaining route path;
4. resolve the route path from the single V2 signal map;
5. reject unknown paths with 404;
6. submit the resolved event to the FSM;
7. apply SSO identity, ACL decision, FSM guards and actions;
8. build the ViewModel;
9. render exclusively through SCORE.

`resolveSignal()` accepts only the route key:

```php
private function resolveSignal(string $routeKey): string
```

The method must not accept or inspect locale.

## 6. Strict contract validation

The runtime must reject a route configuration whose contract is not exactly:

`OPUS_SIGNAL_ROUTES_V2`

There is no compatibility fallback to `OPUS_LOCALIZED_SIGNAL_ROUTES_V1`.

There is no base-language fallback for route maps because route maps are no longer language-scoped.

## 7. FSM source discipline

Every route value must identify an event explicitly declared by the active OWASYS FSM.

Every page route except the event-only logout route must correspond to a declared FSM state route.

The Registry Applications page remains:

- state: `registry`;
- module: `registry`;
- route: `applications`;
- entry event: `change_app`;
- authentication required;
- current application not required.

The route configuration maps signals to events only. State ownership, transitions, guards and actions remain in the FSM source of truth.

## 8. ACL and SSO

Route resolution does not authorize access.

After signal resolution, the runtime must still enforce:

- SSO identity requirements;
- deny-by-default ACL;
- target-state access;
- current-application guards;
- FSM transition guards;
- action dispatch.

No Auth0 proxy, bastion integration or authentication fallback is introduced by this milestone.

## 9. I18n interaction

The route map is independent from catalog inheritance.

All 62 locales use the same technical route map, including:

- `en-IE`;
- `fr-BE`;
- `de-CH`;
- `uk-UA`.

Catalogs retain the canonical filename contract:

`<locale>.json`

No `asap.` prefix, PHP catalog or underscore alias is allowed.

## 10. Structured-file boundary

`routes.json` is read through:

- `Opus\File\File`;
- `Opus\File\StructuredFileLoader`;
- `Opus\File\Json`.

Direct `file_get_contents()` calls are forbidden in the corrected controller.

The developer may select YAML/YML or XML for a future configuration file by changing its extension and configured path, provided the owning application specification is updated and the OPUS parser contract is respected.

## 11. OPUS class contract

P117N-R4 adds no concrete framework class.

Any future concrete OPUS framework class must implement a homonymous interface extending:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

The P117M-R1 exhaustive audit remains mandatory.

## 12. SCORE boundary

No route may render HTML directly.

Forbidden:

- UI-producing `echo`;
- HTML/PHP mixed views;
- route-to-controller rendering bypassing FSM;
- pretranslated visible error strings from the controller.

The corrected route flow terminates in the existing ViewModel and SCORE renderer.

## 13. Required audit gates

Before commit, the maintenance audit must verify:

- exact V2 route contract;
- exact ten-route matrix;
- flat non-localized map;
- all route events declared in the FSM;
- all page routes represented by FSM states;
- exactly 62 configured locales;
- exact browser negotiation cases for regional locales;
- 248 canonical JSON catalogs;
- no `asap.*` catalog;
- no PHP catalog;
- successful module-aware translation runtime construction;
- no locale parameter in `resolveSignal()`;
- no locale-indexed route access;
- no legacy message loader;
- no direct file read in the controller;
- PHP lint;
- P117M-R1 component-contract audit;
- `git diff --check`;
- browser validation on the target Windows runtime.

## 14. Cleanup and staging

No application runtime file must be deleted for P117N-R4.

Obsolete R2/R3 maintenance wrappers may be removed after R4 succeeds. The route configuration and corrected controller are tracked runtime files and must be staged normally.
