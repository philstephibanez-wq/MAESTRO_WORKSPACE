# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R8_ALIGN_DEV_ENVIRONMENT_CONTRACTS_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R8_DEV_ENVIRONMENT_CONTRACTS_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R7 appliqués
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

Ne partager aucun fichier entre les deux applications. Ne livrer aucun `tools`, aucun `scripts/owasys` et aucune racine `owasys-shared`.

## Résultat P117W R7

Conserver la validation des sites sans exiger les répertoires runtime avant démarrage.

## Cause actuelle

`opus:dev-server` retourne :

```text
OPUS_DEV_SERVER_ENVIRONMENT_BINDING_INVALID
```

Aligner les deux `config/site.json` sur le contrat attendu par `SiteCommandService` :

```text
OPUS_DEVELOPMENT_ENVIRONMENT_BINDING_V1
```

Créer dans chaque application un fichier runtime local indépendant :

```text
var/development/environment.json
```

Ne stocker aucun secret dans le ZIP ou Git.

## Statut

```text
P117W R6 : appliqué ; chargement croisé supprimé
P117W R7 : appliqué ; validation des sites propres corrigée
P117W R8 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r8_align_dev_environment_contracts.zip
SHA-256 : 6f2d4f33db9b8e23a134b8e2d1170d26b8009b60c625c02e8d2fee4b94ff82fb
Fichiers : 2
Octets : 1959
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R7 appliqués
```

Inclure uniquement :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

## Valider

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
