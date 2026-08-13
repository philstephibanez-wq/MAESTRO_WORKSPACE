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

R45D2A21/B/C et R45D2A22 sont appliqués localement par l’owner mais ne sont pas considérés publiés tant que l’owner ne les a pas commit/push.

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélé ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer contractuelle ;
- Security Preview + Commit admin et developer acquis ;
- break-glass local-password acquis ;
- aucun mot de passe local ne traverse REST ;
- R45D2A20 publié : provisioning local-password par rôle pour application OPUS standard ;
- R45D2A21 local : `identity_type=user|agent`, legacy `unknown` ;
- R45D2A21B local : dashboard graphique ;
- R45D2A21C local : cockpit compact ;
- gate visuel R45D2A21C accepté ;
- **R45D2A22 exécuté avec succès** : `OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42` ;
- `git status --short` vide après extraction et smoke R45D2A22.

## Gate actif — navigateur viewer

Aucun nouveau patch avant ce gate.

1. se déconnecter de `developer` ;
2. se connecter comme `viewer` ;
3. vérifier en haut à droite `viewer · viewer` ;
4. Applications : ouvrir/sélectionner/changer autorisés, création et suppression absentes ;
5. Structure / Sources de données / Workflows / Sécurité : lecture autorisée ;
6. Sécurité : aucun formulaire/bouton de mutation ;
7. Sources et Git : lecture fichiers autorisée, preview/write/stage/stage-all/unstage/commit/restore absents ou refusés ;
8. Construction / validation : lecture autorisée ;
9. Compte : changement de son propre mot de passe disponible ;
10. Profiler : absent et accès direct `?profiler=1` refusé.

## Suite seulement après gate viewer

Si divergence : corriger la cause avant toute autre fonction.

Si conforme : implémenter backend atomique **Modifier/Supprimer utilisateur ou agent**, puis seulement exposer les boutons correspondants.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO JS/MERMAID RUNTIME IN OWASYS.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
