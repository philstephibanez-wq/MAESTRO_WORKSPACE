# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A11_LOCAL_PASSWORD_RESET_ALERT_2026-08-10.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A11_LOCAL_PASSWORD_RESET_ALERT_2026-08-10.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33  opus_p117w_r45d2a10_login_prg_profiler_correlation
6dbc92bd48e03ba84325f6d68c304c76f73026e1  opus_p117w_r45d2a9b_login_user_feedback_deterministic
ce7a628ddea08334b2d4139be36d12b176396c9b  opus_p117w_r45d2a8_local_password_failure_diagnostics
```

## Preuve owner

`essai2/steve` échoue actuellement avec :

```text
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Le subject existe et son hash existe. Le mot de passe soumis ne correspond pas.

## Livrable actif — R45D2A11

```text
ZIP     : opus_p117w_r45d2a11_local_password_reset_alert.zip
SHA-256 : 6fd302cca2867ea7e75979c62a2ad8fa8748e12d383e19d558f9f07c048d65df
BASE    : 31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33
FILES   : 5
```

Fonctions :

1. reset administrateur d'un credential local existant sans ancien password ;
2. nouveau password uniquement via STDIN ;
3. conservation identité + rôles ;
4. aucun secret dans argv/logs/Profiler/UI ;
5. composant visuel d'alerte login SCORE/CSS standardisé ;
6. migration générique des sites Composer générés existants.

## Gate immédiat

1. appliquer le ZIP ;
2. exécuter `tools/r45d2a11_apply_local_password_reset_alert.php` ;
3. vérifier les local changes ;
4. lint + dump-autoload ;
5. reset `essai2/steve` via `opus:local-password-reset` ;
6. tester connexion avec le nouveau password ;
7. tester mauvais password : alerte standard + Profiler corrélé au POST.

NO SITE-SPECIFIC PATCH.
NO PASSWORD IN ARGV.
NO MANUAL HASH EDIT.
NO SECRET IN UI/LOGS/PROFILER.
NO ACL/SSO RELAXATION.
NO PUSH OPUS BY ASSISTANT.
