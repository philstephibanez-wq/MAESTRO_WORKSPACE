# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_AND_APPLICATION_ROOT_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_2026-07-28.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R23_GENERATED_SITE_SECURE_DELETION_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R23_GENERATED_SITE_SECURE_DELETION_2026-07-28.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R24_SOURCE_TREE_AND_SYNTAX_HIGHLIGHTING_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R24_SOURCE_TREE_AND_SYNTAX_HIGHLIGHTING_2026-07-28.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R25_SCORE_LAYOUT_NAVIGATION_CONTRACT_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R25_SCORE_LAYOUT_NAVIGATION_2026-07-28.md
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

## Architecture

```text
sites/owasys-front
sites/owasys-back
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site OWASYS monolithique, shared ou `owasys_old*`.

## R25

Le layout SCORE commun exige un contrat de ViewModel total.
`OwasysScorePageRenderer` fournit par défaut :

```text
source.browser_enabled = false
```

La page Sources remplace explicitement cette valeur par `true`. Cela corrige
la `ContractException` au retour de Sources vers Applications sans charger
CodeMirror sur les autres pages.

## Livrable actif

```text
ZIP : opus_p117w_r25_score_layout_navigation_contract.zip
Base : OPUS master 544d512b79bac4ca7dab8ac103dd9ff2266593fd
SHA-256 : 2762bd9b2a6ae04396168bc7a33793512b084c22cb952504b23cf80246384f3a
Fichiers : 1
```

## Statut

```text
P117W R6 à R24 : appliqués sur OPUS master
P117W R25 : livrable actif à appliquer et valider
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
