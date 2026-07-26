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

## Interdire les répertoires opérationnels ajoutés

Ne livrer aucun :

```text
tools
scripts/owasys/p117w-*
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Maintenir les commandes CMD hors du produit livré.

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
P117W R2 : rejeté pour présence de scripts opérationnels
P117W R3 : actif à appliquer
```

## P117W R3

```text
ZIP : opus_p117w_r3_clean_sites_no_tools_no_scripts_rest_only.zip
SHA-256 : 0b96f61c57e5baf959eee19a971e1cd97c4a9350b9831690c309cd66821494fe
Fichiers : 5
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-front/config/deployment.manifest.json
sites/owasys-back/config/site.json
sites/owasys-back/config/deployment.manifest.json
```

## Valider

```text
PHP lint : OK
JSON : OK
ZIP : OK
Fichiers complets : 5
Chemins tools : 0
Chemins scripts : 0
Entrées owasys-shared : 0
```

## Nettoyer

Supprimer uniquement les éléments P117W rejetés éventuellement présents :

```text
sites/owasys-shared
sites/owasys-front/tools
sites/owasys-back/tools
scripts/owasys/p117w-r1
scripts/owasys/p117w-r2
scripts/audit_opus_component_interfaces.php
```

Ne supprimer aucun autre contenu du dépôt.

## Préserver

Ne pas supprimer avant acceptation runtime complète :

```text
sites/owasys
sites/owasys_old
sites/owasys/var
```
