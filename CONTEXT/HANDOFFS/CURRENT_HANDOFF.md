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
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A16B_DEV_SERVER_SINGLE_OWNER_BINDING_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A17_FRESH_AUTH_PHASE_BINDING_2026-08-11.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18_SECURITY_MUTATION_FSM_2026-08-11.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18B_REST_COMPOSER_CATALOG_INTEGRITY_2026-08-11.md`
12. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A18B_REST_COMPOSER_CATALOG_INTEGRITY_2026-08-11.md`
13. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
8f0d6ba5a009fbd5c4348d1f4f6cc789ce813ee6  opus_p117w_r45d2a17_fresh_auth_phase_binding
af4016a642c5595304fadbbdab5990bd7e6f3ea9  opus_p117w_r45d2a16b_dev_server_single_owner_binding
9330511436d2e3c40728d1d1bbc93ce15598aa8f  opus_p117w_r45d2a16_security_acl_matrix_alignment
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` ;
- R45D2A14B : logout généré acquis ;
- R45D2A15 : fresh-auth backend non forgeable ;
- R45D2A15B : catalogues REST atomiquement synchronisés ;
- R45D2A16 : matrice Sécurité admin/developer/viewer ;
- R45D2A16B : single-owner dev-server publié et validé ;
- R45D2A17 : fresh-auth lié à la phase preview|commit publié ;
- R45D2A18 : Security Mutation FSM publié ;
- `GET /fr-FR/security` sain ;
- `security.snapshot` passe front -> REST -> back -> Composer en 200 avec trace corrélée.

## Incident actif

Le premier POST Preview atteint bien le back :

```text
POST /api/v1/applications/essai2/security/fresh-auth-proofs
operation=security.fresh-auth-proof.issue
```

mais échoue avec :

```text
OPUS_REST_API_COMPOSER_SCRIPT_UNDECLARED
```

Cause confirmée :

- `backend.operations.json` référence `owasys:security-fresh-auth-proof` ;
- `composer.commands.json` déclare alias + provider interne ;
- `composer.json` racine ne contient pas le script public `owasys:security-fresh-auth-proof` ;
- `ComposerCommandRegistry` valide directement contre `composer.json` et refuse.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Permissions ACL effectives uniquement. Backend décisif, UI alignée, deny-by-default. Admin + developer mutation ; viewer lecture seule ; viewer sans Profiler.

## Livrable actif — R45D2A18B

```text
ZIP     : opus_p117w_r45d2a18b_rest_composer_catalog_integrity.zip
SHA-256 : a4dc4e13778f96037c5f9e9470e6c673e1f58857572e99757c01304458642a27
BASE    : 98b0233bf85f33037f45adde916514c6f8305a16
FILES   : 2
```

Correction :

1. ajouter le script public manquant dans `composer.json` ;
2. smoke global : chaque `composer_script` de `backend.operations.json` doit exister dans `composer.json` ;
3. exercer `ComposerCommandRegistry::publicOperations()` pour reproduire la même frontière que le runtime ;
4. vérifier alias/provider fresh-auth dans `composer.commands.json`.

## Gate immédiat

1. appliquer R45D2A18B ;
2. applicateur + smoke ;
3. dump-autoload ;
4. redémarrer back puis front ;
5. admin : Security Preview ;
6. fresh-auth doit passer REST -> Composer ;
7. preview doit aboutir ;
8. nouvelle fresh-auth ;
9. commit doit aboutir ;
10. vérifier Profiler FSM + REST distribué + Composer ;
11. developer : même workflow ;
12. viewer : lecture seule, aucun contrôle mutation ;
13. aucun mot de passe ni preuve complète dans logs/profiler.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO AUTO-KILL EXISTING PROCESS.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO CROSS-PHASE FRESH-AUTH PROOF.
NO PASSWORD/PROOF IN FSM MEMORY OR LOGS.
NO REST REPLAY STORE.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
