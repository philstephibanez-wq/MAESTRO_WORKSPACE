# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R15

Date : 2026-07-27  
État : livrable actif à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git de base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R14 appliqués
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

## Cause active

La FSM réduite du frontend a perdu les métadonnées nécessaires au rendu SCORE et à I18n.

Pour l’état `registry`, l’absence de `title_key` conduit le renderer à demander :

```text
menu.registry
```

Cette clé n’existe pas. La configuration canonique doit déclarer :

```text
title_key = menu.applications
summary_key = registry.description
```

## Corriger

Remplacer uniquement :

```text
sites/owasys-front/config/fsm.json
```

par la FSM complète :

```text
OWASYS_NAVIGATION_FSM_V1
```

Restaurer les états, événements, transitions, gardes, actions, métadonnées de navigation et clés I18n canoniques.

Ne pas ajouter de fallback et ne pas modifier SCORE ou I18n pour masquer la FSM dégradée.

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

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Appliquer

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

## Validation effectuée

```text
Contrat FSM canonique                    : OK
Binding registry vers I18n               : OK
États, événements et transitions         : OK
Gardes et actions                        : OK
Chemins interdits                        : 0
ZIP                                      : OK
```

Validation runtime Windows owner : requise.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
