# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-06.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 7b390b662573b1e71bd8d770bbcad3d3b386325b
Dernier acquis : E3B Git workspace frontend
Livrable actif : R45B3 contrat client REST et catalogues croisés
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module `application/profiler` dans le scaffold générique.
- R45B2A4 : alignement de `profiler:view` dans le scaffold.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé par édition réelle depuis OWASYS.
- E3A : workspace Git générique/backend, publié à `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.
- E3B : interface Git frontend, publiée à `7b390b662573b1e71bd8d770bbcad3d3b386325b` et validée par création effective d’un commit depuis OWASYS `Sources et Git`.

E3B est le fils direct d’E3A et contient exactement 32 fichiers gouvernés.

R46 `dev-server --site=` est abandonné et ne doit jamais être appliqué.

## Contrat dev-server conservé

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script `composer dev-server` sans préfixe `opus:`.

## État E3B acquis

E3B fournit :

- interface Git intégrée au module `source` ;
- status, diff, historique, stage, unstage, commit et restore ;
- SCORE et fallback POST sans JavaScript ;
- CSRF Git distinct du CSRF Source ;
- FSM explicite par action ;
- ACL viewer lecture seule et developer/admin mutation ;
- catalogues I18n des langues UE configurées plus ukrainien ;
- séparation stricte enregistrement Source / stage / commit ;
- aucun accès Git, filesystem ou shell direct depuis OWASYS-front ;
- expurgation récursive générique des corps REST sensibles dans le Profiler.

La validation owner confirme un commit réel créé depuis l’interface OWASYS.

## Livrable owner actif — R45B3

```text
ZIP     : opus_p117w_r45b3_rest_client_contract.zip
SHA-256 : 06de2d80caebba9aebe9308eeed2f690a3c382ab582bc549e0e96fe3ce9889f7
FILES   : 8
BASE    : 7b390b662573b1e71bd8d770bbcad3d3b386325b
STATUS  : livré, application, validation, commit et push owner requis
```

Smoke owner :

```text
smoke_opus_p117w_r45b3_rest_client_contract_owner.php
SHA-256 : e77aefa501706d1e5e9a2c17ddbbe610bd27f0e495c1d9e7423a9e33251ad838
OUTPUT  : OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_OK
```

R45B3 ajoute :

- `RestResourceCatalog` générique et interface homonyme ;
- catalogue partagé de 23 ressources ;
- fingerprint déterministe indépendant de l’ordre ;
- validation croisée frontend/backend et inline/externe ;
- en-tête runtime `X-Opus-Rest-Catalog` ;
- refus client des méthodes et ressources non déclarées avant transport ;
- HTTP 409 avant Composer en cas de dérive ;
- statuts, enveloppes JSON, content-type et traces strictement contrôlés ;
- limites de requête et de réponse à 2 MiB ;
- acteur REST normalisé ;
- redirections désactivées ;
- `profiler_records` et corps sensibles expurgés des diagnostics.

Fingerprint normalisé :

```text
6deb58f201e5e6a8b12cee96ff006a1a4969442af2f1d1dcb05e5374220ace86
```

Le ZIP ne contient aucun site généré, aucune nouvelle opération métier, aucun JavaScript backend et aucun secret.

## Validation owner attendue

1. HEAD exact avant extraction ;
2. contrôle des SHA-256 ;
3. lint des quatre fichiers PHP ;
4. parsing des quatre fichiers JSON ;
5. `composer validate` ;
6. autoload optimisé ;
7. smoke owner ;
8. tests OWASYS Source et Git ;
9. dérive volontaire de fingerprint donnant HTTP 409 sans Composer ;
10. trace corrélée et Profiler sans contenu sensible ;
11. commit et push owner après succès.

## Suite gouvernée

1. acquisition owner R45B3 ;
2. R45C : wizard OWASYS structuré ;
3. R45D : administration Sécurité.

NO ACL BYPASS.
NO UNDECLARED REST RESOURCE.
NO CLIENT/SERVER CATALOG DRIFT.
NO UNBOUNDED REST BODY.
NO TRACE MISMATCH.
NO CONTENT, DIFF, COMMIT MESSAGE, CONFIRMATION OR PROFILER RECORDS IN PROFILER.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO BACKEND JAVASCRIPT.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
