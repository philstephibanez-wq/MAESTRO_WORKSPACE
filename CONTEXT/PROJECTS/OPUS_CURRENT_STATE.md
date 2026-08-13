# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

OPUS master : `bde15d01e7e357fe83c257e87de04b3de35065d3` — `opus_p117w_r45d2a25b_securitycontroller_source_canonicalization`.

## Acquis

Les incréments R45D2A21C à R45D2A25B sont publiés. R45D2A25B remet `SecurityController.php` en forme canonique sans modifier son comportement.

## Observation UI

Dans le cockpit, la métrique `À classifier` est actuellement un élément statique alors que le panneau correspondant existe plus bas dans la page. La capture owner confirme que le clic ne produit aucune navigation.

## Gate actif

R45D2A25C — rendre la métrique `À classifier` navigable vers son panneau et rendre ce panneau ouvert lorsqu'il contient des éléments, en SCORE/CSS uniquement.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25c_unclassified_metric_navigation.zip
SHA-256 : 83c19ae44dacd128beae6660afccdf41a03777ee1123412fd8bcb42154d1c3c6
BASE    : bde15d01e7e357fe83c257e87de04b3de35065d3
FILES   : 2
```

Gates attendus :
- `OPUS_R45D2A25C_APPLIED`
- `OPUS_R45D2A25C_UNCLASSIFIED_METRIC_NAVIGATION_OK`
- navigation visuelle correcte depuis la métrique vers le panneau.
