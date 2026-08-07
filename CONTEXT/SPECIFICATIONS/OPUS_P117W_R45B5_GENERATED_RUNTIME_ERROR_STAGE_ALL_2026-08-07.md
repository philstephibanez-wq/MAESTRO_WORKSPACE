# OPUS P117W — R45B5 GENERATED RUNTIME ERROR + GIT STAGE ALL

Date : 2026-08-07  
Statut : livrable owner prêt  
Base OPUS : `2376a4de07e4f504aeac1be1d8a183d43c34df80`

## 1. Acquisition précédente

R45B4 est acquis sur `OPUS/master` au commit :

```text
2376a4de07e4f504aeac1be1d8a183d43c34df80
opus_p117w_r45b4_profiler_environment_config
```

R45B5 est construit exclusivement sur ce HEAD. Aucun fichier de `try` ni d'un autre site généré existant n'est corrigé localement.

## 2. Régression générique du runtime généré

Le `catch` de `GeneratedSiteRuntime::handle()` enregistre actuellement `request.failed` avec le statut Profiler `failed`.

Le contrat `Trace` n'autorise que :

```text
success
warning
error
unavailable
```

Une erreur applicative normale déclenche donc une seconde exception pendant son instrumentation. Le rendu d'erreur SCORE n'est jamais atteint et PHP renvoie un HTTP 500 générique.

R45B5 corrige l'appelant :

```text
request.failed -> status=error
```

Le contrat Profiler n'est pas élargi pour accepter `failed`.

Conséquence attendue : une route absente produit la réponse OPUS prévue, notamment une HTTP 404, au lieu d'un second crash Profiler.

## 3. URL observée sur `try`

La capture owner appelle :

```text
http://127.0.0.1:8800/fr-FR/applications
```

Dans le scaffold générique, la route `home` est `/`. Les autres chemins correspondent uniquement aux modules réellement générés. R45B5 ne crée donc pas artificiellement une route `/applications` dans `try`.

Après correction du runtime :

- `http://127.0.0.1:8800/fr-FR/` doit servir de test de l'accueil du site généré ;
- `/fr-FR/applications` doit retourner une erreur OPUS/HTTP 404 si ce module n'existe pas ;
- aucune route locale n'est ajoutée pour masquer une URL incorrecte.

## 4. Stage all générique

R45B5 ajoute au service générique :

```text
SiteGitWorkspaceInterface::stageAll(string $siteId)
SiteGitWorkspace::stageAll(string $siteId)
```

Contrat de résultat :

```text
OPUS_SITE_GIT_STAGE_ALL_V1
```

L'opération :

- valide le site avec le contrat existant ;
- lit le statut Git borné au site ;
- refuse le Stage all si un conflit Git est présent ;
- sélectionne uniquement les changements `unstaged` ou `untracked` du site courant ;
- exécute sans shell libre :

```text
git add -A -- sites/<site_id>
```

- ne peut donc pas stager un autre site ni un chemin fourni librement par le navigateur ;
- conserve le contrôle existant qui interdit ensuite un commit si l'index contient un chemin étranger au site ;
- retourne `affected_path_count` et le statut Git actualisé ;
- ne place aucun contenu de fichier dans Logger ou Profiler.

Un conflit produit :

```text
OPUS_SITE_GIT_STAGE_ALL_CONFLICT_FORBIDDEN
```

## 5. Frontière REST / Composer

Le flux reste strictement :

```text
OWASYS-front
-> POST SCORE + CSRF
-> REST sécurisé
-> OWASYS-back
-> Composer allow-listé
-> SiteGitWorkspace::stageAll()
-> réponse REST
-> ViewModel
-> SCORE
```

Nouvelle ressource collectionnelle :

```text
PUT /api/v1/applications/{site_id}/git/index
operation = git.stage_all
success  = 200
```

La ressource fichier existante reste inchangée :

```text
PUT /api/v1/applications/{site_id}/git/index/{*path}
operation = git.stage
```

Les catalogues frontend, backend externe et backend inline restent identiques et leur fingerprint est recalculé par `RestResourceCatalog`.

Nouvelle opération Composer :

```text
git.stage_all
-> owasys:git-stage-all
-> owasys:git:stage-all
```

L'ACL réutilise l'action contractuelle `git:stage`; aucun nouveau privilège n'est créé.

La FSM réutilise les signaux existants `stage_source` / `source_staged`, car Stage all reste une opération de stage et non un nouvel état métier.

## 6. SCORE et I18n

Le module `Sources et Git` reçoit un formulaire SCORE serveur :

```text
git_action=stage_all
```

Il est affiché uniquement lorsque :

- le rôle autorise `git:stage` ;
- au moins un changement est stageable ;
- aucun conflit Git n'est présent.

