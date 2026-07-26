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

## Interdire tools

Interdire tout répertoire `tools` dans OPUS, OWASYS et les différentiels livrés.

Placer les scripts contractuels sous :

```text
scripts/
```

## Front

Maintenir `OwasysFrontApplication` et `OwasysFrontApplicationInterface`.

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, client REST, Logger et Profiler.

Interdire toute mutation métier et toute exécution Composer locale.

## Back

Maintenir `OwasysBackApplication` et `OwasysBackApplicationInterface`.

Appliquer Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, API REST sécurisée, Composer allow-listé, Logger et Profiler.

Interdire tout rendu UI.

## Serveur de développement

Utiliser :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Réserver la commande au développement. Conserver les trois valeurs comme arguments variables.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, architecture rejetée
P117W R1 : rejeté pour présence de répertoires tools
P117W R2 : actif à appliquer
```

## P117W R2

```text
ZIP : opus_p117w_r2_owasys_no_tools_two_applications_rest_only.zip
SHA-256 : e956043cbb799497fa51fa4ca40217f7fa9944063de297e0baa32d47a3d69ad4
Fichiers : 14
Octets : 22184
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Valider :

```text
Chemins tools : 0
Références tools : 0
Entrées owasys-shared : 0
PHP lint : OK
JSON : OK
ZIP : OK
```

## Appliquer

Utiliser les scripts sous :

```text
scripts/owasys/p117w-r2
```

Exécuter les migrations front et back, reconstruire l’autoload, exécuter les deux smokes, supprimer la racine rejetée, exécuter l’audit des interfaces, provisionner le canal REST local, lancer les deux applications, tester REST vers Composer, puis contrôler Logger, Profiler et `trace_id`.

## Préserver

Ne pas supprimer avant acceptation runtime complète :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
```
