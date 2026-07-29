# OPUS P117W R37 — audit complet des bastions, diagnostics et corrélation

Date : 2026-07-29

## Cause

L’audit de la session propre R36 a établi quatre écarts actifs :

- le workflow de création écrivait encore dans `owasys-frontend.log` au lieu du journal canonique `owasys-front.log` ;
- `open_profiler` appelait la garde FSM `current_app_required` sans transmettre l’application courante ;
- `RestClient` ne propageait pas le `trace_id` frontend dans `X-Opus-Trace-Id` ;
- le site frontend contenait encore 385 fichiers inactifs sous `application/front`, `application/shared` et `application/back`, plus deux configurations backend obsolètes.

## Contrat deux bastions

OWASYS contient exactement deux applications autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Aucun troisième runtime et aucune couche `shared`. Aucun partage de fichiers, configuration, secret, état ou diagnostic. Le seul échange autorisé est :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Corrections

- `OwasysCreationController` écrit exclusivement dans `owasys-front.log` et réutilise le `OPUS_TRACE_ID` parent.
- `OwasysSourceController` fournit `current_app` et `has_current_app` aux signaux Profiler.
- `Opus\\Api\\Rest\\RestClient` valide et propage `OPUS_TRACE_ID` via `X-Opus-Trace-Id`.
- `SiteCommandService::validate()` refuse explicitement les couches obsolètes ; un frontend autonome refuse aussi `config/backend.rest.json` et `config/backend.operations.json`.
- l’aide CLI SSO désigne le chemin canonique `sites/owasys-front`.

## Nettoyage obligatoire

Supprimer avant validation :

```text
sites/owasys-front/application/shared
sites/owasys-front/application/front
sites/owasys-front/application/back
sites/owasys-front/config/backend.rest.json
sites/owasys-front/config/backend.operations.json
sites/owasys-front/var/logs/owasys-frontend.log
```

Ces éléments sont absents du bootstrap actif et ne sont utilisés par aucun flux R34–R36.

## Preuves des traces

- `c031c832a7dba801` : création invalide écrite dans le mauvais fichier de log ;
- `4fe62438d101f35c` : garde FSM refusée à l’ouverture du Profiler ;
- aucune erreur backend ;
- `source.list` environ 269 ms et `source.read` environ 11 ms, tous deux `execution_mode: in_process`.

## Livraison

R37 est cumulatif après R34, R35-R2 et R36. Le ZIP contient cinq fichiers complets. Les suppressions sont réalisées par commandes CMD owner explicites, car un ZIP différentiel direct ne représente pas une suppression.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO SHARED LAYER.
