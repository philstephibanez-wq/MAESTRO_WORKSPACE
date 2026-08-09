# OPUS P117W R45D2A2 — GENERATED LOCAL-PASSWORD RUNTIME

Date : 2026-08-09  
Statut : LIVRABLE OWNER À VALIDER

## Base canonique

```text
OPUS/master
01b146876fd96282dfd0f618dc84341b49d6eec6
essai2 !
```

Cette base contient R45D2, R45D2A1 et le site diagnostique généré `essai2` poussé par l'owner.

## Preuves runtime reçues

Le site `essai2` est généré avec :

```text
authentication_required = true
login_page = true
default_provider = local-password
initial identity = steve
status onboarding = password-setup-required
```

L'ouverture de la racine du site renvoie actuellement `OPUS_AUTH_REQUIRED` alors qu'une route `login` existe. La cause est générique : `GeneratedSiteRuntime` applique l'ACL sur la route protégée avant de rediriger un visiteur anonyme vers la route login configurée.

La tentative R45D2 de mutation affiche `OPUS_SSO_AUTHENTICATION_FAILED`. Les journaux owner prouvent que cette erreur survient côté `owasys-front` pendant la fresh reauthentication de l'administrateur OWASYS : le backend ne reçoit aucun POST `security/previews`; il reçoit uniquement le GET `security.snapshot` qui réussit. Cette preuve ne justifie donc aucune baisse de garde SSO ni aucun patch backend.

## Cause complémentaire : credential local initial absent

Le scaffold ne versionne volontairement aucun mot de passe. Pour `local-password`, `security.onboarding.json` référence l'identité et le runtime store `var/auth/local-users.json`, tandis que `LocalPasswordSsoProvider` authentifie uniquement contre un `password_hash` présent dans ce store runtime.

Il manque donc un mécanisme générique de provisioning du credential initial hors Git, hors REST, hors argv, hors logs et hors Profiler.

R45D2A2 ajoute ce mécanisme comme commande Composer locale OPUS, alimentée exclusivement par STDIN non interactif. Le secret n'est jamais ajouté au blueprint de création et ne traverse jamais OWASYS REST/Composer.

## Correction générique OPUS

### 1. Redirection authentification du runtime généré

`GeneratedSiteRuntime` conserve ACL deny-by-default. Lorsqu'une identité anonyme demande une ressource refusée et que le SSO déclare simultanément :

```text
authentication_required = true
login_page = true
```

le runtime résout la route dont le module est `login` et répond HTTP 303 vers `/{locale}{login_path}`.

La locale négociée est conservée. Aucune redirection n'est effectuée pour une route déjà autorisée à `everyone`, ni depuis la route login elle-même. Une configuration annonçant une page login sans route login réelle échoue explicitement. La redirection est journalisée/profilée sans secret.

### 2. Provisioning local-password runtime

Nouveau composant framework :

```text
Opus\Security\Sso\LocalPasswordCredentialProvisioner
```

avec interface homonyme étendant directement les quatre marqueurs OPUS.

Le provisioner accepte uniquement :

- un site `generated-opus-application` ;
- `generated_by = composer` ;
- `OPUS_GENERATED_APPLICATION_SSO_V1` ;
- provider `local-password` actif ;
- sujet déjà déclaré dans `security.onboarding.json` ;
- runtime store sous `var/auth/` ;
- mot de passe d'au moins 10 octets.

Le store `OPUS_LOCAL_USER_STORE_V1` est écrit via `File::writeAtomic` + `Json`. Le mot de passe n'est jamais écrit : seul `password_hash()` est persisté. Un credential déjà provisionné n'est jamais écrasé silencieusement.

### 3. Commande Composer locale

```text
composer opus:local-password-provision -- <site_id> <subject>
```

La commande refuse un STDIN interactif et exige que le secret arrive par STDIN non interactif. Le password ne se trouve donc ni dans argv, ni dans Git, ni dans les logs, ni dans le Profiler, ni dans une requête REST.

Cette commande est un mécanisme local de provisioning/deployment. Elle ne constitue pas un contournement OWASYS : aucune mutation métier OWASYS ne l'invoque et aucun secret n'est transporté par le flux front -> REST -> back -> Composer.

## Profiler `.lock` — clarification définitive

Les fichiers `<storage>.lock` du Profiler sont des **sidecars de synchronisation persistants**. Leur présence après une requête est normale.

Le code ouvre ce fichier stable avec `fopen(..., 'c+b')`, prend `LOCK_SH` pour lecture ou `LOCK_EX` pour append/rotation, puis exécute `LOCK_UN` et `fclose()`.

Le verrou réel est donc le verrou OS associé au descripteur ouvert ; le fichier `.lock` restant sur disque ne signifie pas qu'un verrou est encore détenu. Le supprimer après chaque requête serait dangereux : deux processus pourraient alors synchroniser sur deux fichiers distincts.

```text
.lock persistant = normal
.lock != trace profiler
.lock ne doit pas être affiché comme trace
pas de purge aveugle
pas de patch Profiler pour sa seule persistance
```

Toute ancienne hypothèse disant que le `.lock` devait disparaître après exécution est annulée.

## Livrable

```text
ZIP     : opus_p117w_r45d2a2_generated_local_password_runtime.zip
SHA-256 : 764ca50be8b07eac4c64edd3d0ebb64a40113e70e19eadb79fd5fb8908c356c4
BASE    : 01b146876fd96282dfd0f618dc84341b49d6eec6
FILES   : 6
```

Fichiers complets :

```text
composer.json
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommand.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommandInterface.php
Opus/Security/Sso/LocalPasswordCredentialProvisioner.php
Opus/Security/Sso/LocalPasswordCredentialProvisionerInterface.php
```

Aucun fichier de `sites/essai2` n'est corrigé manuellement.

## Validation assistant

```text
PHP lint                         OK (5)
composer.json JSON               OK
interfaces 4 marqueurs           OK
GeneratedSiteRuntime base blob   166fd209172991e6e0ce2a7833b0ca24f4ba3301 exact avant delta
composer.json base blob          1ef3ce15b48c4d0152579aa2cb701bea0d64220d exact avant delta
provisioner synthetic test       OK
credential overwrite rejection   OK
secret absent result             OK
ZIP members                      6 exacts
```

## Gates owner

1. base owner exacte `01b146876fd96282dfd0f618dc84341b49d6eec6` ;
2. PHP lint des cinq fichiers PHP ;
3. JSON Composer valide ;
4. interfaces homonymes et quatre marqueurs ;
5. `composer dump-autoload -o` ;
6. provisioning `essai2/steve` par STDIN sécurisé ;
7. aucune modification Git du runtime store ;
8. requête racine `essai2` -> HTTP 303 vers route login localisée ;
9. login avec le credential provisionné -> session authentifiée ;
10. aucun secret dans Git/logs/Profiler/argv ;
11. les `.lock` restent admis comme sidecars persistants et ne sont pas supprimés ;
12. reprendre ensuite R45D2 preview avec le mot de passe de l'administrateur OWASYS.

NO SITE-SPECIFIC PATCH.  
NO ACL RELAXATION.  
NO SECRET OVER REST.  
NO SECRET IN ARGV.  
NO PROFILER LOCK PURGE.  
NO PUSH OPUS BY ASSISTANT.
