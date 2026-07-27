# OPUS P117W R10 — ACTIVER LES SECRETS DE DÉVELOPPEMENT SANS FICHIER SUPPLÉMENTAIRE

Date : 2026-07-27  
État : procédure active ; aucun correctif source supplémentaire requis

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Constater

Après appliquer P117W R10, `opus:dev-server` refuse de démarrer avec :

```text
OPUS_APPLICATION_ENVIRONMENT_SOURCE_MISSING:OPUS_OWASYS_BACKEND_TOKEN
```

Ce refus est contractuel. Les sections `dev`, `test` et `prod` restent dans `config/site.json`, mais les secrets ne doivent jamais être stockés dans Git, dans le ZIP ou sous `var`.

## Traiter la cause

Définir une seule paire de secrets bearer/HMAC dans le processus parent de développement.

Faire hériter exactement les mêmes valeurs aux deux processus enfants :

```text
owasys-back
owasys-front
```

Ne pas lancer séparément les deux applications depuis des terminaux ne partageant pas les mêmes valeurs secrètes.

Ne pas introduire :

```text
.env
.env.local
config/secrets.json
var/development/environment.json
script de lancement dans le produit
secret littéral dans site.json
secret dans argv
```

## Conserver la configuration

Conserver dans chaque `config/site.json` :

```text
environments.dev
environments.test
environments.prod
```

Conserver les adresses et ports d’écoute locaux comme arguments variables de `opus:dev-server`.

Conserver dans la section `dev` les coordonnées du peer et les références suivantes :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

## Lancer

Générer les deux secrets une seule fois dans le terminal parent, puis ouvrir les deux serveurs depuis ce terminal.

Les deux fenêtres enfants héritent des mêmes secrets. Effacer ensuite les variables du terminal parent sans interrompre les processus enfants.

## Statut du code

Ne produire aucun P117W R11 pour cette erreur. P117W R10 exécute correctement le contrat de sécurité en refusant un démarrage sans secrets.

Produire un nouveau ZIP uniquement si un défaut source distinct apparaît après démarrer les deux applications avec les mêmes secrets.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
