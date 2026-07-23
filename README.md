# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

## Priorité active

```text
OPUS = framework générique
OWASYS = application OPUS
pages OWASYS = frontend
REST + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

## Source de vérité

- OPUS : `philstephibanez-wq/OPUS`, branche `master`
- base P117U : `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- workspace : `philstephibanez-wq/MAESTRO_WORKSPACE`

## Racine OPUS verrouillée

Répertoires admis : `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Fichiers racine admis : `.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Interdictions : root `bin/`, root `config/` minuscule, root `public/`, toute nouvelle racine.

## Livrable actif

- ZIP : `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256 : `43fbcc75384d96b7116d9ee5afe34d997c7b509049bff1b2159f42ee3b43a429`
- fichiers : 57
- octets : 73,261
- entrées de premier niveau : `composer.json`, `Opus`, `scripts`, `sites`

P117S et P117T sont rejetés.

## OWASYS canonique

- contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE`
- rôle : `standard-opus-application`
- point d'entrée unique : `sites/owasys/www/index.php`
- layout : `sites/owasys/application/default/layouts/layout.score`
- Registry et mot de passe : REST puis Composer, côté commande applicative

## Règles permanentes

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
- COMPOSER EXPOSES USER COMMANDS ONLY.
- OPUS IS THE FRAMEWORK.
- OWASYS IS AN OPUS APPLICATION.
- OWASYS PAGES ARE THE FRONTEND.
- REST + COMPOSER IS THE OWASYS BACKEND.
- CREATED SITES ARE INDEPENDENT OPUS APPLICATIONS.
- SCORE AND BACKEND-FIRST ARE MANDATORY.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.

## Feuille de route

1. appliquer P117U sur une base OPUS propre ;
2. supprimer l'ancien layout OWASYS sous `templates` ;
3. valider Composer/autoload et les recettes existantes hors aliases Composer ;
4. démarrer backend REST et frontend OWASYS ;
5. valider Registry, mot de passe, navigateur sans JavaScript, Auth0, HTTPS et bastion ;
6. committer OPUS après acceptation owner ;
7. décider séparément de `sites/owasys_old`.
