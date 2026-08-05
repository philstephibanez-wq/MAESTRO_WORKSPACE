# OPUS P117W — E2A SOURCES REST / COMPOSER

Date : 2026-08-05  
Statut : spécification du livrable E2A  
Base OPUS : `60f45aae8ee6f3a10096069076900a41c33d9a19`

## 1. Acquisition E1

E1 est publié par l’owner sur `OPUS/master` au commit :

```text
60f45aae8ee6f3a10096069076900a41c33d9a19
opus_p117w_e1_source_workspace
```

Le commit owner est exactement en avance d’un commit sur la base E1 et ne contient que les trois fichiers annoncés :

```text
Opus/Application/Inspection/SiteSourceInspector.php
Opus/Application/Source/SiteSourceWorkspace.php
Opus/Application/Source/SiteSourceWorkspaceInterface.php
```

E1 est donc acquis et devient la source de vérité du prochain différentiel.

## 2. Décision de découpage

E2 est découpé en deux paliers atomiques :

- **E2A** : mutation Sources sécurisée dans `owasys-back`, via REST puis Composer allow-listé puis service OPUS E1 ;
- **E2B** : éditeur Sources dans `owasys-front`, ViewModel et SCORE, avec preview, enregistrement, conflit concurrent et fallback sans JavaScript obligatoire.

E2A ne modifie pas l’interface frontend. Il établit d’abord la frontière backend contractuelle nécessaire à E2B.

## 3. Cause traitée

Le catalogue Composer REST existant transporte les paramètres métier dans `argv`. Cette mécanique convient aux identifiants et chemins bornés, mais pas au contenu complet d’un fichier source :

- le contenu ne doit pas apparaître dans la ligne de commande ;
- les espaces et fins de ligne doivent être conservés exactement ;
- le hash attendu et le contenu proposé doivent rester dans le corps structuré de la requête ;
- Logger et Profiler ne doivent recevoir ni contenu ni diff.

E2A ajoute donc au registre générique Composer un transport de paramètre `request`, distinct du transport `argv`.

## 4. Routes REST E2A

```text
POST /api/v1/applications/{site_id}/source-previews/{*path}
PUT  /api/v1/applications/{site_id}/sources/{*path}
```

Opérations :

```text
source.preview
source.write
```

Rôles REST autorisés :

```text
admin
developer
```

Le rôle `viewer` demeure strictement en lecture.

## 5. Commandes Composer allow-listées

```text
owasys:source-preview -> owasys:source:preview
owasys:source-write   -> owasys:source:write
```

Les commandes sont enregistrées dans :

- le `composer.json` racine ;
- `sites/owasys-back/config/composer.commands.json` ;
- `sites/owasys-back/config/backend.operations.json`.

Le provider OWASYS-back appelle exclusivement `SiteSourceWorkspace::preview()` et `SiteSourceWorkspace::write()`.

## 6. Contrat du corps structuré

Le corps REST fournit dans `data` :

```text
expected_content_hash : SHA-256 hexadécimal sur 64 caractères
new_content            : contenu textuel complet, maximum 1 MiB
```

Les paramètres fusionnés dans la requête Composer sont :

```text
site_id
path
expected_content_hash
new_content
```

`site_id` et `path` sont validés puis transmis en arguments Composer.  
`expected_content_hash` et `new_content` utilisent `transport=request` et ne sont jamais ajoutés à `argv`.

Pour `new_content`, `trim=false` conserve exactement les espaces, retours ligne et lignes vides de début ou de fin.

## 7. ACL et verrouillage

Le provider OWASYS-back applique en plus du rôle REST l’ACL applicative deny-by-default :

```text
source:preview
source:write
```

La politique existante autorise `source:*` aux développeurs et administrateurs, et seulement `source:read` aux viewers.

Le verrouillage optimiste, la validation textuelle, le confinement des chemins, le verrou interprocessus et l’écriture atomique restent exclusivement propriétaires du service générique OPUS E1.

Un hash périmé produit :

```text
OPUS_SITE_SOURCE_CONFLICT
HTTP 409
```

## 8. Logger et Profiler

Le provider construit `SiteSourceWorkspace` avec les Logger et Profiler OWASYS-back dédiés.

La corrélation reprend le `trace_id` REST. Les contextes mesurés restent limités aux identifiants, chemins, tailles, statuts et codes d’erreur. Le contenu source, le diff et le hash ne sont pas journalisés.

## 9. Fichiers du différentiel

```text
MODIFY Opus/Api/Composer/ComposerCommandRegistry.php
MODIFY Opus/Api/Rest/RestServer.php
MODIFY composer.json
MODIFY sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php
MODIFY sites/owasys-back/config/backend.operations.json
MODIFY sites/owasys-back/config/backend.rest.json
MODIFY sites/owasys-back/config/composer.commands.json
```

Aucun fichier `owasys-front`, aucun site généré et aucun JavaScript backend ne sont inclus.

## 10. Validation réalisée

- base OPUS exacte vérifiée ;
- acquisition E1 vérifiée par comparaison Git ;
- PHP lint des trois fichiers PHP : OK ;
- parsing des quatre fichiers JSON : OK ;
- cohérence routes → opérations → scripts → aliases → providers : OK ;
- transport `request` ciblé : OK ;
- conservation du contenu sans `trim` : OK ;
- absence du contenu et du hash dans `argv` : OK ;
- archive : 7 fichiers, intégrité OK ;
- aucune extension JavaScript/TypeScript ou lockfile frontend sous `owasys-back` : OK ;
- aucune exécution shell ou écriture fichier directe dans le provider : OK ;
- smoke owner fourni séparément du ZIP.

## 11. Hors périmètre E2A

- formulaire d’édition dans `owasys-front` ;
- ViewModel de preview ou d’enregistrement ;
- rendu SCORE des boutons et conflits ;
- CodeMirror, recherche et onglets ;
- stage, commit ou toute opération Git ;
- création, renommage ou suppression de fichiers ;
- correction locale d’un site témoin.

Ces éléments relèvent de E2B puis E3.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO CONTENT IN ARGV.  
NO ACL BYPASS.  
NO LOCAL SITE FIX.
