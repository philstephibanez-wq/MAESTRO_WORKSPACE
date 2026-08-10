# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A1_CREATION_SECURITY_INPUT_CANONICALIZATION_2026-08-09.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A2_GENERATED_LOCAL_PASSWORD_RUNTIME_2026-08-09.md`
9. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A2_GENERATED_LOCAL_PASSWORD_RUNTIME_2026-08-09.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2  site: essai pour analyser la génération
e822848896734f92eb2fd631449e625a55aa8e08  opus_p117w_r45d2_controlled_security_mutations
```

R45D2A1 est publié. `01b146...` ajoute le site diagnostique `essai2` généré après R45D2A1.

## Preuves runtime courantes

`essai2` :

```text
fullstack
authentication_required = true
login_page = true
provider = local-password
identity = steve
identity state = password-setup-required
role = admin
```

La racine preview renvoie `OPUS_AUTH_REQUIRED` au lieu de rediriger vers login.

Une mutation R45D2 renvoie `OPUS_SSO_AUTHENTICATION_FAILED`. Les logs corrélés montrent que le POST OWASYS front n'envoie aucun `security/previews` au back ; le back ne reçoit que `security.snapshot` 200. L'échec est donc la fresh reauthentication de l'administrateur OWASYS côté front, pas l'authentification cible `steve`.

## Profiler `.lock` — état définitif

Le `.lock` persistant est normal.

`Opus\Profiler\Profiler` utilise un sidecar stable `<storage>.lock` :

```text
lecture -> LOCK_SH
append/rotation -> LOCK_EX
fin -> LOCK_UN + fclose
```

Le verrou réel est l'état OS du descripteur ouvert. Le fichier `.lock` restant sur disque n'indique pas un verrou encore détenu. Il ne doit pas être supprimé automatiquement et n'est pas une trace Profiler.

Toute ancienne hypothèse indiquant qu'un `.lock` devait disparaître après une requête est annulée.

```text
NO PROFILER LOCK PURGE.
```

## Livrable actif — R45D2A2

```text
ZIP     : opus_p117w_r45d2a2_generated_local_password_runtime.zip
SHA-256 : e9c92966b2fe1206a020134726995ab2ebe85bdb28e74857f241c57fa6bd5b7f
BASE    : 01b146876fd96282dfd0f618dc84341b49d6eec6
FILES   : 6
```

R45D2A2 corrige la cause générique :

- `GeneratedSiteRuntime` redirige une requête anonyme refusée vers la route login localisée lorsque `authentication_required=true` et `login_page=true` ;
- ACL deny-by-default reste inchangée ;
- une route publique ou la route login elle-même n'est pas redirigée ;
- un provisioner OPUS générique crée le credential runtime initial `local-password` uniquement pour une identité déjà onboardée ;
- credential fourni uniquement par STDIN non interactif ;
- aucun password dans Git, argv, REST, logs ou Profiler ;
- store uniquement sous `var/auth/`, écrit via `File::writeAtomic` + `Json` ;
- aucun patch spécifique `sites/essai2`.

Fichiers :

```text
composer.json
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommand.php
Opus/Composer/LocalPasswordCredentialProvisionerComposerCommandInterface.php
Opus/Security/Sso/LocalPasswordCredentialProvisioner.php
Opus/Security/Sso/LocalPasswordCredentialProvisionerInterface.php
```

## Validation assistant R45D2A2

```text
PHP lint                         OK (5)
composer.json JSON               OK
interfaces 4 marqueurs           OK
GeneratedSiteRuntime base blob   exact 166fd209172991e6e0ce2a7833b0ca24f4ba3301
composer.json base blob          exact 1ef3ce15b48c4d0152579aa2cb701bea0d64220d
provisioner synthetic test       OK
overwrite rejection              OK
secret absent result/store       OK
ZIP integrity                    OK, 6 fichiers exacts
```

## Gate owner immédiat

1. HEAD exact `01b146...` et working tree propre ;
2. extraire R45D2A2 ;
3. lint + composer JSON + dump-autoload ;
4. provisionner `essai2/steve` via STDIN sécurisé ;
5. relancer la preview ;
6. racine `essai2` -> HTTP 303 vers login localisé ;
7. login -> home authentifié ;
8. vérifier que `var/auth/local-users.json` reste hors Git ;
9. reprendre R45D2 preview avec le mot de passe de l'**admin OWASYS**, pas celui de `steve` ;
10. si la fresh-auth OWASYS correcte échoue encore, traiter ce défaut séparément à partir de la preuve runtime.

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
