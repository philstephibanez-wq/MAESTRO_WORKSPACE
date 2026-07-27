# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R15_RESTORE_CANONICAL_FRONT_FSM_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R15_RESTORE_CANONICAL_FRONT_FSM_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R14 appliqués
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

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

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

## Cause traitée par R15

Le frontend contient une FSM réduite qui a perdu les métadonnées nécessaires au rendu SCORE et à I18n.

Pour l’état `registry`, l’absence de `title_key` conduit le renderer à demander :

```text
menu.registry
```

Cette clé n’existe pas. La FSM canonique déclare :

```text
title_key = menu.applications
summary_key = registry.description
```

## Correction

Restaurer uniquement :

```text
sites/owasys-front/config/fsm.json
```

avec le contrat complet :

```text
OWASYS_NAVIGATION_FSM_V1
```

Restaurer les états, événements, transitions, gardes, actions, métadonnées de navigation et clés I18n canoniques.

Ne pas ajouter de fallback I18n et ne pas modifier le renderer pour masquer la FSM dégradée.

## Livrable actif

```text
ZIP : opus_p117w_r15_restore_canonical_front_fsm.zip
SHA-256 : 1a39348365bfe5dbb3a286519b93bb50ccd60a5a09d642f111cf0836224ae575
Fichiers : 1
Octets non compressés : 7206
```

Inclure uniquement :

```text
sites/owasys-front/config/fsm.json
```

## Appliquer et valider

```text
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r15_restore_canonical_front_fsm.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r15_restore_canonical_front_fsm.zip" -C H:\OPUS
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
P117W R6 à R10 : appliqués
P117W R11 : appliqué
P117W R12 : appliqué
P117W R13 : appliqué
P117W R14 : appliqué
P117W R15 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
