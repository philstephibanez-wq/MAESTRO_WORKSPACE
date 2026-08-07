# HANDOFF — OPUS P117W R45B5 GENERATED RUNTIME ERROR + GIT STAGE ALL

Date : 2026-08-07  
Statut : livré, validation et acquisition owner requises

## Base exacte

```text
OPUS master : 2376a4de07e4f504aeac1be1d8a183d43c34df80
Commit       : opus_p117w_r45b4_profiler_environment_config
```

R45B4 est acquis. R45B5 ne modifie aucun fichier de `sites/try` ni d'un autre site généré existant.

## Causes traitées

### 1. HTTP 500 générique des sites générés

`GeneratedSiteRuntime` instrumentait son `catch` avec le statut Profiler `failed`, alors que `Trace` autorise uniquement `success`, `warning`, `error`, `unavailable`.

La seconde exception Profiler masquait donc l'erreur initiale et empêchait le rendu d'erreur SCORE.

R45B5 corrige l'appelant :

```text
request.failed -> error
```

Le contrat `Trace` reste strict et n'est pas élargi.

### 2. Stage all

R45B5 ajoute `SiteGitWorkspace::stageAll()` et la chaîne complète :

```text
SCORE + CSRF
-> PUT /api/v1/applications/{site_id}/git/index
-> git.stage_all
-> owasys:git-stage-all
-> owasys:git:stage-all
-> SiteGitWorkspace::stageAll()
```

Exécution Git bornée :

```text
git add -A -- sites/<site_id>
```

Aucun chemin libre n'est fourni par le navigateur. Un conflit Git interdit Stage all. Les opérations fichier par fichier restent disponibles.

## Livrable actif

```text
ZIP     : opus_p117w_r45b5_generated_runtime_error_stage_all.zip
SHA-256 : 74e70f1b93c7b719497aeb99c704fd4d5c2e38489ec235bba8aacf924caf15cc
FILES   : 1 script différentiel complet
TARGETS : 38 fichiers suivis
BASE    : 2376a4de07e4f504aeac1be1d8a183d43c34df80
STATUS  : application, validation, commit et push owner requis
```

Script :

```text
apply_opus_p117w_r45b5.php
SHA-256 : 967ddf96a845b59994c3c6eb4a118e9a57a9c31145c2cf40aa81de52860c6ef2
OUTPUT  : OPUS_P117W_R45B5_APPLIED
FILES   : 38
```

Le ZIP ne contient aucun smoke, audit, rapport, log, cache, vendor, temporaire ou secret.

Le script d'application :

- exige le HEAD exact R45B4 ;
- refuse des fichiers cibles déjà modifiés ;
- utilise `File` et `Json` ;
- valide les ancres et la symétrie REST ;
- lint les PHP avant écriture ;
- écrit atomiquement et restaure en cas d'échec ;
- n'est pas destiné à être committé dans OPUS.

## Smoke owner séparé

```text
FILE    : smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php
SHA-256 : 22c496ebf5fe77552bfb39febce5cee81da7306bf6dd4c4a77f865623f0f2ee7
OUTPUT  : OPUS_P117W_R45B5_SMOKE_OK
```

Le smoke doit être copié temporairement à la racine OPUS puis supprimé avant commit.

## Stage all UI

Le module `Sources et Git` expose un bouton SCORE sans JavaScript :

```text
Tout stager
```

Il n'est affiché que si :

- `git:stage` est autorisé ;
- au moins un changement est stageable ;
- aucun conflit Git n'est présent.

Les deux nouvelles clés I18n sont présentes dans les 24 langues officielles UE configurées plus l'ukrainien.

## Test de `try`

L'URL observée dans la capture est :

```text
http://127.0.0.1:8800/fr-FR/applications
```

Le scaffold généré mappe `home` sur `/`. R45B5 ne crée pas de route locale `/applications` pour `try`.

Après application :

```text
http://127.0.0.1:8800/fr-FR/
```

doit être utilisé pour tester l'accueil minimal de `try`.

Une URL non déclarée telle que `/fr-FR/applications` doit produire une HTTP 404 OPUS propre si aucun module `applications` n'existe, jamais le 500 générique causé par le mauvais statut Profiler.

## Validation owner

```text
1. HEAD exact 2376a4de07e4f504aeac1be1d8a183d43c34df80
2. SHA-256 ZIP + smoke
3. extraction du script hors H:\OPUS
4. exécution du script sur H:\OPUS
5. OPUS_P117W_R45B5_APPLIED + FILES=38
6. composer validate
7. composer dump-autoload -o
8. smoke owner temporaire
9. OPUS_P117W_R45B5_SMOKE_OK
10. suppression du smoke
11. relance OWASYS-front / OWASYS-back
12. Stage all réel sur try
13. vérification qu'aucun autre site n'est stagé
14. stage fichier individuel toujours fonctionnel
15. accueil try sur /fr-FR/
16. route absente => 404 OPUS et non HTTP 500 générique
17. commit et push owner
```

## Suite

Après acquisition :

```text
R45C — wizard OWASYS structuré
R45D — administration Sécurité
```

NO LOCAL TRY FIX.  
NO PROFILER STATUS CONTRACT WIDENING.  
NO CROSS-SITE STAGE.  
NO FREE GIT PATH OR COMMAND.  
NO ACL BYPASS.  
NO BACKEND JAVASCRIPT.  
NO REST CATALOG DRIFT.  
NO SMOKE IN OPUS ZIP.  
NO PUSH OPUS PAR L’ASSISTANT.