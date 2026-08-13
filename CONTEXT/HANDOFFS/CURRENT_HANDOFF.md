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
13. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A22_ROLE_CAPABILITY_MATRIX_2026-08-13.md`
14. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
50d68b724a1f32201bd068e0cb23c9f925780093  opus_p117w_r45d2a20_standard_local_password_role_provisioning
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
```

R45D2A21/B/C et R45D2A22 sont appliqués localement par l’owner mais non considérés publiés tant que l’owner ne les a pas commit/push.

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
- viewer / Construction et validation : lecture OK, mais **divergence** : lien global `OPUS Profiler` visible alors que `viewer` doit être refusé.

## Cause confirmée

Le template Build ne contient pas ce lien. La cause est partagée :

- `default/layouts/layout.score` affiche le lien Profiler sans garde ACL ;
- `OwasysScorePageRenderer` calcule la visibilité depuis `?profiler=1` sans capacité `profiler:view` ;
- le endpoint de trace possède déjà une garde ACL ;
- un refus ACL remontant au composition root doit être rendu en HTTP 403, pas 500.

## Livrable actif — R45D2A22B

```text
ZIP     : opus_p117w_r45d2a22b_profiler_acl_presentation_guard.zip
SHA-256 : 7baa608c1a5c305d6d69cb8e7973de8b3f44e3f1d2c037a68e71def010db79b8
PREREQ  : R45D2A22 appliqué ; R45D2A21C local
FILES   : 2
```

R45D2A22B traite la cause au niveau partagé : session + RuntimeSecurity injectés dans le renderer, `profiler.allowed` dérivé de l’ACL, lien/iframe SCORE conditionnés, query directe refusée, erreurs ACL de composition mappées HTTP 403.

## Gate immédiat

1. appliquer R45D2A22B ;
2. exiger :

```text
OPUS_R45D2A22B_APPLIED
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

3. viewer : recharger Build, le lien `OPUS Profiler` doit être absent ;
4. viewer : tester `/fr-FR/build?profiler=1`, exiger HTTP 403 sans Profiler ;
5. viewer : vérifier ensuite Compte / changement de son propre mot de passe.

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
