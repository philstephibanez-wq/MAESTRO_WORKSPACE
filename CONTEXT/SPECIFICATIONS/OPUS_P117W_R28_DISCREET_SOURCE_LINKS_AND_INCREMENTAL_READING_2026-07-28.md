# OPUS P117W R28 — LIENS DE SOURCES DISCRETS ET LECTURE INCRÉMENTALE

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 544d512b79bac4ca7dab8ac103dd9ff2266593fd
Racine owner : H:\OPUS
Pré-requis : R24 présent ; R25, R27 et R28 inclus au livrable cumulatif
```

## Décisions owner

- aucun fichier lanceur `.cmd` ;
- lancement uniquement avec `composer opus:dev-server -- owasys-back` et
  `composer opus:dev-server -- owasys-front` ;
- fichiers présentés comme liens compacts dans l’arborescence ;
- fichier ouvert identifiable sans ambiguïté ;
- aucune reconstruction de l’arborescence lors d’une lecture interactive.

## Causes traitées

R27 remplaçait chaque feuille par un grand bouton et réexpédiait, à chaque
sélection, environ 44 Ko contenant l’inventaire complet et le fichier. Le
processus Composer restait unique mais l’écran entier était reconstruit.

R28 conserve l’inventaire déjà rendu dans le navigateur. Une sélection
JavaScript appelle seulement l’opération allow-listée `source.read`, puis met
à jour le titre, les métadonnées, l’état courant et CodeMirror en place.

Le fallback sans JavaScript reste un POST SCORE utilisant `source.browse`.
Aucun accès direct au système de fichiers n’est ajouté au frontend.

## Livrable

```text
ZIP : opus_p117w_r28_discreet_source_links_and_incremental_reading.zip
SHA-256 : 7ffa75e6f3ea049bf18a7d87491f80d5c563ee45e1b947b4c165719845f7ae83
Fichiers : 24
```

## Chaîne contractuelle interactive

```text
owasys-front SCORE
-> POST asynchrone source-read
-> REST sécurisé source.read
-> owasys-back
-> Composer allow-listé owasys:source-read
-> SiteSourceInspector read
-> réponse JSON contractuelle
-> mise à jour locale CodeMirror
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
