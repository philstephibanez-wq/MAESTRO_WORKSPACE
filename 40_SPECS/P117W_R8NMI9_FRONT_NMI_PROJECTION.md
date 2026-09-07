# P117W R8NMI9 — Projection NMI sur OWASYS front

Status: DELIVERED — owner runtime acceptance pending

## Autorité

Cette évolution applique `README-FIRST.md`, le contrat de ZIP natif différentiel, le workflow stepwise et le Security Baseline Contract.

## Défaut prouvé

Le front possède bien les NMI canoniques dans `sites/owasys-front/config/fsm.json`, notamment :

- `* --critical_error / NMI--> fault` ;
- `* --security_violation / NMI--> security_quarantine`.

Cependant, la projection hôte de `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` élimine explicitement toute transition ayant `interrupt = nmi` avant l'appel au renderer OPUS. Les états purs de destination (`fault`, `security_quarantine`) sont également absents du sous-ensemble construit uniquement depuis les états de navigation autorisés.

Le back pouvant afficher les NMI, le renderer OPUS n'est pas la cause de cette absence spécifique au front.

## Correction

La projection front :

1. conserve les états de navigation existants ;
2. découvre les destinations de toutes les transitions NMI canoniques ;
3. exige pour une NMI projetée : identifiant non vide, `from = *`, signal déclaré et destination existante ;
4. ajoute ces états purs uniquement au sous-ensemble du diagramme, sans les transformer en modules ni en entrées de navigation ;
5. accepte un état courant de contrôle NMI comme état visible du diagramme ;
6. projette directement la transition NMI avec sa sémantique canonique `from = *` ;
7. ne convertit pas une NMI en transition `global` et ne touche pas au flux métier/actionnable ;
8. conserve le renderer OPUS et le back inchangés.

Cette correction traite la cause locale de projection OWASYS front. Elle n'introduit aucune primitive NMI spécifique supplémentaire dans OPUS puisque le renderer générique sait déjà les représenter.

## Fichier livré

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Baseline GitHub blob SHA-1 : `dc23e0303bf95e8315a401058343798b83356706`.

## Critères d'acceptation

- PHP lint OK ;
- `composer opus:validate-site -- owasys-front` OK ;
- diff limité au builder attendu ;
- le diagramme front affiche les deux NMI canoniques vers `fault` et `security_quarantine` ;
- les transitions ordinaires/globales restent inchangées ;
- aucun changement dans `owasys-back` ;
- aucune création de module factice pour les états purs ;
- toute régression ou divergence de baseline est un stop condition.
