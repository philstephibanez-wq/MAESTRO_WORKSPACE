# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-05.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 2c268e998c7f714c17476050e652d7afb88db9f4
Dernier jalon scaffold publié : R45B2A4
```

## État des jalons précédents

- R45B2A2 est acquis et publie la rétention/rotation bornée du Profiler JSONL.
- R45B2A3 est publié à `a1afd6415c9ddbd80b7944756210f33c36f7253b` et ajoute le module `application/profiler` au scaffold générique.
- `test7` a ensuite été généré par OWASYS.
- R45B2A4 est publié au HEAD courant et aligne `profiler:view` sur les rôles de la page d’accueil dans le scaffold générique.
- Le commit R45B2A4 contient aussi des fichiers générés de `test7`; ils ne constituent pas la cible du livrable E1.

## Livrable owner actif — E1

```text
ZIP     : opus_p117w_e1_source_workspace.zip
SHA-256 : b4b4b681ea9e7ca19c06529f9bf59ba8125e31a2aadd7d89927f3c6be71bb657
FILES   : 3
BASE    : 2c268e998c7f714c17476050e652d7afb88db9f4
STATUS  : livré, application, validation et push owner requis
```

E1 crée le service générique `SiteSourceWorkspace` pour liste, lecture, métadonnées, diff, verrouillage optimiste et écriture atomique. La façade `SiteSourceInspector` conserve ses contrats read-only V1.

Le smoke owner reste hors ZIP.

## Suites gouvernées

1. validation, commit et push owner de E1 ;
2. E2 : intégration OWASYS Sources, REST sécurisé puis Composer allow-listé, ACL, ViewModel et SCORE ;
3. E3 : statut/diff/historique/stage/unstage/commit Git contrôlés sans push implicite ;
4. R45B3 : client REST frontend générique et validateurs croisés ;
5. R45C : wizard OWASYS structuré ;
6. R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L’ASSISTANT.
