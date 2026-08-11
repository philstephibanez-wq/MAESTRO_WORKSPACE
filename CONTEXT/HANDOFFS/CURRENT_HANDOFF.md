# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A15_BACKEND_FRESH_AUTH_PROOF_2026-08-11.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A15_BACKEND_FRESH_AUTH_PROOF_2026-08-11.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
a3f5b2257628d5b6ea0c98ba92178b4fe51030b2  opus_p117w_r45d2a14b_logout_atomic_migration
f195471557727d23d0be036b80382f3ba3ad9787  opus_p117w_r45d2a14_generated_logout
186517fd37c14047e33308500d0699b8ac36ab44  opus_p117w_r45d2a12_source_acl_ui_truth
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée ;
- R45D2A14B : `/fr` authentifié fonctionne et `Déconnexion` est visible.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Règle : capacités fondées sur permissions ACL effectives, jamais sur `primary_role` seul. Backend décisif, UI alignée, deny-by-default.

## R45D2A15 — état

Fresh-auth backend non forgeable introduit localement : preuve `OWASYS_FRESH_AUTH_PROOF_V1`, HMAC SHA-256, TTL court, liée acteur + site + mutation.

Régression détectée lors du premier redémarrage : `OPUS_REST_API_CATALOG_MISMATCH` sur tout appel REST, y compris `GET /api/v1/applications`.

Cause : R45D2A15 a ajouté `security.fresh-auth-proof.issue` aux ressources inline de `sites/owasys-back/config/backend.rest.json` sans synchroniser :

- `sites/owasys-back/config/backend.resources.json`
- `sites/owasys-front/config/rest.resources.json`

Les logs owner confirment la même erreur corrélée front/back dans `Opus/Api/Rest/RestResourceCatalog.php:174`.

## Livrable actif — R45D2A15B

```text
ZIP     : opus_p117w_r45d2a15b_rest_catalog_atomic_sync.zip
SHA-256 : 27e83c7c4480ce1ee25414184604353493a434760baa0b2fb48d84b98d5247c4
BASE    : a3f5b2257628d5b6ea0c98ba92178b4fe51030b2 + R45D2A15 local
FILES   : 2
```

Correction :

- `backend.rest.json` reste la liste serveur autoritative ;
- synchronisation atomique vers les deux catalogues `OPUS_REST_RESOURCE_CATALOG_V1` ;
- validation de la ressource fresh-auth ;
- smoke comparant les trois fingerprints ;
- smoke vérifiant `registry.sync` et la nouvelle route fresh-auth.

## Gate immédiat

1. appliquer R45D2A15B sur l'arbre contenant R45D2A15 ;
2. exécuter applicateur + smoke ;
3. redémarrer owasys-back puis owasys-front ;
4. vérifier disparition de `OPUS_REST_API_CATALOG_MISMATCH` ;
5. vérifier `/fr-FR/applications` ;
6. reprendre ensuite le test fresh-auth preview/commit ;
7. préserver la matrice admin/developer/viewer.

NO SITE-SPECIFIC PATCH.
NO CATALOG FALLBACK.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO SSO/ACL RELAXATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
