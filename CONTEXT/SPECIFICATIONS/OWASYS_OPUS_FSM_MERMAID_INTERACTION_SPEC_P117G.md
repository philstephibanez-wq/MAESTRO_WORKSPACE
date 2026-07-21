# Spécification OWASYS — FSM Mermaid, flèches et interaction P117G

## 1. Frontière framework/application

```text
Opus/                  composants génériques du framework
sites/owasys/          application autonome
```

`Opus/Owasys` est interdit. Un composant spécifique à OWASYS ne doit jamais être placé sous `Opus/`.

## 2. Source de vérité

Le schéma est une projection de :

```text
config/owasys-navigation.fsm.json
        ∩
navigation autorisée par ACL
```

Il ne possède aucun état, événement, transition ou route autonome.

## 3. Transitions visuelles

Seules les transitions portant `visual: true` sont projetées.

Chaque transition projetée doit présenter :

- une ligne visible ;
- une pointe de flèche visible dans le thème sombre ;
- le libellé de l’événement ;
- une couleur suffisamment contrastée avec le canevas.

La visibilité des marqueurs SVG est assurée par le CSS applicatif du composant, sans modification de la sémantique FSM.

## 4. Navigation des nœuds

Les routes proviennent exclusivement du ViewModel de navigation déjà filtré par ACL.

Après rendu Mermaid :

1. chaque identifiant d’état attendu est résolu vers un groupe SVG Mermaid ;
2. le groupe reçoit `role="link"` et `tabindex="0"` ;
3. le clic déclenche la route autorisée ;
4. Entrée et Espace déclenchent la même route ;
5. le nombre de nœuds liés doit être égal au nombre de routes attendues ;
6. une divergence déclenche une erreur explicite et interdit le statut `ready`.

Les directives Mermaid `click` ne sont pas utilisées. L’interaction est ajoutée après rendu, ce qui préserve `securityLevel: strict`.

## 5. États du composant

```text
initialisation
    -> rendu Mermaid
    -> liaison des routes
    -> ready
```

Toute erreur de source, rendu, parsing de routes ou liaison conduit à :

```text
error
```

Le fallback reste visible en état `error`.

## 6. Accessibilité

- navigation souris ;
- navigation clavier par Entrée et Espace ;
- focus visible sur le nœud ;
- libellé accessible dérivé du texte du nœud ;
- aucun nœud non autorisé par ACL dans la table de routes.

## 7. Packaging

Le correctif runtime contient uniquement :

```text
sites/owasys/www/asset/css/fsm-mermaid.css
sites/owasys/www/asset/js/fsm-mermaid.js
sites/owasys/application/default/services/ScorePageRenderer.php
```

Il ne contient aucun smoke, Markdown, manifeste, script racine ou répertoire `Opus/Owasys`.
