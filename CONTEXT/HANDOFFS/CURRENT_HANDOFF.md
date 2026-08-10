# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A8_LOCAL_PASSWORD_FAILURE_DIAGNOSTICS_2026-08-10.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A8_LOCAL_PASSWORD_FAILURE_DIAGNOSTICS_2026-08-10.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
62ed6c6b7440034c5855e310899fb11d605fdf00  opus_p117w_r45d2a5_generated_profiler_iframe_integration
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
```

## Preuves owner courantes

Après application locale R45D2A7 :

```text
/fr/login reste affichée
Profiler intégré et repliable
Security / ACL / SSO = 1
security.sso.authentication.failed
provider = local-password
locale = fr
error_code = OPUS_SSO_AUTHENTICATION_FAILED
```

La correction du Profiler est donc acquise : le panneau Security reçoit maintenant l'événement réel.

## Cause restante

`LocalPasswordSsoProvider::authenticate()` retournait `null` pour plusieurs causes distinctes :

```text
credentials absents
subject absent du runtime store
password_hash absent
password_verify faux
```

`SsoManager` transforme ensuite le `null` en `OPUS_SSO_AUTHENTICATION_FAILED`. Ce code est donc encore trop générique pour décider si `essai2` souffre d'un problème de username, de provisioning/hash ou de mot de passe.

## Livrable actif — R45D2A8

```text
ZIP     : opus_p117w_r45d2a8_local_password_failure_diagnostics.zip
SHA-256 : 1a18337ac7d08bb1554bfda2688cc484a7fad0062218e19c02f3c1dc979d94ef
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 3
```

R45D2A8 supersède R45D2A7 et contient :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/WebProfilerView.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
```

Codes techniques attendus après un nouveau POST login :

```text
OPUS_SSO_LOCAL_CREDENTIALS_REQUIRED
OPUS_SSO_LOCAL_SUBJECT_UNKNOWN
OPUS_SSO_LOCAL_PASSWORD_HASH_MISSING
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Le message visible reste `Authentication failed`; aucune donnée sensible n'est journalisée.

## Gate owner immédiat

1. appliquer R45D2A8 directement sur `62ed6c6b...` ;
2. `php -l` sur les deux PHP ;
3. `composer dump-autoload -o` ;
4. relancer `composer opus:dev-server -- essai2` ;
5. retenter le login `steve` ;
6. ouvrir `Security / ACL / SSO` ;
7. relever le nouveau `error_code` ;
8. traiter uniquement cette cause ;
9. reprendre ensuite R45D2 preview/commit avec fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET IN LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
