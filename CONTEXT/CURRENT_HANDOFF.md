# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R27_SOURCE_BROWSER_USABILITY_AND_SINGLE_EXCHANGE_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R27_SOURCE_BROWSER_USABILITY_AND_SINGLE_EXCHANGE_2026-07-28.md
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

## R27

Le navigateur de sources conserve SCORE et son fallback POST. Les feuilles
sont de grands boutons et le fichier courant possède un état vert explicite.
Une sélection utilise une seule chaîne REST/Composer `source.browse`, qui
exécute liste et lecture dans le même processus sans cache silencieux.

## Livrable actif

```text
ZIP : opus_p117w_r27_source_browser_usability_and_single_exchange.zip
Base : OPUS master 544d512b79bac4ca7dab8ac103dd9ff2266593fd
SHA-256 : b5d1624f5170b96a09f2866d3cbafd2fa4a6a86eba2f466d8cc8481069e234ce
Fichiers : 12
Contenu cumulatif : R25 + R26 + R27
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
