# Handoff — OPUS toutes classes contractuelles P117M-R1

Date : 2026-07-22

## Incident constaté

L'exécution du premier livrable P117M s'est arrêtée avant toute écriture sur :

```text
OPUS_COMPONENT_CONTRACT_MULTIPLE_NAMESPACES_UNSUPPORTED:H:/OPUS/Opus/Smtp/Smtp.class.php
```

`git status --short` est resté vide. Aucun fichier OPUS n'a été modifié par cette exécution.

Le fichier `Opus/Smtp/Smtp.class.php` contient plusieurs namespaces PHP légitimes sous forme de blocs :

```php
namespace {
}

namespace SMTP4PHP {
}
```

Le refus global des fichiers multi-namespace était donc incompatible avec la tête réelle du dépôt.

## Correction P117M-R1

Le tokenizer suit désormais le namespace actif de chaque déclaration de classe ou d'interface, au lieu d'associer un unique namespace au fichier entier.

Les formes suivantes sont prises en charge :

```php
namespace {
}

namespace Vendor\Package {
}
```

et :

```php
namespace First;

namespace Second;
```

Pour les namespaces délimités par accolades, le moteur suit la profondeur des blocs et restaure le namespace précédent à la fermeture du bloc. Les accolades présentes dans les classes, fonctions et chaînes interpolées sont comptabilisées sans faire sortir prématurément du namespace.

Chaque classe et chaque interface conserve donc son namespace propre dans l'index tokenizer. La recherche de l'interface homonyme et le contrôle des quatre marqueurs s'effectuent sur le FQCN réel de la déclaration.

## Livrable de remplacement

```text
opus_p117m_contractualize_all_r1.zip
```

Contenu :

```text
tools/maintenance/opus_contractualize_all.php
tools/maintenance/APPLY_OPUS_CONTRACTS_P117M.cmd
```

Ces fichiers remplacent ceux du premier ZIP P117M.

## Validation

Le correctif a été validé sur une arborescence synthétique comprenant simultanément :

- un bloc global `namespace {}` ;
- un bloc nommé `namespace SMTP4PHP {}` ;
- une classe abstraite exemptée ;
- une classe déjà contractuelle ;
- une classe concrète nécessitant une interface ;
- une classe anonyme ;
- deux namespaces successifs avec point-virgule ;
- une classe readonly ;
- application, nouvel audit idempotent et lint de tous les fichiers générés.

Résultat :

```text
PHP_FILES=7
CONCRETE_CLASSES=4
INTERFACES_FOUND=5
FILES_TO_CREATE=3
FILES_TO_MODIFY=2
OPUS_COMPONENT_CONTRACT_APPLY_OK

PHP_FILES=10
CONCRETE_CLASSES=4
INTERFACES_FOUND=8
FILES_TO_CREATE=0
FILES_TO_MODIFY=0
OPUS_COMPONENT_CONTRACT_AUDIT_OK
```

## Gouvernance

Le présent handoff corrige et remplace la règle P117M qui déclarait les fichiers contenant plusieurs namespaces non supportés.

Aucune écriture directe n'est effectuée dans `philstephibanez-wq/OPUS`. Le correctif reste livré sous forme de ZIP différentiel à appliquer localement.