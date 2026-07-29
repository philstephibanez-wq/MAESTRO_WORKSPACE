# HANDOFF — OPUS P117W R32

Date : 2026-07-29

Appliquer R31 avant R32. R30 reste invalidé.

## Résultats

- Le changement de langue conserve la ressource Source ouverte.
- L'URL reste un GET canonique avec locale et chemin complet.
- OWASYS back ne redémarre plus `composer.phar` pour chaque requête REST.
- Le script Composer demeure allow-listé, résolu par `ComposerScripts` et exécuté par `OpusConsoleApplication`.
- REST, HMAC, ACL, FSM, Logger et Profiler restent obligatoires.

## Mesure de cause

```text
source.read observé : 3491 ms
sous-processus Composer : 3454 ms
préparation REST avant Composer : environ 26 ms
```

## Livrable

```text
opus_p117w_r32_locale_preservation_and_fast_composer_dispatch.zip
dba5139b5defcf3e03d8090c466eee27b7b1fbf4728441d7b3bf85d41fa0df15
8 fichiers
base R31
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```
