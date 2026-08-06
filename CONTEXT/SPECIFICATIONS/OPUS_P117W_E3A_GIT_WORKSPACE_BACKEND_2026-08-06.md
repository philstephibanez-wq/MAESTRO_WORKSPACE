# OPUS P117W E3A — GIT WORKSPACE GÉNÉRIQUE ET FRONTIÈRE BACKEND

Date : 2026-08-06  
Statut : livrable owner actif  
Base OPUS exacte : `fac5f8d94f29f8529ad9b99f72a0b83f9a74240f`

## 1. Décision de découpage

Le jalon E3 est découpé en deux acquisitions atomiques :

- E3A : service Git générique OPUS, exposition OWASYS-back REST/Composer et correction de la projection du rôle principal ;
- E3B : intégration UI SCORE dans OWASYS-front, FSM, I18n et formulaires CSRF.

E3A ne crée aucune interface Git frontend et ne modifie aucun site généré.

## 2. Service générique OPUS

Le service `Opus\Application\Git\SiteGitWorkspace` est borné au dépôt OPUS et à un site déclaré sous `sites/<site-id>`.

Capacités E3A :

- statut Git du site ;
- diff index et worktree pour un chemin validé ;
- historique borné à 50 commits ;
- stage explicite d'un chemin ;
- unstage explicite d'un chemin ;
- commit explicite ;
- restauration bornée du worktree avec empreinte SHA-256 et confirmation renforcée.

Le service refuse :

- les chemins absolus, `..`, `.git`, les traversées et les liens symboliques ;
- les répertoires comme cible d'une opération fichier ;
- tout stage implicite ;
- tout commit si l'index contient un chemin extérieur au site sélectionné ;
- les commandes Git libres ;
- push, pull, fetch, remote, rebase, reset destructif et clean ;
- les invites interactives Git ;
- les sorties non bornées ou les processus dépassant le timeout.

L'enregistrement Source, le stage et le commit restent trois opérations distinctes.

## 3. Frontière OWASYS-back

Flux obligatoire :

```text
future UI SCORE
-> REST sécurisé
-> OWASYS-back
-> Composer allow-listé
-> SiteGitWorkspace
-> réponse structurée
```

Opérations REST/Composer :

- `git.status` / `owasys:git-status` ;
- `git.diff` / `owasys:git-diff` ;
- `git.history` / `owasys:git-history` ;
- `git.stage` / `owasys:git-stage` ;
- `git.unstage` / `owasys:git-unstage` ;
- `git.commit` / `owasys:git-commit` ;
- `git.restore` / `owasys:git-restore`.

ACL deny-by-default :

- viewer : lecture Git uniquement ;
- developer : `git:*` ;
- admin : `*:*`.

Le message de commit, l'empreinte de restauration, la confirmation et la limite d'historique restent dans la requête structurée et n'entrent pas dans `argv` lorsque cela n'est pas nécessaire.

## 4. Logger et Profiler

Chaque opération est instrumentée sous le panneau `git` et corrélable par trace.

Aucun contenu de fichier, diff, message de commit, confirmation, ligne de commande complète ou sortie Git n'entre dans Logger ou Profiler.

## 5. Correction du rôle principal affiché

La session pouvait conserver les rôles dans l'ordre reçu, par exemple `viewer, admin`. L'ACL examinait correctement tous les rôles, mais l'UI projetait le premier élément et affichait alors `viewer`.

E3A normalise désormais les rôles selon la priorité :

```text
admin > developer > viewer > autres rôles triés
```

Tous les rôles restent présents pour les décisions ACL. Seule la projection `profile` devient déterministe et cohérente avec le rôle effectif le plus privilégié connu.

## 6. Livrable

```text
ZIP     : opus_p117w_e3a_git_workspace_backend.zip
SHA-256 : 18bfeca293b10d911c717e266823b10771d1899b81dd5ae3edd281ca242bfcdc
FILES   : 11
BASE    : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e3a_git_workspace_backend_owner.php
SHA-256 : bb37d9e0fe75a4f516593968e79fc1d134ffdeab1c7c9ea6e7944f67c9634db7
OUTPUT  : OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_OK
```

## 7. Validation obligatoire

Le smoke valide notamment :

- base Git exacte ;
- graph REST -> opération -> script Composer -> alias -> provider ;
- exclusion des données structurées d'`argv` ;
- interface homonyme et quatre marqueurs ;
- absence de JavaScript/Node dans OWASYS-back ;
- rôle principal `admin` pour une identité contenant `viewer, admin, developer` ;
- statut, diff, stage, unstage, commit, historique et restauration sur un dépôt temporaire réel ;
- refus d'un commit comportant un stage étranger ;
- refus d'une traversée de chemin.

## 8. Suite

Après validation, commit et push owner de E3A, E3B ajoutera l'interface Git SCORE dans OWASYS-front avec FSM, I18n, ACL, CSRF, fallback sans JavaScript, statut, diff, historique et actions explicites.

NO PUSH IMPLICITE.  
NO FREE GIT COMMAND.  
NO FOREIGN STAGED PATH.  
NO DIRECT FRONTEND GIT ACCESS.  
NO BACKEND JAVASCRIPT.  
NO LOCAL SITE FIX.
