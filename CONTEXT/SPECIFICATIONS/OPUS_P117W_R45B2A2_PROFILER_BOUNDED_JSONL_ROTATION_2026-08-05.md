# OPUS P117W R45B2A2 — RÉTENTION BORNÉE ET ROTATION JSONL DU PROFILER

Date : 2026-08-05  
Statut : livrable owner actif  
Base OPUS : `00ba1221de99b838e211adb1cb4f5925a11f3193`

## Acquis

R45B2A1R7 est acquis et publié. Les applications générées disposent de l'instrumentation FSM et de la surface Web Profiler contractuelle en environnement de développement.

## Cause

`Profiler` écrit toutes les traces dans un unique fichier JSONL append-only sans limite de taille ni politique de rétention. La croissance est donc non bornée et finit par dégrader les lectures, l'espace disque et l'exploitation du Profiler.

## Correction générique

R45B2A2 :

- ajoute une politique de rétention générique lue depuis `config/site.json` via `StructuredFileLoader` ;
- génère par défaut `max_bytes = 10485760` et `max_archives = 5` ;
- borne `max_bytes` entre 64 KiB et 1 GiB et `max_archives` entre 0 et 100 ;
- refuse un enregistrement individuel dépassant la limite au lieu de contourner la borne ;
- sérialise écriture, rotation et lecture par un verrou interprocessus dédié ;
- effectue une rotation déterministe `.jsonl.1` à `.jsonl.N` ;
- supprime uniquement l'archive la plus ancienne au-delà de la rétention ;
- conserve la lecture des traces présentes dans les archives retenues ;
- reste compatible avec les enregistrements V1 et V2 ;
- ne modifie aucun site généré existant.

## Livrable

```text
ZIP     : opus_p117w_r45b2a2_profiler_bounded_jsonl_rotation.zip
SHA-256 : 20bf71f25fd2db05e9525af29512fb99c6c5d233812463675759d6d69c4020c5
FILES   : 2
BASE    : 00ba1221de99b838e211adb1cb4f5925a11f3193
```

Chemins :

- `Opus/Profiler/Profiler.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Gates owner

- vérifier la base OPUS exacte ;
- appliquer le ZIP ;
- linter les deux sources PHP ;
- exécuter `composer dump-autoload -o` ;
- valider `owasys-front` et `owasys-back` ;
- auditer les interfaces homonymes et les quatre marqueurs ;
- exécuter `git diff --check` ;
- supprimer puis recréer un site témoin par les commandes OPUS/OWASYS ;
- vérifier la configuration générée ;
- provoquer plusieurs rotations avec une limite de test réduite ;
- vérifier la lecture d'une trace active et d'une trace archivée ;
- vérifier la suppression bornée de l'archive la plus ancienne ;
- vérifier les écritures concurrentes Windows et Linux ;
- vérifier qu'aucun secret n'entre dans les fichiers, erreurs ou archives.

PHP CLI/Composer/runtime n'ont pas été exécutés dans le conteneur de préparation. Un parseur PHP indépendant et `git diff --check` ont réussi.

NO LOCAL SITE FIX.  
NO UNBOUNDED STORAGE.  
NO SILENT RETENTION FALLBACK.  
NO SECRET IN PROFILER.
