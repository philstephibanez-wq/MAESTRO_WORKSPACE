# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R8

Date : 2026-07-27  
État : livrable actif à appliquer

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial et R3 à R7 appliqués
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

Ne partager aucun fichier entre les deux applications.

## Corriger

Aligner `development_server.environment` dans les deux `site.json` sur :

```text
contract = OPUS_DEVELOPMENT_ENVIRONMENT_BINDING_V1
file = var/development/environment.json
```

Créer un fichier runtime indépendant dans chaque application. Ne pas livrer les secrets.

## Livrable actif

```text
ZIP : opus_p117w_r8_align_dev_environment_contracts.zip
SHA-256 : 6f2d4f33db9b8e23a134b8e2d1170d26b8009b60c625c02e8d2fee4b94ff82fb
Fichiers : 2
Octets : 1959
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
