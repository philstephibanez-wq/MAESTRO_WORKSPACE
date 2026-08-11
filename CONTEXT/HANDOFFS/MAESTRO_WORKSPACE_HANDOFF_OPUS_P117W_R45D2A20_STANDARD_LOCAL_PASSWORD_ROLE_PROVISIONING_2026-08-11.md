# HANDOFF — OPUS P117W R45D2A20

Date : 2026-08-11

## Base OPUS

`38a053d585bfd0b154183a5ad7b043504634c043` — R45D2A19D publié.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a20_standard_local_password_role_provisioning.zip
SHA-256 : c74fb241be1b53237e9271ef5302f0e3ded1d0ae60451c4c34d157ff908e8b0c
FILES   : 4
```

R45D2A20 généralise `LocalPasswordCredentialProvisioner` aux `standard-opus-application` avec rôles explicites validés dans l'ACL deny-by-default, sans modifier le contrat onboarding des sites générés.

## Commandes owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45d2a20_standard_local_password_role_provisioning.zip"
php -l Opus\Security\Sso\LocalPasswordCredentialProvisioner.php
php -l Opus\Security\Sso\LocalPasswordCredentialProvisionerInterface.php
php -l Opus\Composer\LocalPasswordCredentialProvisionerComposerCommand.php
php -l tools\smoke_r45d2a20_standard_local_password_role_provisioning.php
php tools\smoke_r45d2a20_standard_local_password_role_provisioning.php
composer dump-autoload -o
git status --short
```

Attendu : `OPUS_R45D2A20_SMOKE_OK`.

## Provisioning OWASYS de test

Ne pas éditer `var/auth/local-users.json` manuellement.

Créer une identité developer avec mot de passe lu par `Read-Host -AsSecureString`, transmis à Composer uniquement par STDIN :

```cmd
powershell -NoProfile -Command "$s=Read-Host 'Mot de passe developer' -AsSecureString; $p=[Runtime.InteropServices.Marshal]::SecureStringToBSTR($s); try {[Console]::Out.Write([Runtime.InteropServices.Marshal]::PtrToStringBSTR($p))} finally {[Runtime.InteropServices.Marshal]::ZeroFreeBSTR($p)}" | composer opus:local-password-provision -- owasys-front developer --role=developer
```

Même mécanisme pour viewer :

```cmd
powershell -NoProfile -Command "$s=Read-Host 'Mot de passe viewer' -AsSecureString; $p=[Runtime.InteropServices.Marshal]::SecureStringToBSTR($s); try {[Console]::Out.Write([Runtime.InteropServices.Marshal]::PtrToStringBSTR($p))} finally {[Runtime.InteropServices.Marshal]::ZeroFreeBSTR($p)}" | composer opus:local-password-provision -- owasys-front viewer --role=viewer
```

Les sujets `developer` et `viewer` sont des choix opérateur runtime et ne sont pas codés dans le framework ni versionnés.

## Gate navigateur suivant

Developer :

- Applications ouvrir/sélectionner/changer ;
- créer et supprimer application générée ;
- Structure/Data/Workflows/Security ;
- Sources et Git lecture + mutations ;
- Security Preview + Commit ;
- account password change ;
- Profiler visible.

Viewer :

- Applications ouvrir/sélectionner/changer ;
- aucun bouton create/delete ;
- Structure/Data/Workflows/Security en lecture ;
- Sources et Git lecture uniquement ;
- aucune mutation source/git/security ;
- account password change autorisé ;
- Profiler absent et accès direct refusé.

Backend doit également refuser les mutations viewer : le test ne se limite pas au masquage SCORE.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
