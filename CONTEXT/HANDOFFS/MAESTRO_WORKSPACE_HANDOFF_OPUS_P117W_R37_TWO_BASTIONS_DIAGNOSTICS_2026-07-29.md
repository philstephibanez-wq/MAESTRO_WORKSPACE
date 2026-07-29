# MAESTRO WORKSPACE handoff — OPUS P117W R37

Date : 2026-07-29

## Décision

R37 résulte d’un audit transversal des quatre diagnostics frais et de l’empilement R31–R36. Il remplace le correctif local initialement envisagé.

## Invariants

- exactement deux bastions : `owasys-front` et `owasys-back` ;
- aucune couche `shared`, `front` ou `back` imbriquée dans le frontend ;
- FSM R34 propriétaire de l’état ;
- dispatch R35-R2 in-process ;
- Profiler R36 rendu par SCORE et protégé par ACL ;
- un Logger et un Profiler canoniques par application ;
- un même `trace_id` front, REST, back et Composer.

## Correctifs

Cinq fichiers complets :

```text
Opus/Api/Rest/RestClient.php
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/source/controllers/SourceController.php
sites/owasys-front/application/sso/cli/bootstrap-local-user.php
```

## Nettoyage owner obligatoire

Retirer les 385 fichiers inactifs de l’ancienne architecture et les configurations backend frontend obsolètes avant `opus:validate-site`. Le gate R37 doit ensuite empêcher leur retour.

## Validation runtime

- une création invalide n’écrit que dans `owasys-front.log` ;
- `?profiler=1` ouvre le panneau sans `OWASYS_FRONT_RUNTIME_FAILED` ;
- les enregistrements front, REST, back et Composer partagent le même `trace_id` ;
- `execution_mode: in_process` reste présent ;
- aucun chemin `application/shared`, `application/front`, `application/back` ne subsiste.

NO SHARED LAYER.
NO FALLBACK SILENCIEUX.
