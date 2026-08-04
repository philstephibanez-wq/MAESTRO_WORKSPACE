# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-04.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 21ce3ccbaa2c09adabc18d4bf021fbb126db9717
Dernier acquis : R45B2A1
```

## Livrable owner actif — R45B2A1R3

```text
ZIP     : opus_p117w_r45b2a1r3_session_identity_onboarding.zip
SHA-256 : 5794c90454beb8df8fefceaba7dc1abb37216ca243f8833ae5c680f596816a46
FILES   : 4
BASE    : 21ce3ccbaa2c09adabc18d4bf021fbb126db9717
STATUS  : livré, validation et push owner requis
```

R45B2A1R3 est cumulatif : autorisation collective `everyone`, distinction des validations standard/générées et onboarding d'identités de session sans secret. Aucun site généré n'est modifié.

Les résultats owner ayant précédé ce livrable sont non conformes : validations structurelles des deux bastions en échec, puis `OWASYS_CREATION_USERS_PROVIDER_INVALID` au stade sécurité.
Aucun commit owner avant validation réussie des deux bastions.

## Suite gouvernée

- R45B2A2 : rétention bornée et rotation JSONL configurable ;
- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
