# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A3_GENERATED_LOGIN_OBSERVABILITY_2026-08-10.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A4_GENERATED_PROFILER_LINK_DEV_POLICY_2026-08-10.md`
9. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A4_GENERATED_PROFILER_LINK_DEV_POLICY_2026-08-10.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
```

R45D2A3 est publié.

## Preuves owner courantes

- ignorer explicitement la déclaration retirée « Prévisualiser casse OWASYS » ;
- `essai2` affiche sa page `/fr/login` mais refuse encore la connexion navigateur ;
- `steve` existe dans la sécurité cible avec `provider=local-password`, `status=active`, `role=admin`, `source=runtime.local-password` ;
- aucun lien Profiler n'est visible sur `/fr/login` ;
- `.lock` Profiler persistant reste normal et ne doit pas être purgé.

## Identités

La vue **Sécurité > Identités** concerne l'application cible sélectionnée, pas les comptes OWASYS.

```text
acteur OWASYS  -> authentifie et réauthentifie les mutations OWASYS
identité cible -> provider + subject dans l'application sélectionnée
```

`Référencer une identité` ne fixe aucun mot de passe. Le champ de réauthentification demande le password OWASYS de l'acteur courant.

## Login essai2

R45D2A3 journalise désormais :

```text
security.sso / authentication.succeeded
security.sso / authentication.failed
```

sans username/password/hash/POST brut. Si le login `steve` échoue encore, le prochain diagnostic doit partir du `error_code` corrélé dans `sites/essai2/var/logs/essai2.log`. Aucun correctif SSO supplémentaire n'est autorisé avant cette preuve.

## Cause du Profiler absent

`sites/essai2/config/environment.yaml` contient :

```text
environment = dev
collect = true
web.enabled = true
web.links = false
```

La valeur `links=false` est produite génériquement par `Opus\Scaffold\ProfilerEnvironmentScaffoldPolicy::environmentYaml()`. `GeneratedSiteRuntime` respecte cette valeur ; le template login n'est pas fautif.

## Livrable actif — R45D2A4

```text
ZIP     : opus_p117w_r45d2a4_generated_profiler_link_dev_policy.zip
SHA-256 : f503525aff801b664a3e3441fb250b202c0839cc1bb4da9a1eb0dc6107b00acb
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 2
```

Fichiers :

```text
Opus/Profiler/ProfilerConfiguration.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
```

R45D2A4 :

- futurs sites générés dev -> `profiler.web.links=true` ;
- sites existants lancés par `opus:dev-server` -> `OPUS_ENV=dev` active le lien si le site est lui-même configuré `environment: dev` ;
- `collect` et `web.enabled` restent obligatoires ;
- production guard inchangée ;
- aucun fichier `sites/essai2` modifié ;
- aucun changement ACL/SSO/FSM.

## Gate owner immédiat

1. appliquer R45D2A4 sur HEAD exact `dfab7d0...` ;
2. lint + `composer dump-autoload -o` + `git diff --check` ;
3. relancer preview/dev-server de `essai2` ;
4. vérifier `OPUS Profiler` visible sur `/fr/login` et trace ouvrable ;
5. tenter login `steve` avec le password provisionné pour `essai2` ;
6. si échec, fournir les dernières lignes de `sites/essai2/var/logs/essai2.log` contenant `security.sso/authentication.failed` ;
7. corriger ensuite uniquement cette cause ;
8. reprendre ensuite R45D2 preview/commit avec le password admin OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET IN LOGS/PROFILER.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
