# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R10_SINGLE_ENVIRONMENT_CONFIG_SECTIONS_2026-07-27.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R11_FRONT_REGISTRY_REST_BOUNDARY_FIX_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R11_FRONT_REGISTRY_REST_BOUNDARY_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R10 appliqués
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

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret et aucune racine partagée.

## Configuration

Conserver dans chaque `config/site.json` :

```text
environments.dev
environments.test
environments.prod
```

Conserver les adresses et ports d’écoute comme arguments variables. Référencer les secrets par variables d’environnement.

## Affectation développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

## Erreur active

```text
OWASYS_FRONT_RUNTIME_FAILED
sites/owasys-front/application/default/controllers/RuntimeController.php:738
```

Route :

```text
http://127.0.0.1:8000/fr-FR/applications
```

## Cause

`RuntimeController::registryModel()` conserve l’ancien accès local au Registry avec `OwasysApplicationSingletonInspector`.

Le modèle actuel `OwasysRegistryModel` est REST-only et accepte uniquement `$siteRoot`.

## Corriger

```php
$this->registryModel = new OwasysRegistryModel($this->siteRoot);
```

Supprimer toute inspection locale du Registry depuis le frontend.

## Livrable actif

```text
ZIP : opus_p117w_r11_front_registry_rest_boundary_fix.zip
SHA-256 : 1ee0e1738b684f6b674a1c64555cbb22ab85745bc8470fa0352fd1baab272aa9
Fichiers : 1
Octets non compressés : 30866
```

Inclure uniquement :

```text
sites/owasys-front/application/default/controllers/RuntimeController.php
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r11_front_registry_rest_boundary_fix.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r11_front_registry_rest_boundary_fix.zip" -C H:\OPUS
php -l sites\owasys-front\application\default\controllers\RuntimeController.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

Frontend :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend :

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Définir les mêmes valeurs `OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` dans les deux terminaux CMD.

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
