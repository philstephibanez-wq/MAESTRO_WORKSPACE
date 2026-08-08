# MAESTRO WORKSPACE HANDOFF — OPUS P117W / R45C3 LOCAL CLEANUP 5994903D

Date : 2026-08-09
Statut : source live owner requise avant prochain livrable

## Règles appliquées

Lecture stricte de :

- `README-FIRST.md` ;
- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md` ;
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md` ;
- `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md` ;
- incident R45C3/R45C4 du 2026-08-09.

Règles bloquantes :

```text
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
NO PUSH OPUS BY ASSISTANT.
```

## État Git owner constaté

Après `git fetch origin` :

```text
## master...origin/master [ahead 2]
5994903d (HEAD -> master) cleanup
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
058984bf (origin/master, origin/HEAD) opus_p117w_r45c2_dev_preview_runtime_fix
```

La working tree est propre (`git status --short` vide).

Conséquences :

- `origin/master` reste sur R45C2 `058984bf` ;
- R45C3 existe comme commit local owner `0e0e5485` ;
- un commit local supplémentaire `5994903d cleanup` est le HEAD owner effectif ;
- la base réelle du prochain diagnostic est donc `5994903d`, pas `058984bf` ni `0e0e5485` ;
- les deux commits locaux ne sont pas disponibles dans le dépôt GitHub canonique au moment de cette relecture.

## Source live préparée par l'owner

L'owner a créé localement :

```text
%USERPROFILE%\Downloads\opus_5994903d_live_source.zip
```

avec les fichiers :

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

Ce ZIP n'est pas encore accessible à l'assistant tant qu'il n'est pas attaché à la conversation.

## Incident runtime à reprendre

Symptôme connu :

```text
http://127.0.0.1:8000/fr-FR/applications
HTTP 500
```

Pile antérieure :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

Cette pile ne suffit pas pour modifier le code : le diagnostic doit être refait sur les fichiers exacts du HEAD `5994903d` et avec l'état effectif de `owasys-back`.

## R45C3 / R45C4

- R45C3 : NON ACQUIS tant que la navigation runtime end-to-end n'est pas validée.
- R45C4 : RETIRÉ / INVALIDÉ ; ne plus utiliser son ZIP, son script ni son smoke.

## Prochain livrable

Le prochain livrable est bloqué jusqu'à lecture du ZIP live `opus_5994903d_live_source.zip`.

Une fois la source relue :

1. diagnostiquer la cause exacte du HTTP 500 / frontière REST ;
2. déterminer si R45C3 est conservé, corrigé ou annulé ;
3. produire un ZIP différentiel direct ;
4. ZIP contenant uniquement les fichiers complets modifiés à leurs chemins finaux ;
5. aucun `apply_*`, smoke, rapport, log, cache, temporaire ou dépendance ;
6. valider PHP/configuration/autoload/interfaces OPUS concernées ;
7. valider les deux bastions `owasys-back` puis `owasys-front` ;
8. valider navigation, REST sécurisé, Logger/Profiler et absence de JavaScript backend ;
9. commit/push OPUS exclusivement par l'owner après succès.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
