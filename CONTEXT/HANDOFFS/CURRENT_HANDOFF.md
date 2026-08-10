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
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A3_GENERATED_LOGIN_OBSERVABILITY_2026-08-10.md`
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A3_GENERATED_LOGIN_OBSERVABILITY_2026-08-10.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
```

R45D2A2 est publié. `f634e337...` supprime le site diagnostique `essai` et conserve `essai2`.

## Clarification Sécurité / Identités

La vue **Sécurité > Identités** d'OWASYS affiche les identités de l'application cible sélectionnée, pas les comptes OWASYS.

```text
acteur OWASYS       -> compte connecté à owasys-front ; réauthentifie les mutations
identité cible      -> provider + subject dans l'application sélectionnée
```

Pour `essai2`, le screenshot owner montre :

```text
subject  = steve
provider = local-password
status   = active
role     = admin
source   = runtime.local-password
```

Cela prouve que le store runtime `local-password` contient le credential de `steve`. Cela ne prouve pas qu'un password navigateur a déjà été vérifié avec succès.

`Référencer une identité` référence un couple `provider + subject` pour l'application cible. Il ne crée pas de compte externe et ne fixe aucun password.

`Saisissez à nouveau votre mot de passe OWASYS` demande le password de l'acteur OWASYS courant, jamais celui de `steve`.

## Profiler `.lock`

Le `.lock` persistant reste normal : sidecar de synchronisation, pas trace, pas verrou OS nécessairement détenu.

```text
NO PROFILER LOCK PURGE.
```

## Livrable actif — R45D2A3

```text
ZIP     : opus_p117w_r45d2a3_generated_login_observability.zip
SHA-256 : bfbc032c7e8e5147905e48035dda6208d924de5d5d0b0ff8e5ebb5f6ffaf05e3
BASE    : f634e337ec0b5df0020bfba6eb240da0395a05bd
FILES   : 1
```

R45D2A3 traite la perte d'observabilité du login généré : `GeneratedSiteRuntime::handleLogin()` absorbait toute erreur SSO et ne produisait aucun événement Logger/Profiler permettant de distinguer credential invalide, store invalide ou provider invalide.

Le correctif :

- conserve le comportement SSO/ACL ;
- corrèle `security.sso/authentication.succeeded` et `security.sso/authentication.failed` ;
- journalise uniquement provider, locale et code d'erreur normalisé ;
- n'enregistre aucun username, password, hash, POST brut, token ou secret ;
- ne modifie aucun fichier `sites/essai2` ;
- ne touche pas au Profiler `.lock`.

Fichier :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
```

## Gate owner immédiat

1. HEAD exact `f634e337...` et working tree propre ;
2. extraire R45D2A3 ;
3. lint + dump-autoload + diff-check ;
4. relancer `essai2` ;
5. login avec username `steve` et exactement le password provisionné pour `essai2/steve` ;
6. ne pas utiliser le password admin OWASYS sur la page login de `essai2` ;
7. si l'échec persiste, récupérer le code corrélé `security.sso/authentication.failed` dans Logger/Profiler ;
8. corriger ensuite uniquement la cause prouvée ;
9. reprendre R45D2 preview/commit avec le password admin OWASYS pour la réauthentification OWASYS.

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
NO SECRET IN LOGS/PROFILER.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
