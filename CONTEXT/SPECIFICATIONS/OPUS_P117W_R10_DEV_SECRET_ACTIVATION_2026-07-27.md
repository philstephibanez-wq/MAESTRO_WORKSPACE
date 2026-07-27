# OPUS P117W R10 — ACTIVER LES SECRETS ET LANCER LES SERVEURS DE DÉVELOPPEMENT

Date : 2026-07-27  
État : procédure active ; aucun correctif source supplémentaire requis

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver dans chaque `config/site.json` :

```text
environments.dev
environments.test
environments.prod
```

Conserver les secrets hors de Git, du ZIP, de `config`, de `var`, des journaux, du profiler et des arguments.

## Affecter les ports

Utiliser l’affectation canonique suivante en développement :

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

Utiliser le script Composer contractuel suivant pour les deux applications :

```text
opus:dev-server
```

Ne pas utiliser `composer dev-server` tant qu’aucun alias Composer `dev-server` n’est déclaré dans le contrat du dépôt.

## Préparer les secrets

Définir dans chacun des deux environnements de processus les mêmes valeurs pour :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Refuser tout démarrage lorsqu’une de ces variables manque.

## Lancer le frontend

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

## Lancer le backend

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Diagnostiquer l’inversion

Recevoir `OWASYS_BACK_ROUTE_FORBIDDEN` sur :

```text
http://127.0.0.1:8000/fr-FR/applications
```

signifie que le backend a été lancé sur le port réservé au frontend.

Arrêter les deux processus et relancer les commandes avec l’affectation canonique.

## Statut du code

Ne produire aucun P117W R11 pour une simple inversion des commandes ou pour une variable secrète absente.

Produire un nouveau ZIP uniquement si un défaut source distinct apparaît après lancer les deux applications avec les bons ports et les mêmes secrets.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
