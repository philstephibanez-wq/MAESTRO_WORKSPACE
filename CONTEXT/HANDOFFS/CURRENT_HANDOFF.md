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
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19B_ACCOUNT_I18N_COMPLETENESS_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19C_LOCAL_PASSWORD_CREDENTIAL_OWNERSHIP_2026-08-11.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19D_CREDENTIAL_OWNERSHIP_ATOMIC_CLEANUP_2026-08-11.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19D1_SMOKE_API_ALIGNMENT_2026-08-11.md`
12. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A19D_CREDENTIAL_OWNERSHIP_ATOMIC_CLEANUP_2026-08-11.md`
13. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
ddd71ee3b0554b685156cfbc22994aba5d35989d  opus_p117w_r45d2a19_local_password_break_glass_recovery
6f82ea0ad46eadd11435e02bc2dd1ff703034c02  opus_p117w_r45d2a18d_security_workflow_atomic_contract
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
- aucun mot de passe local ne doit traverser REST.

## Publication partielle à fermer

Le commit `1908e9ae...` est fonctionnel côté front mais ne contient que les 25 catalogues account + `RuntimeSecurity.php` par rapport à son parent.

Le master contient encore l'ancien flux backend password :

- `owasys:admin-password-change` dans `composer.json` ;
- `owasys:security:admin-password:change` dans le registre interne ;
- `security.admin-password.change` dans le catalogue d'opérations ;
- `PATCH /api/v1/security/admin-password` ;
- handler `OwasysCommandProvider::changePassword()` ;
- permissions explicites `account:change` côté back.

## Livrable fonctionnel actif — R45D2A19D

```text
ZIP     : opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup.zip
SHA-256 : 783a9474375d93ef1e2fe2ac336e2b63eec0c528b98a41df257687fee65e26ca
BASE    : 1908e9ae4e28d599855b5e8d1e424a6c335d0507
FILES   : 2
```

R45D2A19D supprime atomiquement l'ancien flux backend de changement de mot de passe, retire la capacité account explicite du back et resynchronise les trois catalogues REST.

Owner a appliqué R45D2A19D et `git status --short` matérialise bien :

- `composer.json` ;
- `sites/owasys-back/application/registry/services/OwasysCommandProvider.php` ;
- `sites/owasys-back/config/acl.json` ;
- `sites/owasys-back/config/backend.operations.json` ;
- `sites/owasys-back/config/backend.resources.json` ;
- `sites/owasys-back/config/backend.rest.json` ;
- `sites/owasys-back/config/composer.commands.json` ;
- `sites/owasys-front/config/rest.resources.json`.

## Correctif de validation actif — R45D2A19D1

Le smoke R45D2A19D initial était erroné : il appelait `AclPolicy::isAllowed()`, méthode inexistante. L'API canonique est `AclPolicy::decide(...)->allowed`.

Un second défaut latent du smoke est corrigé : `ComposerCommandRegistry::publicOperations()` retourne une liste, pas un tableau indexé par nom d'opération.

```text
ZIP     : opus_p117w_r45d2a19d1_smoke_api_alignment.zip
SHA-256 : 9bc4e07453f936bea8cea968ff6833c30bf9032a7211922b49e67d0f182599aa
FILES   : 1
```

R45D2A19D1 remplace uniquement :

`tools/smoke_r45d2a19d_credential_ownership_atomic_cleanup.php`

## Gate immédiat

1. extraire R45D2A19D1 ;
2. `php -l tools\smoke_r45d2a19d_credential_ownership_atomic_cleanup.php` ;
3. exiger `OPUS_R45D2A19D_SMOKE_OK fingerprint=... operations=...` ;
4. vérifier `git status --short` ;
5. owner commit/push du correctif fonctionnel R45D2A19D uniquement lorsque le smoke corrigé passe ;
6. vérifier GitHub master après push ;
7. seulement ensuite reprendre la matrice ACL developer/viewer.

## Suite matrice ACL

Après publication R45D2A19D :

- developer : Security Preview + Commit ;
- viewer : Security lecture seule ;
- viewer : Profiler refusé ;
- verrouiller ensuite toute la matrice admin/developer/viewer par smoke exécutable.

Si des identités locales developer/viewer authentifiables manquent, faire évoluer génériquement `LocalPasswordCredentialProvisioner` pour les applications standard dev-only. Aucun compte test codé en dur, aucun store runtime versionné.

NO PARTIAL PUBLICATION.
NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO SITE-SPECIFIC USER HACK.
NO FRESH-AUTH BYPASS.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
