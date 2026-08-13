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
12. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A21C_SECURITY_COMPACT_COCKPIT_2026-08-13.md`
13. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
50d68b724a1f32201bd068e0cb23c9f925780093  opus_p117w_r45d2a20_standard_local_password_role_provisioning
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
```

R45D2A21 et R45D2A21B sont appliqués localement mais pas déclarés publiés tant que l’owner ne les a pas commit/push.

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélé ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer contractuelle ;
- Security Preview + Commit admin et developer acquis ;
- break-glass local-password acquis ;
- aucun mot de passe local ne traverse REST ;
- R45D2A20 publié : provisioning local-password par rôle pour application OPUS standard ;
- R45D2A21 appliqué localement : `identity_type=user|agent`, legacy `unknown` ;
- R45D2A21B appliqué localement : dashboard graphique fonctionnel.

## Retour owner R45D2A21B

Retour : **« C'est un peu mieux »**.

La direction graphique est conservée, mais le formulaire d’ajout ouvert prend encore presque tout le premier viewport. Les panneaux Utilisateurs / Agents sont repoussés sous la ligne de flottaison et les métriques `0 / 0` ne rendent pas visible la présence des identités legacy.

## Livrable actif — R45D2A21C

```text
ZIP     : opus_p117w_r45d2a21c_security_compact_cockpit.zip
SHA-256 : 5072d4f5b0e9f2b6ffdbda00f6a16c07df225747ac2b7cc6a3c08bbbc4bd3cd2
PREREQ  : R45D2A21B appliqué
FILES   : 2 scripts PHP
```

R45D2A21C :

- compacte encore le dashboard ;
- ajoute la métrique `À classifier` si nécessaire ;
- remplace le grand formulaire ouvert par deux quick-actions repliées Utilisateur / Agent ;
- fixe explicitement `identity_type=user|agent` dans chaque action ;
- met provider sous Détails techniques, prérempli et modifiable ;
- rend Utilisateurs / Agents toujours visibles en panneaux ;
- conserve `À classifier` secondaire et compact ;
- ne change ni backend, ni FSM, ni fresh-auth, ni ACL ;
- SCORE/CSS uniquement, aucun JS/Mermaid runtime.

## Gate immédiat

1. extraire R45D2A21C après R45D2A21B ;
2. lancer l’applicator ;
3. exiger `OPUS_R45D2A21C_APPLIED` ;
4. lancer le smoke ;
5. exiger `OPUS_R45D2A21C_SMOKE_OK` ;
6. `composer dump-autoload -o` ;
7. `git status --short` ;
8. redémarrer front/back ;
9. ouvrir Sécurité comme developer ;
10. juger le premier viewport avant toute nouvelle fonction.

## Suite seulement après validation visuelle

1. gate viewer ACL ;
2. smoke complet admin/developer/viewer front+back ;
3. mutations backend atomiques Modifier/Supprimer utilisateur ou agent ;
4. exposition UI seulement après support backend réel.

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
