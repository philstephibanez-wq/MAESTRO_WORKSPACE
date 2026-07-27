# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R12

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Base locale : P117W initial et R3 à R11 appliqués
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

Ne partager aucun fichier et ne créer aucune racine commune.

## Cause traitée

`composer opus:dev-server` exige encore une préparation manuelle de :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Cette dépendance empêche le démarrage autonome des deux applications dans deux terminaux CMD distincts.

## Correction framework

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
```

Ajouter le binding générique :

```text
OPUS_DEVELOPMENT_DERIVED_SECRET_V1
```

Dériver les valeurs en mémoire depuis la machine, la racine OPUS, le canal de développement et le nom de variable.

Autoriser ce binding uniquement pour `dev`, uniquement pour les variables secrètes et uniquement sur loopback.

Conserver `test` et `prod` sur variables d’environnement externes.

## Réseau de développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Le frontend cible le backend sur `127.0.0.1:8080`.

Le backend connaît le frontend sur `127.0.0.1:8000`.

## Livrable actif

```text
ZIP : opus_p117w_r12_dev_credentials_in_environment_sections.zip
SHA-256 : 11f06689cabbddd71dace4445e31b31996c7703d709fa092f2a1bdbbc2d7a936
Fichiers : 3
Octets : 14370
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit et aucun rapport.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r12_dev_credentials_in_environment_sections.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r12_dev_credentials_in_environment_sections.zip" -C H:\OPUS
php -l Opus\Console\Service\SiteCommandService.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer séparément

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Ne définir manuellement aucune variable bearer/HMAC pour `dev`.

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué ; frontière REST frontend corrigée
P117W R12 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
