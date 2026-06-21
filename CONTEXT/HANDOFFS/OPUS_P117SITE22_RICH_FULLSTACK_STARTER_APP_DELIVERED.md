# Handoff — OPUS P117SITE22 rich fullstack starter app

## État

P117SITE22 est livré sur GitHub côté OPUS et workspace.

## Décision clé

Le starter généré doit montrer une vraie application OPUS fullstack, riche, navigable et testable avec le serveur interne PHP.

## Ce qui a été ajouté

- Frontend riche : views, layouts, sections, navigation, composants OPUS standards, langues.
- Middle visible : routes, API contracts, security pipeline, FSM gate.
- Backend visible : module Catalog, actions, services, repositories, endpoint API, runners/jobs/dto.
- Endpoint `/api/catalog`.
- Routes HTML : `/`, `/architecture`, `/catalog`, `/catalog/module-catalog`, `/components`, `/security`, `/backoffice`, `/documentation`.
- Langues : `fr`, `en`, `es`.

## Tests à faire

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\smoke_p117site22_rich_fullstack_starter_app.py
```

Puis test visuel :

```cmd
cd /d H:\OPUS
if exist sites\demo-rich-fullstack rmdir /s /q sites\demo-rich-fullstack
composer opus:create-application -- demo-rich-fullstack --write --serve --port 8791
```

Ouvrir :

- `http://127.0.0.1:8791/`
- `http://127.0.0.1:8791/architecture?lang=en`
- `http://127.0.0.1:8791/catalog?lang=fr`
- `http://127.0.0.1:8791/catalog/module-catalog?lang=es`
- `http://127.0.0.1:8791/api/catalog?lang=en`

## Cleanup après test

Arrêter le serveur avec `Ctrl+C`, puis :

```cmd
cd /d H:\OPUS
if exist sites\demo-rich-fullstack rmdir /s /q sites\demo-rich-fullstack
git status --short
```
