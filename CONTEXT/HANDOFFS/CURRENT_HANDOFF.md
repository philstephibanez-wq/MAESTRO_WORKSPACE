# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R3_CLEAN_SITES_NO_TOOLS_NO_SCRIPTS_REST_ONLY_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R3_CLEAN_SITES_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial extrait et migré
```

## Conserver deux applications propres

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute racine `owasys-shared` et tout partage de fichiers entre les deux bastions.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Interdire les répertoires opérationnels ajoutés

Ne livrer aucun :

```text
tools
scripts/owasys/p117w-*
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Ne placer aucune migration, aucun smoke, aucun audit et aucun provisionnement dans le produit livré.

## Statut

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r3_clean_sites_no_tools_no_scripts_rest_only.zip
SHA-256 : 0b96f61c57e5baf959eee19a971e1cd97c4a9350b9831690c309cd66821494fe
Fichiers : 5
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-front/config/deployment.manifest.json
sites/owasys-back/config/site.json
sites/owasys-back/config/deployment.manifest.json
```

## Valider

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver la commande au développement.

## Contrats

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier côté front ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
