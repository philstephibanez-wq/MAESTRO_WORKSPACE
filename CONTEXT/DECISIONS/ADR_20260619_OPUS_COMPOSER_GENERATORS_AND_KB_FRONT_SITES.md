# ADR 20260619 — OPUS Composer generators and KB front/back office as OPUS sites

## Status

ACCEPTED — permanent workspace rule.

## Context

The user clarified the intended OPUS application model after providing the historical ASAP demo as reference.

ASAP was designed around real applications, not isolated pages. An application contains common parts inherited by modules, and each module owns only its business-specific parts.

OPUS must preserve this application/module model. The main difference from ASAP is that OPUS uses Composer for package/autoload orchestration and avoids external dependencies whenever possible.

The user also clarified that future `KB_FRONT_OFFICE` and `KB_BACK_OFFICE` must be full OPUS sites/applications, not standalone bricolage pages or unrelated front projects.

## Decision

OPUS applications/sites must be created and evolved through contractual generators, not by manually creating isolated pages.

Composer is part of the OPUS orchestration contract, but Composer must not become an excuse for uncontrolled third-party dependencies.

## ASAP-to-OPUS application equivalence

```text
ASAP principle:
Application = common application base + business modules.
Module = inherited common parts + business-specific resources/overrides.

OPUS principle:
Application/site = Composer-declared OPUS application + common application base + business modules.
Module = inherited common parts + business-specific resources/overrides + .score templates.
```

The following are common/inheritable application concerns unless explicitly overridden by a module:

```text
acl
helpers
css/assets
javascript
local/i18n
models/services
controllers base contracts
views/view-model base contracts
templates base contracts
routing/navigation defaults
FSM/transition defaults when present
```

The following belong inside the business module when specific to that module:

```text
module acl rules
module helpers
module css/assets
module javascript
module locale/i18n resources
module models/services
module controllers
module view-models/views
module .score templates
module pages/partials/components
module route declarations
module FSM transitions/states
```

Common parts must never be duplicated module by module. Modules inherit common parts and only provide their business-specific implementation, resources, and overrides.

## ScoreTemplate obligation

Every OPUS page representation must go through `.score` templates.

```text
NO MODULE, NO OPUS PAGE.
NO .score TEMPLATE, NO OPUS PAGE.
NO ROUTE DECLARATION, NO PUBLIC ACCESS.
NO FSM/TRANSITION DECLARATION, NO STATEFUL NAVIGATION.
```

Forbidden:

```text
manual page creation in public/
HTML page rendering in public/index.php
HTML page rendering in controllers
HTML concatenation in PHP services
Twig active rendering for OPUS sites
module-less page files
route-less pages
hidden navigation state in JavaScript
hidden FSM transitions in controllers/templates
```

Required pipeline:

```text
FrontController -> Composer autoload -> OPUS Application -> SiteResolver -> Router -> FSM/Transition contract when present -> Controller -> Service -> ViewModel -> ScoreTemplateRenderer -> .score -> HTML Response
```

## Composer rule

OPUS uses Composer for:

```text
package identity
autoload
internal OPUS packages
site/application generators
bin commands
versioned manifests
optional official packages
```

OPUS must avoid external dependencies whenever possible.

An external dependency is an exception and requires:

```text
explicit justification
license verification
version lock
security review
offline/local behavior review
no runtime network dependency
documented replacement/removal plan when feasible
user validation before introduction
```

Composer is allowed as orchestration. Composer dependency sprawl is not allowed.

## Generator rule

No OPUS site, module, page, route, transition, locale, asset, or `.score` template may be created manually as an isolated file.

Creation must go through OPUS generators, equivalent in intent to `composer create site`, `create module`, etc.

Target command family:

```text
composer opus -- create:site <site>
composer opus -- create:module <site> <module>
composer opus -- create:page <site> <module> <page>
composer opus -- create:route <site> <module> <page> <path>
composer opus -- create:transition <site> <module> <from-state> <signal> <to-state>
composer opus -- create:locale <site> <module> <locale>
composer opus -- create:asset <site> <module> <asset-type>
composer opus -- create:template <site> <module> <template-kind> <name>
```

Alternative binary form is acceptable if OPUS standardizes it:

```text
vendor/bin/opus create:site <site>
vendor/bin/opus create:module <site> <module>
vendor/bin/opus create:page <site> <module> <page>
```

Generators must create complete contractual structures, not single loose files.

A `create:module` generator must create the expected module skeleton, including the standard resource categories and `.score` template locations.

A `create:page` generator must create, register, or update at least:

```text
module page .score template
route declaration
locale/content placeholders when required
view-model/service/controller contract stubs when required
FSM transition placeholder when the page participates in stateful navigation
```

## KB front/back office rule

`KB_FRONT_OFFICE` and `KB_BACK_OFFICE` are future OPUS sites/applications.

They must not be built as bricolage pages, unrelated standalone sites, or hardcoded UIs.

They must follow the OPUS application/module/generator contract:

```text
Composer-declared OPUS site/application
common application base inherited by modules
business modules for each domain area
routes declared through OPUS contract
FSM/transitions declared through OPUS contract when present
controllers/services/view-models separated
all rendering through .score templates
local/i18n/theme/assets structured per application/module rules
no external dependency unless contractually justified and validated
```

## Consequences

Future OPUS work must first implement or specify the OPUS generator contract before migrating sites by hand.

RefBook, Log&Play, KB front office, and KB back office must be aligned as OPUS applications/sites, not patched as isolated pages.

If a requested change implies creating a page/module/site and the generator does not exist yet, the next correct delivery is generator contract/audit/implementation, not manual file creation.
