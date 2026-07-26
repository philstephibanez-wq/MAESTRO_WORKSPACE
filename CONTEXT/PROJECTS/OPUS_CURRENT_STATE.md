# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-26.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Déployer indépendamment les deux applications sur deux bastions possibles.

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Front

Maintenir `OwasysFrontApplication` et `OwasysFrontApplicationInterface`.

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, client REST, Logger et Profiler.

Interdire toute mutation métier et toute exécution Composer applicative locale.

Déclarer un registre Composer frontend vide :

```text
sites/owasys-front/config/composer.commands.json
site_id = owasys-front
providers = []
aliases = []
```

## Back

Maintenir `OwasysBackApplication` et `OwasysBackApplicationInterface`.

Appliquer Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, API REST sécurisée, Composer allow-listé, Logger et Profiler.

Interdire tout rendu UI.

Conserver le registre de commandes métier dans :

```text
sites/owasys-back/config/composer.commands.json
```

## Cause du blocage P117W R3

La migration P117W initiale a copié `sites/owasys/config/composer.commands.json` dans le frontend.

Le fichier copié déclare `site_id = owasys`, alors que `ApplicationCommandDispatcher` exige `site_id = owasys-front` pour la racine `sites/owasys-front`.

Cette incohérence bloque `opus:validate-site` et `opus:dev-server` avant leur exécution.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de tools
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : appliqué, registre Composer frontend invalide détecté
P117W R4 : actif à appliquer
```

## P117W R4

```text
ZIP : opus_p117w_r4_fix_front_composer_registry_clean_site.zip
SHA-256 : 421fbd6d39e01e166b798d5bdee313cb24c39ef8761d62b4fc2ae7edb1dcc7d0
Fichiers : 1
Octets : 309
```

Inclure uniquement :

```text
sites/owasys-front/config/composer.commands.json
```

Ne livrer aucun répertoire opérationnel, aucun outil, aucune migration, aucun smoke, aucun audit et aucune troisième racine.

## Valider

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Lancer

```text
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Réserver `opus:dev-server` au développement. Conserver l'identifiant d'application, l'adresse et le port comme arguments variables.

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`, puis utiliser `Json`, `Xml` ou `Yaml` selon le format.

Imposer Logger et Profiler. Interdire tout fallback silencieux.