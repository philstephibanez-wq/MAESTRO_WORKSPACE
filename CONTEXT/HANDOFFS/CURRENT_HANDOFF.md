# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-06

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_2026-08-06.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_2026-08-06.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_2026-08-06.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_2026-08-06.md`
11. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_2026-08-06.md`
12. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `7b390b662573b1e71bd8d770bbcad3d3b386325b`.

E3B est acquis au commit `7b390b662573b1e71bd8d770bbcad3d3b386325b`, fils direct d’E3A, avec exactement les 32 fichiers attendus. La validation owner confirme la création effective d’un commit Git depuis OWASYS `Sources et Git`.

R46 `dev-server --site=` reste abandonné. Le contrat positionnel reste :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_r45b3_rest_client_contract.zip
SHA-256 : 06de2d80caebba9aebe9308eeed2f690a3c382ab582bc549e0e96fe3ce9889f7
FILES   : 8
BASE    : 7b390b662573b1e71bd8d770bbcad3d3b386325b
STATUS  : livré, application, validation, commit et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b3_rest_client_contract_owner.php
SHA-256 : e77aefa501706d1e5e9a2c17ddbbe610bd27f0e495c1d9e7423a9e33251ad838
OUTPUT  : OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_OK
```

## Cible R45B3

- catalogue REST générique OPUS partagé par client et serveur ;
- 23 ressources Source, Git, Registry, construction et sécurité ;
- fingerprint déterministe indépendant de l’ordre des routes ;
- validation croisée inline/externe au boot du backend ;
- échange runtime `X-Opus-Rest-Catalog` ;
- refus des méthodes et ressources frontend non déclarées avant transport ;
- HTTP 409 avant Composer en cas de dérive catalogue ;
- statuts, enveloppes, content-type et traces strictement validés ;
- corps de requête et lecture de réponse bornés ;
- acteur REST normalisé ;
- Profiler expurgé des corps et enregistrements sensibles.

Empreinte fonctionnelle du catalogue :

```text
6deb58f201e5e6a8b12cee96ff006a1a4969442af2f1d1dcb05e5374220ace86
```

R45B3 ne contient aucun fichier de site généré, aucune nouvelle opération métier et aucun JavaScript backend.

## Validation owner obligatoire

- vérifier le HEAD et les deux SHA-256 ;
- extraire le ZIP à la racine OPUS ;
- lint des quatre PHP et parsing des quatre JSON ;
- `composer validate` puis autoload optimisé ;
- exécuter le smoke owner ;
- tester les opérations Source et Git réelles ;
- provoquer une dérive de fingerprint et confirmer HTTP 409 sans Composer ;
- confirmer trace corrélée et absence de contenu sensible dans le Profiler ;
- commit et push owner seulement après succès.

## Suite après acquisition

R45C : wizard OWASYS structuré.

Puis R45D : administration Sécurité.

NO ACL BYPASS.
NO UNDECLARED REST RESOURCE.
NO CLIENT/SERVER CATALOG DRIFT.
NO UNBOUNDED REST BODY.
NO TRACE MISMATCH.
NO CONTENT, DIFF, COMMIT MESSAGE, CONFIRMATION OR PROFILER RECORDS IN PROFILER.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO BACKEND JAVASCRIPT.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L’ASSISTANT.
