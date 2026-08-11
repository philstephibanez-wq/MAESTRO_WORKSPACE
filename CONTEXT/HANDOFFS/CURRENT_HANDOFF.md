# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A15_BACKEND_FRESH_AUTH_PROOF_2026-08-11.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A16_SECURITY_ACL_MATRIX_ALIGNMENT_2026-08-11.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A17_FRESH_AUTH_PHASE_BINDING_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18_SECURITY_MUTATION_FSM_2026-08-11.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18B_REST_COMPOSER_CATALOG_INTEGRITY_2026-08-11.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18C_FRESH_AUTH_RUNTIME_SECRET_POLICY_2026-08-11.md`
12. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
13. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
14. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
d7226d4e0696319876b1bde69dbcfa9aa3feff3e  opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
8f0d6ba5a009fbd5c4348d1f4f6cc789ce813ee6  opus_p117w_r45d2a17_fresh_auth_phase_binding
```

## États acquis

- login local-password `essai2/steve` acquis ;
- Profiler intégré/repliable et corrélation login acquise ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer acquise ;
- dev-server single-owner acquis ;
- catalogues REST synchronisés ;
- intégrité REST -> Composer acquise ;
- secret fresh-auth dérivé automatiquement en dev acquis ;
- `security.snapshot` passe front -> REST -> back -> Composer en HTTP 200.

## Incident actif

Preview Sécurité échoue avec :

```text
OWASYS_FRESH_AUTH_PROOF_BINDING_INVALID
```

Logs : le POST fresh-auth atteint le back et le script `owasys:security-fresh-auth-proof` est effectivement lancé.

Cause racine vérifiée sur le master : publication partielle des contrats R45D2A17/R45D2A18.

- R45D2A17 publié : seulement 3 fichiers back ;
- `RuntimeSecurity.php` courant n'envoie pas `phase` ;
- `SecurityController.php` courant n'est pas raccordé à `security.mutation.fsm.json` ;
- `OwasysSecurityMutationService.php` courant appelle encore `assertValid()` sans phase ;
- R45D2A18 publié : seulement le JSON FSM.

## Livrable actif — R45D2A18D

```text
ZIP     : opus_p117w_r45d2a18d_security_workflow_atomic_contract.zip
SHA-256 : cc46c530413d2915dab62ade329bf939b11997d9c5343179d2f82f959f1e33ca
BASE    : d7226d4e0696319876b1bde69dbcfa9aa3feff3e
FILES   : 3
```

R45D2A18D remet atomiquement en cohérence : RuntimeSecurity, SecurityController + FSM/session, OwasysSecurityMutationService, backend.operations, Composer public/interne, route/catalogues REST et politique de secret.

## Gate immédiat

1. applicateur R45D2A18D ;
2. smoke atomique obligatoire ;
3. lints + autoload ;
4. vérifier `git status --short` et ne pas publier un sous-ensemble du contrat ;
5. redémarrer back puis front sans secret manuel ;
6. admin : Preview doit aboutir ;
7. aperçu : nouvelle fresh-auth ;
8. Commit doit aboutir ;
9. contrôler FSM + REST + Composer corrélés sans secret ;
10. developer : même workflow ;
11. viewer : lecture seule, aucune mutation, aucun Profiler.

## Matrice ACL cible obligatoire

Permissions effectives uniquement. Admin + developer peuvent muter Sécurité. Viewer lecture seule et sans Profiler. Aucun `primary_role` comme autorité.

NO PARTIAL CONTRACT PUBLICATION.
NO SITE-SPECIFIC HACK.
NO MANUAL DEV SECRET.
NO SILENT FALLBACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO CROSS-PHASE PROOF.
NO PASSWORD/PROOF IN FSM MEMORY OR LOGS.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
