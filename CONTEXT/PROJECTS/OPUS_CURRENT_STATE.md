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

## E1 acquis

`SiteSourceWorkspace` fournit désormais dans OPUS :

- liste et lecture bornées ;
- métadonnées et empreinte SHA-256 ;
- diff de prévisualisation ;
- verrouillage optimiste ;
- verrou interprocessus ;
- écriture atomique ;
- instrumentation Logger/Profiler sans contenu source.

## E2A acquis

E2A ajoute :

- transport générique `request` pour les paramètres Composer exclus d'`argv` ;
- conservation exacte du contenu avec `trim=false` ;
- routes REST preview et write ;
- opérations Composer allow-listées ;
- ACL admin/developer pour mutation ;
- provider OWASYS-back utilisant exclusivement E1 ;
- statut HTTP 409 pour conflit optimiste.

## Livrable owner actif — R46

```text
ZIP     : opus_p117w_r46_dev_server_site_option.zip
SHA-256 : 4112fef6bff85d9dc8d064439eda7397793d06917ac5c9390949bdc8b1140f33
FILES   : 1
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

R46 remplace l'identifiant positionnel de `opus:dev-server` par le contrat explicite :

```text
composer opus:dev-server -- --site=<site> [--host=<local-address>] [--port=<local-port>]
```

La forme positionnelle et `--site test7` sont refusées. La correction est générique et ne modifie pas `test7`.

Le smoke owner reste hors ZIP.

## Suites gouvernées

1. validation, commit et push owner de R46 ;
2. E2B : éditeur Sources dans `owasys-front`, ViewModel, SCORE, preview/write et conflit concurrent ;
3. E3 : statut/diff/historique/stage/unstage/commit Git contrôlés sans push implicite ;
4. R45B3 : client REST frontend générique et validateurs croisés ;
5. R45C : wizard OWASYS structuré ;
6. R45D : administration Sécurité.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO POSITIONAL DEV-SERVER SITE.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L'ASSISTANT.
