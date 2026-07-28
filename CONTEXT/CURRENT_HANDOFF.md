# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_AND_APPLICATION_ROOT_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
P117W R21 : présent dans la base relue
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site monolithique, aucun partage filesystem et aucun vestige `owasys_old*`.

## État runtime confirmé

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : succès
frontend /fr-FR/applications : succès
```

## Cause active

Le Registry SQLite conserve les applications physiquement supprimées car
la synchronisation réalise uniquement des UPSERT.

```text
SQLite : owasys -> sites/owasys_old
Disque : racine absente
```

Le repository Registry ne reconnaît pas directement le contrat courant :

```text
OPUS_SITE_STANDARD_CONTRACT_CORE
```

## Correction R22

```text
transaction SQLite atomique
découverte des contrats standard actuels
comparaison id + root_path avec les sites physiques canoniques
suppression des lignes obsolètes
effacement du contexte courant seulement s’il est obsolète
```

## Racine des applications créées

```text
H:\OPUS\sites\<application-id>\
```

## Livrable actif

```text
ZIP : opus_p117w_r22_registry_physical_reconciliation.zip
SHA-256 : 72dbe3d7700dfea0364b807f9e1714ca96218acc692d27c85517d03684538ba1
Fichiers : 1
```

Contenu :

```text
sites/owasys-back/application/registry/repositories/RegistryRepository.php
```

## Statut

```text
P117W R6 à R21 : présents dans la base relue
P117W R22 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
