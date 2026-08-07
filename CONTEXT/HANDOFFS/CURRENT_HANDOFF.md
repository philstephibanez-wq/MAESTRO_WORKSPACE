# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-07

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_2026-08-06.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_2026-08-06.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_2026-08-06.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_2026-08-06.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B4_PROFILER_ENVIRONMENT_CONFIG_2026-08-07.md`
12. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B4_PROFILER_ENVIRONMENT_CONFIG_2026-08-07.md`
13. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `6be07a76e20dfeea09b51c7c016083da626bf974`.

R45B3 est acquis au commit `6be07a76e20dfeea09b51c7c016083da626bf974` (`opus_p117w_r45b3_rest_client_contract`). R45B4 doit être appliqué exclusivement sur ce HEAD.

R46 `dev-server --site=` reste abandonné. Le contrat positionnel reste :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_r45b4_profiler_environment_config.zip
SHA-256 : e67034362a664b78c0b993f46c358c9dea5e9a7b4b8747fc14b6dc0a0e23da16
FILES   : 9
BASE    : 6be07a76e20dfeea09b51c7c016083da626bf974
STATUS  : livré, application, validation, commit et push owner requis
```

Le ZIP est strictement différentiel et ne contient aucun smoke, audit, rapport, log, cache, vendor ou temporaire.

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b4_profiler_environment_owner.php
SHA-256 : 65aaa0dfc8adf171db262383452f0fc1b3914568d9d4997ce73d899c061f50a9
OUTPUT  : OPUS_P117W_R45B4_SMOKE_OK
```

Le smoke n'est pas destiné à être committé dans OPUS. Il audite avec `token_get_all()` toutes les classes concrètes sous `Opus/**/*.php`, en plus du contrat R45B4.

## Cible R45B4

- configuration `config/environment.yaml` lue par `File` + `StructuredFileLoader` ;
- collecte, Web Profiler et liens pilotés séparément ;
- Web Profiler autorisé uniquement en environnement exact `dev` ;
- `ProfilerLinkProvider` générique injectant `diagnostics.profiler_*` ;
- URL `/_opus/profiler/trace/{trace_id}` ;
- route directe disponible avec `web.enabled=true` même si `links=false` ;
- vraie 404 lorsque le Web Profiler n'est pas enregistré ;
- aucun `OPUS_ENV` ni `accessGranted` dans `WebProfilerController` ;
- aucun contrôleur/vue/fournisseur Web Profiler instancié lorsqu'il n'est pas enregistré ;
- aucune route/FSM/ACL/I18n/template/CSS Profiler propre au site généré ;
- layout SCORE limité au slot générique `diagnostics.profiler_available` ;
- configuration générée commentée en YAML ;
- aucune correction locale de `test7` ou d'un autre site existant.

## Prévalidation assistant

- neuf fichiers PHP du ZIP : `php -l` OK ;
- harnais local : `R45B4_LOCAL_HARNESS_OK` ;
- audit `token_get_all()` du smoke : test synthétique `AUDIT_OK` ;
- contrôle du ZIP : neuf fichiers complets, aucune pollution interdite.

L'autoload optimisé et le smoke exhaustif sur le dépôt OPUS réel restent obligatoires côté owner avant conformité.

## Validation owner obligatoire

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip" SHA256
certutil -hashfile "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b4_profiler_environment_config.zip"
composer dump-autoload -o
copy /Y "%USERPROFILE%\Downloads\smoke_opus_p117w_r45b4_profiler_environment_owner.php" "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
php smoke_opus_p117w_r45b4_profiler_environment_owner.php
del /Q "H:\OPUS\smoke_opus_p117w_r45b4_profiler_environment_owner.php"
```

Attendu :

```text
OPUS_P117W_R45B4_SMOKE_OK
```

Puis générer un nouveau site via OWASYS et valider `links=false`, `links=true`, accès direct en `dev`, refus d'activation Web en production et HTTP 404 lorsque le Web Profiler est absent.

Commit et push OPUS uniquement par l'owner après succès.

## Suite après acquisition

R45C : wizard OWASYS structuré.

Puis R45D : administration Sécurité.

NO PROFILER WEB OUTSIDE DEV.
NO SITE-OWNED PROFILER ROUTE/FSM/ACL/TEMPLATE.
NO OPUS_ENV GATE IN WEB CONTROLLER.
NO SMOKE IN OPUS ZIP.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L’ASSISTANT.
