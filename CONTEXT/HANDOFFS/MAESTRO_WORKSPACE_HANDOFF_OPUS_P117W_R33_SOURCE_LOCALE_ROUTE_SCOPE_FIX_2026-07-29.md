# HANDOFF — OPUS P117W R33

Date : 2026-07-29

Appliquer R31, puis R32, puis R33. R30 reste invalidé.

## Cause corrigée

R32 utilisait dans `OwasysSourceController::render()` la variable `$sourcePath`, définie seulement dans `run()`. La trace owner `66742282ed38c98e` échouait donc avec un `TypeError` à la ligne 181 après une réponse backend réussie.

R33 utilise `$selectedPath`, disponible dans `render()`, pour construire la route de langue courante.

## Résultats attendus

- `/fr-FR/source` s'affiche de nouveau ;
- un fichier ouvert reste dans l'URL lors du changement de langue ;
- `source.list` reste exécuté via REST puis Composer allow-listé en mode `in_process` ;
- aucun retour au sous-processus `composer.phar` ;
- aucun cache ou fallback silencieux.

## Livrable

```text
opus_p117w_r33_source_locale_route_scope_fix.zip
ea4dca1a3c71144122840741204e62c12b8843c7d50dd5fa870e80f9143a954e
1 fichier
base R31 puis R32
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```
