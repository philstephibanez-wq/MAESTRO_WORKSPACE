# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 01b146876fd96282dfd0f618dc84341b49d6eec6
Commit : essai2 !
```

Historique immédiat :

```text
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121  opus_p117w_r45d1_security_snapshot_workspace
```

## États acquis / publiés

R45C3R1 : workflow OWASYS structuré acquis.

R45D1 : workspace Sécurité réel acquis.

R45D2 : mutations de sécurité additives publiées ; preview/commit complète encore à valider.

R45D2A1 : wizard de création sécurité canonicalisé et publié sous `d39b66d...`.

## Site `essai2` observé

Le site généré après R45D2A1 déclare et projette :

```text
profile = fullstack
authentication_required = true
login_page = true
provider = local-password
initial identity = steve
identity status = password-setup-required
role = admin
```

Il prouve que R45D2A1 génère maintenant la combinaison `auth + local-password + login` attendue.

## Défauts runtime confirmés

### Redirection login

La preview de `essai2` sur une route protégée anonyme affiche :

```text
OPUS_AUTH_REQUIRED
```

alors que `config/routes.json` contient une route `login` et que `sso.json` contient `authentication_required=true`, `login_page=true`.

Cause source : `GeneratedSiteRuntime` appelle l'ACL avant toute redirection vers login.

### Credential initial local-password

`security.onboarding.json` ne contient volontairement aucun secret et référence `var/auth/local-users.json`. `LocalPasswordSsoProvider` exige cependant un `password_hash` dans ce runtime store.

Aucun mécanisme générique publié ne provisionne encore ce credential initial sans secret dans Git/REST/argv.

### Mutation R45D2

Le POST `/fr-FR/security` montrant `OPUS_SSO_AUTHENTICATION_FAILED` échoue côté front pendant la fresh reauthentication OWASYS. Les logs back corrélés ne contiennent aucun POST `security/previews`, uniquement un GET `security.snapshot` réussi.

Ce défaut ne justifie pas de relâcher SSO. Le champ de réauthentification demande le password de l'admin **OWASYS**, pas le password de l'identité cible `steve`.

## Profiler `.lock`

État source confirmé dans `Opus/Profiler/Profiler.php` : les `.lock` sont des sidecars persistants de synchronisation.

```text
fopen(<storage>.lock, c+b)
LOCK_SH | LOCK_EX
LOCK_UN
fclose
```

La persistance du fichier ne signifie pas que le verrou OS reste détenu. Supprimer/recréer le sidecar entre opérations pourrait au contraire casser la synchronisation inter-processus.

```text
.lock persistant = normal
.lock != trace
NO PROFILER LOCK PURGE
```

Toute ancienne hypothèse disant que le `.lock` devait disparaître est annulée.

## Livrable actif — R45D2A2

```text
ZIP     : opus_p117w_r45d2a2_generated_local_password_runtime.zip
SHA-256 : e9c92966b2fe1206a020134726995ab2ebe85bdb28e74857f241c57fa6bd5b7f
BASE    : 01b146876fd96282dfd0f618dc84341b49d6eec6
FILES   : 6
```

Fonctions :

1. redirection 303 vers la route login localisée pour route protégée anonyme quand auth+login sont déclarés ;
2. ACL deny-by-default inchangée ;
3. provisioner framework `LocalPasswordCredentialProvisioner` ;
4. commande Composer `opus:local-password-provision` ;
5. secret accepté uniquement sur STDIN non interactif ;
6. store runtime sous `var/auth/` ;
7. `File::writeAtomic` + `Json` ;
8. sujet obligatoirement présent dans onboarding avec statut `password-setup-required` ;
9. overwrite silencieux interdit ;
10. aucun patch spécifique `essai2`.

Fichiers :

```text
composer.json
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommand.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommandInterface.php
Opus/Security/Sso/LocalPasswordCredentialProvisioner.php
Opus/Security/Sso/LocalPasswordCredentialProvisionerInterface.php
```

## Validation assistant

```text
PHP lint                         OK (5)
composer.json                    JSON OK
interfaces homonymes             4 marqueurs OK
GeneratedSiteRuntime base blob   166fd209172991e6e0ce2a7833b0ca24f4ba3301 exact
composer.json base blob          1ef3ce15b48c4d0152579aa2cb701bea0d64220d exact
provisioner synthetic test       OK
credential overwrite blocked     OK
secret absent result/store       OK
ZIP integrity                    OK, 6 fichiers
```

## Suite

1. owner applique R45D2A2 sur `01b146...` ;
2. provisionne `essai2/steve` hors Git/REST/argv ;
3. valide racine -> login -> home ;
4. reprend R45D2 preview avec password OWASYS admin ;
5. si fresh-auth correcte échoue encore, diagnostiquer l'identité/store OWASYS à partir de preuve runtime ;
6. compléter ensuite couverture Profiler des refus métier si nécessaire.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO SECRET IN ARGV.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
