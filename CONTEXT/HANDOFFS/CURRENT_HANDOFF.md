# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-25

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117U_HF10_APPLICATION_SURFACES_RUNTIME_MODES_SPEC_2026-07-25.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF10_APPLICATION_SURFACES_RUNTIME_MODES_2026-07-25.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
head            : 41f77ad7187c0facb125a5737b62d10928809e66
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
owner local     : H:\OPUS
```

Le code OPUS/OWASYS n'est pas poussé directement par l'assistant. Les modifications sont livrées par ZIP différentiel, appliquées et committées par l'owner après validation.

## Décision architecture validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` est interdit. Fullstack est une composition.

### shared

Contrats, domaine, DTO, configuration commune, I18n commune, composition Singleton et corrélation Logger/Profiler.

### front

Modules de présentation, contrôleurs frontend, ViewModels, templates/vues SCORE, navigation et ACL de présentation.

### back

Modules API, contrôleurs REST, services, providers, commandes Composer allow-listées, ACL backend et persistance.

## Différentiel actif

```text
ZIP     : opus_p117u_hf10_application_surfaces_runtime_modes.zip
SHA-256 : 5ca8ddbb1e765ec9a63393cbdb2d70a95e17e0e62b39027e0f921854c0174721
BASE    : 41f77ad7187c0facb125a5737b62d10928809e66
```

HF10 fournit :

- `OPUS_APPLICATION_STRUCTURE_V2` ;
- `ApplicationStructure` et son interface homonyme à quatre marqueurs ;
- scaffold `shared/front/back` pour les nouvelles applications ;
- profils par composition ;
- routes et états FSM qualifiés par surface ;
- interface SCORE côté front ;
- réponses JSON côté back ;
- modes de processus explicites `front|back` ;
- ports configurables sans rôle implicite ;
- refus croisé des routes ;
- Logger et Profiler autour du runtime OWASYS ;
- lanceurs CMD réels ;
- smoke test HF10.

## Runtime local après HF10

```text
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
```

Ou :

```text
sites\owasys\tools\cmd\START_OWASYS_FRONT.cmd
sites\owasys\tools\cmd\START_OWASYS_BACK.cmd
```

Le rôle est défini par `--mode`, pas par le port.

## HTTP 500 et diagnostics

État owner avant HF10 :

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HTTP 500
log runtime exploitable : absent
```

HF10 ajoute :

```text
sites/owasys/var/logs/owasys-runtime.log
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
X-Opus-Trace-Id
```

HF10 apporte l'observabilité obligatoire. Il ne déclare pas la cause du HTTP 500 corrigée sans trace réelle.

## Migration physique OWASYS

Le processus front/back est cloisonné par HF10. Le déplacement physique de l'arbre historique OWASYS est déclaré :

```text
owasys-physical-migration-pending
```

HF10B déplacera les composants vers `application/shared`, `application/front` et `application/back` après récupération du `trace_id` du HTTP 500.

## Contrats permanents

- toute classe concrète sous `Opus/**/*.php` implémente son interface homonyme ;
- l'interface homonyme étend les quatre marqueurs standards ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy et bastion ;
- SCORE uniquement pour l'interface ;
- aucun echo UI, aucun mélange HTML/PHP ;
- locale par défaut négociée depuis le navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Installation owner

1. vérifier le worktree propre sur le HEAD exact ;
2. extraire le ZIP dans un dossier temporaire ;
3. exécuter `INSTALL_HF10.cmd` ;
4. obtenir `P117U_HF10_APPLICATION_SURFACES_SMOKE_OK` ;
5. lancer back puis front ;
6. reproduire `/fr-FR/applications` ;
7. transmettre `request.failed` et le `trace_id` si le 500 persiste ;
8. produire HF10B depuis cette preuve ;
9. exécuter le gate tokenizer P117M ;
10. commit/push owner après acceptation.

## Nettoyage

Aucun nettoyage requis. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
