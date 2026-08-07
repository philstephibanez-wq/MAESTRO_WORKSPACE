# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-07.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 2376a4de07e4f504aeac1be1d8a183d43c34df80
Dernier acquis : R45B4 Profiler configurable par environnement
Livrable actif : R45B5 runtime d'erreur généré + Git Stage all
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module Profiler historique du scaffold, remplacé par la politique générique R45B4.
- R45B2A4 : alignement historique `profiler:view`, remplacé par la politique générique R45B4.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e`.
- E3A : workspace Git générique/backend, publié à `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.
- E3B : interface Git frontend, publiée à `7b390b662573b1e71bd8d770bbcad3d3b386325b` et validée par commit réel depuis OWASYS.
- R45B3 : contrat client REST/catalogues croisés, publié à `6be07a76e20dfeea09b51c7c016083da626bf974`.
- R45B4 : Profiler configurable par environnement, publié à `2376a4de07e4f504aeac1be1d8a183d43c34df80`.

R45B4 est acquis et constitue la base exacte de R45B5.

R46 `dev-server --site=` reste abandonné.

## Contrat dev-server

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## État R45B4 acquis

R45B4 fournit :

- `config/environment.yaml` lu via `File` + `StructuredFileLoader` ;
- collecte, Web Profiler et liens séparés ;
- Web Profiler autorisé uniquement en `dev` ;
- `ProfilerLinkProvider` générique ;
- route Profiler enregistrée structurellement au runtime ;
- absence de logique Profiler propre aux nouveaux sites générés ;
- slot SCORE `diagnostics.profiler_*` ;
- configuration YAML commentée ;
- production sans route/contrôleur/fournisseur Web Profiler.

Commit owner :

```text
2376a4de07e4f504aeac1be1d8a183d43c34df80
opus_p117w_r45b4_profiler_environment_config
```

## Régression détectée après acquisition R45B4

`GeneratedSiteRuntime::handle()` instrumente son chemin d'erreur avec le statut `failed`, alors que `Trace` n'autorise que `success`, `warning`, `error`, `unavailable`.

Une erreur applicative normale peut donc déclencher une seconde exception Profiler et produire un HTTP 500 PHP générique au lieu du rendu d'erreur SCORE.

La capture `try` sur `:8800/fr-FR/applications` expose cette régression. Le scaffold générique mappe l'accueil `home` sur `/`; R45B5 ne crée pas de route locale `/applications` pour masquer ce fait.

## Livrable owner actif — R45B5

```text
ZIP     : opus_p117w_r45b5_generated_runtime_error_stage_all.zip
SHA-256 : 74e70f1b93c7b719497aeb99c704fd4d5c2e38489ec235bba8aacf924caf15cc
FILES   : 1 script différentiel complet
TARGETS : 38 fichiers suivis
BASE    : 2376a4de07e4f504aeac1be1d8a183d43c34df80
STATUS  : livré, application, validation, commit et push owner requis
```

Script :

```text
apply_opus_p117w_r45b5.php
SHA-256 : 967ddf96a845b59994c3c6eb4a118e9a57a9c31145c2cf40aa81de52860c6ef2
OUTPUT  : OPUS_P117W_R45B5_APPLIED
FILES   : 38
```

Smoke owner séparé :

```text
smoke_opus_p117w_r45b5_generated_runtime_error_stage_all_owner.php
SHA-256 : 22c496ebf5fe77552bfb39febce5cee81da7306bf6dd4c4a77f865623f0f2ee7
OUTPUT  : OPUS_P117W_R45B5_SMOKE_OK
```

Le ZIP ne contient aucun smoke, audit, rapport, log, cache, vendor, temporaire ou secret.

## R45B5 — causes traitées

### Runtime d'erreur

- `request.failed` utilise désormais le statut Profiler contractuel `error` ;
- `Trace` reste strict et ne reçoit pas de nouveau statut `failed` ;
- une route non déclarée doit pouvoir retourner la HTTP 404 OPUS prévue au lieu d'un second crash Profiler ;
- aucun fichier de `try` n'est modifié.

### Git Stage all

- `SiteGitWorkspaceInterface::stageAll()` et `SiteGitWorkspace::stageAll()` ;
- contrat `OPUS_SITE_GIT_STAGE_ALL_V1` ;
- refus si conflit Git ;
- `git add -A -- sites/<site_id>` sans shell libre ;
- aucun chemin fourni par le navigateur ;
- ressource collectionnelle `PUT /api/v1/applications/{site_id}/git/index` ;
- opération `git.stage_all` ;
- Composer `owasys:git-stage-all` / `owasys:git:stage-all` ;
- catalogues REST front/back/inline synchronisés ;
- ACL `git:stage` réutilisée ;
- FSM `stage_source/source_staged` réutilisée ;
- bouton SCORE POST+CSRF, sans JavaScript ;
- stages individuels conservés ;
- deux clés I18n ajoutées aux 24 langues officielles UE configurées plus ukrainien.

## Validation owner attendue

1. HEAD exact `2376a4de07e4f504aeac1be1d8a183d43c34df80` ;
2. contrôle des SHA-256 ;
3. application du script différentiel ;
4. résultat `OPUS_P117W_R45B5_APPLIED` et `FILES=38` ;
5. `composer validate` ;
6. autoload optimisé ;
7. smoke owner temporaire ;
8. résultat `OPUS_P117W_R45B5_SMOKE_OK` ;
9. suppression du smoke ;
10. relance OWASYS-front/back ;
11. Stage all réel sur `try` et contrôle qu'aucun autre site n'est stagé ;
12. contrôle du stage individuel ;
13. accueil de `try` sur `/fr-FR/` ;
14. route absente donnant HTTP 404 OPUS et non 500 PHP générique ;
15. commit et push owner après succès.

## Suite gouvernée

1. acquisition owner R45B5 ;
2. R45C : wizard OWASYS structuré ;
3. R45D : administration Sécurité.

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