# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R10 DEV SECRET ACTIVATION

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

## Erreur owner

```text
OPUS_APPLICATION_ENVIRONMENT_SOURCE_MISSING:OPUS_OWASYS_BACKEND_TOKEN
```

## Cause

P117W R10 référence les secrets de développement par variables d’environnement et refuse tout secret littéral dans `config/site.json`.

Les deux commandes ont été lancées sans définir les secrets requis dans leur environnement de processus.

## Activer

Générer une seule paire bearer/HMAC dans un terminal parent.

Lancer `owasys-back` et `owasys-front` depuis ce même terminal afin de faire hériter les mêmes valeurs aux deux processus enfants.

Conserver :

```text
owasys-back : 127.0.0.1:8000
owasys-front : 127.0.0.1:8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Interdire

Ne pas ajouter :

```text
.env
.env.local
config/secrets.json
var/development/environment.json
tools
scripts/owasys
secret littéral dans site.json
secret dans argv
```

## Statut

```text
P117W R10 : appliqué
Erreur source : aucune démontrée
Activation runtime : définir les deux secrets puis démarrer les deux processus
Nouveau ZIP : non requis
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
