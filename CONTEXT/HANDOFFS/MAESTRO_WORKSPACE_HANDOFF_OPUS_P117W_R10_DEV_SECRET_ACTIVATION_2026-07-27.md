# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R10 DEV SERVER ACTIVATION

Date : 2026-07-27  
État : procédure active ; aucun ZIP supplémentaire requis

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R10 appliqués
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier entre les deux applications.

## Affectation canonique en développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour lancer les deux applications.

Ne pas utiliser `composer dev-server` tant qu’un alias Composer homonyme n’est pas présent dans le dépôt.

## Préparer les secrets

Définir les mêmes valeurs dans les deux environnements de processus :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Ne placer aucune valeur secrète dans Git, le ZIP, `config`, `var`, les journaux, le profiler ou argv.

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

## Diagnostiquer

Recevoir une réponse `OWASYS_BACK_ROUTE_FORBIDDEN` sur le port `8000` signifie que le backend occupe le port réservé au frontend.

Arrêter les deux processus avec `Ctrl+C`, puis relancer les commandes avec la bonne affectation.

## Statut

```text
P117W R10 : appliqué
Erreur source distincte : aucune démontrée par l’inversion des ports
Activation runtime : définir les secrets puis lancer frontend:8000 et backend:8080
Nouveau ZIP : non requis
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
