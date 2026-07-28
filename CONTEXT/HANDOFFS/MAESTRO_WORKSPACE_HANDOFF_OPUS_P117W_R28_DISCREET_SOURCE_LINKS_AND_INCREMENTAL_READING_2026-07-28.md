# HANDOFF — OPUS P117W R28

Date : 2026-07-28

R28 remplace les grands boutons de fichiers par des liens compacts. Le fichier
ouvert conserve une coche, une barre et un fond verts, ainsi qu’une graisse
renforcée.

Le trajet interactif ne reconstruit plus l’arborescence. Il exécute uniquement
`source.read`, retourne le fichier sélectionné et met à jour CodeMirror en
place. Le fallback POST SCORE reste contractuel via `source.browse`.

Les trois lanceurs `.cmd` de R26 sont exclus. Les seules commandes de lancement
sont :

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

Base OPUS :

```text
544d512b79bac4ca7dab8ac103dd9ff2266593fd
```

Livrable :

```text
opus_p117w_r28_discreet_source_links_and_incremental_reading.zip
7ffa75e6f3ea049bf18a7d87491f80d5c563ee45e1b947b4c165719845f7ae83
24 fichiers
```
