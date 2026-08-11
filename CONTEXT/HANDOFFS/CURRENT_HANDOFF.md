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
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A19C_LOCAL_PASSWORD_CREDENTIAL_OWNERSHIP_2026-08-11.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
ddd71ee3b0554b685156cfbc22994aba5d35989d  opus_p117w_r45d2a19_local_password_break_glass_recovery
6f82ea0ad46eadd11435e02bc2dd1ff703034c02  opus_p117w_r45d2a18d_security_workflow_atomic_contract
d7226d4e0696319876b1bde69dbcfa9aa3feff3e  opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
```

R45D2A19B est appliqué localement chez l'owner mais n'est pas encore visible dans master au moment de ce handoff.

## États acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélation login acquise ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer acquise ;
- dev-server single-owner acquis ;
- catalogues REST synchronisés ;
- intégrité REST -> Composer acquise ;
- fresh-auth dérivé automatiquement en dev acquis ;
- Security Mutation FSM atomiquement raccordée ;
- admin Security Preview + Commit acquis dans les logs ;
- R45D2A19 break-glass publié ;
- login avec mot de passe temporaire -> `must_change_password` -> `/account/password` acquis ;
- R45D2A19B : page account/password rend désormais et le POST atteint le changement de password.

## Incident actif

POST `/fr-FR/account/password` échoue avec :

```text
OWASYS_SECURITY_PROVIDER_UNSUPPORTED
```

Les logs montrent :

`PATCH /api/v1/security/admin-password -> owasys:admin-password-change -> OwasysCommandProvider.php`.

Cause : `owasys-front` possède le provider/store runtime `local-password`, tandis que `owasys-back/config/sso.json` possède légitimement `auth0-proxy` et service-HMAC. L'ancien handler back vérifie son propre `default_provider` contre `local-password` et est donc faux par construction. Faire lire le store front au back est interdit car les applications doivent rester autonomes et déployables sur des bastions séparés.

## Livrable actif — R45D2A19C

```text
ZIP     : opus_p117w_r45d2a19c_local_password_credential_ownership.zip
SHA-256 : 3437dab7d86e76cbace4d041b5d46e74a00a8e274f1996ebaf2212dd1f4037ba
BASE    : ddd71ee3b0554b685156cfbc22994aba5d35989d + R45D2A19B local
FILES   : 2
```

R45D2A19C :

- `OwasysRuntimeSecurity::changePassword()` utilise le SSO local du front ;
- aucun mot de passe ne traverse REST ;
- suppression de `/api/v1/security/admin-password` ;
- suppression opération/script/alias/handler back associé ;
- resynchronisation atomique des catalogues REST.

## Gate immédiat

1. appliquer R45D2A19C ;
2. smoke + lints ;
3. redémarrer front/back ;
4. login avec mot de passe temporaire ;
5. `/account/password` ;
6. saisir temporaire comme actuel + nouveau + confirmation ;
7. FSM `password_changed` -> `/applications` ;
8. ancien temporaire refusé, nouveau accepté ;
9. aucun appel backend `/api/v1/security/admin-password` ;
10. reprendre matrice ACL : developer workflow Security puis viewer lecture seule/sans Profiler.

## Matrice ACL cible obligatoire

Permissions effectives uniquement. Admin + developer peuvent muter Sécurité. Viewer lecture seule et sans Profiler. Aucun `primary_role` comme autorité.

NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO BROWSER LOCAL-PASSWORD RESET WITHOUT VERIFIED RECOVERY CHANNEL.
NO FRESH-AUTH BYPASS.
NO SILENT I18N FALLBACK.
NO PARTIAL CONTRACT PUBLICATION.
NO SITE-SPECIFIC HACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
