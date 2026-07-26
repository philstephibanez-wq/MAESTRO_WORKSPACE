# OPUS P117W R7 — VALIDER DES SITES PROPRES SANS RÉPERTOIRES RUNTIME PRÉCRÉÉS

Date : 2026-07-27  
État : ZIP différentiel produit ; validation owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

Appliquer notamment :

```text
Toujours traiter la cause, jamais l'effet
```

## Constater

P117W R6 permet de lancer les deux serveurs de développement sans charger plusieurs applications dans le même processus.

Les commandes suivantes échouent encore :

```text
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Le serveur de développement backend démarre correctement. Les journaux Logger et les traces Profiler sont créés au démarrage du runtime.

## Identifier la cause

`SiteCommandService::validate()` et `LayeredSiteCommandService::validate()` exigent actuellement l'existence préalable de :

```text
var/logs
var/profiler
```

Ces deux répertoires constituent des données runtime. Ils sont créés par Logger et Profiler au démarrage de l'application et ne doivent pas polluer un site propre ni être requis dans un artefact de déploiement.

Faire dépendre `validate-site` de répertoires runtime absents avant le premier démarrage provoque l'échec des deux applications propres.

## Corriger OPUS génériquement

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

Retirer uniquement `var/logs` et `var/profiler` des listes de répertoires source obligatoires.

Conserver toutes les autres validations :

- configuration ;
- FSM ;
- I18n ;
- ACL deny-by-default ;
- SSO ;
- racines applicatives ;
- Singleton ;
- SCORE côté frontend ;
- API côté backend ;
- modules et routes.

Ne créer aucun répertoire pendant `validate-site` et ne rendre la validation mutative.

## Conserver l'architecture

```text
sites/owasys-front
sites/owasys-back
```

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier entre les deux applications.

## Livrer

```text
ZIP : opus_p117w_r7_validate_clean_sites_without_runtime_directories.zip
SHA-256 : e24708b8488769d5baef79372cde46d9006d200f1c166e87486501c08513b7ac
Fichiers : 2
Octets : 14728
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
Opus/Console/Service/LayeredSiteCommandService.php
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun journal et aucune racine partagée.

## Valider avant livraison

```text
Analyser la syntaxe PHP des deux fichiers                         : OK
Valider owasys-back sans var/logs ni var/profiler en simulation : OK
Valider owasys-front sans var/logs ni var/profiler en simulation: OK
Conserver les validations Singleton/FSM/routes/ACL/SSO           : OK
Détecter un chemin interdit dans le ZIP                          : 0
Réouvrir et contrôler le ZIP                                     : OK
```

Ne pas présenter ces simulations isolées comme une validation runtime Windows owner.

## Valider côté owner

```text
composer dump-autoload -o
php -l Opus/Console/Service/SiteCommandService.php
php -l Opus/Console/Service/LayeredSiteCommandService.php
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

## Tester le backend

Tester le statut sur :

```text
http://127.0.0.1:8000/api/v1/status
```

Conserver la racine `/` du backend interdite. Le backend ne fournit aucune interface utilisateur.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
