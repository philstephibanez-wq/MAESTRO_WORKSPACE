# HANDOFF — OPUS P117W R45D2A7 PROFILER HIERARCHICAL CATEGORIES

Date : 2026-08-10

## Base canonique

`62ed6c6b7440034c5855e310899fb11d605fdf00` — `opus_p117w_r45d2a5_generated_profiler_iframe_integration`

## Capture owner

État observé sur `essai2` :

- page `/fr/login` conservée ;
- Profiler intégré dans la page ;
- surface Profiler repliable/masquable acquise ;
- login toujours refusé avec `Authentication failed` ;
- trace visible : `Security / ACL / SSO = 0` malgré l’instrumentation `security.sso` publiée en R45D2A3.

## Cause prouvée

`WebProfilerView::buildPanels()` utilise une égalité stricte entre `row.category` et les catégories de panneau. Une catégorie réelle `security.sso` n’est donc jamais retenue par `['security','acl','sso','auth']`.

Le défaut concerne potentiellement toutes les catégories hiérarchiques `racine.*`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a7_profiler_hierarchical_categories.zip
SHA-256 : cae99b491d5d8c988f3a8d8a59d9cd4775bd902358e7e1749fbb552e2d1d8d35
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 2
```

Fichiers :

```text
Opus/Profiler/WebProfilerView.php
Opus/Application/Runtime/templates/profiler-iframe.score
```

R45D2A7 supersède R45D2A6 : il contient également la surface `<details>/<summary>` repliable validée visuellement.

## Validation assistant

- `php -l Opus/Profiler/WebProfilerView.php` : OK ;
- matching exact conservé ;
- matching descendant `candidate.*` ajouté ;
- aucun événement synthétique ;
- aucun patch site-specific ;
- aucun changement ACL/SSO.

## Suite owner

1. appliquer R45D2A7 ;
2. relancer `essai2` ;
3. refaire un POST de login `steve` ;
4. ouvrir `Security / ACL / SSO` ;
5. relever `authentication.failed` et `error_code` ;
6. corriger ensuite uniquement la cause SSO prouvée.

NO PUSH OPUS BY ASSISTANT.
