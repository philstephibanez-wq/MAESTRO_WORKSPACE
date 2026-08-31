# R8B6R — Renommage persistant de transition EFSM

Date: 2026-08-31

Status: READY FOR OWNER VALIDATION

## Baseline

OPUS master: `b4be25e73ad388bb1f9286f8100292f5bd20ec55` — `diagrammes ok`.

## Cause

La barre TRANSITION affichait Renommer comme un bouton désactivé. Aucune
opération `transition.rename` n’était définie dans le navigateur, le provider
REST OWASYS ou l’éditeur sémantique OPUS. La géométrie de transition étant
indexée par son identifiant canonique, un renommage incomplet aurait perdu
courbe Bézier, libellé et leader au rechargement.

## Portée

- active le bouton TRANSITION → Renommer après sélection d’une transition ;
- ajoute un formulaire contrôlé ancien identifiant / nouvel identifiant ;
- ajoute `transition.rename` à l’éditeur sémantique OPUS ;
- migre atomiquement `fsm.json` et l’entrée de géométrie associée dans
  `fsm.layout.json` ;
- conserve source, signal, cible, guards, actions et ports ;
- journalise `transition_geometry_migrated`.

## Interdictions

- aucun changement de FSM métier autre que l’identité de la transition ;
- aucune suppression automatique de signal ;
- aucune donnée ou configuration FSM owner dans le ZIP ;
- aucun JavaScript dans `owasys-back`;
- aucun commit/push OPUS/OWASYS par l’assistant.

## Validation owner

Renommer une transition ayant une courbe Bézier réglée et un libellé déplacé,
recharger, puis confirmer :

1. nouvel identifiant affiché ;
2. ancienne clé absente du layout ;
3. courbe, contrôles, libellé et leader inchangés ;
4. source, signal, cible, guards et actions inchangés ;
5. durée de la mutation affichée après rechargement.

Les mesures fraîches sont à retourner par classe de requête ; aucune valeur
postérieure à la baseline n’est présumée.
