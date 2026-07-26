# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R7_VALIDATE_CLEAN_SITES_WITHOUT_RUNTIME_DIRECTORIES_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R7_VALIDATE_CLEAN_SITES_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R6 appliqués
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

## Résultat P117W R6

Démarrer correctement les deux serveurs de développement sans chargement croisé des applications.

Conserver le backend sans interface utilisateur. Refuser la racine `/` et exposer le statut sur :

```text
/api/v1/status
```

## Cause restante

`validate-site` exige actuellement :

```text
var/logs
var/profiler
```

Ces répertoires appartiennent au runtime et sont créés par Logger et Profiler. Ne pas les exiger dans un site source propre avant le premier démarrage.

## Statut

```text
P117W R3 : appliqué
P117W R4 : appliqué
P117W R5 : appliqué
P117W R6 : appliqué ; serveurs de développement démarrés
P117W R7 : livrable actif
```

## Livrable actif

```text
ZIP : opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip
SHA-256 : e24708b8488769d5baef79372cde46d9006d200f1c166e87486501c08513b7ac
Fichiers : 2
Octets : 14728
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R6 appliqués
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

## Appliquer et valider

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

Conserver l'identifiant d'application, l'adresse et le port comme arguments variables. Réserver `opus:dev-server` au développement.

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
