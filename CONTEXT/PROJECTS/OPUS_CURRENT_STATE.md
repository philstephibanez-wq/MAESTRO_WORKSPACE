# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-30.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 63470fb43c4b692eea2d7db2c0be5f6086008d1a
Racine owner : H:/OPUS
```

## État acquis

- R38 : création layered supprimée.
- R39 : stockage REST replay fichier supprimé.
- R40 : ancien `sites/demo-opus` supprimé.
- R42 : serveur de développement générique appliqué.
- `sites/opus-demo` supprimé par l’owner.
- R43 : assistant transactionnel appliqué et poussé avec exactement 39 fichiers.
- `owasys-front` et `owasys-back` restent les deux seules applications OWASYS.

## Action active — R44

Valider en runtime le workflow `basics -> security -> review -> mutation`, puis créer depuis OWASYS un site fullstack neuf et minimal.

Le site attendu contient uniquement l’accueil et, si demandé, le login. Il initialise les langues UE + ukrainien et respecte Singleton, FSM, I18n, ACL deny-by-default, SSO, SCORE, Logger et Profiler.

Tout défaut ouvre un correctif générique OPUS/OWASYS. Le site généré n’est jamais corrigé manuellement.

## Invariants

- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- aucune mutation avant confirmation ;
- SCORE uniquement, sans mélange HTML/PHP ;
- backend OWASYS exclusivement PHP ;
- aucune scorie après rollback ;
- l’assistant ne committe ni ne pousse OPUS/OWASYS.
