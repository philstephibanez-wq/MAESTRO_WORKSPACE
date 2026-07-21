# MAESTRO_WORKSPACE — Handoff OWASYS / OPUS P117F

**Date :** 2026-07-21  
**Source de vérité code relue :** `philstephibanez-wq/OPUS`, branche `master`  
**Commit relu :** `9467dbb1977c32cdd7d63a19335f35c6988946dd` (`p117e`)

## Symptôme observé

Le panneau FSM Mermaid est présent dans le document, mais le canevas reste vide et le fallback demeure visible.

## Cause exacte

`Opus\Componants\Diagram\MermaidDiagram` sérialise la définition Mermaid ainsi :

```html
<script type="text/plain">SOURCE_HTML_ECHAPPEE</script>
```

Le contenu d’un élément `script` est du texte brut HTML. Les entités telles que `&gt;` ne sont pas décodées. Une transition Mermaid produite comme `-->` est donc transmise au navigateur sous la forme `--&gt;`, ce que le parseur Mermaid rejette.

La validation P117E vérifiait la présence de la source échappée côté serveur, mais ne validait pas la source réellement récupérée par le JavaScript dans le DOM.

## Correction P117F

1. `MermaidDiagram` transporte la source dans un payload JSON sécurisé :

```html
<script type="application/json" data-opus-mermaid-source>{"source":"..."}</script>
```

2. Le payload utilise `JSON_HEX_TAG`, `JSON_HEX_AMP`, `JSON_HEX_APOS` et `JSON_HEX_QUOT` afin qu’aucune source ne puisse fermer prématurément l’élément `script`.
3. L’intégration OWASYS décode le JSON avant d’appeler `window.OPUS.Mermaid.render()`.
4. `FrameworkAssetResponder` reste un pont strictement limité à deux bundles du framework :
   - `mermaid/opus-mermaid.js` ;
   - `codemirror/opus-codemirror.js`.
5. Toute autre ressource sous `/asset/opus/` reste refusée.
6. Le rendu Mermaid reste en `securityLevel: strict`.
7. La source du diagramme reste dérivée de la FSM et filtrée par l’ACL.

## Frontières conservées

- aucun CDN ;
- aucune copie Mermaid ou CodeMirror dans OWASYS ;
- aucun HTML construit par le contrôleur runtime ;
- rendu commun via `application/default/templates/*.score` ;
- FSM, ACL et SSO inchangés ;
- aucun smoke ni document dans le ZIP runtime.

## Fichiers du correctif

```text
Opus/Assets/FrameworkAssetResponder.php
Opus/Componants/Diagram/MermaidDiagram.php
sites/owasys/application/default/services/ScorePageRenderer.php
sites/owasys/www/asset/js/fsm-mermaid.js
```

## Critères de sortie

- le bundle Mermaid répond en HTTP 200 ;
- le bundle CodeMirror répond en HTTP 200 ;
- toute autre clé du responder répond en 404 ;
- la source extraite du payload JSON est strictement identique à la source Mermaid d’origine ;
- le SVG est injecté dans `.opus-mermaid-diagram` ;
- le panneau passe à `data-fsm-mermaid-status="ready"` ;
- le fallback est masqué ;
- les nœuds autorisés restent navigables au clavier et à la souris.
