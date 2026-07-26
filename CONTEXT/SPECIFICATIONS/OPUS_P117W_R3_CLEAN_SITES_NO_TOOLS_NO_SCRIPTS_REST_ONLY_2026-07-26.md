# OPUS P117W R3 — SITES PROPRES, AUCUN TOOLS, AUCUN SCRIPTS LIVRÉ

Date : 2026-07-26  
État : ZIP différentiel produit ; application et validation owner requises

## Lire

Lire et appliquer `README-FIRST.md` avant intervenir.

## Conserver

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Déployer éventuellement chaque application sur un bastion distinct.

## Échanger

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier, dossier, volume, configuration, secret, catalogue, manifeste, état runtime ou artefact entre les deux applications.

## Interdire les répertoires opérationnels

Ne créer, livrer ou conserver aucun répertoire opérationnel ajouté par P117W :

```text
tools
scripts/owasys/p117w-*
sites/owasys-front/tools
sites/owasys-back/tools
sites/owasys-shared
```

Ne placer aucune migration, aucun smoke, aucun audit et aucun provisionnement dans le produit livré.

Fournir les commandes CMD de nettoyage, validation et lancement uniquement dans le handoff et dans la réponse owner.

## Livrer uniquement les fichiers finaux

Inclure dans le ZIP différentiel P117W R3 uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-front/config/deployment.manifest.json
sites/owasys-back/config/site.json
sites/owasys-back/config/deployment.manifest.json
```

Ne contenir aucun installateur, script auxiliaire, répertoire enveloppe, payload, patch, staging, rapport, journal ou copie complète du dépôt.

## Maintenir les contrats applicatifs

### Front

Maintenir `OwasysFrontApplication` et `OwasysFrontApplicationInterface`.

Appliquer Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, client REST, Logger et Profiler.

Interdire toute mutation métier et toute exécution Composer locale.

### Back

Maintenir `OwasysBackApplication` et `OwasysBackApplicationInterface`.

Appliquer Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, API REST sécurisée, Composer allow-listé, Logger et Profiler.

Interdire tout rendu UI.

## Configurer le développement

Conserver :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

Lire séparément :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne faire lire à aucune application le fichier de l’autre application.

Réserver cette configuration au développement local. Injecter séparément les paramètres et secrets en production sur chaque bastion.

## Livrable

```text
ZIP : opus_p117w_r3_clean_sites_no_tools_no_scripts_rest_only.zip
SHA-256 : 0b96f61c57e5baf959eee19a971e1cd97c4a9350b9831690c309cd66821494fe
Fichiers : 5
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial appliqué et migré
```

## Valider

```text
Lire README-FIRST.md                         : OK
Analyser la syntaxe PHP                     : OK
Analyser les quatre configurations JSON     : OK
Réouvrir et contrôler le ZIP                : OK
Compter les fichiers complets               : 5
Détecter un chemin tools                    : 0
Détecter un chemin scripts                  : 0
Détecter une entrée owasys-shared           : 0
```

## Rejeter

Rejeter P117W R1 pour avoir ajouté des répertoires `tools`.

Rejeter P117W R2 pour avoir ajouté un répertoire `scripts/owasys/p117w-r2` et un script d’audit.

## Nettoyer

Supprimer par commandes CMD séparées les seuls éléments rejetés éventuellement présents :

```text
sites/owasys-shared
sites/owasys-front/tools
sites/owasys-back/tools
scripts/owasys/p117w-r1
scripts/owasys/p117w-r2
scripts/audit_opus_component_interfaces.php
```

Ne supprimer aucun autre contenu historique ou contractuel du dépôt.
