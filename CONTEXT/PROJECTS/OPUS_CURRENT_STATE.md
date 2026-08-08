# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt publié

```text
OPUS : philstephibanez-wq/OPUS
Branche canonique distante : master
origin/master : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Commit : opus_p117w_r45c2_dev_preview_runtime_fix
Dernier état acquis publié : R45C2
```

## État owner local

Après `git fetch origin` :

```text
## master...origin/master [ahead 2]
5994903d (HEAD -> master) cleanup
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
058984bf (origin/master, origin/HEAD) opus_p117w_r45c2_dev_preview_runtime_fix
5770a144 opus_p117w_r45c1_dev_preview_button
6b3665c4 opus_p117w_r45b6_permission_surface_consistency
```

`git status --short` est vide.

Le HEAD owner réel est donc :

```text
5994903d cleanup
```

La branche locale est propre et en avance de deux commits sur `origin/master`.

## R45C3

Commit local owner :

```text
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
```

Statut fonctionnel : NON ACQUIS.

La projection OWASYS visible montre :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Mais la validation runtime complète a échoué sur la navigation vers `Applications`.

Le commit local `5994903d cleanup` est postérieur à R45C3 et constitue désormais la base réelle du diagnostic.

## R45C4

Statut : RETIRÉ / INVALIDÉ.

Ne plus utiliser l'ancien ZIP, le script `apply_*` ni le smoke associé.

Aucune hypothèse issue de R45C4 n'est considérée acquise avant relecture de la source live `5994903d`.

## Incident runtime actif

URL :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Résultat : HTTP 500.

Pile précédente disponible :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

La cause doit être réétablie sur les fichiers exacts du HEAD `5994903d` et avec l'état effectif de `owasys-back`.

## Source owner préparée

L'owner a créé :

```text
%USERPROFILE%\Downloads\opus_5994903d_live_source.zip
```

avec notamment :

```text
Opus/Api/Rest/RestClient.php
Opus/Api/Rest/RestClientInterface.php
sites/owasys-front/config/rest-api.json
sites/owasys-front/config/site.json
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/registry/models/RegistryModel.php
sites/owasys-front/application/registry/controllers/RegistryController.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-back/config/site.json
```

Ce ZIP doit être attaché à la conversation avant tout nouveau patch OPUS/OWASYS.

## Gate actif

```text
NO SOURCE OF TRUTH, NO PATCH.
NO CONTRACT, NO PATCH.
NO BRICOLAGE DELIVERY.
```

## Contrat du prochain livrable

Le prochain ZIP différentiel OPUS/OWASYS devra :

- être basé exclusivement sur les fichiers live exacts `5994903d` ;
- contenir uniquement les fichiers complets modifiés à leurs chemins finaux ;
- ne contenir aucun script `apply_*`, smoke, rapport, log, cache, temporaire ou dépendance ;
- conserver les interfaces homonymes et les quatre marqueurs pour toute classe OPUS touchée ;
- respecter REST sécurisé, Logger/Profiler, FSM, ACL, SSO et séparation front/back ;
- ne contenir aucun JavaScript/TypeScript côté `owasys-back` ;
- être validé end-to-end avec `owasys-back` puis `owasys-front` ;
- être commit/push dans OPUS exclusivement par l'owner après validation.

## Suite gouvernée

1. attacher et relire `opus_5994903d_live_source.zip` ;
2. diagnostiquer le HTTP 500 sur cette source ;
3. statuer sur R45C3 ;
4. livrer le correctif direct conforme ;
5. valider runtime front + back ;
6. seulement après acquisition stable, reprendre R45D Sécurité/RBAC.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
