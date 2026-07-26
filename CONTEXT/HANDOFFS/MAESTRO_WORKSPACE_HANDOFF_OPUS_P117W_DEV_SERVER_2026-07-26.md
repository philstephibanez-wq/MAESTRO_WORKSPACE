# MAESTRO_WORKSPACE HANDOFF — OPUS P117W DEV SERVER

Date : 2026-07-26  
Statut : décision owner validée ; intégration au différentiel P117W requise

## Commande retenue

```text
composer opus:dev-server -- <site-id>
```

`opus:serve-site` est déprécié comme commande canonique.

## Variables exclusivement développement

```text
OPUS_ENV=development
OPUS_DEV_SERVER_HOST
OPUS_DEV_SERVER_PORT
```

L'hôte et le port ne doivent plus être fournis comme valeurs codées en dur ni comme configuration production.

## OWASYS frontend local

```cmd
cd /d H:\OPUS
set "OPUS_ENV=development"
set "OPUS_DEV_SERVER_HOST=127.0.0.1"
set "OPUS_DEV_SERVER_PORT=8080"
composer opus:dev-server -- owasys-front
```

## OWASYS backend local

```cmd
cd /d H:\OPUS
set "OPUS_ENV=development"
set "OPUS_DEV_SERVER_HOST=127.0.0.1"
set "OPUS_DEV_SERVER_PORT=8000"
composer opus:dev-server -- owasys-back
```

## Production

La commande `opus:dev-server` doit refuser tout environnement autre que `development`.

En production, les listeners et endpoints sont fournis par l'infrastructure de déploiement des bastions. Les variables `OPUS_DEV_SERVER_HOST` et `OPUS_DEV_SERVER_PORT` n'ont aucune autorité production.

## Intégration P117W

Le ZIP différentiel P117W doit :

1. ajouter le script Composer `opus:dev-server` ;
2. faire lire les trois variables par le service OPUS générique ;
3. valider l'adresse et le port ;
4. refuser l'exécution hors développement ;
5. journaliser et profiler le démarrage sans secret ;
6. lancer indépendamment `owasys-front` et `owasys-back` ;
7. ne pas embarquer ces valeurs dans les artefacts production.
