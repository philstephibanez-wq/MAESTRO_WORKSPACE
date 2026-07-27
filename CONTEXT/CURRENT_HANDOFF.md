# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R16_RESTORE_APPLICATION_COMMAND_ALIASES_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R16_RESTORE_APPLICATION_COMMAND_ALIASES_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R15 appliqués
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

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

## Cause traitée par R16

Le trace `296ba2a1e87ba3e0` prouve que le frontend atteint le backend REST, puis que Composer lance :

```text
owasys:registry-sync
```

Le registre backend déclare :

```text
owasys:registry-sync -> owasys:registry:sync
```

R14 a supprimé la lecture de `aliases` dans `ApplicationCommandDispatcher`. La commande invoquée par Composer n’est donc pas reconnue et le provider backend n’est jamais chargé.

## Correction

Restaurer dans :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

la lecture et la validation des alias, puis :

```text
cibler application_id
résoudre alias -> commande canonique
charger uniquement le provider ciblé
exécuter la commande canonique
```

## Livrable actif

```text
ZIP : opus_p117w_r16_restore_application_command_aliases.zip
SHA-256 : 31448c0030d19ab7e0d0dd921ce5df20e9bb94ffa3d8c199048fc99b106cb3dd
Fichiers : 1
Octets ZIP : 2827
Octets non compressés : 11588
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r16_restore_application_command_aliases.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r16_restore_application_command_aliases.zip" -C H:\OPUS
php -l Opus\Console\Application\ApplicationCommandDispatcher.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
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
P117W R6 à R15 : appliqués
P117W R16 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
