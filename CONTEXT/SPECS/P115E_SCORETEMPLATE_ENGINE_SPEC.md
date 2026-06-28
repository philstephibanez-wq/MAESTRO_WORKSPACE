# P115E — OPUS ScoreTemplate Engine — Palier 1 MVC

## Statut de correction

Cette spécification remplace l'ancien libellé erroné `ASAP ScoreTemplate Engine`.

ScoreTemplate / `.score` appartient à OPUS, pas ASAP.

Les formulations historiques `ASAP ScoreTemplate Engine`, `ASAP\View\ScoreTemplate` et `implémentation ASAP native` sont obsolètes pour la ligne OPUS.

## Clarification MVP / MVC

MVC est l'architecture OPUS.

Le terme MVP ne doit pas être utilisé comme architecture ici. Quand un ancien texte mentionne MVP, il faut lire uniquement : premier palier fonctionnel minimal.

Dans cette spécification, on utilise donc `Palier 1 MVC` pour éviter toute confusion.

## Nom validé

- Nom officiel : `OPUS ScoreTemplate Engine`
- Nom court : `ScoreTemplate`
- Extension : `.score`
- Namespace cible : `Opus\View\ScoreTemplate`
- Propriétaire framework : OPUS
- Architecture : MVC OPUS

## Formule d’architecture

`Smarty-like, mais avec discipline Mustache/Liquid, et sécurité/diagnostic inspirés de Twig.`

## Objectif

Créer un moteur de template natif OPUS, sans dépendance Twig/Symfony à terme, pour rendre les vues de façon stricte, sûre, lisible et facilement débogable.

ScoreTemplate est la couche View du MVC OPUS :

- les controllers/services préparent les données ;
- les view-models transportent les données prêtes pour la vue ;
- le template orchestre uniquement l’affichage ;
- aucune logique métier ne vit dans la vue ;
- aucune erreur n’est masquée.

## Syntaxe Palier 1 MVC

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

{include "partials/header.score"}

{# commentaire non rendu #}
```

## Fonctionnalités Palier 1 MVC

- variables : `{$page.title}`, `{$section.items.0.label}`
- filtres : `escape`, `raw`, `default:"..."`, `upper`, `lower`, `json`, `url`
- conditions : `{if}`, `{else}`, `{/if}`
- boucles : `{foreach $items as $item}`, `{/foreach}`
- includes : `{include "partials/header.score"}`
- commentaires : `{# ... #}`
- erreurs strictes : variable manquante, include manquant, tag non fermé, filtre inconnu, boucle non itérable.

## Interdits Palier 1 MVC

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
OPUS_SCORETEMPLATE_VARIABLE_MISSING
Template: pages/home.score
Line: 12
Variable: $missing.value
```

```text
OPUS_SCORETEMPLATE_UNCLOSED_IF
Template: pages/reference.score
Line: 42
Tag opened: {if $page.visible}
Expected: {/if}
```

```text
OPUS_SCORETEMPLATE_INCLUDE_NOT_FOUND
Template: pages/reference.score
Line: 8
Include: partials/header.score
Root: H:\OPUS\sites\opus-refbook\templates
```

## DebugTrace

Mode debug officiel attendu :

```text
Template rendered:
- layout.score
- partials/header.score
- pages/reference.score
- partials/footer.score

Variables utilisées:
- page.title
- page.sections
- ui.menu.home
- assets.css.refbook

Variables manquantes:
- none

Includes:
- partials/header.score OK
- partials/footer.score OK

Escaping:
- page.title escaped
- page.body raw
```

En développement uniquement, commentaires HTML possibles :

```html
<!-- OPUS_SCORETEMPLATE_START pages/reference.score -->
...
<!-- OPUS_SCORETEMPLATE_END pages/reference.score -->
```

## Classes cibles

```text
Opus\View\ScoreTemplate\ScoreTemplateEngine
Opus\View\ScoreTemplate\ScoreTemplateRenderer
Opus\View\ScoreTemplate\ScoreTemplateParser
Opus\View\ScoreTemplate\ScoreTemplateLoader
Opus\View\ScoreTemplate\ScoreTemplateContext
Opus\View\ScoreTemplate\ScoreTemplateFilterRegistry
Opus\View\ScoreTemplate\ScoreTemplateDebugTrace
Opus\View\ScoreTemplate\ScoreTemplateException
```

Responsabilités :

- Loader : trouve et lit les fichiers.
- Parser : comprend la syntaxe.
- Renderer : produit le HTML.
- Context : transporte les données.
- Filters : applique `escape`, `raw`, `default`, etc.
- DebugTrace : explique le rendu.
- Exception : porte une erreur claire, localisée et contractuelle.

## MVC OPUS

```text
Model / Provider / Repository / Adapter
  -> Service / validation / transformation
  -> Controller
  -> ViewModel
  -> ScoreTemplate .score
  -> HTML
```

ScoreTemplate ne remplace pas MVC. ScoreTemplate est le moteur de rendu strict de la couche View.

## Migration

Ne pas supprimer Twig brutalement.

Ordre :

1. Garder Twig temporairement si encore présent dans une zone historique.
2. Maintenir `.score` comme format OPUS.
3. Créer ou consolider ScoreTemplate côté OPUS uniquement.
4. Ajouter tests Palier 1 MVC.
5. Migrer progressivement les templates RefBook vers `.score` OPUS si certains fragments historiques ne le sont pas encore.
6. Supprimer Twig seulement quand RefBook tourne entièrement avec OPUS ScoreTemplate.

## Contrats permanents

- 0 fallback silencieux.
- Pas de moteur fourre-tout.
- Pas de logique métier dans les vues.
- Séparation stricte data / traitement / représentation.
- ScoreTemplate est une implémentation OPUS native ; Twig, Smarty, Mustache et Liquid sont des inspirations, pas du code à copier.
- ASAP est un contexte historique possible, pas le propriétaire de ScoreTemplate.
- MVC reste l'architecture OPUS ; ScoreTemplate est la couche View, pas un substitut MVC.
