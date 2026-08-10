# OPUS P117W R45D2A3 — GENERATED LOGIN OBSERVABILITY

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base canonique

```text
OPUS/master
f634e337ec0b5df0020bfba6eb240da0395a05bd
cleanup essai
```

Historique immédiat :

```text
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
```

R45D2A2 est donc publié et `essai2` reste la cible de validation du runtime `local-password`.

## Clarification contractuelle — Identités OWASYS

La vue **Sécurité > Identités** d'OWASYS décrit les identités de **l'application sélectionnée**, et non les comptes permettant de se connecter à OWASYS lui-même.

Deux plans sont strictement distincts :

1. **acteur OWASYS** : l'utilisateur connecté à `owasys-front` ; il est utilisé pour les gardes ACL OWASYS et la réauthentification avant mutation ;
2. **identité de l'application cible** : couple `provider + subject` lu dans la configuration/runtime de l'application sélectionnée et utilisé par cette application pour ses propres SSO/ACL.

Pour `essai2` :

```text
application cible : essai2
provider           : local-password
subject            : steve
role applicatif    : admin
source              : runtime.local-password
status              : active
```

`source = runtime.local-password` et `status = active` signifient qu'un enregistrement existe dans le store runtime `sites/essai2/var/auth/local-users.json`. Cela ne prouve pas qu'un mot de passe saisi dans le navigateur a déjà été vérifié avec succès.

Le formulaire **Référencer une identité** crée/référence un couple `provider + subject` pour l'application cible. Il ne crée pas un compte externe et ne définit aucun mot de passe.

Le champ **Saisissez à nouveau votre mot de passe OWASYS** concerne exclusivement l'acteur OWASYS courant ; il n'est pas le mot de passe de `steve` dans `essai2`.

## Preuve runtime courante

Le screenshot owner montre `steve` avec :

```text
Fournisseur : local-password
État        : active
Rôles       : admin
Source      : runtime.local-password
```

Le provisioning R45D2A2 a donc matériellement créé le credential store runtime. L'échec de connexion restant doit être distingué entre :

- credential navigateur différent du credential provisionné ;
- store local-password illisible/invalide ;
- fournisseur local-password non résolu ;
- authentification réussie mais problème de session/redirection.

## Cause source d'opacité

`Opus\Application\Runtime\GeneratedSiteRuntime::handleLogin()` intercepte actuellement toute exception d'authentification avec :

```text
catch (Throwable) -> opus_login_error = true -> retour page login
```

Aucun événement Logger/Profiler n'indique si l'échec réel est `OPUS_SSO_AUTHENTICATION_FAILED`, un problème de store, de provider ou une autre cause sûre.

Cette perte d'observabilité viole le contrat Logger/Profiler OPUS pour un workflow SSO significatif et empêche de diagnostiquer la cause sans bricolage local.

## Correction générique R45D2A3

Le correctif modifie uniquement :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
```

Comportement :

- `trace_id` courant transmis à `handleLogin()` ;
- événement Logger + Profiler `security.sso/authentication.succeeded` après authentification réussie ;
- événement Logger + Profiler `security.sso/authentication.failed` après échec ;
- seul un code d'erreur normalisé est journalisé ;
- aucun username, password, corps POST, hash, token ou secret n'est journalisé/profilé ;
- le rendu utilisateur reste volontairement générique ;
- aucune baisse de garde ACL/SSO ;
- aucune modification de `sites/essai2` ;
- aucun changement du Profiler `.lock`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a3_generated_login_observability.zip
SHA-256 : bfbc032c7e8e5147905e48035dda6208d924de5d5d0b0ff8e5ebb5f6ffaf05e3
BASE    : f634e337ec0b5df0020bfba6eb240da0395a05bd
FILES   : 1
```

## Validation assistant

```text
base GeneratedSiteRuntime blob : b9c1d659308b8d51adc45ef59b9a77d944f8b89b exact
PHP lint                       : OK
ZIP members                    : 1 fichier exact
secret dans nouveaux contextes : aucun
ACL/SSO                        : comportement inchangé
site-specific patch            : aucun
```

## Gate owner

1. appliquer R45D2A3 sur HEAD exact `f634e337...` ;
2. relancer `essai2` ;
3. ouvrir la racine puis la page login ;
4. saisir `steve` comme username ;
5. saisir exactement le password provisionné pour `essai2/steve`, et non le password admin OWASYS ;
6. en cas d'échec, lire uniquement l'événement `security.sso/authentication.failed` corrélé dans Logger/Profiler ;
7. corriger ensuite la cause prouvée, sans toucher aux gardes ACL ni au store manuellement.

NO SITE-SPECIFIC PATCH.  
NO ACL RELAXATION.  
NO SECRET IN LOGS OR PROFILER.  
NO SECRET OVER REST.  
NO PROFILER LOCK PURGE.  
NO PUSH OPUS BY ASSISTANT.
