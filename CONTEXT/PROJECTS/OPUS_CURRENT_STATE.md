# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-06.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
Dernier acquis : E2A source REST / Composer
```

## État des jalons précédents

- R45B2A2 est acquis et publie la rétention/rotation bornée du Profiler JSONL.
- R45B2A3 est publié à `a1afd6415c9ddbd80b7944756210f33c36f7253b` et ajoute le module `application/profiler` au scaffold générique.
- `test7` a ensuite été généré par OWASYS.
- R45B2A4 est publié à `2c268e998c7f714c17476050e652d7afb88db9f4` et aligne `profiler:view` sur les rôles de la page d'accueil dans le scaffold générique.
- E1 est publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A est publié à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- R46 `dev-server --site=` est abandonné et n'a jamais été acquis.

## E1 acquis

`SiteSourceWorkspace` fournit :

- liste et lecture bornées ;
- métadonnées et empreinte SHA-256 ;
- diff de prévisualisation ;
- verrouillage optimiste ;
- verrou interprocessus ;
- écriture atomique ;
- instrumentation Logger/Profiler sans contenu source.

## E2A acquis

E2A fournit :

- transport générique `request` pour les paramètres Composer exclus d'`argv` ;
- conservation exacte du contenu avec `trim=false` ;
- routes REST preview et write ;
- opérations Composer allow-listées ;
- ACL admin/developer pour mutation ;
- provider OWASYS-back utilisant exclusivement E1 ;
- statut HTTP 409 pour conflit optimiste.

## Contrat dev-server conservé

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script `composer dev-server` sans préfixe `opus:`.

## Livrable owner actif — E2B

```text
ZIP     : opus_p117w_e2b_source_editor_front.zip
SHA-256 : da9df8d1e17a16797fdf09a78413fde32db5d9307d30f577addc292ecc21254b
FILES   : 34
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

E2B ajoute :

- éditeur Sources SCORE et POST sans JavaScript obligatoire ;
- CodeMirror, arbre, onglets et sélection GET JSON en amélioration progressive ;
- preview REST POST distincte de write REST PUT ;
- conflit HTTP 409 sans écrasement ;
- POST/Redirect/GET après enregistrement ;
- ACL viewer lecture seule et developer/admin édition ;
- service CSRF OPUS générique, scopé, lié à la session et à usage unique ;
- 25 catalogues I18n de base couvrant les langues UE configurées et l'ukrainien.

Aucun fichier backend, aucun site généré et aucune opération Git ne figurent dans E2B.

Smoke owner :

```text
smoke_opus_p117w_e2b_source_editor_front_owner.php
SHA-256 : 97055a9b832e84bf9bbcdefbb2f764f25ef341c3b124c17f7bd26b703dc0ace4
OUTPUT  : OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_OK
```

## Suites gouvernées

1. validation, commit et push owner de E2B ;
2. E3 : statut/diff/historique/stage/unstage/commit/restauration Git contrôlés sans push implicite ;
3. R45B3 : client REST frontend générique et validateurs croisés ;
4. R45C : wizard OWASYS structuré ;
5. R45D : administration Sécurité.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO DIRECT FRONTEND FILESYSTEM ACCESS.
NO IMPLICIT GIT OPERATION.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L'ASSISTANT.
