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
12. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18C_FRESH_AUTH_RUNTIME_SECRET_POLICY_2026-08-11.md`
13. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A18C_FRESH_AUTH_RUNTIME_SECRET_POLICY_2026-08-11.md`
14. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
8f0d6ba5a009fbd5c4348d1f4f6cc789ce813ee6  opus_p117w_r45d2a17_fresh_auth_phase_binding
af4016a642c5595304fadbbdab5990bd7e6f3ea9  opus_p117w_r45d2a16b_dev_server_single_owner_binding
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
- R45D2A18B : intégrité REST -> Composer publiée ; le script fresh-auth est maintenant déclaré et effectivement lancé ;
- `GET /fr-FR/security` sain ;
- `security.snapshot` passe front -> REST -> back -> Composer en 200 avec trace corrélée.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Permissions ACL effectives uniquement. Backend décisif, UI alignée, deny-by-default. Admin + developer mutation ; viewer lecture seule ; viewer sans Profiler.

## Incident actif

Le POST Preview atteint le back et lance maintenant :

```text
script=owasys:security-fresh-auth-proof
```

mais le service renvoie :

```text
OWASYS_FRESH_AUTH_PROOF_SECRET_INVALID
```

Cause confirmée : `OwasysFreshAuthProofService` attend `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET`, tandis que `sites/owasys-back/config/site.json` ne déclare pas encore ce secret dans `OPUS_APPLICATION_ENVIRONMENTS_V1`.

OPUS possède déjà le mécanisme canonique `OPUS_DEVELOPMENT_DERIVED_SECRET_V1` utilisé par les secrets REST de `owasys-back`. Le secret fresh-auth doit être raccordé à ce mécanisme au lieu de dépendre d'un `set` manuel.

## Livrable actif — R45D2A18C

```text
ZIP     : opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy.zip
SHA-256 : 253b0aba17d839c728ac1a3f602baf2e8b471f27b64314105cef47647c71ec85
BASE    : 9d3c4d5463483cc520d381f7f8de83cfd5e352c4
FILES   : 2
```

Correction :

- dev : `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` dérivé automatiquement par OPUS avec channel `owasys-security-fresh-auth` ;
- test : variable externe `OPUS_TEST_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
- prod : variable externe `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
- `secret: true` partout ;
- aucun secret versionné.

## Gate immédiat

1. appliquer R45D2A18C ;
2. applicateur + smoke ;
3. valider `site.json` ;
4. redémarrer `owasys-back` SANS `set OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
5. redémarrer `owasys-front` ;
6. admin : Security Preview ;
7. fresh-auth doit passer REST -> Composer ;
8. Preview doit aboutir ;
9. nouvelle fresh-auth ;
10. Commit doit aboutir ;
11. vérifier FSM + REST + Composer dans Profiler/Logger sans secret ;
12. developer : même workflow ;
13. viewer : lecture seule, aucune action mutation.

NO SITE-SPECIFIC HACK.
NO MANUAL DEV SECRET.
NO SECRET IN GIT.
NO SILENT FALLBACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO CROSS-PHASE FRESH-AUTH PROOF.
NO PASSWORD/PROOF IN FSM MEMORY OR LOGS.
NO REST REPLAY STORE.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
