# OPUS P117W R8 — ALIGNER LES CONTRATS D’ENVIRONNEMENT DE DÉVELOPPEMENT

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Constater

Après P117W R7, `opus:dev-server` échoue pour `owasys-front` et `owasys-back` avec :

```text
OPUS_DEV_SERVER_ENVIRONMENT_BINDING_INVALID
```

La cause est un écart de contrat entre `SiteCommandService::devServer()` et les deux fichiers `config/site.json` actifs.

## Corriger

Aligner les deux applications sur :

```text
OPUS_DEVELOPMENT_ENVIRONMENT_BINDING_V1
```

Déclarer dans chaque application un fichier local indépendant :

```text
var/development/environment.json
```

Interdire tout fichier commun et toute lecture croisée entre applications.

Conserver l’adresse et le port du serveur PHP comme arguments de `opus:dev-server`.

## Livrer

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport et aucune racine partagée.

## Provisionner

Créer deux fichiers runtime locaux distincts contenant le même couple token/HMAC de développement et, côté frontend seulement, l’endpoint REST du backend.

Ne stocker aucun secret dans Git ni dans le ZIP.

## Valider

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
