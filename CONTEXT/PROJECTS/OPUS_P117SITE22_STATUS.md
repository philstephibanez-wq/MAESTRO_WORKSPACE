# OPUS P117SITE22 — Rich fullstack starter app

Status: DELIVERED

## Objectif

Créer une application OPUS générée suffisamment riche pour être testée visuellement avec le serveur interne PHP :

- plusieurs views frontend ;
- plusieurs routes HTML ;
- langues FR / EN / ES ;
- un module backend démonstratif `Catalog` ;
- une couche `middle/` visible avec routes, API contracts, security pipeline, FSM gate ;
- un endpoint API testable `/api/catalog` ;
- une page backoffice montrant clairement que backoffice ≠ backend ;
- aucun vocabulaire blog/CMS standard.

## Commits OPUS livrés

- `1711532d6bf1257ccbbaff13afa20581f8153298` — `P117SITE22_RICH_FULLSTACK_STARTER_APP`
- `606cc30cc3cc45a212a7f8fee41f610331907a18` — `P117SITE22_RICH_FULLSTACK_STARTER_APP_DOC`
- `f738b1d6ccdf1360e88d3d0d14939ade2efd40d3` — `P117SITE22_RICH_FULLSTACK_STARTER_APP_SMOKE`
- `04d6afa610ca15d3815fd0510a90393e19f22448` — `P117SITE22_KEEP_P117SITE21_SMOKE_COMPATIBLE`
- `ea816a7b7aed07ca0b4d7ec15a6452b4409c553c` — `P117SITE22_KEEP_P117SITE20_SMOKE_COMPATIBLE`

## Fichiers OPUS concernés

- `framework/Opus/Scaffold/FullstackApplicationScaffoldPlan.php`
- `DOC/P117SITE22_RICH_FULLSTACK_STARTER_APP.md`
- `tools/smoke_p117site22_rich_fullstack_starter_app.py`
- `tools/smoke_p117site20_create_application_fullstack_skeleton.py`
- `tools/smoke_p117site21_create_site_application_alias.py`

## Test automatisé attendu

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\smoke_p117site20_create_application_fullstack_skeleton.py
python tools\smoke_p117site21_create_site_application_alias.py
python tools\smoke_p117site22_rich_fullstack_starter_app.py
```

## Test visuel attendu

```cmd
cd /d H:\OPUS
if exist sites\demo-rich-fullstack rmdir /s /q sites\demo-rich-fullstack
composer opus:create-application -- demo-rich-fullstack --write --serve --port 8791
```

Pages à vérifier :

- `http://127.0.0.1:8791/`
- `http://127.0.0.1:8791/architecture?lang=en`
- `http://127.0.0.1:8791/catalog?lang=fr`
- `http://127.0.0.1:8791/catalog/module-catalog?lang=es`
- `http://127.0.0.1:8791/components?lang=fr`
- `http://127.0.0.1:8791/security?lang=fr`
- `http://127.0.0.1:8791/backoffice?lang=fr`
- `http://127.0.0.1:8791/documentation?lang=fr`
- `http://127.0.0.1:8791/api/catalog?lang=en`

## Critères de validation

- Le serveur interne affiche une page riche, non blog/CMS.
- La navigation affiche plusieurs pages.
- Les langues FR / EN / ES sont visibles et opérationnelles.
- Le module backend `Catalog` alimente plusieurs views.
- `/api/catalog` répond en JSON avec `OPUS_API_RESPONSE_V1`.
- `frontend/`, `middle/`, `backend/` sont visibles dans l’application générée.
- `git status --short` est clean après cleanup.
