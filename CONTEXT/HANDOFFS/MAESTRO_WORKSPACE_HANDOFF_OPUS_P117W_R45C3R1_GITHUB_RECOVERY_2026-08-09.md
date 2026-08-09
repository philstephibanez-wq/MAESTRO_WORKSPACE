# HANDOFF — OPUS P117W R45C3R1 GITHUB RECOVERY

Date : 2026-08-09

## Base de récupération

L'owner demande explicitement de repartir de GitHub.

Base unique :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Ne pas utiliser `0e0e5485` ni `5994903d` comme source du correctif. Les préserver seulement dans une branche locale de sauvegarde avant reset.

## Cause de l'échec de validation précédent

Le front synchronise le Registry exclusivement via REST vers `owasys-back`.

Configuration GitHub dev :

```text
owasys-front = 127.0.0.1:8000
owasys-back  = 127.0.0.1:8080
```

Le dev-server OPUS lance uniquement l'application demandée. Il ne démarre pas le peer déclaré.

La pile `RegistryModel -> RestClient -> fopen -> timeout` est donc cohérente avec un backend non disponible. Le précédent test owner ne montrait que le lancement de `owasys-front`.

Aucun correctif `RestClient` n'est inclus dans R45C3R1. R45C4 reste retiré.

## Livrable actif

```text
opus_p117w_r45c3r1_github_recovery_structured_workflow.zip
SHA-256 d54fb21ca36288dbd9d7db279b92cacc55b34715cb5572be34ab2ca79496e2e7
```

Contenu exact :

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucun autre fichier dans le ZIP.

## Résultat attendu

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Sélection ou création réussie : `Sources de données`.

## Ordre de validation obligatoire

1. sauvegarder les deux commits locaux sur une branche ;
2. reset `master` sur `origin/master` ;
3. appliquer le ZIP ;
4. lint/autoload/FSM ;
5. lancer `owasys-back` ;
6. lancer `owasys-front` ;
7. valider `/fr-FR/applications` ;
8. valider tous les onglets ;
9. valider sélection/création ;
10. valider preview R45C2 ;
11. commit/push OPUS uniquement par l'owner après succès.

R45D reste suspendu jusqu'à acquisition de R45C3R1.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
