# OPUS P117W R9 — CONFIGURER LE RÉSEAU DE DÉVELOPPEMENT ET RESTAURER I18N FRONT

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire et appliquer :

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
```

Traiter la cause, jamais l’effet.

## Conserver l’architecture

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier, dossier, volume, secret, configuration ou état runtime.

## Constater les causes

Les deux serveurs de développement démarrent après P117W R8.

Le frontend échoue dans :

```text
sites/owasys-front/application/default/services/LocaleRegistry.php:152
```

Le `site.json` frontend déclare les locales régionales mais ne déclare plus `i18n.language_defaults`. `OwasysLocaleRegistry` exige une locale régionale par défaut pour chaque langue configurée.

La configuration de développement ne déclare pas non plus de contrat réseau complet permettant à chaque application de connaître :

```text
son adresse d’écoute
son port d’écoute
son URL locale
l’identifiant de l’application distante
l’adresse de l’application distante
le port de l’application distante
l’URL ou endpoint de l’application distante
```

## Faire évoluer OPUS génériquement

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
```

Faire accepter à `opus:dev-server` toute adresse IP ou tout nom d’hôte syntaxiquement valide. Réserver cette commande au développement.

Lire dans `development_server.network` le contrat :

```text
OPUS_DEVELOPMENT_NETWORK_BINDING_V1
```

Injecter dans le processus de l’application les valeurs locales provenant exclusivement des arguments de commande :

```text
OPUS_DEV_SERVER_HOST
OPUS_DEV_SERVER_PORT
OPUS_DEV_SERVER_URL
```

Ne coder aucune adresse ni aucun port en dur.

Lire dans le fichier runtime local de chaque application les valeurs de l’application distante. Valider :

```text
adresse distante valide
port distant valide
URL distante HTTP ou HTTPS
égalité entre l’hôte de l’URL et l’hôte déclaré
égalité entre le port de l’URL et le port déclaré
application distante différente de l’application locale
```

Refuser tout endpoint incohérent ou incomplet sans fallback silencieux.

## Configurer le frontend

Modifier :

```text
sites/owasys-front/config/site.json
```

Restaurer la politique I18n complète :

```text
OPUS_APPLICATION_I18N_POLICY_V4
source initiale : navigateur
fallback explicite : fr-FR
sélecteur : langues de l’Union européenne + ukrainien
locales sélectionnables : régionales uniquement
language_defaults : une locale régionale par langue
fallback silencieux : interdit
```

Déclarer le réseau de développement :

```text
local : OPUS_DEV_SERVER_HOST / PORT / URL
peer  : owasys-back
host  : OPUS_OWASYS_BACKEND_HOST
port  : OPUS_OWASYS_BACKEND_PORT
url   : OPUS_OWASYS_BACKEND_ENDPOINT
```

Conserver le client REST sous `config/rcp.json`. Le frontend utilise l’endpoint backend configuré dans son propre environnement runtime local.

## Configurer le backend

Modifier :

```text
sites/owasys-back/config/site.json
```

Déclarer la même politique I18n contractuelle pour l’API.

Déclarer le réseau de développement :

```text
local : OPUS_DEV_SERVER_HOST / PORT / URL
peer  : owasys-front
host  : OPUS_OWASYS_FRONTEND_HOST
port  : OPUS_OWASYS_FRONTEND_PORT
url   : OPUS_OWASYS_FRONTEND_ENDPOINT
```

Le backend connaît ainsi l’identité réseau du frontend sans initier de commande métier vers lui. La direction métier reste exclusivement frontend vers backend.

## Conserver les configurations runtime locales

Conserver deux fichiers distincts, non partagés et non livrés :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Le fichier frontend contient les coordonnées du backend et les secrets REST/HMAC.

Le fichier backend contient les coordonnées du frontend et les mêmes secrets REST/HMAC nécessaires à l’authentification de l’échange.

Ne placer aucun secret dans Git, le ZIP, les logs, le profiler ou les arguments de commande.

## Limiter le périmètre à la phase de développement

Appliquer `development_server.network` uniquement à `opus:dev-server`.

Ne pas utiliser ces bindings pour la production. Configurer indépendamment chaque bastion de production par son infrastructure de déploiement, son reverse proxy, ses secrets et ses endpoints sécurisés.

## Livrer

```text
ZIP : opus_p117w_r9_dev_network_bindings_and_front_i18n.zip
SHA-256 : 3698a7e7f94ab50b95af24c5f93daec3e24ead081113196162ba59923ccb7455
Fichiers : 3
Octets : 12262
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et R3 à R8 appliqués
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Valider avant livraison

```text
Analyser la syntaxe PHP                                  : OK
Analyser les deux JSON                                   : OK
Valider la couverture de tous les language_defaults      : OK
Injecter l’adresse et le port locaux depuis les arguments : OK
Valider l’adresse, le port et l’URL du peer               : OK
Refuser une incohérence port/URL                          : OK
Détecter les chemins interdits dans le ZIP                : 0
Réouvrir le ZIP                                           : OK
```

Marqueurs :

```text
OWASYS_FRONT_LANGUAGE_DEFAULTS_OK
P117W_R9_NETWORK_BINDING_OK
P117W_R9_JSON_OK
P117W_R9_ZIP_CLEAN_OK
```

Ne pas présenter ces validations isolées comme une validation runtime Windows owner.

## Valider côté owner

Valider successivement :

```text
composer dump-autoload -o
php -l Opus/Console/Service/SiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back --host=<adresse-back> --port=<port-back>
composer opus:dev-server -- owasys-front --host=<adresse-front> --port=<port-front>
```

Tester :

```text
http://<adresse-back>:<port-back>/api/v1/status
http://<adresse-front>:<port-front>/fr-FR/
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
