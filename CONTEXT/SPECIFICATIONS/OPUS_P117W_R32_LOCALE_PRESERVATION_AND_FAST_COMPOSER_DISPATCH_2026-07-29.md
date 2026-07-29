# OPUS P117W R32 — Conservation de la ressource lors du changement de langue et dispatch Composer rapide

Date : 2026-07-29  
Statut : prêt à appliquer après R31 et validation owner  
Base OPUS : R31 appliqué sur `8b186cbaa0938cd4c89666eac46bf9f4221ba71a`

## Causes traitées

1. Le sélecteur de langue de la page Source construisait toujours `/<locale>/source`. Il supprimait donc le chemin de la ressource ouverte.
2. Chaque requête REST lançait un nouveau processus `composer.phar`. Les profils owner mesurent 3 199 à 4 273 ms pour le sous-processus, alors que la préparation REST prend quelques dizaines de millisecondes.

## Corrections

- Construire chaque URL de locale à partir de la route Source courante, chemin encodé segment par segment.
- Conserver par exemple :
  `/fr-FR/source/application/default/bootstrap.php`
  vers
  `/hr-HR/source/application/default/bootstrap.php`.
- Ajouter un dispatch explicite `@in-process` au moteur REST OPUS.
- Résoudre le même alias Composer allow-listé par `ComposerScripts`.
- Exécuter le même `OpusConsoleApplication`, le même registre de providers et le même contrat `OPUS_REST_API_COMPOSER_COMMAND_REQUEST_V1` dans le processus OWASYS back déjà actif.
- Ne conserver aucun fallback silencieux : le mode est déclaré dans `backend.rest.json`.
- Conserver authentification, HMAC, nonce, anti-rejeu, ACL, FSM, Logger, Profiler et réponse HTTP REST.

## Flux

```text
owasys-front
-> API REST OPUS sécurisée
-> owasys-back
-> script Composer allow-listé, dispatché dans le processus backend
-> provider métier
-> résultat structuré
-> réponse HTTP
-> owasys-front
```

Aucun accès métier direct du frontend n'est introduit. Aucun cache silencieux n'est utilisé.

## Livrable

```text
ZIP : opus_p117w_r32_locale_preservation_and_fast_composer_dispatch.zip
SHA-256 : dba5139b5defcf3e03d8090c466eee27b7b1fbf4728441d7b3bf85d41fa0df15
Fichiers : 8
Base : R31
```
