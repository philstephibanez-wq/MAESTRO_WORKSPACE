# SERVER_LINUX — Web stack Apache / PHP

## Décision initiale

Stack recommandée pour démarrage :

- Apache ;
- PHP via paquets Debian ;
- SQLite pour usages simples ;
- MariaDB ou PostgreSQL selon besoin applicatif.

## Pourquoi Apache au départ

Apache est cohérent avec l'historique UwAmp et facilite le portage progressif de :

- ASAP_REF_BOOK ;
- applications PHP/ASAP ;
- virtual hosts classiques ;
- configuration lisible.

Nginx + PHP-FPM reste possible plus tard, mais n'est pas la première étape.

## Règle ASAP

ASAP est un framework mutualisé.

Il doit être installé hors racine web exposée, par exemple :

```text
/opt/asap
```

Il ne doit pas être exposé directement par Apache.

## Règle ASAP_REF_BOOK

ASAP_REF_BOOK est un site exposé.

Racine recommandée :

```text
/srv/asap_ref_book
```

Le site consomme ASAP via un chemin configuré explicitement.

## PHP

Installer PHP via paquets Debian au départ.

Règles :

- pas de version bricolée ;
- toute version spécifique doit être documentée ;
- extensions installées explicitement ;
- aucune extension ajoutée sans besoin confirmé.

## Bases de données

Options :

- SQLite : local/simple/embarqué ;
- MariaDB : sites classiques ;
- PostgreSQL : besoin plus structuré.

Aucune BDD ne doit être exposée publiquement sans authentification stricte.
