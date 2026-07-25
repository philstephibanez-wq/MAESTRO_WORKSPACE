# MAESTRO_WORKSPACE HANDOFF — OPUS P117U HF10 APPLICATION SURFACES

Date : 2026-07-25  
Statut : livrable produit ; installation et runtime owner en attente

## Base

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
HEAD       : 41f77ad7187c0facb125a5737b62d10928809e66
Local      : H:\OPUS
```

## Décision owner validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

Aucun `application/full`.

## Livrable

```text
opus_p117u_hf10_application_surfaces_runtime_modes.zip
SHA-256: 5ca8ddbb1e765ec9a63393cbdb2d70a95e17e0e62b39027e0f921854c0174721
```

Le ZIP contient un installateur transactionnel contrôlé, les nouveaux contrats framework, les deux lanceurs CMD et un smoke test sans création de site.

## Effets HF10

- nouveau contrat `OPUS_APPLICATION_STRUCTURE_V2` ;
- classe `ApplicationStructure` + interface homonyme à quatre marqueurs ;
- scaffold des nouvelles applications sous `shared/front/back` ;
- fullstack par composition ;
- routes qualifiées `front|back` ;
- états FSM qualifiés par surface ;
- front SCORE, back JSON ;
- `composer opus:serve-site --mode=front|back` ;
- mode injecté dans le processus, indépendant du port ;
- refus croisé des routes ;
- Logger et Profiler autour du Singleton OWASYS ;
- journal runtime `owasys-runtime.log` et `X-Opus-Trace-Id` sur erreur lorsque possible.

## Limite volontaire

L'arbre physique OWASYS n'est pas déplacé par HF10. Son état est déclaré :

```text
owasys-physical-migration-pending
```

Le différentiel HF10B déplacera les composants après récupération de la trace du HTTP 500. Cette séparation évite une migration massive alors que `/fr-FR/applications` est actuellement en erreur et sans diagnostic exploitable.

## Installation

Extraire le ZIP dans un dossier temporaire puis exécuter :

```text
INSTALL_HF10.cmd
```

L'installateur exige :

- HEAD exact ;
- worktree propre ;
- blobs sources exacts ;
- substitutions uniques ;
- autoload Composer ;
- lint PHP ;
- audit contractuel ;
- smoke HF10.

## Lancement

Terminal back :

```text
sites\owasys\tools\cmd\START_OWASYS_BACK.cmd
```

Terminal front :

```text
sites\owasys\tools\cmd\START_OWASYS_FRONT.cmd
```

## Diagnostic immédiat attendu

Reproduire :

```text
http://localhost:8000/fr-FR/applications
```

Puis consulter :

```text
sites/owasys/var/logs/owasys-runtime.log
sites/owasys/var/profiler/<trace_id>.json
```

Le journal obtenu devient la source de vérité du correctif du HTTP 500 et de la migration physique HF10B.

## Nettoyage

Aucun nettoyage requis. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

## Prochaine séquence

1. appliquer HF10 ;
2. transmettre la sortie de l'installateur ;
3. lancer back puis front ;
4. reproduire la route Applications ;
5. transmettre la ligne `request.failed` et le `trace_id` ;
6. produire HF10B depuis cette preuve ;
7. tester frontend/backend/fullstack ;
8. gate P117M ;
9. commit/push owner.
