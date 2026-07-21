# Handoff OWASYS / OPUS — P117E FSM Mermaid

**Date :** 2026-07-21  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit courant relu :** `af99d2037d8750b772f576dfd72f6a20f5da973b` — `p117d`

## Demande active

Réintégrer le schéma FSM Mermaid tel qu’il existait dans l’ancien OWASYS, sans restaurer le monolithe ni contourner l’architecture SCORE/FSM/ACL/SSO actuelle.

## Références historiques relues

- `0792e2e8000099a11d662eeb63d837b00d8c935a` : première navigation Mermaid cliquable ;
- `1e510a1118645d3118f9ebf7b689bbd5d727470b` : présentation du panneau et de l’état actif ;
- `cc955e8f9e9c09fd30da59f9f639d1b6136bcffa` : projection générée depuis la FSM avec transitions visuelles ;
- `4fd67e8d1f89b22eee6b7f24fd0e4b20fe881f67` : Mermaid intégré au framework OPUS, sans CDN et avec `securityLevel: strict`.

## Comportement historique à restaurer

Le schéma doit :

- être généré depuis la configuration FSM ;
- afficher les états de navigation ;
- souligner l’état courant ;
- enrichir le contexte avec l’application sélectionnée ;
- afficher uniquement les transitions explicitement déclarées visuelles ;
- permettre la navigation vers les routes correspondantes ;
- être visible sur les pages authentifiées, hors login et compte.

## Adaptation au runtime actuel

Le runtime P117D utilise déjà :

- ScoreTemplate pour le document ;
- `FsmProcessor` et `FsmActionDispatcher` ;
- l’identité SSO ;
- l’ACL serveur et la navigation ACL filtrée ;
- `application/default` comme couche commune.

P117E doit donc s’intégrer par les composants communs, sans modifier les contrôleurs fonctionnels des modules.

## Décisions P117E

1. `OwasysFsmMermaidBuilder` appartient à `application/default/services`.
2. Le builder relit la même FSM canonique que le runtime.
3. Les nœuds sont l’intersection entre les états FSM et la navigation autorisée par ACL.
4. Les arêtes utilisent `transition.visual === true`.
5. Pour une transition runtime `from: "*"`, `visual_from` précise uniquement la source graphique.
6. Le composant framework `Opus\Componants\Diagram\MermaidDiagram` construit le conteneur sécurisé.
7. Le bundle local `Opus/Assets/dist/mermaid/opus-mermaid.js` est servi par le front controller via `FrameworkAssetResponder`.
8. Aucun fichier Mermaid n’est copié dans OWASYS et aucun CDN n’est chargé.
9. Le partial `default/templates/partials/fsm-mermaid.score` est inclus par le layout commun SCORE.
10. La navigation des nœuds est branchée après rendu à partir d’une table de routes déjà filtrée par ACL.

## Fichiers du ZIP P117E

```text
Opus/Assets/FrameworkAssetResponder.php
sites/owasys/application/default/services/FsmMermaidBuilder.php
sites/owasys/application/default/services/ScorePageRenderer.php
sites/owasys/application/default/templates/layout.score
sites/owasys/application/default/templates/partials/fsm-mermaid.score
sites/owasys/config/owasys-navigation.fsm.json
sites/owasys/www/asset/css/fsm-mermaid.css
sites/owasys/www/asset/js/fsm-mermaid.js
sites/owasys/www/index.php
```

## Non-régressions obligatoires

- front controller unique ;
- aucune page fonctionnelle dans `default` ;
- aucune vue PHP ;
- aucune duplication de FSM ;
- aucune route ajoutée hors FSM ;
- aucun contournement ACL ;
- aucun login parallèle au SSO ;
- Registry et application courante préservés ;
- menu horizontal préservé ;
- 25 langues et drapeaux préservés ;
- œil des mots de passe préservé ;
- page Code source préservée.

## Validation attendue dans le navigateur

1. La page de connexion ne charge pas le schéma.
2. Le compte mot de passe ne charge pas le schéma.
3. Après connexion, le Registry affiche le schéma.
4. Le schéma contient Registry, Structure, Données, Workflows, Sécurité, Sources et Git, Construction et validation.
5. L’état courant est visuellement accentué.
6. Le nom de l’application courante apparaît sur le nœud Structure.
7. Les nœuds autorisés sont accessibles à la souris et au clavier.
8. Un état refusé par ACL n’apparaît pas.
9. Le réseau ne charge aucun CDN Mermaid.
10. Les transitions fonctionnelles continuent à être exécutées par la FSM et `FsmActionDispatcher`.
