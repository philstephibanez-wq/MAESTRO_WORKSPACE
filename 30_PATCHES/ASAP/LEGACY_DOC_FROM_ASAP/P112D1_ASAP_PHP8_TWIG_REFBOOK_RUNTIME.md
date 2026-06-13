# P112D1 — ASAP PHP8 + Twig Reference Book Runtime

## Rôle

Installer le premier runtime PHP 8 ASAP capable de rendre `ASAP_REF_BOOK`.

## Contrat

```text
NO DOC CONTRACT, NO PATCH
NO SILENT FALLBACK
NO MIXED RESPONSIBILITIES
```

## Couches ajoutées

- `ASAP\Application`
- `ASAP\Http`
- `ASAP\Site`
- `ASAP\Routing`
- `ASAP\Template`
- `ASAP\Documentation`

## Frontières

- `Application` orchestre.
- `SiteResolver` résout le site.
- `Router` matche les routes.
- `TwigTemplateRenderer` représente.
- `MarkdownPageRepository` lit le contenu source.
- `MarkdownHtmlRenderer` convertit la représentation Markdown locale.

## Prochaine étape

P112D2 doit brancher FSM Guard + ACL Guard dans le pipeline avant Router/Dispatcher.
