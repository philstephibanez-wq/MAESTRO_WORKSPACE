# HANDOFF — OPUS P117W R45D2A2 GENERATED LOCAL-PASSWORD RUNTIME

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base OPUS

```text
01b146876fd96282dfd0f618dc84341b49d6eec6
essai2 !
```

## Constats owner

- `essai2` authentifié/local-password est généré et sélectionnable ;
- le snapshot Sécurité montre `steve`, `local-password`, `password-setup-required`, rôle `admin` ;
- la racine preview renvoie `OPUS_AUTH_REQUIRED` au lieu de la page login ;
- une tentative de mutation R45D2 renvoie `OPUS_SSO_AUTHENTICATION_FAILED` ;
- des fichiers Profiler `.lock` persistent.

## Diagnostic

### Profiler

Les `.lock` sont intentionnels et persistants. `Profiler` utilise un sidecar stable `<storage>.lock`, prend `LOCK_SH` ou `LOCK_EX`, puis libère via `LOCK_UN` + `fclose`. Le fichier restant n'est pas un verrou actif et n'est pas une trace.

```text
NO PROFILER LOCK PURGE.
```

### Site généré

`GeneratedSiteRuntime` applique actuellement l'ACL avant toute redirection login. Une route protégée anonyme produit donc `OPUS_AUTH_REQUIRED` même quand `login_page=true` et qu'une route login existe.

### Credential initial

Le scaffold respecte le contrat secret : aucun password n'est versionné. Mais aucun mécanisme générique ne provisionne encore `var/auth/local-users.json`. R45D2A2 introduit un provisioner runtime local, alimenté uniquement par STDIN non interactif.

### Mutation R45D2

Les logs owner montrent que la tentative POST `/fr-FR/security` n'atteint pas `security/previews` côté back. Le back ne reçoit que `security.snapshot` 200. `OPUS_SSO_AUTHENTICATION_FAILED` est donc la fresh reauthentication de l'admin OWASYS côté front, distincte du credential cible `steve`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a2_generated_local_password_runtime.zip
SHA-256 : e9c92966b2fe1206a020134726995ab2ebe85bdb28e74857f241c57fa6bd5b7f
BASE    : 01b146876fd96282dfd0f618dc84341b49d6eec6
FILES   : 6
```

Fichiers :

```text
composer.json
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommand.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommandInterface.php
Opus/Security/Sso/LocalPasswordCredentialProvisioner.php
Opus/Security/Sso/LocalPasswordCredentialProvisionerInterface.php
```

## Comportement

1. une route protégée anonyme redirige 303 vers la route login localisée si le SSO exige auth + login page ;
2. aucune redirection pour route déjà autorisée ou route login ;
3. `composer opus:local-password-provision -- <site> <subject>` provisionne un credential runtime uniquement depuis STDIN ;
4. seul un sujet déjà onboardé avec statut `password-setup-required` sur un site généré Composer/local-password est accepté ;
5. le store reste sous `var/auth/`, hors Git ;
6. seul le hash est écrit ;
7. un credential existant n'est jamais remplacé silencieusement.

## Validation assistant

```text
PHP lint                         OK (5)
composer.json JSON               OK
interface marker audit           OK (2 nouvelles interfaces)
GeneratedSiteRuntime base blob   166fd209172991e6e0ce2a7833b0ca24f4ba3301 exact avant delta
composer.json base blob          1ef3ce15b48c4d0152579aa2cb701bea0d64220d exact avant delta
provisioner synthetic test       OK
credential overwrite rejection   OK
secret absent result/store       OK
ZIP integrity                    OK, 6 fichiers exacts
```

## Gate owner

- appliquer sur HEAD exact `01b146...` ;
- dump-autoload ;
- provisionner `essai2/steve` via STDIN sans secret en argv ;
- relancer preview ;
- racine -> login localisé ;
- login -> home autorisé ;
- vérifier que `git status` n'inclut pas `var/auth/local-users.json` ;
- reprendre R45D2 preview en utilisant le mot de passe **OWASYS admin** dans le champ de réauthentification ;
- si ce password OWASYS correct échoue encore, traiter alors la fresh-auth comme défaut séparé avec preuve runtime.

NO SITE-SPECIFIC PATCH.  
NO ACL RELAXATION.  
NO SECRET OVER REST.  
NO SECRET IN ARGV.  
NO PROFILER LOCK PURGE.  
NO PUSH OPUS BY ASSISTANT.
