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
9. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A16B_DEV_SERVER_SINGLE_OWNER_BINDING_2026-08-11.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
9330511436d2e3c40728d1d1bbc93ce15598aa8f  opus_p117w_r45d2a16_security_acl_matrix_alignment
8b70be74bb83da3f528a0d0e3e2bf74663205fa0  opus_p117w_r45d2a15b_rest_catalog_atomic_sync
```

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
- diagnostic dev-server : front 8000 répond HTTP 200 ; backend 8080 a présenté deux listeners simultanés et un timeout avant `request.received` ; owner a supprimé les processus dupliqués avec Task Manager.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Règle : permissions ACL effectives uniquement, backend décisif, UI alignée, deny-by-default. Admin + developer peuvent gérer Sécurité ; viewer lecture seule ; viewer sans Profiler.

## Livrable actif — R45D2A16B

```text
ZIP     : opus_p117w_r45d2a16b_dev_server_single_owner_binding.zip
SHA-256 : 83f58506c632e901ff927bd1936ce639f6d6e36821bd0ccf9918f2ff27469717
BASE    : 9330511436d2e3c40728d1d1bbc93ce15598aa8f
FILES   : 2
```

Correction générique OPUS : après résolution finale host/port, `SiteCommandService::devServer()` refuse tout endpoint déjà occupé avant RAZ diagnostics, `development_server.starting` et `proc_open()`.

Erreur : `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE:<host>:<port>`.

## Gate immédiat

1. appliquer R45D2A16B ;
2. smoke OK ;
3. démarrer `owasys-back` sur 8080 ;
4. tenter immédiatement un second démarrage `owasys-back` ;
5. le second doit être refusé avec `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE:127.0.0.1:8080` ;
6. le premier backend doit continuer à répondre ;
7. démarrer front ;
8. reprendre Sécurité `fresh-auth -> preview -> commit` ;
9. valider ensuite admin, developer, viewer contre la matrice.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO AUTO-KILL EXISTING PROCESS.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
