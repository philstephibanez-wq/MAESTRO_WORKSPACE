# OPUS P117W — E1 SOURCE WORKSPACE GÉNÉRIQUE

Date : 2026-08-05  
Statut : spécification du livrable E1  
Base OPUS : `2c268e998c7f714c17476050e652d7afb88db9f4`

## 1. Décision

E1 implémente le service générique OPUS propriétaire des opérations d’édition de sources. Il prolonge l’inspection en lecture déjà disponible sans encore exposer de mutation dans OWASYS.

La frontière cible reste :

```text
owasys-front
-> REST sécurisé
-> owasys-back
-> Composer allow-listé
-> service générique OPUS Source
-> réponse structurée
-> ViewModel
-> SCORE
```

Aucun site généré n’est une cible. Les fichiers `sites/test7/**` présents dans le commit owner R45B2A4 ne sont ni repris ni modifiés par E1.

## 2. Source de vérité relue

Le dépôt OPUS courant contient :

- `Opus/Application/Inspection/SiteSourceInspector.php`, inspection bornée en lecture ;
- `Opus/Application/Inspection/SiteSourceInspectorInterface.php`, contrat V1 ;
- l’adapter applicatif read-only `sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php` ;
- les commandes OWASYS `source:list`, `source:read` et `source:browse` seulement.

E1 conserve ces contrats de lecture et ajoute une surface générique séparée pour les opérations mutables.

## 3. Fichiers du différentiel

```text
CREATE  Opus/Application/Source/SiteSourceWorkspace.php
CREATE  Opus/Application/Source/SiteSourceWorkspaceInterface.php
MODIFY  Opus/Application/Inspection/SiteSourceInspector.php
```

L’interface homonyme `SiteSourceWorkspaceInterface` étend directement les quatre marqueurs standards OPUS :

- `OpusFrameworkComponentInterface` ;
- `OpusExceptionAwareInterface` ;
- `OpusProfilerAwareInterface` ;
- `OpusSelfDocumentingInterface`.

## 4. Capacités E1

`SiteSourceWorkspace` fournit :

- liste bornée des fichiers textuels autorisés ;
- lecture complète bornée ;
- empreinte SHA-256 de version ;
- métadonnées d’extension, taille, nombre de lignes et convention de fin de ligne ;
- prévisualisation avant écriture ;
- diff unifié borné ;
- verrouillage optimiste par `expectedContentHash` ;
- verrou interprocessus par ressource ;
- écriture atomique via `Opus\File\File::writeAtomic()` ;
- relecture et vérification du hash après écriture ;
- instrumentation Logger et Profiler sans contenu source dans les contextes.

Contrats de réponse :

```text
OPUS_SITE_SOURCE_LIST_V2
OPUS_SITE_SOURCE_FILE_V2
OPUS_SITE_SOURCE_PREVIEW_V1
OPUS_SITE_SOURCE_WRITE_V1
```

## 5. Confinement et sécurité

Le service :

- exige un site conforme à `OPUS_SITE_STANDARD_CONTRACT_CORE` ;
- borne toutes les opérations à `sites/<site>` après résolution réelle ;
- refuse chemin absolu, lecteur Windows, `.` et `..`, segment vide et caractère de contrôle ;
- refuse toute sortie de racine et tout fichier final symbolique ;
- refuse `.git`, `vendor`, `node_modules`, `var`, caches, logs et temporaires ;
- refuse `.env`, variantes `.env.*` et fichiers d’authentification Composer ;
- applique une allow-list d’extensions textuelles ;
- refuse les contenus binaires par caractères de contrôle interdits ;
- impose une taille maximale de 1 MiB ;
- impose une empreinte SHA-256 syntaxiquement valide ;
- retourne `OPUS_SITE_SOURCE_CONFLICT` si l’empreinte attendue n’est plus courante ;
- ne journalise ni contenu, ni diff, ni secret.

Les fichiers de verrou vivent sous `sites/<site>/var/locks/source`, hors de la surface Sources autorisée.

## 6. Compatibilité

`SiteSourceInspector` devient une façade read-only sur `SiteSourceWorkspace` et conserve exactement les contrats externes historiques :

```text
OPUS_SITE_SOURCE_LIST_V1
OPUS_SITE_SOURCE_FILE_V1
read_only = true
```

Aucune commande OWASYS n’est ajoutée dans E1. L’intégration REST/Composer et l’UI appartiennent à E2.

## 7. Validation réalisée avant livraison

- PHP lint des trois fichiers : OK ;
- interface homonyme et quatre marqueurs : OK ;
- archive différentielle : OK ;
- inventaire : 3 fichiers, aucun `sites/**`, aucun OWASYS ;
- smoke isolé : liste, lecture, hash, métadonnées, diff, conflit, traversée, binaire, symlink, écriture et façade V1 : OK ;
- smoke owner complet fourni séparément du ZIP : PHP lint OK.

Le smoke n’est pas inclus dans le ZIP conformément au contrat de livraison.

## 8. Hors périmètre E1

- commandes Composer OWASYS de preview/write ;
- endpoints REST OWASYS ;
- ACL de mutation Sources ;
- UI SCORE de l’éditeur ;
- CodeMirror et coloration ;
- opérations Git ;
- création ou suppression de fichier ;
- édition de fichier binaire ;
- correction locale de `test7`.

Ces éléments relèvent respectivement de E2 et E3.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO LOCAL SITE FIX.  
NO PUSH IMPLICITE.
