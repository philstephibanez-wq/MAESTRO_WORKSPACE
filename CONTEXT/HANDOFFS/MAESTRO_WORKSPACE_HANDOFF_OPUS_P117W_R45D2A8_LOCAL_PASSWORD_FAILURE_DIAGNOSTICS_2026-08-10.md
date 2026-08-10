# HANDOFF — OPUS P117W R45D2A8 LOCAL PASSWORD FAILURE DIAGNOSTICS

Date : 2026-08-10

## Base canonique

```text
OPUS master = 62ed6c6b7440034c5855e310899fb11d605fdf00
```

R45D2A7 est appliqué localement par l'owner et sa preuve visuelle est acquise :

- page `/fr/login` conservée ;
- Profiler intégré et repliable ;
- `Security / ACL / SSO = 1` ;
- événement visible `security.sso.authentication.failed` ;
- `provider=local-password` ;
- `error_code=OPUS_SSO_AUTHENTICATION_FAILED`.

## Diagnostic

Le code générique provient de la perte de granularité dans `LocalPasswordSsoProvider::authenticate()` : plusieurs causes retournent `null`, puis `SsoManager` les transforme en un même `OPUS_SSO_AUTHENTICATION_FAILED`.

R45D2A8 introduit uniquement des codes techniques sûrs :

```text
OPUS_SSO_LOCAL_CREDENTIALS_REQUIRED
OPUS_SSO_LOCAL_SUBJECT_UNKNOWN
OPUS_SSO_LOCAL_PASSWORD_HASH_MISSING
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Le navigateur continue d'afficher seulement `Authentication failed`.

## Livrable actif

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

R45D2A8 supersède R45D2A7 ; il peut être appliqué directement sur le master publié `62ed6c6b...`.

## Validation assistant

- PHP lint OK sur `WebProfilerView.php` ;
- PHP lint OK sur `LocalPasswordSsoProvider.php` ;
- ZIP différentiel direct ;
- aucun fichier spécifique `essai2` ;
- aucun secret ajouté ;
- aucune relaxation ACL/SSO ;
- aucune modification du store runtime.

## Gate owner immédiat

1. appliquer R45D2A8 ;
2. lint + `composer dump-autoload -o` ;
3. relancer `essai2` ;
4. retenter login `steve` ;
5. relever le nouveau code précis dans `Security / ACL / SSO` ;
6. traiter ensuite uniquement la cause révélée.

NO SITE-SPECIFIC PATCH.
NO SECRET IN LOGS/PROFILER.
NO ACL/SSO RELAXATION.
NO SILENT FALLBACK.
NO PUSH OPUS BY ASSISTANT.
