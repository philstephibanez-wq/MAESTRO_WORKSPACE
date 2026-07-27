# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R11

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

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

## Erreur owner

```text
OWASYS_FRONT_RUNTIME_FAILED
sites/owasys-front/application/default/controllers/RuntimeController.php:738
```

Route :

```text
http://127.0.0.1:8000/fr-FR/applications
```

## Cause

`RuntimeController::registryModel()` conserve l’ancien accès local au Registry et appelle `OwasysApplicationSingletonInspector`.

Le modèle frontend actuel `OwasysRegistryModel` est déjà REST-only et accepte uniquement `$siteRoot`.

## Correction

Remplacer l’ancien branchement par :

```php
$this->registryModel = new OwasysRegistryModel($this->siteRoot);
```

Ne charger aucun inspecteur local dans le frontend.

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

## Appliquer

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

## Validation préalable

```text
Blob source contrôlé : 3252d28bdb084ec4f2fbb2167b842ff71eabffe3
PHP lint : OK
Accès local au Registry dans le fichier livré : supprimé
ZIP direct : OK
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO DELIVERY ROOT POLLUTION.
