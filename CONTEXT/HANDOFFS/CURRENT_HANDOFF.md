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
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A16_SECURITY_ACL_MATRIX_ALIGNMENT_2026-08-11.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
8b70be74bb83da3f528a0d0e3e2bf74663205fa0  opus_p117w_r45d2a15b_rest_catalog_atomic_sync
a3f5b2257628d5b6ea0c98ba92178b4fe51030b2  opus_p117w_r45d2a14b_logout_atomic_migration
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée ;
- R45D2A14B : `/fr` authentifié fonctionne et `Déconnexion` est visible ;
- R45D2A15 : fresh-auth backend non forgeable publié ;
- R45D2A15B : catalogues REST atomiquement synchronisés, `OPUS_REST_API_CATALOG_MISMATCH` disparu, `/fr-FR/applications` validé owner.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Règle : capacités fondées sur permissions ACL effectives, jamais sur `primary_role` seul. Backend décisif, UI alignée, deny-by-default.

## Défaut courant

Le master publié n'est pas encore aligné sur la matrice pour Sécurité :

- front : developer = `security:open` seulement ;
- back : developer = `security:read` seulement ;
- allow-list REST fresh-auth / preview / commit = admin seulement.

La cible contractuelle est : admin + developer peuvent gérer Sécurité ; viewer reste lecture seule.

## Livrable actif — R45D2A16

```text
ZIP     : opus_p117w_r45d2a16_security_acl_matrix_alignment.zip
SHA-256 : e60f750bc8e744a3f027240a37c5344cf563c6455e13de0b8d6ee2e094e9817f
BASE    : 8b70be74bb83da3f528a0d0e3e2bf74663205fa0
FILES   : 2
```

Correction :

- front developer -> `security:*` ;
- back developer -> `security:*` ;
- fresh-auth / preview / commit REST -> `[admin, developer]` ;
- viewer inchangé : open/read uniquement ;
- smoke prouve viewer sans manage et sans Profiler.

## Gate immédiat

1. appliquer R45D2A16 ;
2. smoke ACL matrix ;
3. redémarrer back puis front ;
4. admin : Sécurité mutable ;
5. developer : Sécurité mutable ;
6. viewer : Sécurité lecture seule, contrôles mutation absents/inactifs ;
7. viewer : Profiler inaccessible ;
8. reprendre fresh-auth -> preview -> commit ;
9. conserver CSRF + proof backend + confirmation + state hash + rollback + audit.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
