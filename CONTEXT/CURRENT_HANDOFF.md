# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R28_DISCREET_SOURCE_LINKS_AND_INCREMENTAL_READING_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R28_DISCREET_SOURCE_LINKS_AND_INCREMENTAL_READING_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 544d512b79bac4ca7dab8ac103dd9ff2266593fd
Racine owner : H:\OPUS
P117W R22, R23 et R24 : appliqués sur master
```

## R28

Le navigateur de sources conserve SCORE et son fallback POST. Les feuilles
sont des liens compacts et le fichier courant possède un état vert explicite.
Une sélection JavaScript conserve l'arborescence rendue et utilise uniquement
la chaîne REST/Composer `source.read`; CodeMirror est mis à jour en place.

Les lanceurs `.cmd` physiques sont exclus. Seules les deux commandes Composer
ci-dessous sont contractuelles.

## Livrable actif

```text
ZIP : opus_p117w_r28_discreet_source_links_and_incremental_reading.zip
Base : OPUS master 544d512b79bac4ca7dab8ac103dd9ff2266593fd
SHA-256 : 7ffa75e6f3ea049bf18a7d87491f80d5c563ee45e1b947b4c165719845f7ae83
Fichiers : 24
Contenu cumulatif : R25 + R27 + R28, sans R26
```

## Lancement

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
