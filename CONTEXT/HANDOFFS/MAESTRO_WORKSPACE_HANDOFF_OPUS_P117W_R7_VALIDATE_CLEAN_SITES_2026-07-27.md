# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R7

Date : 2026-07-27  
État : livrable actif à appliquer

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD : 4fb3a92605f14d84b8060ff36fde78828da49273
Local : H:\OPUS avec P117W initial et R3 à R6 appliqués
```

## Conserver

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne créer aucune racine partagée et ne partager aucun système de fichiers.

## Cause corrigée

`validate-site` exigeait `var/logs` et `var/profiler` avant le premier démarrage.

Ces répertoires appartiennent au runtime et sont créés par Logger et Profiler. Ne pas les exiger dans un site source propre.

## Livrable actif

```text
ZIP : opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip
SHA-256 : e24708b8488769d5baef79372cde46d9006d200f1c166e87486501c08513b7ac
Fichiers : 2
Octets : 14728
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun journal et aucune racine `owasys-shared`.

## Appliquer

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip" -C H:\OPUS
composer dump-autoload -o
php -l Opus\Console\Service\SiteCommandService.php
php -l Opus\Console\Service\LayeredSiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer en développement

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables.

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
```

Conserver la racine `/` du backend interdite. Le backend ne fournit aucune interface utilisateur.

## Statut

```text
P117W R3 : appliqué
P117W R4 : appliqué
P117W R5 : appliqué
P117W R6 : appliqué ; serveurs de développement démarrés
P117W R7 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
