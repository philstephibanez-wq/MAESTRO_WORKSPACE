# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A9_LOGIN_USER_FEEDBACK_2026-08-10.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A9_LOGIN_USER_FEEDBACK_2026-08-10.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
62ed6c6b7440034c5855e310899fb11d605fdf00  opus_p117w_r45d2a5_generated_profiler_iframe_integration
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
```

## Preuves owner courantes

Après R45D2A8 local :

```text
/fr/login reste affichée
Profiler intégré et repliable
Security / ACL / SSO = 1
security.sso.authentication.failed
provider = local-password
locale = fr
error_code = OPUS_SSO_LOCAL_PASSWORD_INVALID
```

La cause technique du refus est acquise : subject trouvé + hash présent + `password_verify()` faux.

## Exigence UX courante

La cause technique ne doit pas être exposée à l'utilisateur. Après un POST refusé :

```text
303 -> /<locale>/login
flash I18n -> Identifiant ou mot de passe incorrect.
```

Le flash est consommé après le GET de rendu ; Logger/Profiler conservent la cause technique détaillée.

## Livrable actif — R45D2A9

```text
ZIP     : opus_p117w_r45d2a9_login_user_feedback.zip
SHA-256 : 776dde0bd303d5110804a14212d31786acd945dbe9c55ddaef39dd8281eb4a0f
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00 + R45D2A8 local
FILES   : 4
```

R45D2A9 est cumulatif avec R45D2A8 et contient :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/WebProfilerView.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
tools/r45d2a9_apply_login_user_feedback.php
```

L'applicateur fail-fast met à jour le runtime/scaffold et migre les catalogues login de toutes les applications Composer générées conformes au contrat. Ce n'est pas un patch spécifique `essai2`.

## Gate owner immédiat

1. extraire R45D2A9 dans `H:\OPUS` ;
2. exécuter `php tools/r45d2a9_apply_login_user_feedback.php` ;
3. lint des PHP modifiés ;
4. `composer dump-autoload -o` ;
5. relancer `composer opus:dev-server -- essai2` ;
6. essayer un mauvais password : message utilisateur localisé attendu ;
7. recharger : flash disparu attendu ;
8. Profiler doit conserver `OPUS_SSO_LOCAL_PASSWORD_INVALID` ;
9. ensuite corriger/provisionner le vrai password `steve` et reprendre R45D2 preview/commit.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET IN UI/LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
