# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R3 SITES PROPRES

Date : 2026-07-26  
État : livrable actif à appliquer

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial appliqué et migré
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement des échanges REST sécurisés entre les deux applications. Ne créer aucune racine partagée et ne partager aucun système de fichiers.

## Interdire les répertoires ajoutés

Ne livrer aucun :

```text
tools
scripts/owasys/p117w-*
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Maintenir les commandes de nettoyage, validation, provisionnement et lancement hors du ZIP applicatif.

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

## Statut

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : livrable actif
```

## Appliquer

Extraire directement le ZIP à la racine `H:\OPUS`, puis reconstruire l’autoload Composer.

## Nettoyer

Supprimer uniquement les éléments P117W rejetés éventuellement présents :

```text
sites/owasys-shared
sites/owasys-front/tools
sites/owasys-back/tools
scripts/owasys/p117w-r1
scripts/owasys/p117w-r2
scripts/audit_opus_component_interfaces.php
```

Ne supprimer aucun autre contenu du dépôt.

## Valider

Utiliser les commandes Composer existantes :

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Lancer en développement :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Contrats permanents

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier côté front ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.
