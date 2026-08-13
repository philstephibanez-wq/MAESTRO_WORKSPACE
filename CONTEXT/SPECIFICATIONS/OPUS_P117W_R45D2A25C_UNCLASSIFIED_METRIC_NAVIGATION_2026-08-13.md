# OPUS P117W R45D2A25C — Unclassified Metric Navigation

Date: 2026-08-13

## Cause

Dans le cockpit Security publié par R45D2A25A/B, la tuile métrique `À classifier` est rendue comme un `<article>` statique alors que son apparence suggère une interaction. Le vrai contenu `À classifier` est un `<details>` distinct plus bas dans la page. Un clic sur la métrique ne peut donc rien ouvrir.

## Contrat

- la métrique `À classifier` devient un lien SCORE vers le panneau réel ;
- le panneau reçoit un identifiant stable `ow-security-unclassified` ;
- lorsque des identités `unknown` existent, le panneau est rendu `open` afin que la navigation atteigne directement son contenu ;
- aucune logique JavaScript ;
- aucun changement backend, REST, ACL, FSM ou mutation ;
- les actions `Classifier l’identité` et `Supprimer` restent conditionnées par les capacités Security déjà calculées, donc aucun contrôle de mutation ne devient visible pour `viewer` ;
- le correctif reste une évolution de présentation du front OWASYS uniquement.

## Base publiée

`bde15d01e7e357fe83c257e87de04b3de35065d3` — `opus_p117w_r45d2a25b_securitycontroller_source_canonicalization`.

## Gate

Le clic sur `À classifier` doit atteindre immédiatement le panneau ouvert contenant les trois identités legacy de `essai2`. En admin/developer, les actions lifecycle doivent être visibles. En viewer, le panneau peut être lisible mais aucune action lifecycle ne doit être rendue.
