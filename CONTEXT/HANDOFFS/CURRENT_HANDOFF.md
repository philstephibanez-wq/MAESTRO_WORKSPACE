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

La working tree est propre. Les deux commits locaux doivent être sauvegardés sur une branche locale puis `master` doit être replacé exactement sur `origin/master`.

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

## Cause réétablie depuis GitHub

Le Registry frontend utilise obligatoirement le REST sécurisé vers `owasys-back`.

Configuration canonique de développement :

```text
owasys-front : http://127.0.0.1:8000
owasys-back  : http://127.0.0.1:8080
```

Le service `opus:dev-server` lance uniquement l'application demandée ; le peer déclaré est validé/injecté dans l'environnement mais n'est pas auto-démarré.

Le retour owner ayant montré uniquement `composer opus:dev-server -- owasys-front`, la pile timeout est cohérente avec un backend absent ou indisponible. R45C3R1 ne modifie donc pas `RestClient` et rétablit la validation avec les deux bastions lancés séparément, backend d'abord.

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

## Gates owner

1. sauvegarde branche locale de `5994903d` ;
2. reset `master` sur `origin/master` ;
3. HEAD exact `058984bf` et working tree propre ;
4. extraction directe du ZIP ;
5. PHP lint + chargement FSM via `StructuredFileLoader` + autoload Composer ;
6. lancer `owasys-back` sur 8080 ;
7. lancer `owasys-front` sur 8000 ;
8. `/fr-FR/applications` sans HTTP 500 ;
9. ordre navigation/FSM conforme ;
10. sélection/création -> `Sources de données` ;
11. preview R45C2 toujours fonctionnelle ;
12. commit/push OPUS uniquement par l'owner après succès.

## Suite

R45D Sécurité/RBAC reste suspendu jusqu'à acquisition R45C3R1.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
