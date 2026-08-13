# HANDOFF — OPUS P117W R45D2A22C1

Date : 2026-08-13

## Owner observation

R45D2A22C n'a pas été appliqué.

Sorties :

```text
PHP Warning: Undefined variable $message
PHP Warning: Undefined variable $current
OPUS_R45D2A22C_SAFE_ACL_CODE_TARGET_INVALID
```

Le smoke R45D2A22C présentait également une interpolation involontaire de `$parts`.

Après l'échec :

```text
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
git status --short = vide
```

Conclusion : défaut du livrable, pas régression OPUS.

## Livrable correctif

```text
ZIP     : opus_p117w_r45d2a22c1_acl_denied_visual_error_installer_fix.zip
SHA-256 : 50bec2004a29e5fdaa71f12664bea8be542cbfe734f7800e6ca2c948a634e7b6
FILES   : 3
```

C1 :

- remplace les chaînes interpolées par des chaînes littérales sûres ;
- corrige le smoke ;
- ajoute un garde de non-régression sur les constructions fautives ;
- effectue un préflight complet avant toute écriture ;
- réembarque les traductions pour être autonome.

## Gate immédiat

1. extraire C1 ;
2. linter applicateur + smoke ;
3. appliquer C1 ;
4. linter `Application.php` ;
5. exécuter smoke C1 ;
6. réexécuter smoke B puis matrice A22 ;
7. retester viewer `/fr-FR/build?profiler=1` ;
8. valider le rendu graphique ;
9. vérifier Build normal sans lien Profiler ;
10. seulement ensuite poursuivre viewer / Compte.

Aucun commit/push OPUS/OWASYS par l'assistant.
