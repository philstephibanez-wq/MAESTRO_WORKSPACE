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
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A5_GENERATED_PROFILER_IFRAME_INTEGRATION_2026-08-10.md`
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A5_GENERATED_PROFILER_IFRAME_INTEGRATION_2026-08-10.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
```

R45D2A3 est publié. R45D2A4 n'est pas la nouvelle cible UI : son lien direct est supersédé par R45D2A5.

## Preuves owner courantes

- ignorer explicitement la déclaration retirée « Prévisualiser casse OWASYS » ;
- `essai2` affiche `/fr/login` mais refuse encore la connexion navigateur ;
- `steve` existe dans la sécurité cible avec `provider=local-password`, `status=active`, `role=admin`, `source=runtime.local-password` ;
- le Web Profiler fonctionne et une trace est consultable ;
- le lien Profiler remplace actuellement la page applicative par `/_opus/profiler/trace/<trace_id>` ;
- le comportement attendu est page conservée + Profiler embarqué dans un iframe ;
- `.lock` Profiler persistant reste normal et ne doit pas être purgé.

## Identités

La vue **Sécurité > Identités** concerne l'application cible sélectionnée, pas les comptes OWASYS.

```text
acteur OWASYS  -> authentifie et réauthentifie les mutations OWASYS
identité cible -> provider + subject dans l'application sélectionnée
```

`Référencer une identité` ne fixe aucun mot de passe. Le champ de réauthentification demande le password OWASYS de l'acteur courant.

## Login essai2

R45D2A3 journalise :

```text
security.sso / authentication.succeeded
security.sso / authentication.failed
```

sans username/password/hash/POST brut.

La capture Profiler fournie après l'échec montre une trace avec `1` erreur mais `Security / ACL / SSO = 0`. Cette trace seule ne prouve donc pas la cause du POST de connexion. Aucun patch SSO supplémentaire ne doit être inventé avant obtention de l'`error_code` corrélé du POST `steve`.

## Cause de la navigation Profiler

La route Web Profiler autonome est correcte. La régression UX est générique : la surface générée expose `diagnostics.profiler_url` comme lien direct ; le navigateur quitte alors la page applicative.

R45D2A5 conserve la route autonome comme source same-origin et compose son rendu dans un iframe SCORE à l'intérieur de la page courante. Le flag hérité de lien est neutralisé dans le ViewModel après composition pour supprimer la navigation-away des layouts déjà générés.

## Livrable actif — R45D2A5

```text
ZIP     : opus_p117w_r45d2a5_generated_profiler_iframe_integration.zip
SHA-256 : 9ee324fae8a26f6d5083951cfc182c9d9709fb2f874e91747cbf29f8508d74bd
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 3
```

Fichiers :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/ProfilerConfiguration.php
```

R45D2A5 :

- aucun fichier spécifique `sites/essai2` ;
- surface Profiler intégrée via SCORE ;
- iframe same-origin de la trace courante ;
- page applicative conservée ;
- compatibilité dev des sites générés existants via `OPUS_ENV=dev` ;
- ACL/SSO/FSM inchangés ;
- sidecars `.lock` inchangés.

## Gate owner immédiat

1. HEAD GitHub/base exact `dfab7d0...` ;
2. appliquer R45D2A5 ;
3. lint + `composer dump-autoload -o` + `git diff --check` ;
4. relancer preview/dev-server `essai2` ;
5. vérifier que `/fr/login` reste visible et que le Profiler apparaît dans l'iframe de la même page ;
6. tenter login avec `steve` et exactement le password provisionné pour `essai2/steve` ;
7. dans l'iframe de la réponse d'échec, lire `Security / ACL / SSO` et l'`error_code` de `authentication.failed` ; à défaut lire les dernières lignes de `sites/essai2/var/logs/essai2.log` ;
8. corriger ensuite uniquement la cause SSO prouvée ;
9. reprendre R45D2 preview/commit avec le password admin OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET IN LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
