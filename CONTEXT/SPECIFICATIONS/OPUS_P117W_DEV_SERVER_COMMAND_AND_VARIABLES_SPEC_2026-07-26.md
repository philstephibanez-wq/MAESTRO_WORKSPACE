# OPUS P117W — DEVELOPMENT SERVER COMMAND AND VARIABLES

Date : 2026-07-26  
Statut : décision owner validée

## Commande canonique

Le serveur PHP local OPUS est lancé exclusivement par :

```text
composer opus:dev-server -- <site-id>
```

Le script Composer historique `opus:serve-site` est déprécié par P117W et ne doit plus être utilisé comme commande canonique.

## Portée

`opus:dev-server` est strictement réservé au développement local.

Il est interdit :

- en production ;
- dans un artefact de déploiement production ;
- dans un service système production ;
- comme mécanisme de reverse proxy ;
- comme source de configuration réseau production.

La commande doit échouer explicitement lorsque l'environnement n'est pas déclaré `development`.

## Variables de développement

L'adresse et le port sont fournis uniquement par variables d'environnement de développement :

```text
OPUS_ENV=development
OPUS_DEV_SERVER_HOST=<adresse locale>
OPUS_DEV_SERVER_PORT=<port local>
```

Aucune adresse ni aucun port n'est codé en dur dans OPUS, OWASYS ou un fichier de configuration production.

Les options CLI `--host` et `--port` ne constituent plus la forme canonique P117W.

## OWASYS local

### Frontend

```cmd
cd /d H:\OPUS
set "OPUS_ENV=development"
set "OPUS_DEV_SERVER_HOST=127.0.0.1"
set "OPUS_DEV_SERVER_PORT=8080"
composer opus:dev-server -- owasys-front
```

### Backend

```cmd
cd /d H:\OPUS
set "OPUS_ENV=development"
set "OPUS_DEV_SERVER_HOST=127.0.0.1"
set "OPUS_DEV_SERVER_PORT=8000"
composer opus:dev-server -- owasys-back
```

Ces valeurs sont des conventions locales de développement, pas des valeurs contractuelles de production.

## Production

En production :

- `OPUS_DEV_SERVER_HOST` et `OPUS_DEV_SERVER_PORT` sont ignorées ou refusées ;
- `opus:dev-server` est bloqué ;
- les endpoints, listeners, ports internes, certificats et reverse proxies sont fournis par l'infrastructure de déploiement ;
- `owasys-front` et `owasys-back` peuvent être installés sur deux bastions distincts ;
- le navigateur ne joint jamais directement `owasys-back`.

## Framework

Cette capacité est générique OPUS. Elle ne doit pas être implémentée comme un contournement local OWASYS.

Toute nouvelle classe concrète framework ajoutée pour ce contrat doit implémenter son interface homonyme, laquelle étend directement les quatre marqueurs standards OPUS.
