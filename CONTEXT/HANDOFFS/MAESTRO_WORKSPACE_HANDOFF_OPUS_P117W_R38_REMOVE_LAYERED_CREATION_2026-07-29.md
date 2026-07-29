# MAESTRO WORKSPACE handoff — OPUS P117W R38

Date : 2026-07-29

## Décision

La création layered est supprimée à la racine du framework. Le succès
`opus:create-site` suivi de `OWASYS_CREATION_REGISTRY_ENTRY_MISSING` provenait
d'un désaccord entre le service de création actif et les contrats acceptés par
le Registry.

## Invariants

- exactement deux bastions OWASYS : `owasys-front` et `owasys-back` ;
- aucune couche `shared`, `front` ou `back` imbriquée ;
- sites générés autonomes selon `OPUS_SITE_STANDARD_CONTRACT_CORE` ;
- FSM R34 propriétaire de l'état ;
- dispatch R35-R2 `in_process` ;
- Profiler R36 via SCORE et ACL ;
- diagnostics et corrélation R37 conservés.

## R38

Fichiers complets :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Service/SiteCommandService.php
sites/owasys-back/application/registry/repositories/RegistryRepository.php
```

Le code layered exclusivement obsolète doit être supprimé après application.
Le site invalide créé pendant la session doit être identifié avant toute
suppression ; son identifiant n'est pas présent dans les diagnostics.

## Validation suivante

1. appliquer R38 ;
2. supprimer les classes layered listées dans la recette ;
3. identifier puis supprimer explicitement le site layered créé en échec ;
4. relancer les deux applications ;
5. créer un site test autonome ;
6. vérifier sa présence immédiate dans le Registry avec le même `trace_id`.

NO SHARED LAYER.
NO FALLBACK SILENCIEUX.
