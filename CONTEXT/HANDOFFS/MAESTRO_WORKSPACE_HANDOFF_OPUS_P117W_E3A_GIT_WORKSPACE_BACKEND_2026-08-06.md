# HANDOFF — OPUS P117W E3A GIT WORKSPACE BACKEND

Date : 2026-08-06

## Source de vérité

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
Base       : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
```

E2B est acquis au commit `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé fonctionnellement par édition réelle d'un fichier du site `test` depuis OWASYS Sources.

Le HEAD owner `fac5f8d94f29f8529ad9b99f72a0b83f9a74240f` inclut ensuite les opérations owner sur le site témoin. E3A est fondé exactement sur ce HEAD mais ne contient aucun fichier sous `sites/test`.

## Livrable actif

```text
ZIP     : opus_p117w_e3a_git_workspace_backend.zip
SHA-256 : 18bfeca293b10d911c717e266823b10771d1899b81dd5ae3edd281ca242bfcdc
FILES   : 11
BASE    : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
STATUS  : livré, application, validation et push owner requis
```

Smoke owner :

```text
FILE    : smoke_opus_p117w_e3a_git_workspace_backend_owner.php
SHA-256 : bb37d9e0fe75a4f516593968e79fc1d134ffdeab1c7c9ea6e7944f67c9634db7
OUTPUT  : OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_OK
```

## Contenu

- service générique `SiteGitWorkspace` et interface homonyme ;
- statut, diff, historique, stage, unstage, commit et restauration ;
- confinement au site sélectionné ;
- refus d'un commit si l'index contient un chemin hors site ;
- absence de push et de commande Git libre ;
- REST et Composer allow-listés dans OWASYS-back ;
- ACL viewer lecture, developer/admin mutation ;
- Logger et Profiler sans contenu sensible ;
- normalisation du rôle principal affiché : `admin > developer > viewer`.

## Fichiers

```text
Opus/Application/Git/SiteGitWorkspace.php
Opus/Application/Git/SiteGitWorkspaceInterface.php
composer.json
sites/owasys-back/application/git/console.php
sites/owasys-back/application/git/services/OwasysGitCommandProvider.php
sites/owasys-back/application/git/services/OwasysGitCommandProviderInterface.php
sites/owasys-back/config/acl.json
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/backend.rest.json
sites/owasys-back/config/composer.commands.json
sites/owasys-front/application/default/models/AuthSession.php
```

## Découpage

E3A ne livre pas encore la page Git frontend. Cela évite de coupler la validation du service Git et de sa frontière de sécurité à la composition SCORE/FSM.

Après acquisition owner de E3A :

- E3B ajoute la page Git dans OWASYS-front ;
- rendu SCORE ;
- FSM, I18n, ACL et CSRF ;
- fallback sans JavaScript ;
- statut, diff, historique, stage, unstage, commit et restauration explicites ;
- conservation de la séparation Source save / Git stage / Git commit.

## Interdictions

NO PUSH IMPLICITE.  
NO FREE GIT COMMAND.  
NO DIRECT FRONTEND GIT ACCESS.  
NO FOREIGN STAGED PATH.  
NO BACKEND JAVASCRIPT.  
NO LOCAL SITE FIX.  
NO PUSH OPUS PAR L'ASSISTANT.
