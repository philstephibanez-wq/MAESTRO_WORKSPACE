# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19_LOCAL_PASSWORD_BREAK_GLASS_RECOVERY_2026-08-11.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19D_CREDENTIAL_OWNERSHIP_ATOMIC_CLEANUP_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A20_STANDARD_LOCAL_PASSWORD_ROLE_PROVISIONING_2026-08-11.md`
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A20_STANDARD_LOCAL_PASSWORD_ROLE_PROVISIONING_2026-08-11.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
ddd71ee3b0554b685156cfbc22994aba5d35989d  opus_p117w_r45d2a19_local_password_break_glass_recovery
```

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélé ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer contractuelle ;
- dev-server single-owner acquis ;
- catalogues REST/fresh-auth/Security Mutation FSM acquis ;
- admin Security Preview + Commit acquis ;
- break-glass local-password acquis ;
- login temporaire -> `must_change_password` -> `/account/password` acquis ;
- I18n account/password acquise ;
- changement du mot de passe temporaire vers un nouveau mot de passe acquis ;
- aucun mot de passe local ne traverse REST ;
- R45D2A19D publié : ancien flux backend password supprimé atomiquement.

## Livrable actif — R45D2A20

```text
ZIP     : opus_p117w_r45d2a20_standard_local_password_role_provisioning.zip
SHA-256 : c74fb241be1b53237e9271ef5302f0e3ded1d0ae60451c4c34d157ff908e8b0c
BASE    : 38a053d585bfd0b154183a5ad7b043504634c043
FILES   : 4
```

R45D2A20 généralise `LocalPasswordCredentialProvisioner` aux applications OPUS standard :

- rôle(s) explicites via `--role=<role>` ;
- validation des rôles contre `config/acl.json` deny-by-default ;
- mot de passe uniquement via STDIN ;
- aucun compte codé en dur ;
- aucun store runtime versionné ;
- comportement generated/onboarding préservé et non contournable.

## Gate immédiat

1. extraire R45D2A20 ;
2. linter les 4 fichiers ;
3. exiger `OPUS_R45D2A20_SMOKE_OK` ;
4. `composer dump-autoload -o` ;
5. vérifier `git status --short` ;
6. provisionner une identité runtime rôle developer dans `owasys-front` ;
7. provisionner une identité runtime rôle viewer dans `owasys-front` ;
8. ne jamais éditer `var/auth/local-users.json` manuellement.

## Gate navigateur après provisioning

Developer :

- Applications : ouvrir/sélectionner/changer/créer/supprimer generated ;
- Structure, Sources de données, Workflows, Security ;
- Sources et Git : lecture + mutations ;
- Security Preview + Commit ;
- compte : changement mot de passe ;
- Profiler visible.

Viewer :

- Applications : ouvrir/sélectionner/changer ;
- aucun create/delete ;
- Structure, Sources de données, Workflows, Security : lecture ;
- Sources et Git : lecture uniquement ;
- aucune mutation source/git/security ;
- compte : changement mot de passe autorisé ;
- Profiler absent et accès direct refusé.

Le backend reste décisif : les mutations viewer doivent être refusées même si une requête directe est forgée.

## Suite

Après validation browser developer/viewer : livrer un smoke exécutable couvrant toute la matrice ACL admin/developer/viewer, front et back.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO GENERATED ONBOARDING BYPASS.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
