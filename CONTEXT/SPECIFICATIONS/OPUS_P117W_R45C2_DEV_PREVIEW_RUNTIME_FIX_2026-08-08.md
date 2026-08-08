# OPUS P117W R45C2 — DEV PREVIEW RUNTIME FIX

Date : 2026-08-08
Statut : livrable owner à valider

## Source de vérité

OPUS `master` acquis :

```text
5770a144ed6524de5462eaae780cccc5b1aa8a47
opus_p117w_r45c1_dev_preview_button
```

R45C1 est donc publié et constitue la base exacte de R45C2.

## Constat owner

Dans OWASYS, application courante `OPUS test` (`sites/test`, profil `fullstack`), le bouton `Visualiser le site` est rendu mais l'action retourne :

```text
Le serveur de développement n’a pas pu être démarré.
```

Aucun nouvel onglet n'est ouvert.

## Défauts R45C1 confirmés

### 1. Lancement background Windows fragile et non diagnostiquable

`SiteCommandService::startBackgroundDevelopmentServer()` passe par :

```text
cmd.exe /C start /B ...
```

puis redirige stdout/stderr vers `NUL`.

Ce détour shell est inutile : OPUS connaît déjà `PHP_BINARY`, le public root et le router. En cas d'échec, les diagnostics du serveur PHP sont perdus.

### 2. Fallback silencieux OWASYS

Le POST Build capture tout `Throwable` autour de `startDevelopmentServer()` et le remplace par `build.preview_failed`.

Cela viole le contrat :

```text
NO FALLBACK SILENCIEUX.
TOUJOURS TRAITER LA CAUSE, JAMAIS L'EFFET.
```

### 3. Le bouton ne peut pas ouvrir directement le site

R45C1 envoie un POST dans l'onglet courant. Même en cas de succès, le template ne fait qu'afficher ensuite un second lien `target=_blank`. Le besoin owner est un clic unique qui ouvre directement la prévisualisation.

## Correction R45C2

### Framework OPUS — lancement direct PHP

`opus:dev-server --background --auto-port` conserve le contrat générique et lance directement :

```text
PHP_BINARY -S <host>:<port> -t <site>/www <site>/www/index.php
```

via `proc_open()` sans `cmd.exe`, `start`, PowerShell, shell Unix ou commande libre provenant du navigateur.

Le launcher :

- conserve `bypass_shell=true` ;
- utilise `create_process_group` sous Windows ;
- lie stdin au null device ;
- écrit stdout/stderr du processus dans `sites/<site>/var/logs/dev-server.process.log` ;
- remet ce log à zéro à chaque lancement ;
- contrôle un PID valide ;
- attend au maximum 5 secondes que le port réponde ;
- détecte une sortie prématurée et remonte `OPUS_DEV_SERVER_BACKGROUND_EXITED:<code>` ;
- renvoie le PID dans `OPUS_CONSOLE_DEV_SERVER_START_RESULT_V1` ;
- libère le handle local sans attendre la fin du serveur long-lived.

Aucun fichier runtime n'est versionné : les logs sous `sites/*/var/logs/*` sont ignorés par Git.

### OWASYS — aucun fallback silencieux

Le contrôleur Build ne capture plus arbitrairement `Throwable` pour produire un faux message générique.

Une erreur REST / Composer / OPUS remonte donc dans la chaîne normale OWASYS avec son code sûr.

### OWASYS — nouvel onglet sans JavaScript

Le formulaire SCORE utilise :

```text
target="_blank" rel="noopener"
```

Après succès :

1. la transition FSM OWASYS `open_build -> build` est exécutée et persistée ;
2. OWASYS valide une seconde fois l'URL de prévisualisation ;
3. seuls `http://127.0.0.1:<port>`, `http://localhost:<port>` ou `http://[::1]:<port>` sont autorisés ;
4. OWASYS retourne un HTTP 303 `Location` vers le site ;
5. le nouvel onglet affiche directement le site généré.

Aucun JavaScript n'est requis.

## Séparation FSM contractuelle

R45C2 ne modifie jamais la FSM du site généré.

```text
FSM OWASYS
= navigation OWASYS
+ sécurité/guards OWASYS
+ métier OWASYS de construction des sites

FSM SITE GÉNÉRÉ
= pages/navigation du site
+ sécurité/guards du site
+ workflow métier du site
```

OWASYS peut créer/éditer/valider la FSM du site comme une ressource de construction, mais ne l'exécute pas comme sa propre FSM.

Le bouton de prévisualisation appartient au workflow/outillage OWASYS `Construction et validation`; une fois le serveur démarré, le site exécuté utilise exclusivement son propre runtime et sa propre FSM.

## Livrable

```text
ZIP     : opus_p117w_r45c2_dev_preview_runtime_fix.zip
SHA-256 : 4ce81c7f0847daa144a53d2437380d5f0c1d5fac7ac3d77b10952665173e2042
SCRIPT  : apply_opus_p117w_r45c2_dev_preview_runtime_fix.php
SHA-256 : c8a160bfb03734968bd3c3b4c5ec1e048a6557796e4e827d9d2a4444ffe8306f
BASE    : 5770a144ed6524de5462eaae780cccc5b1aa8a47
TARGETS : 3
OUTPUT  : OPUS_P117W_R45C2_APPLIED / FILES=3
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45c2_dev_preview_runtime_fix_owner.php
SHA-256 : 32c75c0aa36eb62e884f940df159d58ebae1b8ee6b594504226d3d843df70a54
OUTPUT  : OPUS_P117W_R45C2_SMOKE_OK
```

## Fichiers cibles

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-front/application/build/templates/index.score
```

## Gates owner

1. HEAD exact R45C1 `5770a144...` ;
2. cibles propres ;
3. application du ZIP ;
4. `composer dump-autoload -o` ;
5. smoke séparé OK, incluant audit exhaustif `token_get_all()` des interfaces homonymes OPUS ;
6. relance OWASYS back/front ;
7. sélectionner une application `frontend` ou `fullstack` ;
8. cliquer `Visualiser le site` ;
9. un nouvel onglet doit s'ouvrir directement sur l'URL locale retournée ;
10. le site doit exécuter sa propre FSM, indépendante de la FSM OWASYS ;
11. `viewer` ne reçoit pas le bouton ;
12. `backend` pur ne reçoit pas le bouton ;
13. en cas d'échec, le code réel doit remonter et `var/logs/dev-server.process.log` doit permettre le diagnostic ;
14. commit/push OPUS exclusivement par l'owner après succès.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FRONT SHELL EXECUTION.
NO BACKEND JAVASCRIPT.
NO GENERATED-SITE FSM COUPLING.
NO OPUS PUSH BY ASSISTANT.
