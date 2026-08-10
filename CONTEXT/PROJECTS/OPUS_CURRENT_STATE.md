# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 62ed6c6b7440034c5855e310899fb11d605fdf00
Commit : opus_p117w_r45d2a5_generated_profiler_iframe_integration
```

Historique immédiat :

```text
62ed6c6b7440034c5855e310899fb11d605fdf00  opus_p117w_r45d2a5_generated_profiler_iframe_integration
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
```

## États acquis / publiés

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée.
- R45D2A5 : iframe Profiler générée publiée.
- R45D2A7 : appliqué localement owner ; projection hiérarchique Profiler validée par capture.

## Site essai2 — preuve owner courante

La capture owner du 2026-08-10 prouve désormais :

```text
page /fr/login conservée
Profiler intégré et repliable
Security / ACL / SSO = 1
type = security.sso.authentication.failed
provider = local-password
locale = fr
error_code = OPUS_SSO_AUTHENTICATION_FAILED
```

Le défaut de projection `security.sso` est donc corrigé par R45D2A7.

Le refus de credential reste réel. Sa cause précise est encore masquée par `LocalPasswordSsoProvider::authenticate()` qui retourne `null` pour plusieurs cas distincts ; `SsoManager` réduit ensuite tous ces cas à `OPUS_SSO_AUTHENTICATION_FAILED`.

## Profiler

Les `.lock` persistants sont des sidecars de synchronisation et restent normaux.

Le Web Profiler fonctionne. L'iframe same-origin reste repliable/masquable sans JavaScript et sans remplacer la page applicative. Les catégories hiérarchiques `racine.*` sont projetées dans le panneau racine correspondant sans synthèse d'événement.

## Livrable actif — R45D2A8

```text
ZIP     : opus_p117w_r45d2a8_local_password_failure_diagnostics.zip
SHA-256 : 1a18337ac7d08bb1554bfda2688cc484a7fad0062218e19c02f3c1dc979d94ef
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 3
```

Fichiers :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/WebProfilerView.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
```

R45D2A8 supersède R45D2A7 et conserve sa correction Profiler.

Le provider local-password distingue désormais, uniquement dans l'observabilité technique :

```text
OPUS_SSO_LOCAL_CREDENTIALS_REQUIRED
OPUS_SSO_LOCAL_SUBJECT_UNKNOWN
OPUS_SSO_LOCAL_PASSWORD_HASH_MISSING
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Le message navigateur reste `Authentication failed`. Aucun username/password/hash/POST brut n'est ajouté au Logger/Profiler.

Validation assistant : PHP lint OK sur les deux PHP ; ZIP différentiel direct ; aucun changement ACL/FSM/session/store ; aucun patch `essai2`.

## Suite

1. owner applique R45D2A8 sur `62ed6c6b...` ;
2. lint + `composer dump-autoload -o` ;
3. relance `essai2` ;
4. reproduit le POST login `steve` ;
5. relève le nouveau `error_code` précis dans `Security / ACL / SSO` ;
6. corrige uniquement cette cause prouvée ;
7. reprend ensuite la validation R45D2 preview/commit avec fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO SECRET IN LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
