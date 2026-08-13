# OPUS P117W R45D2A22C1 — ACL DENIED VISUAL ERROR INSTALLER FIX

Date : 2026-08-13

## Cause

Le livrable R45D2A22C est fonctionnellement correct dans son intention, mais son applicateur et son smoke contiennent des chaînes PHP à guillemets doubles qui interpolent par erreur des variables destinées à être recherchées littéralement dans `Application.php`.

Défauts observés owner :

- applicateur : interpolation de `$message` et `$current` ;
- smoke : interpolation de `$parts` ;
- conséquence : `OPUS_R45D2A22C_SAFE_ACL_CODE_TARGET_INVALID` avant toute écriture ;
- `git status --short` reste vide ;
- R45D2A22B et R45D2A22 restent validés.

## Contrat C1

R45D2A22C1 corrige uniquement le livrable d'installation/test de R45D2A22C :

1. chaînes de recherche PHP rendues littérales avec nowdoc ou chaînes non interpolées ;
2. smoke sans interpolation de `$parts` ;
3. préflight complet avant la première écriture ;
4. écriture des fichiers seulement après validation de tous les catalogues I18n ;
5. conservation du contrat R45D2A22C : page SCORE graphique HTTP 403, ressource/action, locale de requête, trace repliée, 25 langues de base ;
6. aucune modification de décision ACL ;
7. aucun hardcode `viewer` ;
8. aucun JavaScript.

## Livrable

```text
ZIP     : opus_p117w_r45d2a22c1_acl_denied_visual_error_installer_fix.zip
SHA-256 : 50bec2004a29e5fdaa71f12664bea8be542cbfe734f7800e6ca2c948a634e7b6
PREREQ  : R45D2A22B appliqué ; R45D2A22C non appliqué
FILES   : 3
```

## Gate

```text
OPUS_R45D2A22C1_APPLIED locales=25
OPUS_R45D2A22C1_ACL_DENIED_VISUAL_ERROR_OK locales=25
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis, avec le rôle `viewer` :

- `/fr-FR/build?profiler=1` doit répondre HTTP 403 ;
- la page doit être graphique et afficher `Accès refusé` ;
- ressource `profiler` ;
- action `view` ;
- détails techniques repliés ;
- retour vers `/fr-FR/build` ;
- le lien Profiler reste absent sur Build normal.
