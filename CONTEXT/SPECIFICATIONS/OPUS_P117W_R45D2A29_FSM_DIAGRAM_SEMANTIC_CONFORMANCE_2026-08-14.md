# OPUS P117W R45D2A29 — FSM Diagram Semantic Conformance

Date : 2026-08-14

## Base

OPUS publiée : `f61382ea8e8c2e590176e25ef98208a7ff8ceaee` (`R45D2A28A`).

R45D2A28B peut être appliqué localement en parallèle : il touche la navigation Security, tandis que R45D2A29 traite le renderer FSM générique `Opus/Fsm/Diagram.class.php`.

## Cause traitée

Le renderer FSM OPUS actuel produit un schéma visuellement agréable mais sémantiquement insuffisant pour représenter une machine à états :

- les arêtes sont indexées par simple couple `from -> to`, ce qui fusionne plusieurs transitions distinctes entre les mêmes états ;
- les signaux sont concaténés au lieu de rester attachés à leur transition ;
- les actions sont affichées séparément des transitions ;
- les gardes ne sont pas représentées ;
- aucun traitement graphique spécifique des self-loops ;
- les wildcards OPUS (`__any__`, source `*`, `__default__`) ne sont pas représentés fidèlement ;
- l'état initial/final est rendu comme un rectangle ordinaire tagué et non avec une sémantique graphique dédiée ;
- le placement des états suit l'ordre du tableau et non la topologie des transitions.

## Référence sémantique

Le diagramme doit suivre la sémantique usuelle des automates d'états / statecharts :

- un état est un nœud ;
- une transition est une arête orientée distincte ;
- son libellé suit le modèle `signal [garde] / effet` lorsque ces éléments existent ;
- plusieurs transitions entrantes et sortantes sont autorisées pour un même état ;
- plusieurs signaux depuis un même état sont représentés distinctement ;
- plusieurs transitions entre le même couple d'états ne sont pas fusionnées ;
- une transition vers le même état est rendue sous forme de boucle ;
- l'état courant est une information runtime de surbrillance, pas un type de nœud différent ;
- l'initialisation et la terminaison utilisent des marqueurs dédiés ;
- les extensions OPUS wildcard/fallback restent explicites et ne sont pas déguisées en transitions standards.

Référence normative complémentaire : W3C SCXML, où les transitions sont déclenchées par des événements, conditionnées par des gardes et peuvent porter du contenu exécutable.

## Contrat OPUS

1. Conserver l'API publique historique de `OPUS_FSM_Diagram` utilisée par `OPUS_FSM_Fsm::draw()`.
2. Ajouter une entrée compatible avec les définitions canoniques `FsmProcessor` afin d'exposer `from`, `signal`, `next_state`, `guards`, `actions` et `runtime_operations` sans perte.
3. Ne jamais agréger deux transitions distinctes en une seule transition graphique.
4. Afficher les guards et actions sur l'arête correspondante.
5. Rendre les self-loops explicitement.
6. Rendre les transitions de retour/cycle sans imposer un faux pipeline linéaire.
7. Utiliser un layout topologique déterministe à partir de l'état initial ; les états non atteignables restent visibles et identifiés sans inventer de transition.
8. Représenter la source globale `*`, `__any__` et `__default__` comme extensions OPUS explicites.
9. Préserver le rendu SVG serveur autonome : zéro GraphViz, zéro `exec()`, zéro JavaScript.
10. Ne pas modifier le moteur `FsmProcessor` ni sa priorité de résolution des transitions.
11. Préserver les accents et l'UTF-8 dans les labels.

## Contrat visuel

- état normal : rectangle sobre ;
- état courant : même rectangle, surbrillance uniquement ;
- pseudo-initial : marqueur circulaire plein avec flèche vers l'état initial ;
- final déclaré : marqueur terminal dédié ;
- transition : flèche orientée ;
- transition parallèle : courbe/offset distinct ;
- self-loop : boucle visible autour de l'état ;
- signal : texte principal de transition ;
- garde : `[guard]` ;
- effet/action : `/ action()` ;
- wildcard/fallback : style pointillé et légende OPUS explicite.

## Smoke obligatoire

Le smoke doit construire au minimum une FSM contenant :

- un état avec trois signaux sortants ;
- deux transitions différentes entre le même couple d'états ;
- deux transitions entrantes vers le même état ;
- un self-loop ;
- une garde ;
- une action ;
- un `__any__` local ;
- une transition source `*` ;
- un `__default__` ;
- un état courant ;
- un état final.

Il doit vérifier que chaque transition reste individualisée dans le SVG et que les marqueurs sémantiques sont présents.

## Suite

Après validation R45D2A29, la navigation graphique Security doit reprendre ce langage visuel rectangulaire et les connecteurs, mais rester nommée comme chaîne de sécurité / droits et non comme FSM.

NO JAVASCRIPT.
NO GRAPHVIZ.
NO EXEC.
NO PUSH OPUS/OWASYS BY ASSISTANT.