Aucun JavaScript n'est ajouté.

Deux clés sont ajoutées aux 24 langues officielles de l'Union européenne déjà configurées dans OWASYS ainsi qu'à l'ukrainien :

```text
git.stage_all
git.stage_all_success
```

En français :

```text
Tout stager
Toutes les modifications de l’application ont été stagées.
```

## 7. Périmètre de modification

Le script différentiel modifie exactement 38 fichiers suivis :

- 3 fichiers OPUS framework/runtime ;
- `composer.json` ;
- 5 fichiers OWASYS-back ;
- 4 fichiers OWASYS-front code/config/SCORE ;
- 25 catalogues I18n du module Source.

Aucun fichier de `sites/try` n'est modifié.
Aucun JavaScript backend n'est ajouté.
Aucun smoke, log, cache, rapport, vendor ou secret n'est inclus dans le ZIP.

## 8. Livrable

Le README-FIRST autorise explicitement un ZIP différentiel composé de scripts ou de fichiers complets. R45B5 utilise un script d'application transactionnel afin de modifier les sources exactes publiées sans reconstituer de gros fichiers privés hors de leur source de vérité.

```text
ZIP     : opus_p117w_r45b5_generated_runtime_error_stage_all.zip
SHA-256 : 74e70f1b93c7b719497aeb99c704fd4d5c2e38489ec235bba8aacf924caf15cc
FILES   : 1 script différentiel complet
TARGETS : 38 fichiers suivis
BASE    : 2376a4de07e4f504aeac1be1d8a183d43c34df80
```

Script :

```text
apply_opus_p117w_r45b5.php
SHA-256 : 967ddf96a845b59994c3c6eb4a118e9a57a9c31145c2cf40aa81de52860c6ef2
OUTPUT  : OPUS_P117W_R45B5_APPLIED
```

Le script :

- exige le HEAD exact R45B4 ;
- refuse toute modification préalable d'un des 38 fichiers cibles ;
- lit/écrit les fichiers via `Opus\File\File` ;
- parse/encode les JSON avec `Opus\File\Json` ;
- vérifie les ancres exactes avant mutation ;
- valide la symétrie des trois catalogues REST avant écriture ;
- lint les PHP modifiés avant écriture ;
- écrit atomiquement ;
- restaure les originaux si une écriture échoue.

Le script d'application n'est pas destiné à être committé dans OPUS.

## 9. Smoke owner séparé

```text
FILE    : smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php
SHA-256 : 22c496ebf5fe77552bfb39febce5cee81da7306bf6dd4c4a77f865623f0f2ee7
OUTPUT  : OPUS_P117W_R45B5_SMOKE_OK
```

Le smoke :

- audite toutes les classes concrètes OPUS avec `token_get_all()` ;
- confirme que `Trace` continue de refuser `failed` et accepte `error` ;
- confirme le correctif `request.failed -> error` ;
- confirme `SiteGitWorkspaceInterface::stageAll()` ;
- confirme la séparation ressource collectionnelle / ressource fichier ;
- compare les fingerprints REST front/back ;
- compare backend inline/externe ;
- confirme l'allow-list Composer ;
- confirme le ViewModel/SCORE Stage all ;
- confirme les 25 catalogues I18n ;
- contrôle l'absence de JavaScript dans OWASYS-back.

Le smoke doit être supprimé avant commit.

## 10. Validation owner obligatoire

1. vérifier le HEAD exact `2376a4de07e4f504aeac1be1d8a183d43c34df80` ;
2. contrôler les SHA-256 du ZIP et du smoke ;
3. extraire le script hors du dépôt OPUS ;
4. exécuter le script contre `H:\OPUS` ;
5. obtenir `OPUS_P117W_R45B5_APPLIED` et `FILES=38` ;
6. `composer validate` ;
7. `composer dump-autoload -o` ;
8. copier temporairement le smoke à la racine OPUS ;
9. exécuter le smoke et obtenir `OPUS_P117W_R45B5_SMOKE_OK` ;
10. supprimer le smoke ;
11. relancer OWASYS-front/back ;
12. vérifier le bouton `Tout stager` sur `try` ;
13. confirmer que Stage all ne stage que `sites/try` ;
14. confirmer que les stages individuels fonctionnent toujours ;
15. démarrer `try` et tester son accueil sur `/fr-FR/` ;
16. tester une route absente et confirmer une HTTP 404 OPUS, pas un 500 générique ;
17. commit et push owner après succès.

## 11. Suite gouvernée

Après acquisition R45B5 :

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
NO FALLBACK SILENCIEUX.  
NO PUSH OPUS PAR L’ASSISTANT.