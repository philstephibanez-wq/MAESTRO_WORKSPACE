# ADR 20260619 — OPUS Score-first MVC and source-agnostic data contract

## Status

ACCEPTED.

## Context

During P117SITE12 OPUS site generator work, the first skeleton used JSON files as a convenient way to populate starter content. This created a wrong architectural signal: it looked like hardcoded PHP had been replaced by hardcoded JSON.

OPUS is an applicative web framework. Its primary output is clean HTML produced by templates, not layout encoded as JSON data.

## Decision

OPUS rendering is Score-first and MVC-oriented.

```text
.score
= declarative HTML structure, visual composition, variables, loops, conditions, partials and components.

i18n
= translated strings, labels, interface text and simple starter copy.

data
= normalized data prepared for rendering, regardless of original source.
```

Data sources are source-agnostic. A module may receive data from any official provider, for example:

```text
file
JSON
XML
database
API
cache
KB
internal service
other explicit provider
```

The rendering layer must not care about the original source.

## Required pipeline

```text
Data source
  -> Provider / Repository / Adapter
  -> Business service
  -> Validation / transformation / enrichment
  -> ViewModel
  -> .score template
  -> HTML
```

## Mandatory rules

```text
No PHP HTML assembly.
No JSON layout disguised as data.
No template querying databases, APIs or files directly.
No controller doing business rendering.
No service rendering HTML.
No module page without .score.
No manual page creation outside OPUS generators.
```

A `.score` template may receive variables, lists, route URLs, module states, translated strings and view-model data. It may render HTML through variables, loops, conditions, partials and components.

JSON is allowed only as a data source or data transport format, not as a substitute for templates. The same rule applies to XML, BDD/API payloads and all other sources: they must be normalized before reaching the template.

## Consequences for the skeleton generator

The OPUS skeleton must be changed so that:

```text
- starter layout and page structure live in .score templates;
- starter text lives in i18n files;
- resources/content is reduced or reserved for real business/editorial data examples;
- modules expose services and view-models as the normal data preparation layer;
- routes/modules/rubrics remain contract-driven;
- the language selector and persistent language navigation remain supported.
```

## Consequences for KB_FRONT_OFFICE and KB_BACK_OFFICE

`KB_FRONT_OFFICE` and `KB_BACK_OFFICE` are future OPUS applications. Their data may come from files, JSON, XML, BDD, APIs, cache, KB services or other providers, but their rendering must remain independent of those sources through the OPUS MVC pipeline and `.score` templates.

## Handoff requirement

This ADR must be reflected in `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` before further OPUS skeleton/generator work continues.
