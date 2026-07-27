# OPUS P117W R12 — DÉMARRAGE AUTONOME DES SERVEURS DE DÉVELOPPEMENT

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne créer aucun partage de fichiers, aucune racine commune, aucun `tools` et aucun répertoire opérationnel `scripts/owasys`.

## Constater la cause

Après P117W R11, les deux sites valident correctement mais `composer opus:dev-server` dépend encore de variables secrètes préparées manuellement :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Cette dépendance empêche de lancer séparément les deux applications avec les commandes Composer contractuelles.

Le problème appartient au framework OPUS et non à une commande locale OWASYS.

## Corriger génériquement OPUS

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
```

Étendre `OPUS_APPLICATION_ENVIRONMENTS_V1` avec un binding strictement réservé à `dev` :

```text
development.contract = OPUS_DEVELOPMENT_DERIVED_SECRET_V1
development.channel  = <canal de développement>
secret               = true
```

Dériver en mémoire les identifiants de développement à partir :

```text
nom de machine
racine OPUS
canal déclaré
nom de variable cible
```

Produire la même valeur dans deux processus Composer séparés exécutés sur la même installation OPUS, sans fichier supplémentaire et sans préparation manuelle.

Refuser ce binding :

- hors de la section `dev` ;
- pour une variable non marquée secrète ;
- lorsque le serveur écoute ailleurs que sur `127.0.0.1`, `localhost` ou `::1` ;
- lorsque le contrat ou le canal est invalide.

Conserver l’interdiction des secrets littéraux.

Conserver les sections `test` et `prod` fondées sur des variables d’environnement de déploiement.

## Corriger les coordonnées de développement

Affectation canonique :

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Dans `sites/owasys-front/config/site.json`, déclarer le backend sur `127.0.0.1:8080`.

Dans `sites/owasys-back/config/site.json`, déclarer le frontend sur `127.0.0.1:8000`.

Conserver l’adresse et le port d’écoute locaux comme arguments de `composer opus:dev-server`.

## Livrer

```text
ZIP : opus_p117w_r12_dev_credentials_in_environment_sections.zip
SHA-256 : 11f06689cabbddd71dace4445e31b31996c7703d709fa092f2a1bdbbc2d7a936
Fichiers : 3
Octets : 14370
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun secret, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit et aucun rapport.

## Valider avant livraison

```text
PHP lint                                              : OK
JSON front/back                                       : OK
Dériver les deux identifiants sans variables externes : OK
Obtenir les mêmes valeurs côté front et back          : OK
Conserver test/prod sur variables d’environnement     : OK
Refuser un bind non loopback                          : OK
Coordonnées front 8000 / back 8080                    : OK
Chemins interdits dans le ZIP                         : 0
Réouvrir le ZIP                                       : OK
```

Marqueurs :

```text
P117W_R12_DERIVED_DEV_CREDENTIALS_OK
P117W_R12_ZIP_CLEAN_OK
```

Ne pas présenter ces validations isolées comme une validation runtime Windows owner.

## Lancer côté owner

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Ne définir manuellement aucune variable bearer/HMAC pour `dev`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
