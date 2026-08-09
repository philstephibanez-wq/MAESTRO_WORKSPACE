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

## Incident runtime HTTP 500 — état rétabli

Pile owner initiale :

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

Le 2026-08-09, l'owner a trouvé deux processus PHP résiduels en mémoire. Après arrêt forcé de ces deux processus et suppression du site de test, OWASYS est reparti.

Les logs fournis après nettoyage montrent un runtime sain :

```text
owasys-back 127.0.0.1:8080
GET /api/v1/applications -> succès
owasys:registry-sync -> succès
PUT /api/v1/session/application/owasys-back -> succès
owasys:registry-select -> succès
owasys-front 127.0.0.1:8000
/fr-FR/applications -> succès
/fr-FR/data -> succès
```

Conclusion actuelle : incident lié à des processus PHP résiduels / conflit d'instance. Aucun changement `RestClient` n'est retenu.

## Profiler `.lock`

Des fichiers `.lock` ont été observés dans le répertoire profiler. Ils sont classés comme artefacts de synchronisation runtime à auditer séparément :

- ils ne doivent jamais être exposés comme traces profiler ;
- un lock d'une opération active peut être légitime et transitoire ;
- un lock orphelin après terminaison normale doit être considéré comme un défaut d'hygiène runtime ;
- aucune suppression aveugle n'est autorisée tant que la propriété et le cycle de vie exacts des locks n'ont pas été relus dans la source OPUS canonique.

Ce sujet ne bloque pas R45C3R1 mais doit être traité génériquement dans OPUS si l'audit confirme un défaut.

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

1. arrêter les serveurs de développement et vérifier l'absence de processus PHP résiduel ;
2. reset owner vers GitHub R45C2 après branche de sauvegarde ;
3. appliquer R45C3R1 ;
4. lint/autoload/FSM ;
5. lancer backend 8080 ;
6. lancer frontend 8000 ;
7. valider `/fr-FR/applications` ;
8. valider navigation et projection FSM ;
9. valider sélection/création ;
10. valider preview R45C2 ;
11. owner commit/push seulement après succès.

## Suite gouvernée

R45D Sécurité/RBAC seulement après acquisition R45C3R1.

L'audit générique du cycle de vie des `.lock` du Profiler peut être mené en parallèle en lecture seule, mais toute correction OPUS correspondante reste soumise à la source canonique et à un livrable séparé.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
