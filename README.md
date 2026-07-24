# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate

Lire dans cet ordre :

1. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_SPEC.md`
3. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF6_COMPOSER_AUTOLOAD_CALLBACK_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

## Priorité active

```text
OPUS = framework générique
OWASYS = application construite avec OPUS
pages OWASYS = frontend SCORE
REST + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

OPUS n'est pas une application.

## Source de vérité

- OPUS : `philstephibanez-wq/OPUS`, branche `master`
- head relu : `96884961248fc82bf5e13187a6ffcfffacb82d9f`
- workspace : `philstephibanez-wq/MAESTRO_WORKSPACE`

## Racine OPUS verrouillée

Répertoires admis : `.git`, `.github`, `application`, `Config`, `DOC`, `Opus`, `packages`, `runtime`, `scripts`, `sites`, `tools`, `vendor`.

Fichiers racine admis : `.gitignore`, `AGENTS.md`, `composer.json`, `composer.lock`, `composer.phar`, `LICENSE`, `README.md`.

Interdictions : root `bin/`, root `config/` minuscule, root `public/`, toute nouvelle racine.

## Livrables applicables

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6
```

HF5 est remplacé par HF6 et n'est pas nécessaire sur une base propre.

HF6 :

- ZIP : `opus_owasys_p117u_hf6_composer_autoload_callback.zip`
- SHA-256 : `d482f4b352c958557e63095f5eacb5fdd9fcbb783853dd2c6202c16ccf79505c`
- fichiers : 4

HF6 supprime la dépendance des commandes Composer au chemin relatif `scripts/opus.php`. Composer appelle désormais une classe callback générique OPUS autoloadée. Les alias applicatifs restent déclarés dans la configuration de chaque application.

## OWASYS canonique

- contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE`
- rôle : `standard-opus-application`
- point d'entrée unique : `sites/owasys/www/index.php`
- frontend : pages SCORE actuelles
- backend : API REST sécurisée puis Composer
- Registry et mot de passe : commandes applicatives backend
- log : `sites/owasys/var/logs/rcp-backend.log`
- profiler : `sites/owasys/var/profiler/<trace_id>.json`

## Règles permanentes

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- ONLY THE OWNER-CONFIRMED OPUS ROOT IS ADMITTED.
- COMPOSER EXPOSES USER COMMANDS ONLY.
- OPUS IS A FRAMEWORK, NOT AN APPLICATION.
- OWASYS IS AN APPLICATION BUILT WITH OPUS.
- NO OWASYS BUSINESS IMPLEMENTATION UNDER `Opus/`.
- REST + COMPOSER IS THE OWASYS BACKEND.
- LOGGER AND PROFILER ARE MANDATORY.
- SCORE AND BACKEND-FIRST ARE MANDATORY.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.

## Feuille de route

1. appliquer HF6 après HF4 ;
2. régénérer l'autoload Composer ;
3. démarrer le backend REST puis vérifier son status ;
4. démarrer le frontend OWASYS ;
5. valider Registry, mot de passe, navigateur sans JavaScript, Auth0, HTTPS et bastion ;
6. committer OPUS après acceptation owner ;
7. décider séparément de `sites/owasys_old`.
