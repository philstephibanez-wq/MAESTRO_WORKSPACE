# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R10

Date : 2026-07-27  
État : livrable appliqué ; procédure de lancement corrigée

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Base locale : P117W initial et R3 à R10 appliqués
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

Ne partager aucun fichier et ne créer aucune racine commune.

## Décision R10

Conserver une section `environments` dans le `config/site.json` de chaque application :

```text
dev
test
prod
```

Utiliser `OPUS_APPLICATION_ENVIRONMENTS_V1` et sélectionner l’environnement par `OPUS_ENV`.

Faire sélectionner `dev` automatiquement par `opus:dev-server`.

Conserver l’adresse et le port locaux comme arguments variables de la commande. Déclarer l’adresse, le port et l’endpoint du peer dans la section de l’environnement correspondant.

Conserver les secrets hors du fichier de configuration. Référencer les variables d’environnement bearer et HMAC et refuser leur absence avant démarrer le serveur.

## Livrable appliqué

```text
ZIP : opus_p117w_r10_single_environment_config_sections.zip
SHA-256 : 590f204c6ea2cb36816499443e735174b51d557813731b54efbe8e93878e3c59
Fichiers : 3
Octets : 12938
```

## Affectation canonique en développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

## Préparer les secrets

Définir les mêmes valeurs dans les deux environnements de processus :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Ne placer aucune valeur secrète dans Git, le ZIP, les journaux, le profiler, `config`, `var` ou argv.

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

Utiliser le préfixe `opus:` pour les deux scripts Composer. Ne pas supposer l’existence d’un alias `composer dev-server`.

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Diagnostiquer

Une réponse `OWASYS_BACK_ROUTE_FORBIDDEN` sur `http://127.0.0.1:8000/fr-FR/applications` indique que le backend a été lancé sur le port réservé au frontend.

Arrêter les deux serveurs puis les relancer avec l’affectation canonique.

## Validation

```text
P117W R10 appliqué
Configuration centralisée dans config/site.json
Frontend réservé au port 8000 en développement local
Backend réservé au port 8080 en développement local
Nouveau ZIP non requis pour corriger l’ordre de lancement
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
