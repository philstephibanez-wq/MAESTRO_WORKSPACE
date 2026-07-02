# OPUS Manager - Auth I18N finalize

Contrat : `OPUS_MANAGER_AUTH_I18N_FINALIZE_CORE`

## Objectif

Finaliser la brique OPUS Manager auth/sign-in/logout/i18n restee dirty dans `H:\OPUS`.

## Portee

- router auth-aware
- SignInController
- LogoutController
- OpusManagerAuth
- OpusManagerEnvironment
- OpusManagerI18n
- config languages
- shell sans repetition `Langue : ...`
- prod sans profiler/debug activable par URL

## Regles

- Sign in dev : `admin / admin`.
- Le selecteur de langue suffit.
- `uk` est le code ukrainien, jamais `ua`.
- `/opus-manager/login` et `/opus-manager/signin` redirigent vers `/opus-manager/sign-in`.
- Les routes OPUS Manager protegees redirigent vers Sign in si non connecte.
- Les controllers restent separes par fonctionnalite.

## Smokes attendus

- `OPUS_MANAGER_AUTH_I18N_FINALIZE_CORE_SMOKE_OK`
- `OPUS_MANAGER_SHELL_AUTH_PROD_I18N_CORE_SMOKE_OK`
- `OPUS_MANAGER_CONTROLLER_SHELL_REUSE_CORE_SMOKE_OK`
- `OPUS_MANAGER_CREATE_SITE_TECH_TYPE_FIRST_CORE_SMOKE_OK`

## Etat cible

Apres commit/push OPUS, `H:\OPUS` doit revenir propre sur `master...origin/master`.
