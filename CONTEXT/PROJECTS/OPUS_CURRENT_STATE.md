# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-28.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 2c48c86f04ab96fb031c2c22b8505f270a8eafad
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Ne partager aucun fichier, dossier, volume, configuration, secret, manifeste ou état runtime.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Résultats acquis

```text
P117W R6  : supprimer le chargement croisé
P117W R7  : valider les sites propres
P117W R8  : aligner le contrat d’environnement
P117W R9  : restaurer I18n et les bindings réseau
P117W R10 : centraliser dev, test et prod dans config/site.json
P117W R11 : supprimer l’accès Registry local du frontend
P117W R12 : lancer sans préparation manuelle de secrets en dev
P117W R13 : lire host et port depuis la configuration
P117W R14 : cibler le provider Composer backend
P117W R15 : restaurer la FSM frontend canonique
P117W R16 : restaurer les alias de commandes applicatives
P117W R17 : conserver un Logger et un Profiler par application
P117W R18 : conserver la cause interne des erreurs Console
P117W R19 : supprimer les vestiges locaux owasys_old*
P117W R20 : restaurer les quatre opérations backend perdues
```

## Runtime confirmé

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : exit_code 0
frontend /fr-FR/applications : request.completed
```

## Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

## Audit fonctionnel corrigé

Parité confirmée pour :

```text
connexion et SSO
changement de mot de passe
session et contexte applicatif
registre SQLite
synchronisation, sélection et effacement du registre
création d’application
routes et FSM
ACL deny-by-default
I18n UE + ukrainien
rendu SCORE
Logger et Profiler
API REST backend
Composer allow-listé
ajout de langue
création de page
création de rubrique
export de site
```

Le module `source` de l’ancien OWASYS contenait une fonction réelle de navigation en lecture seule. Il ne doit plus être classé comme simple `OWASYS_MODULE_PENDING`.

Fonctions historiques constatées :

```text
lister les fichiers textuels autorisés de l’application courante
lire un fichier autorisé
limiter chaque fichier à 1 Mio
retourner path, bytes, sha256 et content
bloquer .git, vendor, node_modules, var, cache, logs, tmp et .env
```

L’ancienne implémentation est interdite dans l’architecture actuelle car elle :

```text
accède directement au filesystem depuis le frontend
produit le JSON avec echo
repose sur une interface construite en JavaScript
contourne REST sécurisé puis Composer
```

## Évolution générique P117W R21

Créer sous le framework :

```text
Opus/Application/Inspection/SiteSourceInspector.php
Opus/Application/Inspection/SiteSourceInspectorInterface.php
```

Faire implémenter l’interface homonyme par la classe concrète et faire étendre l’interface directement par les quatre marqueurs OPUS.

`SiteSourceInspector` doit valider le contrat standard du site avec `StructuredFileLoader`, lire les fichiers avec `File`, imposer les limites, refuser les liens symboliques et empêcher toute sortie de la racine `sites`.

## Backend P117W R21

Ajouter un provider Source autonome :

```text
sites/owasys-back/application/source/console.php
sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php
sites/owasys-back/application/source/services/OwasysSourceCommandProviderInterface.php
```

Commandes et opérations :

```text
source.list -> owasys:source-list -> owasys:source:list
source.read -> owasys:source-read -> owasys:source:read
```

ACL :

```text
admin     : *:*
developer : source:*
viewer    : source:read
```

## Frontend P117W R21

Créer :

```text
sites/owasys-front/application/source/models/SourceModel.php
sites/owasys-front/application/source/controllers/SourceController.php
sites/owasys-front/application/source/templates/index.score
```

Le frontend :

```text
utilise uniquement RcpRestClient
passe par FSM open_source
exige SSO, ACL source:open et une application courante
rend le ViewModel via SCORE
reste fonctionnel sans JavaScript
ne lit jamais le filesystem applicatif
```

## Livrable actif

```text
ZIP : opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip
SHA-256 : 66fc714986b3d8da7fc74b9a1a573a072cad9404a160484bb5cc866aa499e9ff
Fichiers : 14
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Validation effectuée

```text
PHP lint des fichiers concernés             : OK
JSON                                         : OK
Interface homonyme et quatre marqueurs       : OK
Test runtime isolé list/read                 : OK
Blocage .env, vendor, var et traversée ../   : OK
Rendu SCORE sans echo UI                     : OK
Navigation sans JavaScript obligatoire       : OK
REST puis Composer                           : OK
Chemins interdits dans le ZIP                : 0
ZIP                                          : OK
```

## Validation owner

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

Tester après sélection d’une application :

```text
http://127.0.0.1:8000/fr-FR/source
```

## Statut

```text
P117W R6 à R20 : présents/appliqués
P117W R21 : actif à appliquer
```

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`. Imposer Logger et Profiler. Interdire tout fallback silencieux.
