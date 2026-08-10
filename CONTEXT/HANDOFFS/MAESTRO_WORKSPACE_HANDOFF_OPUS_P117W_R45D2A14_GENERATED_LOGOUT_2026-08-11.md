# HANDOFF — OPUS P117W R45D2A14 GENERATED LOGOUT

Date : 2026-08-11

## Base canonique

`philstephibanez-wq/OPUS` master : `186517fd37c14047e33308500d0699b8ac36ab44` (`opus_p117w_r45d2a12_source_acl_ui_truth`).

## États acquis owner

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- Profiler intégré/repliable et corrélation login : acquis ;
- R45D2A12 ACL/UI Sources/Git publié.

## Nouveau besoin owner

Une fois connecté à `essai2`, aucune déconnexion propre n'est disponible.

## Cause

Le site généré ne possède aucune route `/logout`, et `GeneratedSiteRuntime` n'implémente aucun traitement de logout/session destroy.

## Livrable actif — R45D2A14

```text
ZIP     : opus_p117w_r45d2a14_generated_logout.zip
SHA-256 : 2bdfb59b45b54a903722d5a2b63c5ecfc573c4eacb78049fbda3e0d4a88e0dbb
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 3
```

R45D2A14 supersède R45D2A13 et inclut sa migration `opus-alert`.

Fonctions :

- `POST /logout` uniquement ;
- CSRF single-use scoped ;
- formulaire SCORE `Déconnexion` pour identité session/local-password authentifiée ;
- destruction session + expiration cookie ;
- redirection 303 vers login localisé ;
- événement Logger/Profiler `security.sso.logout.succeeded` ;
- I18n UE + ukrainien ;
- migration générique de tous les sites Composer générés avec login ;
- aucun faux logout local pour Auth0 proxy.

## Gate immédiat

```text
php tools/r45d2a14_apply_generated_logout.php
php tools/smoke_r45d2a14_generated_logout.php
php -l Opus/Application/Runtime/GeneratedSiteRuntime.php
php -l Opus/Scaffold/SiteScaffoldPlan.php
composer dump-autoload -o
composer opus:dev-server -- essai2
```

Validation : connecté à `essai2`, `Déconnexion` visible ; activation => POST CSRF, session supprimée, `/fr/login`; `/fr` requiert de nouveau une authentification.

NO SITE-SPECIFIC PATCH.
NO GET LOGOUT.
NO ACL/SSO RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
