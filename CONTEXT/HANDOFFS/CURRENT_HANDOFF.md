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
11. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A18_SECURITY_MUTATION_FSM_2026-08-11.md`
12. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
9330511436d2e3c40728d1d1bbc93ce15598aa8f  opus_p117w_r45d2a16_security_acl_matrix_alignment
8b70be74bb83da3f528a0d0e3e2bf74663205fa0  opus_p117w_r45d2a15b_rest_catalog_atomic_sync
```

R45D2A16B est validé localement par l'owner ; sa protection refuse un second bind dev-server sur le même port. R45D2A17 est dans la progression locale owner mais n'est pas encore confirmé comme commit GitHub dans ce handoff.

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` ;
- R45D2A14B : logout généré acquis ;
- R45D2A15 : fresh-auth backend non forgeable ;
- R45D2A15B : catalogues REST atomiquement synchronisés ;
- R45D2A16 : matrice Sécurité admin/developer/viewer publiée ;
- R45D2A16B : single-owner dev-server validé localement ;
- logs owner 2026-08-11 07:49Z : `/fr-FR/security` fonctionne ; backend `security.snapshot` passe REST -> Composer en 200 avec trace corrélée.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Permissions ACL effectives uniquement. Backend décisif, UI alignée, deny-by-default. Admin + developer mutation ; viewer lecture seule ; viewer sans Profiler.

## Livrable actif — R45D2A18

```text
ZIP     : opus_p117w_r45d2a18_security_mutation_fsm.zip
SHA-256 : 4b54105a5836dfe4fb0136eee1a74b8c7bd6a71a2afc1b4ee1bf44ff59be4afd
BASE    : R45D2A17 local + R45D2A16B local validé
FILES   : 3
```

Cause : `SecurityController` pilotait encore preview/commit procéduralement ; la FSM de navigation ne porte que `open_security`.

Solution : FSM dédiée `security.mutation.fsm.json`, persistée dans la session front entre preview et commit.

Workflow :

`idle -> requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed`

Branches : `rejected`, `rolled_back`.

Binding de workflow : site + hash mutation/reason + vue. Aucun mot de passe ni preuve fresh-auth en mémoire FSM.

## Gate immédiat

1. appliquer R45D2A18 ;
2. smoke FSM + lint + autoload ;
3. démarrer back puis front ;
4. admin : mutation Sécurité -> preview -> nouvelle fresh-auth -> commit ;
5. vérifier Profiler FSM + REST distribué + Composer ;
6. developer : même workflow ;
7. viewer : lecture seule, aucun contrôle de mutation ;
8. inspecter logs/profiler : aucun mot de passe ni preuve complète.

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
