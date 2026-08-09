# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-09

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_INCIDENT_OPUS_P117W_R45C3_R45C4_DELIVERY_INVALID_2026-08-09.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C3R1_GITHUB_RECOVERY_STRUCTURED_WORKFLOW_2026-08-09.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45C3R1_GITHUB_RECOVERY_2026-08-09.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Décision owner

L'owner demande de repartir du GitHub canonique afin d'éliminer les effets des deux livraisons locales non acquises.

## Base canonique OPUS

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

GitHub `origin/master` reste sur cette base.

État local owner avant récupération :

```text
5994903d cleanup
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
058984bf origin/master
```

La working tree était propre. Les deux commits locaux doivent être sauvegardés sur une branche locale puis `master` doit être replacé exactement sur `origin/master` avant application du livrable de récupération.

## Incident précédent

R45C3 précédent : NON ACQUIS.  
R45C4 précédent : RETIRÉ / INVALIDÉ.

Pile owner observée :

```text
owasys-front
-> RegistryModel::synchronize()
-> RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

## Cause runtime rétablie

Le Registry frontend utilise obligatoirement le REST sécurisé vers `owasys-back`.

Configuration canonique de développement :

```text
owasys-front : http://127.0.0.1:8000
owasys-back  : http://127.0.0.1:8080
```

Le service `opus:dev-server` lance uniquement l'application demandée ; le peer déclaré est validé/injecté dans l'environnement mais n'est pas auto-démarré.

Le 2026-08-09, l'owner a identifié deux processus PHP résiduels en mémoire. Après arrêt forcé de ces deux processus et suppression du site de test, OWASYS est reparti normalement.

Les logs fournis après nettoyage confirment :

```text
owasys-back actif 127.0.0.1:8080
GET /api/v1/applications OK
owasys:registry-sync OK
PUT /api/v1/session/application/owasys-back OK
owasys:registry-select OK
owasys-front actif 127.0.0.1:8000
/fr-FR/applications OK
/fr-FR/data OK
```

Le timeout précédent est donc classé comme incident runtime lié à des processus PHP résiduels / conflit d'instance. Aucun patch `RestClient` n'est retenu. R45C4 reste retiré.

## Livrable actif — R45C3R1

```text
ZIP     : opus_p117w_r45c3r1_github_recovery_structured_workflow.zip
SHA-256 : d54fb21ca36288dbd9d7db279b92cacc55b34715cb5572be34ab2ca79496e2e7
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
FILES   : 2
```

Contenu exclusif :

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucun `apply_*`, smoke, rapport, log, cache, temporaire ou dépendance.

## Comportement cible

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Sélection d'une application existante ou création réussie : `Sources de données`.

## Profiler `.lock`

Des `.lock` ont été observés dans le répertoire profiler. Ce point est désormais un suivi OPUS générique distinct :

- aucun `.lock` ne doit être exposé comme trace ;
- un lock actif peut être transitoire ;
- un lock orphelin persistant après terminaison normale doit être traité à la source ;
- aucune suppression aveugle n'est autorisée sans relecture du cycle de vie réel des locks dans OPUS.

Ce suivi ne remplace ni ne bloque l'acquisition R45C3R1.

## Gates owner R45C3R1

1. arrêter les serveurs de développement et vérifier qu'aucun PHP résiduel ne conserve 8000/8080 ;
2. sauvegarder la pile locale `5994903d` ;
3. reset `master` sur `origin/master` ;
4. HEAD exact `058984bf` et working tree propre ;
5. extraction directe du ZIP ;
6. PHP lint + chargement FSM via `StructuredFileLoader` + autoload Composer ;
7. lancer `owasys-back` sur 8080 ;
8. lancer `owasys-front` sur 8000 ;
9. `/fr-FR/applications` sans HTTP 500 ;
10. ordre navigation/FSM conforme ;
11. sélection/création -> `Sources de données` ;
12. preview R45C2 toujours fonctionnelle ;
13. commit/push OPUS uniquement par l'owner après succès.

## Suite

R45D Sécurité/RBAC reste suspendu jusqu'à acquisition R45C3R1.

L'audit Profiler `.lock` peut avancer en lecture seule en parallèle mais tout correctif OPUS correspondant doit faire l'objet d'un livrable séparé fondé sur la source canonique.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
