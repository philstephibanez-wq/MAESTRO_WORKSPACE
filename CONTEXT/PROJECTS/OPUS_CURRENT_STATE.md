# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-04.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : edf17d28d32b1c2f293ba7993252b6e1748c906c
Dernier acquis : R45B2A1
```

## Livrable owner actif — R45B2A1R2

```text
ZIP     : opus_p117w_r45b2a1r2_everyone_validation_regressions.zip
SHA-256 : c8dbf7d0c726c659b666728b208fcd7b024aaa5c7c04fe9ccf39591ada122516
FILES   : 2
BASE    : edf17d28d32b1c2f293ba7993252b6e1748c906c
STATUS  : livré, validation et push owner requis
```

R45B2A1R2 est cumulatif : autorisation collective `everyone`, distinction des noms FSM standard/généré et exigences du runtime backend généré limitées aux applications générées. Aucun fichier OWASYS ni site témoin n'est modifié.

Les résultats owner ayant précédé ce livrable sont non conformes :
`owasys-front = OPUS_SITE_FSM_CONTRACT_INVALID` et `owasys-back = OPUS_SITE_REQUIRED_PATH_MISSING`.
Aucun commit owner avant validation réussie des deux bastions.

## Suite gouvernée

- R45B2A2 : rétention bornée et rotation JSONL configurable ;
- R45B3 : client REST frontend générique et validateurs croisés ;
- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
