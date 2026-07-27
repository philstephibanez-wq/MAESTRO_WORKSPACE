# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R12_AUTONOMOUS_DEV_SERVER_CREDENTIALS_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R12_AUTONOMOUS_DEV_SERVER_CREDENTIALS_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R11 appliqués
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

Conserver les adresses et ports d’écoute comme arguments variables.

Affectation développement :

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

## Cause traitée par R12

Le profil `dev` dépend encore de variables bearer/HMAC préparées manuellement, ce qui empêche de lancer séparément les deux serveurs avec leurs commandes Composer contractuelles.

## Correction générique OPUS

Ajouter dans `SiteCommandService` le binding :

```text
OPUS_DEVELOPMENT_DERIVED_SECRET_V1
```

Dériver les identifiants en mémoire depuis la machine, la racine OPUS, le canal et le nom de variable.

Autoriser ce binding uniquement :

```text
environnement dev
variable marquée secrète
écoute loopback
```

Conserver `test` et `prod` sur variables d’environnement externes. Conserver l’interdiction des secrets littéraux.

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

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r12_dev_credentials_in_environment_sections.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r12_dev_credentials_in_environment_sections.zip" -C H:\OPUS
php -l Opus\Console\Service\SiteCommandService.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer sans préparation manuelle de secrets

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
P117W R12 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
