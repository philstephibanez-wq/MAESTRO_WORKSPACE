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
10. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A17_FRESH_AUTH_PHASE_BINDING_2026-08-11.md`
11. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
9330511436d2e3c40728d1d1bbc93ce15598aa8f  opus_p117w_r45d2a16_security_acl_matrix_alignment
8b70be74bb83da3f528a0d0e3e2bf74663205fa0  opus_p117w_r45d2a15b_rest_catalog_atomic_sync
```

R45D2A16B est appliqué et validé localement par l'owner mais pas encore visible sur GitHub au moment de ce handoff.

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée ;
- R45D2A14B : logout généré acquis ;
- R45D2A15 : fresh-auth backend non forgeable publié ;
- R45D2A15B : catalogues REST atomiquement synchronisés, mismatch disparu ;
- R45D2A16 : matrice Sécurité admin/developer/viewer publiée ;
- R45D2A16B : second démarrage `owasys-back` refusé par `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE`; single-owner binding validé localement.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Règle : permissions ACL effectives uniquement, backend décisif, UI alignée, deny-by-default. Admin + developer peuvent gérer Sécurité ; viewer lecture seule ; viewer sans Profiler.

## Livrable actif — R45D2A17

```text
ZIP     : opus_p117w_r45d2a17_fresh_auth_phase_binding.zip
SHA-256 : a216a0619d69eab274aaca54bc21ea7a4ff7a92b35fc891c2e6fecf590abbcb7
BASE    : 9330511436d2e3c40728d1d1bbc93ce15598aa8f + R45D2A16B local validé
FILES   : 2
```

Correction : la preuve fresh-auth est désormais liée cryptographiquement à la phase `preview|commit`. Claims signés : acteur, provider, site, hash mutation, `operation=security.mutation.<phase>`, `phase`, TTL, nonce.

## Gate immédiat

1. appliquer R45D2A17 ;
2. smoke : preuve preview acceptée en preview et refusée en commit ;
3. lint + autoload ;
4. démarrer owasys-back puis owasys-front ;
5. admin : `fresh-auth -> preview -> nouvelle fresh-auth -> commit` ;
6. developer : même workflow ;
7. viewer : lecture Sécurité seulement, aucune action de mutation ;
8. inspecter Logger/Profiler : aucun mot de passe ni preuve complète sensible journalisée.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO AUTO-KILL EXISTING PROCESS.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO CROSS-PHASE FRESH-AUTH PROOF.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO REST REPLAY STORE.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
