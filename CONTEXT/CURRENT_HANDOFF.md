# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R10_SINGLE_ENVIRONMENT_CONFIG_SECTIONS_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R10_SINGLE_ENVIRONMENT_CONFIG_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R9 appliqués
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

Ne partager aucun fichier entre les deux applications. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret et aucune racine partagée.

## Décision active

Remplacer les fichiers runtime de configuration de développement par une section unique `environments` dans le `config/site.json` de chaque application.

Déclarer :

```text
dev
test
prod
```

Utiliser le contrat :

```text
OPUS_APPLICATION_ENVIRONMENTS_V1
```

Sélectionner l’environnement par `OPUS_ENV`. Faire sélectionner automatiquement `dev` par `opus:dev-server`.

Conserver l’adresse et le port d’écoute locaux comme arguments variables. Déclarer les coordonnées du peer dans la section d’environnement correspondante.

Référencer les secrets par variables d’environnement. Refuser tout secret littéral et toute variable secrète absente avant démarrer le serveur.

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : appliqué puis remplacé pour configuration fragmentée
P117W R10 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r10_single_environment_config_sections.zip
SHA-256 : 590f204c6ea2cb36816499443e735174b51d557813731b54efbe8e93878e3c59
Fichiers : 3
Octets : 12938
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R9 appliqués
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r10_single_environment_config_sections.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r10_single_environment_config_sections.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\Service\SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Nettoyer

Supprimer uniquement après appliquer R10 :

```text
sites/owasys-front/var/development
sites/owasys-back/var/development
```

## Lancer en développement

Définir les mêmes valeurs secrètes dans les deux terminaux :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Puis lancer :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
