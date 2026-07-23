# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate

Lire dans cet ordre :

1. `README.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/SPECIFICATIONS/OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`
4. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OWASYS_CANONICAL_REST_COMPOSER_P117U_2026-07-23.md`
5. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
6. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

## Priorité active

OWASYS P117U : conserver les pages SCORE actuelles comme frontend et fournir leur backend sécurisé REST + Composer sans mélanger OPUS, OWASYS et les sites générés.

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
- OPUS local owner : `H:/OPUS`, détail local sans valeur distributive

## Racine OPUS verrouillée

Répertoires admis uniquement :

`.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Fichiers racine admis uniquement :

`.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Interdictions : root `bin/`, root `config/` minuscule, root `public/`, toute nouvelle racine.

## Livrable actif

- ZIP : `opus_owasys_p117u_canonical_rest_composer.zip`
- SHA-256 : `1ee231cbcbe9e5a4578aa6f50b7a83559f89b46f6916e93f682c50f360401e46`
- fichiers : 55
- entrées de premier niveau : `composer.json`, `Opus`, `scripts`, `sites`

P117S et P117T sont rejetés. P117T a violé la racine avec `bin/` et `config/` minuscule.

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
- SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## Feuille de route

1. appliquer P117U sur une base OPUS propre ;
2. valider Composer/autoload et les recettes existantes hors aliases Composer ;
3. démarrer backend REST et frontend OWASYS ;
4. valider Registry, mot de passe, navigateur sans JavaScript, Auth0, HTTPS et bastion ;
5. committer OPUS après acceptation owner ;
6. décider séparément de `sites/owasys_old` ;
7. Démo officielle, User Book, Reference Book, LSTSAR, KB.
