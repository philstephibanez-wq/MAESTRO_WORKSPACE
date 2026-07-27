# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R13_DEV_SERVER_BINDING_FROM_SITE_CONFIG_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R13_DEV_SERVER_BINDING_FROM_CONFIG_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R12 appliqués
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

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime et aucune racine partagée.

## Configuration

Conserver dans chaque `config/site.json` :

```text
environments.dev
environments.test
environments.prod
```

Lire l’adresse et le port du serveur de développement depuis :

```text
development_server.network.local.host_env
development_server.network.local.port_env
environments.sections.dev.variables
```

Affectation développement :

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

## Cause traitée par R13

`composer opus:dev-server` exige encore manuellement `--host` et `--port`, alors que ces valeurs appartiennent à la configuration de l’application.

## Correction générique OPUS

Rendre `--host` et `--port` facultatifs. Lorsque les options sont absentes, résoudre les valeurs dans `config/site.json`. Conserver les options comme surcharges explicites et validées.

## Livrable actif

```text
ZIP : opus_p117w_r13_dev_server_binding_from_site_config.zip
SHA-256 : a0ae3b511f68b80504fd5f7a31aa57da973bddbe7a58cfe9c5a51d6158c21983
Fichiers : 4
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r13_dev_server_binding_from_site_config.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r13_dev_server_binding_from_site_config.zip" -C H:\OPUS
php -l Opus\Console\OpusConsoleApplication.php
php -l Opus\Console\Service\SiteCommandService.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer depuis la configuration

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : appliqué
P117W R13 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
