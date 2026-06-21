# OPUS — Front / Middle / Back application contract

## Décision

Une application OPUS est un site/projet fullstack autonome basé sur le framework OPUS, avec séparation obligatoire :

```text
Application OPUS
├── frontend  = représentation
├── middle    = routage, transport, sécurité, contrats request/response
└── backend   = traitement métier, données, runners, jobs, intégrations
```

## Règles

- `frontend/` contient les views, layouts, sections, composants custom éventuels, navigation, API clients, assets et thème.
- `middle/` contient les routes, contrats API, pipeline de sécurité, ACL/SSO placeholders, FSM gates, audit, rate limit, transport request/response.
- `backend/` contient les modules métier, actions, services, repositories, validators, policies, API endpoints, runners, jobs, DTO et viewmodels.
- OPUS possède les composants standards : Menu, Form, Input, Button, Card, Table, List, etc.
- Une application ne possède que ses composants custom éventuels.
- Form est un composant placé dans une section.
- Menu est un composant standard de navigation.
- Une view est composée de sections arrangées par un layout.
- Le backend ne rend pas de HTML.
- Le frontend ne contient pas de logique métier.
- Le backoffice n’est pas le backend : c’est un frontend spécialisé.
- Les API request/response sont la frontière stricte entre représentation et traitement.

## Objectif architectural

OPUS doit forcer le développement :

```text
secure by design
clean by design
```

Cela signifie que la structure générée doit rendre difficile ou impossible le mélange entre représentation, transport sécurisé et métier.

## Paliers associés

- P117SITE20 : création d’une application fullstack frontend/backend.
- P117SITE21 : `create:site` devient alias de `create:application`.
- P117SITE22 : starter riche visible au navigateur, avec front/middle/back, langues, plusieurs views, un module backend et une API.
