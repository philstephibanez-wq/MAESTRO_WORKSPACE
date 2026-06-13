# P115E — ASAP ScoreTemplate Engine MVP

## Nom validé

- Nom officiel : `ASAP ScoreTemplate Engine`
- Nom court : `ScoreTemplate`
- Namespace cible : `ASAP\View\ScoreTemplate`

## Formule d’architecture

`Smarty-like, mais avec discipline Mustache/Liquid, et sécurité/diagnostic inspirés de Twig.`

## Objectif

Créer un moteur de template natif ASAP, sans dépendance Twig/Symfony à terme, pour rendre les vues de façon stricte, sûre, lisible et facilement débogable.

ScoreTemplate est une “partition de vue” :
- les controllers/services préparent les données ;
- le template orchestre uniquement l’affichage ;
- aucune logique métier ne vit dans la vue ;
- aucune erreur n’est masquée.

## Syntaxe MVP

```text
{$page.title}
{$user.name}
{$content|raw}

{if $page.visible}
  <h1>{$page.title}</h1>
{else}
  <p>Page masquée</p>
{/if}

{foreach $items as $item}
  <li>{$item.label}</li>
{/foreach}

{include "partials/header.tpl"}

{# commentaire non rendu #}
```

## Fonctionnalités MVP

- variables : `{$page.title}`, `{$section.items.0.label}`
- filtres : `escape`, `raw`, `default:"..."`, `upper`, `lower`, `json`, `url`
- conditions : `{if}`, `{else}`, `{/if}`
- boucles : `{foreach $items as $item}`, `{/foreach}`
- includes : `{include "partials/header.tpl"}`
- commentaires : `{# ... #}`
- erreurs strictes : variable manquante, include manquant, tag non fermé, filtre inconnu, boucle non itérable.

## Interdits MVP

- Pas de PHP libre dans les templates.
- Pas de SQL/API/fichiers depuis un template.
- Pas d’appels méthodes métier arbitraires.
- Pas de calculs complexes.
- Pas de logique métier dans la vue.
- Pas de fallback silencieux.
- Pas de `extends`, `block`, `macro`, `import` au premier palier.

## Sécurité

Escape HTML par défaut :

```text
{$title}
```

HTML volontaire uniquement via `raw` explicite :

```text
{$content|raw}
```

`raw` doit rester visible et assumé.

## Diagnostic obligatoire

Chaque erreur doit indiquer :
- template ;
- ligne ;
- colonne si possible ;
- tag ou variable ;
- cause ;
- correction probable.

Exemples :

```text
ASAP_TEMPLATE_VARIABLE_MISSING
Template: pages/home.tpl
Line: 12
Variable: $missing.value
```

```text
ASAP_TEMPLATE_UNCLOSED_IF
Template: pages/reference.tpl
Line: 42
Tag opened: {if $page.visible}
Expected: {/if}
```

```text
ASAP_TEMPLATE_INCLUDE_NOT_FOUND
Template: pages/reference.tpl
Line: 8
Include: partials/header.tpl
Root: H:\ASAP_REF_BOOK\application\reference\templates
```

## DebugTrace

Mode debug officiel attendu :

```text
Template rendered:
- layout.tpl
- partials/header.tpl
- pages/reference.tpl
- partials/footer.tpl

Variables utilisées:
- page.title
- page.sections
- ui.menu.home
- assets.css.refbook

Variables manquantes:
- none

Includes:
- partials/header.tpl OK
- partials/footer.tpl OK

Escaping:
- page.title escaped
- page.body raw
```

En développement uniquement, commentaires HTML possibles :

```html
<!-- ASAP_SCORETEMPLATE_START pages/reference.tpl -->
...
<!-- ASAP_SCORETEMPLATE_END pages/reference.tpl -->
```

## Classes cibles

```text
ASAP\View\ScoreTemplate\ScoreTemplateEngine
ASAP\View\ScoreTemplate\ScoreTemplateRenderer
ASAP\View\ScoreTemplate\ScoreTemplateParser
ASAP\View\ScoreTemplate\ScoreTemplateLoader
ASAP\View\ScoreTemplate\ScoreTemplateContext
ASAP\View\ScoreTemplate\ScoreTemplateFilterRegistry
ASAP\View\ScoreTemplate\ScoreTemplateDebugTrace
ASAP\View\ScoreTemplate\ScoreTemplateException
```

Responsabilités :
- Loader : trouve et lit les fichiers.
- Parser : comprend la syntaxe.
- Renderer : produit le HTML.
- Context : transporte les données.
- Filters : applique `escape`, `raw`, `default`, etc.
- DebugTrace : explique le rendu.
- Exception : porte une erreur claire, localisée et contractuelle.

## Migration

Ne pas supprimer Twig brutalement.

Ordre :
1. Garder Twig temporairement.
2. Finaliser P115C : assets RefBook ASAP déplacés de `DOC/refbook` vers `resources/refbook`.
3. Finaliser P115D : RefBook consomme ASAP vendor au lieu de son propre vendor.
4. Créer ScoreTemplate côté ASAP.
5. Ajouter tests MVP.
6. Migrer progressivement les templates RefBook.
7. Supprimer Twig seulement quand RefBook tourne entièrement avec ScoreTemplate.

## Contrats permanents

- 0 fallback silencieux.
- Pas de moteur fourre-tout.
- Pas de logique métier dans les vues.
- Séparation stricte data / traitement / représentation.
- ScoreTemplate est une implémentation ASAP native ; Twig, Smarty, Mustache et Liquid sont des inspirations, pas du code à copier.
