# OPUS P117W R33 — Correction de portée de la route Source localisée

Date : 2026-07-29  
Statut : correctif obligatoire après R32  
Base OPUS : R31 puis R32

## Incident owner

Après application de R32, toute ouverture de `/<locale>/source` échoue avec :

```text
OWASYS_FRONT_RUNTIME_FAILED
Trace owner : 66742282ed38c98e
TypeError : sites/owasys-front/application/source/controllers/SourceController.php:181
```

Les journaux corrélés montrent que le backend termine `source.list` correctement en mode Composer `in_process` en 238 ms, puis que le frontend échoue pendant le rendu.

## Cause

R32 a ajouté dans `OwasysSourceController::render()` le calcul de la route localisée à partir de `$sourcePath`. Cette variable existe uniquement dans `run()` et n'est ni transmise ni définie dans `render()`.

Sous PHP strict, son utilisation conduit à transmettre `null` à `trim()`, provoquant le `TypeError`.

## Correction

Construire `$currentSourceRoute` à partir de `$selectedPath`, déjà normalisé dans `render()` depuis le résultat REST :

- sans fichier sélectionné : `source` ;
- avec fichier sélectionné : `source/<chemin encodé segment par segment>`.

Aucun changement n'est apporté à l'API REST OPUS, au dispatch Composer in-process, à SCORE, FSM, I18n, ACL, SSO, Logger ou Profiler.

## Validation

- différentiel limité au contrôleur Source frontend ;
- aucune référence à `$sourcePath` ne subsiste dans `render()` ;
- archive ZIP testée ;
- validation PHP owner requise dans la recette Windows.

## Livrable

```text
ZIP : opus_p117w_r33_source_locale_route_scope_fix.zip
SHA-256 : ea4dca1a3c71144122840741204e62c12b8843c7d50dd5fa870e80f9143a954e
Fichiers : 1
Base : R31 puis R32
```
