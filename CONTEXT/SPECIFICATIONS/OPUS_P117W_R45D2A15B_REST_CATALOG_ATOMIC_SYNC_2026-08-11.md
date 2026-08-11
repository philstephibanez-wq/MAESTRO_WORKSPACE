# OPUS P117W R45D2A15B — REST catalog atomic sync

Date: 2026-08-11

R45D2A15 ajoute la ressource `security.fresh-auth-proof.issue` dans `sites/owasys-back/config/backend.rest.json`. Les catalogues canoniques `sites/owasys-back/config/backend.resources.json` et `sites/owasys-front/config/rest.resources.json` doivent contenir exactement la même liste de ressources. Sinon les fingerprints REST divergent et OPUS refuse les appels avec `OPUS_REST_API_CATALOG_MISMATCH`.

R45D2A15B synchronise atomiquement les deux catalogues depuis la liste `resources` validée de `backend.rest.json`, via `StructuredFileLoader`, puis vérifie par smoke que les trois fingerprints sont identiques. Le smoke vérifie aussi la conservation de `GET /api/v1/applications -> registry.sync` et la présence de `POST /api/v1/applications/{site_id}/security/fresh-auth-proofs -> security.fresh-auth-proof.issue`.

Livrable:

- ZIP: `opus_p117w_r45d2a15b_rest_catalog_atomic_sync.zip`
- SHA-256: `27e83c7c4480ce1ee25414184604353493a434760baa0b2fb48d84b98d5247c4`
- Base: `a3f5b2257628d5b6ea0c98ba92178b4fe51030b2 + R45D2A15 local`
- Files: 2

Acceptation: disparition de `OPUS_REST_API_CATALOG_MISMATCH`, applications accessibles depuis owasys-front, puis reprise du test fresh-auth preview/commit. La matrice ACL admin/developer/viewer reste inchangée.
