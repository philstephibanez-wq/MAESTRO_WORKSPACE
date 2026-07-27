# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R14_SCOPE_RCP_APPLICATION_COMMAND_PROVIDER_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R14_SCOPE_RCP_APPLICATION_COMMAND_PROVIDER_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R13 appliqués
```

## Architecture

Conserver uniquement les deux applications actives :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime et aucune racine partagée.

## Configuration développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Lancer depuis la configuration :

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

## Cause traitée par R14

Les registres suivants déclarent les mêmes commandes métier :

```text
sites/owasys/config/composer.commands.json
sites/owasys-back/config/composer.commands.json
```

La requête frontend atteint correctement le backend REST. Le processus Composer échoue ensuite parce que `ApplicationCommandDispatcher` découvre deux providers pour `owasys:registry:sync` sans connaître l’application propriétaire.

## Correction générique OPUS

Déclarer :

```text
sites/owasys-back/config/backend.rest.json.application_id = owasys-back
```

Propager cette valeur dans :

```text
OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1.application_id
```

Filtrer le provider par :

```text
command + application_id
```

Ne charger aucun provider du site historique lorsque la requête cible `owasys-back`.

## Livrable actif

```text
ZIP : opus_p117w_r14_scope_rcp_application_command_provider.zip
SHA-256 : 8e94705f4a8992a3188ff0c469436e3c458b888713709da877ec79c1e7d8f494
Fichiers : 3
Octets ZIP : 7614
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys-back/config/backend.rest.json
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r14_scope_rcp_application_command_provider.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r14_scope_rcp_application_command_provider.zip" -C H:\OPUS
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
php -l Opus\Rcp\Rest\RcpRestServer.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

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
curl -i http://127.0.0.1:8080/api/v1/status
curl -i http://127.0.0.1:8000/fr-FR/
curl -i http://127.0.0.1:8000/fr-FR/applications
```

## Statut

```text
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : appliqué
P117W R13 : appliqué
P117W R14 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
