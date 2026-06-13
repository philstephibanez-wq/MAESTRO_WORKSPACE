# HANDOFF ASAP_REF_BOOK — P115 RefBook consumes ASAP vendor

## Dépôt

```text
H:\ASAP_REF_BOOK
GitHub : philstephibanez-wq/ASAP_REF_BOOK
Branche : p114-refbook-wip
```

## Décision

RefBook ne porte plus Twig directement. Twig appartient à ASAP tant que ScoreTemplate n’a pas remplacé Twig.

## Nettoyage attendu

- Supprimer `H:\ASAP_REF_BOOK\vendor` local.
- Retirer `twig/twig` du `composer.json` RefBook.
- Retirer `composer.lock` du dépôt RefBook.
- Vérifier que le bootstrap consomme `H:\ASAP\vendor\autoload.php`.
- Vérifier visuellement `127.0.0.1/ASAP_REF_BOOK/`.

Commit cible :

```text
P115D Consume ASAP vendor instead of RefBook vendor
```

## Future migration

Après P115C/P115D :
- créer ScoreTemplate côté ASAP ;
- migrer RefBook de Twig vers ScoreTemplate ;
- supprimer Twig d’ASAP seulement quand RefBook fonctionne sans Twig.
