# OPUS P117W R11 — CORRIGER LA FRONTIÈRE REST DU REGISTRY FRONTEND

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Constater

Le frontend démarre sur `127.0.0.1:8000`, puis `/fr-FR/applications` échoue dans :

```text
sites/owasys-front/application/default/controllers/RuntimeController.php:738
```

Le journal indique `OWASYS_FRONT_RUNTIME_FAILED` avec une exception `Error` à cette ligne.

## Identifier la cause

`OwasysRegistryModel` frontend est désormais un client REST et son constructeur accepte uniquement :

```text
string $siteRoot
```

`RuntimeController::registryModel()` conserve toutefois l’ancien branchement local :

```text
$opusRoot
OwasysApplicationSingletonInspector::instance($opusRoot)
```

Ce code tente encore d’inspecter directement les applications locales depuis le frontend. Il contredit la frontière obligatoire :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

L’erreur visible est donc l’effet d’un contrôleur frontend resté sur l’ancienne architecture locale.

## Corriger

Modifier uniquement :

```text
sites/owasys-front/application/default/controllers/RuntimeController.php
```

Instancier le modèle avec :

```php
$this->registryModel = new OwasysRegistryModel($this->siteRoot);
```

Supprimer toute référence frontend à :

```text
OwasysApplicationSingletonInspector
$opusRoot
inspection locale du Registry
```

Conserver toutes les opérations Registry via `OwasysRegistryModel`, donc via `RcpRestClient` et le backend sécurisé.

## Livrer

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret, aucun fichier runtime et aucune racine partagée.

## Valider avant livraison

```text
Source GitHub exacte reconstruite et contrôlée par blob SHA : 3252d28bdb084ec4f2fbb2167b842ff71eabffe3
PHP lint : OK
Référence OwasysApplicationSingletonInspector dans le fichier livré : 0
ZIP direct : OK
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

Définir les mêmes secrets bearer/HMAC dans les deux terminaux CMD avant lancer.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO DELIVERY ROOT POLLUTION.
