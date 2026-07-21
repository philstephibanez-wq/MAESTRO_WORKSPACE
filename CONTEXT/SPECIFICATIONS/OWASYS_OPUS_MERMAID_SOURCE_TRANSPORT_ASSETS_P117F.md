# Spécification OWASYS / OPUS — transport Mermaid et exposition des assets P117F

## 1. Périmètre

Cette spécification régit :

- le transport serveur → DOM d’une définition Mermaid ;
- le chargement des bundles frontend partagés du framework ;
- l’intégration du schéma FSM Mermaid dans OWASYS.

## 2. Source de vérité

```text
config/owasys-navigation.fsm.json
  -> OwasysFsmMermaidBuilder
  -> Opus\Componants\Diagram\MermaidDiagram
  -> payload JSON DOM
  -> window.OPUS.Mermaid.render()
```

Le diagramme n’est jamais une seconde définition de la FSM.

## 3. Contrat de transport Mermaid

La définition Mermaid ne doit pas être placée sous forme HTML échappée dans un élément `script` de texte brut.

Format obligatoire :

```html
<div data-opus-mermaid="true">
  <script
    type="application/json"
    data-opus-mermaid-source
  >{"source":"flowchart LR\n..."}</script>
</div>
```

Le JSON doit être produit avec :

```text
JSON_UNESCAPED_SLASHES
JSON_UNESCAPED_UNICODE
JSON_HEX_TAG
JSON_HEX_AMP
JSON_HEX_APOS
JSON_HEX_QUOT
JSON_THROW_ON_ERROR
```

Le consommateur JavaScript doit :

1. localiser `script[type="application/json"][data-opus-mermaid-source]` ;
2. exécuter `JSON.parse(textContent)` ;
3. vérifier que `payload.source` est une chaîne non vide ;
4. transmettre cette chaîne sans transformation à `window.OPUS.Mermaid.render()`.

## 4. Assets partagés du framework

`FrameworkAssetResponder` est autorisé uniquement pour :

```text
/asset/opus/mermaid/opus-mermaid.js
/asset/opus/codemirror/opus-codemirror.js
```

Correspondances physiques :

```text
Opus/Assets/dist/mermaid/opus-mermaid.js
Opus/Assets/dist/codemirror/opus-codemirror.js
```

Toute autre clé sous `/asset/opus/` doit produire une réponse 404 explicite.

Le responder :

- accepte seulement GET et HEAD ;
- refuse les chemins non listés ;
- vérifie le confinement réel sous `Opus/Assets/dist` ;
- envoie `X-Content-Type-Options: nosniff` ;
- ne devient pas un serveur générique de fichiers du framework.

## 5. Sécurité

- aucun CDN ;
- `securityLevel: strict` ;
- aucune directive Mermaid `click` générée ;
- les routes sont branchées après rendu depuis une table déjà filtrée par ACL ;
- la visibilité d’un nœud ne remplace jamais le contrôle ACL serveur ;
- les données de contexte sont nettoyées avant intégration à la syntaxe Mermaid.

## 6. SCORE et architecture OWASYS

Le panneau reste un composant commun sous :

```text
sites/owasys/application/default/templates/partials/fsm-mermaid.score
```

`application/default` demeure la couche commune ; ce n’est ni un état ni une page home.

Le contrôleur runtime prépare uniquement le ViewModel. Il ne construit pas le panneau HTML ni le SVG.

## 7. Cache

Le script d’intégration applicatif modifié doit être appelé avec une version de ressource afin qu’un navigateur ne conserve pas le JavaScript P117E défectueux :

```text
/asset/js/fsm-mermaid.js?v=p117f
```

## 8. Validation minimale

La validation doit démontrer :

- syntaxe PHP valide ;
- syntaxe JavaScript valide ;
- round-trip exact d’une source contenant `-->`, `<br/>`, accents et guillemets ;
- absence de `&gt;` dans la source obtenue après `JSON.parse` ;
- whitelist du responder limitée à Mermaid et CodeMirror ;
- rendu SVG effectif dans un navigateur ;
- statut `ready` et fallback masqué.

La seule présence du panneau ou de la source échappée côté serveur n’est pas une preuve de rendu Mermaid fonctionnel.
