# HANDOFF — OPUS P117W E1 SOURCE WORKSPACE

Date : 2026-08-05  
Statut : livré, application, validation et push owner requis

## Base exacte

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
Base       : 2c268e998c7f714c17476050e652d7afb88db9f4
```

R45B2A3 est publié par l’owner à `a1afd6415c9ddbd80b7944756210f33c36f7253b` et `test7` a ensuite été généré. R45B2A4 est publié à la base courante et corrige la visibilité ACL générique du Profiler. E1 ne cible aucun fichier généré.

## Livrable

```text
ZIP     : opus_p117w_e1_source_workspace.zip
SHA-256 : b4b4b681ea9e7ca19c06529f9bf59ba8125e31a2aadd7d89927f3c6be71bb657
FILES   : 3
BASE    : 2c268e998c7f714c17476050e652d7afb88db9f4
```

Fichiers :

```text
Opus/Application/Source/SiteSourceWorkspace.php
Opus/Application/Source/SiteSourceWorkspaceInterface.php
Opus/Application/Inspection/SiteSourceInspector.php
```

Aucun `sites/**`, aucun fichier OWASYS, aucun test, rapport, log, cache ou temporaire n’est contenu dans le ZIP.

## Smoke owner séparé

```text
FILE    : smoke_opus_p117w_e1_source_workspace_owner.php
SHA-256 : 04950f12a089db63886b5397958d1aaae7bd267335eea0699cf08c7f66ea781a
STATUS  : hors ZIP
```

Le smoke crée un site temporaire contractuel sous `sites/e1-smoke-*`, valide E1 puis le supprime dans son bloc `finally`.

## Protocole owner

Le dépôt OPUS doit être propre et exactement sur la base indiquée avant extraction.

```cmd
cd /d H:\OPUS
git status --short
git rev-parse HEAD
tar -xf "%USERPROFILE%\Downloads\opus_p117w_e1_source_workspace.zip"
php -l Opus\Application\Source\SiteSourceWorkspaceInterface.php
php -l Opus\Application\Source\SiteSourceWorkspace.php
php -l Opus\Application\Inspection\SiteSourceInspector.php
composer dump-autoload -o
php "%USERPROFILE%\Downloads\smoke_opus_p117w_e1_source_workspace_owner.php" H:\OPUS
git status --short
```

Résultat attendu du smoke :

```text
OPUS_P117W_E1_SOURCE_WORKSPACE_OK
```

Après validation owner : commit et push OPUS par l’owner uniquement.

## Gates d’acquisition

E1 est acquis lorsque :

1. les trois lints réussissent ;
2. Composer régénère l’autoload optimisé ;
3. le smoke owner retourne `OPUS_P117W_E1_SOURCE_WORKSPACE_OK` ;
4. aucun site témoin permanent n’est laissé ;
5. le diff Git ne contient que les trois fichiers du livrable ;
6. le commit owner OPUS est publié ;
7. le SHA owner publié est reporté dans le workspace.

## Suite après acquisition

E2 : intégration OWASYS Sources par REST sécurisé puis Composer allow-listé, avec preview/write, ACL deny-by-default, maintien du chemin et de la locale dans l’URL GET, ViewModel et SCORE.

E3 reste séparé : statut/diff/historique/stage/unstage/commit Git contrôlés, sans push implicite.

NO ACL BYPASS.  
NO LOCAL SITE FIX.  
NO FALLBACK SILENCIEUX.  
NO PUSH OPUS PAR L’ASSISTANT.
