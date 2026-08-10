# HANDOFF — OPUS P117W R45D2A11 LOCAL PASSWORD RESET + STANDARD ALERT

Date : 2026-08-10

## Base canonique

```text
31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33  opus_p117w_r45d2a10_login_prg_profiler_correlation
```

## Livrable

```text
ZIP     : opus_p117w_r45d2a11_local_password_reset_alert.zip
SHA-256 : 6fd302cca2867ea7e75979c62a2ad8fa8748e12d383e19d558f9f07c048d65df
FILES   : 5
```

Fichiers directs :

```text
Opus/Security/Sso/LocalPasswordCredentialResetter.php
Opus/Security/Sso/LocalPasswordCredentialResetterInterface.php
Opus/Composer/LocalPasswordCredentialResetterComposerCommand.php
Opus/Composer/LocalPasswordCredentialResetterComposerCommandInterface.php
tools/r45d2a11_apply_local_password_reset_alert.php
```

L'applicateur ajoute `opus:local-password-reset` à Composer, remplace le simple paragraphe d'erreur login par une alerte SCORE standard et migre génériquement le CSS/template des applications Composer générées existantes.

Les quatre nouveaux PHP et l'applicateur ont été lintés sans erreur côté assistant.

## Gate owner

1. appliquer le ZIP sur le master exact ;
2. exécuter l'applicateur ;
3. vérifier `git status --short` ;
4. lint + dump-autoload ;
5. réinitialiser le credential `essai2/steve` via STDIN ;
6. confirmer connexion réussie ;
7. confirmer look d'alerte sur mauvais password ;
8. confirmer conservation de la corrélation Profiler du POST fautif.

NO SITE-SPECIFIC PATCH.
NO PASSWORD IN ARGV.
NO MANUAL HASH EDIT.
NO SECRET IN UI/LOGS/PROFILER.
NO ACL/SSO RELAXATION.
NO PUSH OPUS BY ASSISTANT.
