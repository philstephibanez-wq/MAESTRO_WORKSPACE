# OPUS P117W R45D2A8 — LOCAL PASSWORD FAILURE DIAGNOSTICS

Date : 2026-08-10

## Contexte

Après R45D2A7, le Web Profiler classe correctement les événements hiérarchiques `security.sso` dans le panneau `Security / ACL / SSO`.

Preuve owner : le POST de connexion de `essai2` produit désormais réellement :

```text
security.sso.authentication.failed
provider=local-password
locale=fr
error_code=OPUS_SSO_AUTHENTICATION_FAILED
```

Le problème restant n'est plus la projection Profiler : `LocalPasswordSsoProvider::authenticate()` retourne `null` pour plusieurs causes distinctes et `SsoManager` les réduit toutes à `OPUS_SSO_AUTHENTICATION_FAILED`.

## Cause générique

Dans `LocalPasswordSsoProvider`, quatre états différents étaient indistinguables :

1. username ou password absent ;
2. username absent du store runtime ;
3. entrée présente mais `password_hash` absent ;
4. `password_verify()` faux.

Cette perte d'information empêche le diagnostic de la cause réelle tout en donnant l'illusion d'une erreur unique.

## Contrat R45D2A8

Le provider local-password doit conserver l'échec d'authentification côté utilisateur, sans secret ni donnée brute, mais produire un code technique distinct destiné au Logger/Profiler :

```text
OPUS_SSO_LOCAL_CREDENTIALS_REQUIRED
OPUS_SSO_LOCAL_SUBJECT_UNKNOWN
OPUS_SSO_LOCAL_PASSWORD_HASH_MISSING
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Aucun username, password, hash, contenu POST ou secret ne doit être ajouté aux événements, logs ou Profiler.

Le message SCORE visible reste générique : `Authentication failed`.

## Compatibilité

- aucune relaxation ACL/SSO ;
- aucun patch `sites/essai2` ;
- aucune donnée synthétique ;
- aucun changement de session ;
- aucun changement FSM ;
- aucune modification du store runtime ;
- le comportement `SsoManager` reste générique pour les providers qui retournent `null` ;
- les exceptions techniques du provider local sont capturées par `GeneratedSiteRuntime`, normalisées et injectées uniquement dans l'observabilité déjà contractuelle.

## Livrable

```text
ZIP     : opus_p117w_r45d2a8_local_password_failure_diagnostics.zip
SHA-256 : 1a18337ac7d08bb1554bfda2688cc484a7fad0062218e19c02f3c1dc979d94ef
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 3
```

Le ZIP supersède R45D2A7 et contient :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/WebProfilerView.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
```

## Gate owner

Après application :

1. lint PHP ;
2. `composer dump-autoload -o` ;
3. relancer `essai2` ;
4. POST login `steve` ;
5. lire le nouveau `error_code` dans `Security / ACL / SSO` ;
6. corriger uniquement cette cause prouvée.

NO SITE-SPECIFIC PATCH.
NO SECRET IN LOGS/PROFILER.
NO ACL/SSO RELAXATION.
NO SILENT FALLBACK.
NO PUSH OPUS BY ASSISTANT.
