# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-30.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 63470fb43c4b692eea2d7db2c0be5f6086008d1a
Racine owner : H:/OPUS
```

## État acquis

- R38 : création layered supprimée.
- R39 : stockage REST replay fichier supprimé.
- R40 : ancien `sites/demo-opus` supprimé.
- R42 : serveur de développement générique appliqué.
- `sites/opus-demo` supprimé par l’owner.
- R43 : assistant transactionnel appliqué et poussé avec exactement 39 fichiers.
- R44 : recette réelle exécutée jusqu’à l’étape Sécurité ; aucune mutation, aucun POST backend et aucun site partiel.
- `owasys-front` et `owasys-back` restent les deux seules applications OWASYS.

## Défaut actif — R44A

R43 perd les valeurs soumises lors d’une validation Sécurité, classe l’erreur comme refus backend et ne trace pas ce refus local.

Le ZIP R44A corrige à la source `owasys-front` : conservation des saisies, erreurs I18n par champ et diagnostics Logger/Profiler sans donnée brute ni appel REST/Composer.

## Action active

L’owner applique et valide R44A, répète le cas en échec, puis reprend R44 jusqu’à la création d’un site fullstack neuf et minimal.

## Invariants

- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- aucune mutation avant confirmation ;
- SCORE uniquement, sans mélange HTML/PHP ;
- backend OWASYS exclusivement PHP ;
- aucune scorie après rollback ;
- l’assistant ne committe ni ne pousse OPUS/OWASYS.
