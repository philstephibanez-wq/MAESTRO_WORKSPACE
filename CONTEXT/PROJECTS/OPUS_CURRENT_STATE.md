# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-05.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 60f45aae8ee6f3a10096069076900a41c33d9a19
Dernier acquis : E1 source workspace
```

## État des jalons précédents

- R45B2A2 est acquis et publie la rétention/rotation bornée du Profiler JSONL.
- R45B2A3 est publié à `a1afd6415c9ddbd80b7944756210f33c36f7253b` et ajoute le module `application/profiler` au scaffold générique.
- `test7` a ensuite été généré par OWASYS.
- R45B2A4 est publié à `2c268e998c7f714c17476050e652d7afb88db9f4` et aligne `profiler:view` sur les rôles de la page d’accueil dans le scaffold générique.
- E1 est publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- La comparaison E1 contient exactement les trois fichiers annoncés et aucun site ni smoke.

## E1 acquis

`SiteSourceWorkspace` fournit désormais dans OPUS :

- liste et lecture bornées ;
- métadonnées et empreinte SHA-256 ;
- diff de prévisualisation ;
- verrouillage optimiste ;
- verrou interprocessus ;
- écriture atomique ;
- instrumentation Logger/Profiler sans contenu source.

## Livrable owner actif — E2A

```text
ZIP     : opus_p117w_e2a_source_rest_composer.zip
SHA-256 : cb6ff147974ef987cb416a106f28a6b4f13fabcb20a62d6e4b3f986c25ea7f13
FILES   : 7
BASE    : 60f45aae8ee6f3a10096069076900a41c33d9a19
STATUS  : livré, application, validation et push owner requis
```

E2A ajoute :

- transport générique `request` pour les paramètres Composer qui ne doivent pas entrer dans `argv` ;
- conservation exacte du contenu avec `trim=false` ;
- routes REST preview et write ;
- opérations Composer allow-listées ;
- ACL admin/developer pour mutation ;
- provider OWASYS-back utilisant exclusivement E1 ;
- statut HTTP 409 pour conflit optimiste.

Aucun fichier `owasys-front`, aucun site généré et aucun JavaScript backend ne figurent dans E2A.

Le smoke owner reste hors ZIP.

## Suites gouvernées

1. validation, commit et push owner de E2A ;
2. E2B : éditeur Sources dans `owasys-front`, ViewModel, SCORE, preview/write et conflit concurrent ;
3. E3 : statut/diff/historique/stage/unstage/commit Git contrôlés sans push implicite ;
4. R45B3 : client REST frontend générique et validateurs croisés ;
5. R45C : wizard OWASYS structuré ;
6. R45D : administration Sécurité.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
