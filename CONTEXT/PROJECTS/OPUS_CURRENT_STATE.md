# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : f634e337ec0b5df0020bfba6eb240da0395a05bd
Commit : cleanup essai
```

Historique immédiat :

```text
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
```

## États acquis / publiés

R45C3R1 : workflow OWASYS structuré acquis.

R45D1 : workspace Sécurité réel acquis.

R45D2 : mutations de sécurité additives publiées ; preview/commit complète encore à valider.

R45D2A1 : wizard de création sécurité canonicalisé et publié.

R45D2A2 : runtime local-password publié sous `052cc6e...` : redirection vers login + provisioner initial hors Git/REST/argv.

## Site `essai2`

Configuration publiée :

```text
profile = fullstack
authentication_required = true
login_page = true
provider = local-password
initial identity = steve
role = admin
```

Le screenshot owner post-R45D2A2 montre :

```text
steve
provider = local-password
status   = active
roles    = admin
source   = runtime.local-password
```

Le store runtime contient donc l'identité/credential `steve`. OWASYS construit cet état à partir de `var/auth/local-users.json`. `active` ne signifie pas qu'une tentative de login navigateur a déjà réussi.

## Clarification Identités OWASYS

La vue **Sécurité > Identités** affiche les identités de l'application cible sélectionnée.

L'acteur OWASYS courant est un plan de sécurité distinct :

- il se connecte à OWASYS ;
- ses rôles OWASYS gardent les actions d'administration ;
- son password OWASYS sert à la fresh reauthentication avant mutation.

Une identité cible est le couple contractuel `provider + subject`. Pour `essai2`, `local-password + steve` est un utilisateur de `essai2`, pas un compte OWASYS.

`Référencer une identité` ne crée pas de password. Les credentials `local-password` restent dans le store runtime non versionné.

## Login `essai2` — défaut d'observabilité confirmé

R45D2A2 corrige la redirection login et le provisioning, mais `GeneratedSiteRuntime::handleLogin()` absorbe encore toute exception d'authentification :

```text
catch(Throwable) -> opus_login_error=true -> retour login
```

Le runtime ne produit actuellement aucun Logger/Profiler spécifique pour distinguer :

- password incorrect ;
- store absent/invalide ;
- provider invalide ;
- autre refus SSO sûr.

Cette opacité est un défaut générique OPUS car Logger/Profiler sont contractuels pour SSO.

## Profiler `.lock`

Les `.lock` restent des sidecars persistants de synchronisation.

```text
.lock persistant = normal
.lock != trace
NO PROFILER LOCK PURGE
```

## Livrable actif — R45D2A3

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

Fonctions :

1. transmettre le `trace_id` courant au traitement login ;
2. profiler/journaliser `security.sso/authentication.succeeded` ;
3. profiler/journaliser `security.sso/authentication.failed` ;
4. ne conserver que provider, locale et code d'erreur normalisé ;
5. ne jamais enregistrer username, password, hash, POST brut ou secret ;
6. ne modifier ni ACL, ni comportement d'authentification, ni `sites/essai2`.

Validation assistant :

```text
GeneratedSiteRuntime base blob : b9c1d659308b8d51adc45ef59b9a77d944f8b89b exact
PHP lint                       : OK
ZIP                            : 1 fichier exact
secret nouveaux contextes      : aucun
```

## Suite

1. owner applique R45D2A3 sur `f634e337...` ;
2. relance `essai2` ;
3. tente login avec `username=steve` et le password provisionné pour `essai2/steve` ;
4. si échec, récupère le code `security.sso/authentication.failed` ;
5. traiter ensuite la cause prouvée ;
6. reprendre R45D2 preview/commit avec le password admin OWASYS dans la fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO SECRET IN ARGV.
NO SECRET IN LOGS/PROFILER.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
