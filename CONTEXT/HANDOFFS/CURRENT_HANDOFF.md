# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R4_FRONT_COMPOSER_REGISTRY_CLEAN_SITE_SPEC_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R4_FRONT_COMPOSER_REGISTRY_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et P117W R3 appliqués
```

## Conserver deux applications propres

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute racine partagée et tout partage de fichiers entre les deux bastions.

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Identifier le blocage actuel

```text
OPUS_APPLICATION_COMMAND_REGISTRY_SITE_INVALID:sites/owasys-front/config/composer.commands.json
```

La migration P117W initiale a copié dans le frontend le registre Composer de l'ancien site `owasys`.

`ApplicationCommandDispatcher` impose l'égalité entre le `site_id` déclaré et le nom de la racine du site. Le registre copié déclare `owasys` dans `sites/owasys-front` et bloque donc toutes les commandes Composer OPUS.

## Corriger

Remplacer uniquement :

```text
sites/owasys-front/config/composer.commands.json
```

Déclarer :

```text
contract  = OPUS_APPLICATION_COMMAND_PROVIDER_REGISTRY_V1
site_id   = owasys-front
providers = []
aliases   = []
```

Interdire ainsi toute commande Composer applicative locale dans le frontend.

## Statut

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : appliqué, blocage registre Composer détecté
P117W R4 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r4_fix_front_composer_registry_clean_site.zip
SHA-256 : 421fbd6d39e01e166b798d5bdee313cb24c39ef8761d62b4fc2ae7edb1dcc7d0
Fichiers : 1
Octets : 309
```

Inclure uniquement :

```text
sites/owasys-front/config/composer.commands.json
```

Ne livrer aucun `tools`, aucun répertoire opérationnel, aucune migration, aucun smoke, aucun audit et aucune racine `owasys-shared`.

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

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables. Réserver la commande au développement.

## Contrats

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- rendre uniquement via SCORE côté front ;
- interdire toute mutation métier et toute exécution Composer locale côté front ;
- faire passer toute mutation par REST sécurisé puis Composer côté back ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.