# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

OPUS master : `05c0075027ac5818fb6960680e390721fa028b3f` — `opus_p117w_r45d2a25c_unclassified_metric_navigation`.

## Acquis récents

R45D2A25A expose le lifecycle Utilisateur/Agent dans le front Security. R45D2A25B remet `SecurityController.php` en forme canonique sans changer le comportement. R45D2A25C rend la métrique `À classifier` navigable vers le panneau réel et ouvre ce panneau en SCORE/CSS uniquement.

## Validation navigateur lifecycle

- navigation `À classifier` validée ;
- actions Classifier/Supprimer visibles en admin ;
- suppression d'une identité legacy validée via Preview puis Commit ;
- classification `unknown -> user` validée sur `steve` ;
- la Preview de classification n'a montré aucun accès gagné ni perdu ;
- le rôle `admin` de `steve` est conservé après classification ;
- état courant observé : 1 Utilisateur (`steve`), 0 Agent, 1 identité legacy restante (`home`).

## Gate actif

Validation finale : Preview de suppression de `steve` pour vérifier le refus de supprimer la dernière identité administrative, sans Commit, puis contrôle viewer sans aucun bouton lifecycle.
