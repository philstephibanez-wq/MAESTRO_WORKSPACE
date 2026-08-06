# OPUS P117W E3B — GIT WORKSPACE FRONTEND

Date : 2026-08-06

## Base exacte

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
Jalon acquis : E3A Git workspace générique/backend
```

E3A est acquis au commit `4b1f621051a306443ada7eb5fada2a8e9363b0aa` avec exactement les onze fichiers gouvernés du service Git générique et de sa frontière OWASYS-back.

## Objectif

Intégrer les opérations Git contrôlées d'E3A dans le module OWASYS-front existant **Sources et Git**, sans créer de route, de module ou de frontière parallèle.

Le flux obligatoire reste :

```text
OWASYS-front SCORE/POST
  -> client REST OPUS
  -> REST sécurisé OWASYS-back
  -> Composer allow-listé
  -> provider OWASYS-back
  -> SiteGitWorkspace OPUS
```

Le frontend ne peut utiliser directement ni Git, ni le système de fichiers, ni un shell.

## Livrable différentiel

```text
ZIP     : opus_p117w_e3b_git_workspace_front.zip
SHA-256 : f6cdd8160f16586851b2983373eedba473e865db237db2c388b005bebcc49743
FILES   : 32
BASE    : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e3b_git_workspace_front_owner.php
SHA-256 : 4cc4c4cbe15d20d0f83f96d7a8431e420aea3ffcf2b4ecb9dc6a85b953bf5f6a
OUTPUT  : OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_OK
```

## Périmètre fonctionnel

Le module Sources et Git expose, via SCORE et formulaires POST :

- statut Git du site sélectionné ;
- branche et HEAD ;
- liste des changements index/worktree ;
- diff staged et unstaged de la source sélectionnée ;
- historique borné ;
- stage explicite d'un chemin ;
- unstage explicite d'un chemin ;
- commit explicite avec message borné ;
- restauration explicite du worktree avec hash optimiste et chaîne de confirmation exacte.

L'enregistrement Source, le stage Git et le commit Git sont trois actions distinctes. Aucun enregistrement ne déclenche implicitement un stage ou un commit.

## SCORE et fallback sans JavaScript

- rendu exclusivement par `source/templates/index.score` ;
- tous les contrôles Git sont des formulaires serveur ;
- CSRF à usage unique et scope Git distinct ;
- POST/Redirect/GET après succès ;
- aucun JavaScript requis pour status, stage, unstage, commit ou restore ;
- CodeMirror et le navigateur Source existants restent de simples améliorations progressives.

## FSM

Le state demeure `source`.

Signaux ajoutés :

- `stage_source` / `source_staged` ;
- `unstage_source` / `source_unstaged` ;
- `commit_source` / `source_committed` ;
- `restore_source` / `source_restored` ;
- `git_action_failed`.

Toutes les transitions restent `source -> source`, gardées par `current_app_required`. Les transitions de demande mémorisent uniquement l'action et, lorsque pertinent, le chemin Git.

## ACL

Deny-by-default conservé.

```text
admin     : *:*
developer : git:*
viewer    : git:read
```

La vue ne constitue pas une autorisation : chaque mutation est réévaluée par l'ACL frontend, puis par REST, Composer et le provider backend.

## I18n

Les vingt-cinq catalogues du module Source sont complétés : langues officielles de l'Union européenne configurées plus ukrainien.

Aucun libellé fonctionnel Git n'est codé en dur dans le contrôleur.

## Correction générique du Profiler REST

Le client REST OPUS projetait auparavant les corps structurés bruts dans les spans du Profiler. Cette cause générique aurait exposé notamment contenu Source, diff Git, message de commit, confirmation de restauration et sujets/auteurs d'historique.

E3B remplace cette projection par une expurgation récursive :

- métadonnées techniques conservées ;
- chaînes sensibles remplacées par type et taille ;
- tableaux sensibles remplacés par type et nombre d'éléments ;
- booléens d'état `staged` / `unstaged` conservés ;
- aucun corps Source ou Git sensible dans les diagnostics.

## Fichiers

- `Opus/Api/Rest/RestClient.php` ;
- contrôleur, modèle, template et CSS du module Source frontend ;
- ACL et FSM OWASYS-front ;
- vingt-cinq catalogues I18n Source.

Aucun fichier OWASYS-back, aucun JavaScript, aucun site généré et aucune configuration Composer ne figure dans E3B.

## Validations réalisées

- 32 fichiers exacts ;
- intégrité ZIP ;
- lint PHP des trois fichiers PHP ;
- 27 JSON valides ;
- 25 catalogues complets ;
- IDs FSM uniques et transitions E3B cohérentes ;
- ACL Git deny-by-default ;
- CSRF présent dans chaque formulaire de mutation ;
- absence de Git, shell et écriture filesystem directs dans le frontend ;
- test focalisé du modèle REST Git ;
- test focalisé de l'expurgation récursive du Profiler ;
- absence de fichier backend et de JavaScript backend dans le ZIP.

## Validation owner obligatoire

Après application du ZIP :

1. lint PHP et parsing JSON ;
2. `composer validate` et autoload optimisé ;
3. smoke owner ;
4. test OWASYS réel : status, diff, stage, unstage, commit et restore ;
5. confirmation qu'un enregistrement Source ne stage pas le fichier ;
6. confirmation viewer lecture seule et developer/admin mutation ;
7. commit et push owner seulement après succès.

NO ACL BYPASS.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO CONTENT, DIFF, COMMIT MESSAGE OR CONFIRMATION IN PROFILER.
NO IMPLICIT GIT OPERATION.
NO FREE GIT COMMAND.
NO PUSH IMPLICITE.
NO BACKEND JAVASCRIPT.
NO GENERATED SITE FILE.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
