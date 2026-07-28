# OPUS P117W R21 — RESTAURER LE NAVIGATEUR DE SOURCES VIA REST, COMPOSER ET SCORE

Date : 2026-07-28  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md`, les règles globales MAESTRO/OPUS/OWASYS et le contrat standard des sites OPUS.

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 2c48c86f04ab96fb031c2c22b8505f270a8eafad
Ancien module audité : sites/owasys_old/application/states/source
```

## Corriger l’audit fonctionnel

Le module `source` de l’ancien OWASYS n’était pas une simple surface en attente. Il permettait :

```text
lister les fichiers autorisés de l’application sélectionnée
lire un fichier autorisé en lecture seule
limiter la taille à 1 Mio
bloquer .git, vendor, node_modules, var, cache, logs et tmp
bloquer les fichiers .env
retourner path, bytes, sha256 et content
```

L’ancienne implémentation n’est pas restaurable telle quelle car elle :

```text
accède directement au filesystem depuis le frontend
utilise une action PHP locale
produit du JSON avec echo
construit l’interface avec JavaScript
contourne REST puis Composer
```

## Évolution générique OPUS obligatoire

Créer :

```text
Opus/Application/Inspection/SiteSourceInspector.php
Opus/Application/Inspection/SiteSourceInspectorInterface.php
```

`SiteSourceInspector` doit :

```text
implémenter son interface homonyme
faire étendre cette interface par les quatre marqueurs OPUS
valider OPUS_SITE_STANDARD_CONTRACT_CORE via StructuredFileLoader
résoudre uniquement sites/<site_id>
interdire toute sortie de la racine sites
lister uniquement les extensions textuelles autorisées
ignorer les liens symboliques
bloquer les segments et fichiers sensibles
lire le contenu avec Opus\File\File
limiter à 5000 fichiers et 1 Mio par fichier
retourner uniquement des chemins relatifs
```

Contrats retournés :

```text
OPUS_SITE_SOURCE_LIST_V1
OPUS_SITE_SOURCE_FILE_V1
```

## Backend OWASYS

Ajouter un provider métier autonome :

```text
sites/owasys-back/application/source/console.php
sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php
sites/owasys-back/application/source/services/OwasysSourceCommandProviderInterface.php
```

Ajouter les commandes canoniques :

```text
owasys:source:list
owasys:source:read
```

Ajouter les alias Composer publics :

```text
owasys:source-list
owasys:source-read
```

Ajouter les opérations REST allow-listées :

```text
source.list
source.read
```

Flux obligatoire :

```text
owasys-front SCORE
-> FSM + ACL + SSO
-> REST bearer + HMAC
-> FSM backend
-> Composer allow-listé
-> OwasysSourceCommandProvider
-> SiteSourceInspector OPUS
-> résultat structuré
-> ViewModel
-> SCORE
```

ACL backend :

```text
admin     : *:*
developer : source:*
viewer    : source:read
```

## Frontend OWASYS

Créer :

```text
sites/owasys-front/application/source/models/SourceModel.php
sites/owasys-front/application/source/controllers/SourceController.php
sites/owasys-front/application/source/templates/index.score
```

Modifier :

```text
sites/owasys-front/application/default/bootstrap.php
sites/owasys-front/application/default/Application.php
```

Le frontend doit :

```text
ne jamais ouvrir un fichier applicatif local
utiliser exclusivement RcpRestClient
passer par l’événement FSM open_source
exiger une identité et une application courante
appliquer ACL source:open
rendre la liste et le contenu exclusivement via SCORE
fonctionner sans JavaScript
conserver la négociation initiale de langue depuis le navigateur
réutiliser les catalogues I18n communs sans textes UI bruts
```

## Livrable

```text
ZIP : opus_p117w_r21_restore_source_browser_via_rest_composer_score.zip
SHA-256 : 66fc714986b3d8da7fc74b9a1a573a072cad9404a160484bb5cc866aa499e9ff
Fichiers : 14
```

Contenu exclusif :

```text
Opus/Application/Inspection/SiteSourceInspector.php
Opus/Application/Inspection/SiteSourceInspectorInterface.php
composer.json
sites/owasys-back/application/source/console.php
sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php
sites/owasys-back/application/source/services/OwasysSourceCommandProviderInterface.php
sites/owasys-back/config/acl.json
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/composer.commands.json
sites/owasys-front/application/default/Application.php
sites/owasys-front/application/default/bootstrap.php
sites/owasys-front/application/source/controllers/SourceController.php
sites/owasys-front/application/source/models/SourceModel.php
sites/owasys-front/application/source/templates/index.score
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Validation effectuée

```text
PHP lint des 9 fichiers PHP                         : OK
JSON composer/config                                : OK
Classe OPUS et interface homonyme                    : OK
Quatre marqueurs OPUS                               : OK
Lecture de configuration via StructuredFileLoader   : OK
Lecture de fichier via File                         : OK
Test runtime isolé list/read                        : OK
Blocage .env, vendor et var                         : OK
Blocage traversée ../                               : OK
Rendu frontend SCORE sans echo                      : OK
Navigation sans JavaScript obligatoire              : OK
REST puis Composer                                  : OK
Chemins interdits dans le ZIP                       : 0
```

Marqueurs :

```text
P117W_R21_INSPECTOR_RUNTIME_OK
P117W_R21_SOURCE_REST_COMPOSER_SCORE_READY
P117W_R21_ZIP_CLEAN_OK
```

La validation runtime intégrée Windows des deux serveurs reste à effectuer côté owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
