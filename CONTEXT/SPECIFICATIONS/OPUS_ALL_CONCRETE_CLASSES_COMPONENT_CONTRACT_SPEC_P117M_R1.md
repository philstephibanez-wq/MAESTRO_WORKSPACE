# OPUS — Addendum P117M-R1 pour les fichiers PHP multi-namespace

## 1. Portée

Le présent addendum corrige la section tokenizer de la spécification P117M initiale.

Un fichier PHP contenant plusieurs déclarations de namespace n'est pas interdit. Il doit être analysé déclaration par déclaration.

## 2. Formes supportées

Le moteur doit prendre en charge les namespaces délimités par blocs :

```php
namespace {
    // symboles globaux
}

namespace Vendor\Package {
    // symboles du package
}
```

Il doit également prendre en charge les namespaces successifs non délimités :

```php
namespace First;

class Alpha
{
}

namespace Second;

class Beta
{
}
```

## 3. Contexte de namespace

Chaque classe et chaque interface reçoit le namespace actif à sa position exacte dans le flux tokenizer.

Le namespace ne doit jamais être déduit uniquement du premier `T_NAMESPACE` du fichier.

Pour un namespace délimité par accolades :

1. le moteur mémorise le namespace précédent ;
2. il active le nouveau namespace à l'ouverture du bloc ;
3. il suit la profondeur des accolades ;
4. il restaure le namespace précédent uniquement à la fermeture du bloc de namespace ;
5. les blocs de classes, méthodes, fonctions, closures et chaînes interpolées ne doivent pas provoquer une sortie anticipée du namespace.

Pour un namespace terminé par point-virgule, le namespace reste actif jusqu'à la déclaration de namespace suivante ou jusqu'à la fin du fichier.

## 4. FQCN contractuel

Le FQCN d'une déclaration est calculé avec son propre namespace actif :

```text
<namespace de la déclaration> + <nom de classe ou d'interface>
```

La recherche de l'interface homonyme, la détection des doublons et le contrôle des quatre marqueurs utilisent ce FQCN.

Deux classes de même nom court mais de namespaces différents sont deux composants distincts.

## 5. Règle contractuelle inchangée

Toute classe concrète nommée doit directement implémenter une interface homonyme du même namespace.

Cette interface doit directement étendre :

```text
Opus\Framework\OpusFrameworkComponentInterface
Opus\Framework\OpusExceptionAwareInterface
Opus\Framework\OpusProfilerAwareInterface
Opus\Framework\OpusSelfDocumentingInterface
```

Les classes abstraites, classes anonymes, interfaces, traits et enums restent exclues de la création automatique d'une interface homonyme.

## 6. Cas de référence OPUS

`Opus/Smtp/Smtp.class.php` est un cas de référence obligatoire. Il contient un namespace global délimité puis le namespace `SMTP4PHP` délimité.

L'audit ne doit pas échouer sur ce fichier du seul fait qu'il contient plusieurs namespaces.

Les classes concrètes sous `SMTP4PHP` doivent être associées à leurs interfaces du namespace `SMTP4PHP`. Les fonctions du bloc global ne créent aucun composant contractuel.

## 7. Critères d'acceptation complémentaires

1. aucun message `OPUS_COMPONENT_CONTRACT_MULTIPLE_NAMESPACES_UNSUPPORTED` ne subsiste ;
2. les namespaces globaux délimités sont acceptés ;
3. les namespaces nommés délimités sont acceptés ;
4. les namespaces successifs avec point-virgule sont acceptés ;
5. chaque déclaration conserve son namespace propre ;
6. le rescan après application est idempotent ;
7. tous les fichiers générés passent `php -l` ;
8. une erreur avant écriture laisse le dépôt inchangé ;
9. aucune écriture directe n'est effectuée dans le dépôt OPUS par l'assistant.