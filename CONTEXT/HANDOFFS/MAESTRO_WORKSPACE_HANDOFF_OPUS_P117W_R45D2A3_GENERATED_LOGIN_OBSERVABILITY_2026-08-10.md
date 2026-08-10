# HANDOFF — OPUS P117W R45D2A3 GENERATED LOGIN OBSERVABILITY

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base OPUS

```text
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
```

## État acquis

R45D2A2 est publié sur OPUS. Le screenshot owner montre pour `essai2` :

```text
steve
provider = local-password
status   = active
role     = admin
source   = runtime.local-password
```

Le credential runtime existe donc dans le store non versionné. La vue **Identités** d'OWASYS décrit la sécurité de l'application cible sélectionnée ; elle ne représente pas les comptes OWASYS.

Le champ de réauthentification dans les formulaires de mutation reste le password de l'acteur OWASYS courant. Le login de `essai2` utilise `steve` et le password provisionné pour `essai2/steve`.

## Défaut traité

`GeneratedSiteRuntime::handleLogin()` absorbait toute erreur d'authentification et ne laissait qu'un booléen UI. Logger et Profiler ne permettaient donc pas de distinguer un mauvais credential d'un store/provider invalide.

R45D2A3 ajoute une observabilité SSO sûre et corrélée sans enregistrer username, password, hash ou corps POST.

## Livrable

```text
ZIP     : opus_p117w_r45d2a3_generated_login_observability.zip
SHA-256 : bfbc032c7e8e5147905e48035dda6208d924de5d5d0b0ff8e5ebb5f6ffaf05e3
BASE    : f634e337ec0b5df0020bfba6eb240da0395a05bd
FILES   : 1
```

Fichier :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
```

## Gate immédiat

- appliquer sur HEAD exact `f634e337...` ;
- `php -l` + `composer dump-autoload -o` + `git diff --check` ;
- relancer preview `essai2` ;
- username = `steve` ;
- password = credential provisionné pour `essai2/steve`, pas le password admin OWASYS ;
- si échec, récupérer le seul code `security.sso/authentication.failed` dans Logger/Profiler ;
- traiter ensuite la cause prouvée.

NO SITE-SPECIFIC PATCH.  
NO ACL RELAXATION.  
NO SECRET IN LOGS/PROFILER.  
NO PROFILER LOCK PURGE.  
NO PUSH OPUS BY ASSISTANT.
