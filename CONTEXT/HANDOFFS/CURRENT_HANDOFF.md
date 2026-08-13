# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19D_CREDENTIAL_OWNERSHIP_ATOMIC_CLEANUP_2026-08-11.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A20_STANDARD_LOCAL_PASSWORD_ROLE_PROVISIONING_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A21_SECURITY_VISUAL_WORKSPACE_2026-08-12.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A21B_SECURITY_VISUAL_DASHBOARD_2026-08-13.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A21C_SECURITY_COMPACT_COCKPIT_2026-08-13.md`
12. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A22_ROLE_CAPABILITY_MATRIX_EXECUTABLE_CONTRACT_2026-08-13.md`
13. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A22C1_ACL_DENIED_VISUAL_ERROR_INSTALLER_FIX_2026-08-13.md`
14. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A22C1_ACL_DENIED_VISUAL_ERROR_INSTALLER_FIX_2026-08-13.md`
15. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
50d68b724a1f32201bd068e0cb23c9f925780093  opus_p117w_r45d2a20_standard_local_password_role_provisioning
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
```

R45D2A21/B/C, R45D2A22, R45D2A22B/C1 sont locaux tant que l’owner ne les a pas commit/push.

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable/corrélé pour rôles autorisés ;
- logout généré acquis ;
- Security Preview + Commit admin/developer acquis ;
- R45D2A20 publié : provisioning local-password par rôle ;
- R45D2A21/B/C locaux ; gate visuel R45D2A21C accepté ;
- R45D2A22 validé : `OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42` ;
- compte runtime `viewer` provisionné avec rôle `viewer` ;
- viewer / Sécurité validé en lecture seule ;
- viewer / Sources et Git validé en lecture seule ;
- viewer / Construction et validation : lecture OK ;
- R45D2A22B : accès direct `/fr-FR/build?profiler=1` correctement refusé par ACL ;
- présentation brute `OPUS_ACL_DENIED` à améliorer ;
- première tentative R45D2A22C non appliquée : défaut dans les scripts du livrable, pas dans OPUS ;
- après échec C : `git status --short` vide, smoke B et matrice A22 toujours OK.

## Cause R45D2A22C1

Le livrable C utilisait des chaînes PHP à guillemets doubles pour rechercher du code contenant `$message`, `$current` et `$parts`.

Ces variables ont été interpolées par l’applicateur/smoke eux-mêmes, produisant :

```text
Undefined variable $message
Undefined variable $current
OPUS_R45D2A22C_SAFE_ACL_CODE_TARGET_INVALID
```

Le défaut est strictement dans le ZIP C.

## Livrable actif — R45D2A22C1

```text
ZIP     : opus_p117w_r45d2a22c1_acl_denied_visual_error_installer_fix.zip
SHA-256 : 50bec2004a29e5fdaa71f12664bea8be542cbfe734f7800e6ca2c948a634e7b6
PREREQ  : R45D2A22B appliqué ; R45D2A22C non appliqué
FILES   : 3
```

C1 :

- rend les chaînes de recherche littérales, sans interpolation ;
- corrige le smoke `$parts` ;
- ajoute un garde de non-régression sur ces constructions ;
- effectue tout le préflight avant la première écriture ;
- conserve le rendu ACL Denied graphique SCORE, HTTP 403, ressource/action, locale et I18n 25 langues ;
- ne change aucune décision ACL.

## Gate immédiat

Exiger :

```text
OPUS_R45D2A22C1_APPLIED locales=25
OPUS_R45D2A22C1_ACL_DENIED_VISUAL_ERROR_OK locales=25
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis viewer :

1. retester `/fr-FR/build?profiler=1` ;
2. exiger page graphique `Accès refusé`, ressource `profiler`, action `view`, HTTP 403, détails techniques repliés ;
3. revenir sur Build normal et vérifier que le lien Profiler reste absent ;
4. poursuivre ensuite viewer / Compte.

## Suite seulement après gate viewer complet

Si conforme : backend atomique **Modifier/Supprimer utilisateur ou agent**, puis exposition UI seulement après support backend preview/fresh-auth/commit/rollback.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO VIEWER PROFILER.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO CSS-ONLY HIDING.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
