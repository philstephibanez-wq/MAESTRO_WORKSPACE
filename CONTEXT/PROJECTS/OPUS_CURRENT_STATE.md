# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Commit : opus_p117w_r45c2_dev_preview_runtime_fix
Dernier état acquis publié : R45C2
```

L'owner a explicitement demandé de repartir de GitHub pour récupérer les deux livraisons locales non acquises.

## État local avant récupération

```text
5994903d (HEAD -> master) cleanup
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
058984bf (origin/master, origin/HEAD) opus_p117w_r45c2_dev_preview_runtime_fix
```

Working tree : propre.  
Branche locale : ahead 2.

Plan de récupération : sauvegarder `5994903d` sur une branche locale puis replacer `master` sur `origin/master`.

## R45C3 / R45C4 historiques

R45C3 précédent : NON ACQUIS.  
R45C4 : RETIRÉ / INVALIDÉ.

Ils ne servent pas de source au nouveau livrable.

## Diagnostic GitHub de l'incident HTTP 500

Pile owner :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

Source canonique :

- `RegistryModel` appelle REST `/api/v1/applications` ;
- le frontend a pour peer `owasys-back` ;
- frontend dev : `127.0.0.1:8000` ;
- backend dev : `127.0.0.1:8080` ;
- `SiteCommandService::devServer()` lance uniquement l'application demandée ;
- le peer est injecté et validé, sans auto-start cross-application.

Le test owner précédent montrait uniquement le lancement du frontend. La pile est cohérente avec un backend absent ou indisponible. Aucun changement `RestClient` n'est retenu dans la récupération.

## Livrable actif — R45C3R1

```text
opus_p117w_r45c3r1_github_recovery_structured_workflow.zip
SHA-256 d54fb21ca36288dbd9d7db279b92cacc55b34715cb5572be34ab2ca79496e2e7
BASE 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
FILES 2
```

Fichiers :

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Le ZIP est différentiel direct et ne contient aucun script, smoke, rapport, log ou temporaire.

## R45C3R1 — workflow cible

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Sélection ou création : entrée dans `Sources de données`.

Aucune classe `Opus/**/*.php` n'est modifiée.

## Validation requise

1. reset owner vers GitHub R45C2 après branche de sauvegarde ;
2. appliquer R45C3R1 ;
3. lint/autoload/FSM ;
4. lancer backend 8080 ;
5. lancer frontend 8000 ;
6. valider `/fr-FR/applications` ;
7. valider navigation et projection FSM ;
8. valider sélection/création ;
9. valider preview R45C2 ;
10. owner commit/push seulement après succès.

## Suite gouvernée

R45D Sécurité/RBAC seulement après acquisition R45C3R1.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
