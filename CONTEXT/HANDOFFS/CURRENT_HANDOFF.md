# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-12

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
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A21_SECURITY_VISUAL_WORKSPACE_2026-08-12.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
50d68b724a1f32201bd068e0cb23c9f925780093  opus_p117w_r45d2a20_standard_local_password_role_provisioning
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
```

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélé ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer contractuelle ;
- dev-server single-owner acquis ;
- catalogues REST/fresh-auth/Security Mutation FSM acquis ;
- admin Security Preview + Commit acquis ;
- break-glass local-password et changement forcé de mot de passe acquis ;
- aucun mot de passe local ne traverse REST ;
- R45D2A19D publié : ancien flux backend password supprimé atomiquement ;
- R45D2A20 publié : provisioning local-password par rôle pour application OPUS standard ;
- compte `developer` opérationnel ;
- developer Security Preview + Commit acquis.

## Décisions UX Sécurité acquises

- UX : **Ajouter / modifier / supprimer un utilisateur ou un agent** ;
- modèle interne : identité canonique `provider + subject` ;
- droits : rôles et permissions appliqués à des **ressources** ;
- OWASYS doit être aussi graphique que possible ;
- accordéons : Utilisateurs, Agents, Rôles, Permissions, Attributions, Ressources/ACL ;
- Mermaid dans le Workspace seulement ; l’UI OWASYS reste SCORE/CSS sans dépendance Mermaid/Node.

## Livrable actif — R45D2A21

```text
ZIP     : opus_p117w_r45d2a21_security_visual_workspace.zip
SHA-256 : 86ad0e9f9815d0af56d416bf6939b944656f344dc62227fb7e2bb513567a426a
BASE    : 50d68b724a1f32201bd068e0cb23c9f925780093
FILES   : 3
```

R45D2A21 traite la cause empêchant une séparation graphique honnête Utilisateur/Agent : ajout de `identity_type=user|agent`. Les identités historiques sans type restent `unknown` / « À classifier ».

La page Sécurité devient :

- carte visuelle `Utilisateurs/Agents -> Attributions -> Rôles -> Permissions -> Ressources/ACL` ;
- accordéons SCORE natifs `<details>/<summary>` ;
- formulaire « Ajouter un utilisateur ou un agent » avec choix explicite du type ;
- I18n UE + ukrainien ;
- aucun JS/Mermaid runtime.

## Gate immédiat

1. extraire R45D2A21 ;
2. lancer l’applicator ;
3. exiger `OPUS_R45D2A21_APPLIED locales=25` ;
4. lancer le smoke ;
5. exiger `OPUS_R45D2A21_SMOKE_OK locales=25` ;
6. linter les fichiers PHP modifiés ;
7. `composer dump-autoload -o` ;
8. vérifier `git status --short` ;
9. redémarrer front/back ;
10. ouvrir Sécurité comme developer ;
11. vérifier carte + accordéons ;
12. ajouter puis Preview/Commit une identité `user` ou `agent` ;
13. vérifier son classement dans le bon accordéon.

## Ne pas encore exposer

Le backend courant garde `destructive_mutations=false`. Ne pas afficher de faux boutons Modifier/Supprimer tant que les mutations backend atomiques correspondantes ne sont pas implémentées avec fresh-auth, preview, confirmation, rollback et protection du dernier administrateur.

## Suite

Après validation R45D2A21 :

1. gate viewer de la matrice ACL ;
2. smoke exécutable complet admin/developer/viewer ;
3. implémentation des mutations Modifier/Supprimer utilisateur ou agent.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO MERMAID/JS RUNTIME IN OWASYS.
NO PUSH OPUS/OWASYS BY ASSISTANT.
