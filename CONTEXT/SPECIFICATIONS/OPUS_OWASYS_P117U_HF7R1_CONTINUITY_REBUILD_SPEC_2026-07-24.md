# OPUS / OWASYS P117U HF7R1 — CONTINUITY REBUILD

Date : 2026-07-24  
Statut : spécification de différentiel applicable après HF6  
Base GitHub relue : `philstephibanez-wq/OPUS@79f261854ee06a9f828fec389adca77d57323d00`

## Objet

Reconstruire le différentiel HF7 depuis la source de vérité GitHub et les contrats versionnés du workspace, afin de restaurer la continuité sans dépendre du contexte conversationnel.

HF7R1 conserve le périmètre de 45 chemins de HF7 : 17 fichiers existants corrigés et 28 fichiers du module applicatif OWASYS Creation.

## Défaut confirmé sur OPUS/master

- `create_new_app` passe encore directement de Registry à Build ;
- l’action `start_creation_flow` est encore active ;
- l’opération REST `registry.creation.start` et les alias Composer associés existent encore ;
- `site.create` ne reçoit pas de profil ;
- `SiteScaffoldPlan` ne distingue pas frontend, backend et fullstack ;
- le Registry ignore encore les sites au contrat `OPUS_SITE_STANDARD_CONTRACT_CORE`.

## Workflow corrigé

```text
Registry
-> create_new_app
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> SiteScaffoldPlan profile-aware
-> Registry synchronize
-> Registry select
-> application_created
-> Build
```

`application_creation_failed` reste dans Creation. `cancel_creation` retourne dans Registry.

## Évolution générique OPUS

Les classes concrètes modifiées restent liées à leur interface homonyme étendant directement :

- `OpusFrameworkComponentInterface` ;
- `OpusExceptionAwareInterface` ;
- `OpusProfilerAwareInterface` ;
- `OpusSelfDocumentingInterface`.

Classes concernées :

- `OpusConsoleApplication` ;
- `SiteCommandService` ;
- `SiteScaffoldPlan` ;
- `FullstackApplicationScaffoldPlan`.

Le CLI expose `--profile=frontend|backend|fullstack`. L’usage direct reste rétrocompatible avec `fullstack` par défaut. Le catalogue REST OWASYS exige explicitement le profil.

Les sites générés déclarent `OPUS_APPLICATION_PROFILE_V1`, leur `kind`, leur blueprint, leur origine et leurs capacités. Ils restent Singleton, FSM-first, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy ready et SCORE-rendered.

## Évolution OWASYS

Nouveau module applicatif :

```text
sites/owasys/application/creation/
```

Il contient :

- un contrôleur FSM ;
- un modèle REST-only ;
- un template SCORE ;
- 25 catalogues I18n de base correspondant aux langues configurées de l’UE et à l’ukrainien.

Le frontend n’écrit aucun site et ne lance aucun processus. La mutation passe exclusivement par `RcpRestClient`, REST sécurisé et Composer.

## Configuration

Tous les fichiers de configuration restent lus via `File` et `StructuredFileLoader`, puis parsés par les classes OPUS JSON, XML ou YAML/YML selon leur extension.

Aucun `file_get_contents`, `json_decode` local, parseur ad hoc ou fallback silencieux n’est ajouté pour la configuration.

## Logger et Profiler

Le workflow Creation utilise :

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

Les événements request/success/failure sont corrélés par trace. Les identifiants d’application, valeurs de formulaire, tokens, mots de passe, clés HMAC et lignes de commande ne sont pas persistés dans les diagnostics.

## Mode de livraison et d’installation

Le propriétaire ne manipule pas directement le patch Git.

Le ZIP est extrait dans un dossier temporaire, puis l’installation est exécutée par :

```text
INSTALL_HF7R1.cmd
```

Ce programme contrôle automatiquement :

1. la présence de `H:\OPUS` ;
2. le head exact HF6 ;
3. la propreté Git du dépôt ;
4. l’applicabilité du différentiel ;
5. l’application du différentiel ;
6. `composer dump-autoload -o` ;
7. la validation OWASYS ;
8. la liste des routes.

Aucune commande `git apply` n’est à saisir manuellement.

Deux lanceurs sont également fournis :

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

## Artefact HF7R1 installable

- ZIP : `opus_owasys_p117u_hf7r1_application_creation_profiles.zip` ;
- SHA-256 : `16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858` ;
- patch interne SHA-256 : `4e90d025a26474d0c19eaecae92048d1bf6b7ab403f4bfea2db796b9b05e53c8` ;
- chemins modifiés ou créés : 45 ;
- statistiques : 1 307 insertions, 110 suppressions.

Contenu du ZIP :

```text
INSTALL_HF7R1.cmd
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
payload/opus_owasys_p117u_hf7r1_application_creation_profiles.patch
```

Le ZIP précédent contenant seulement le patch est remplacé et ne doit pas être utilisé.

## Validations exécutées dans le runtime de livraison

- structure du patch analysée ;
- 45 chemins présents ;
- syntaxe PHP verte pour les deux nouvelles classes ;
- parsing JSON vert pour les 25 nouveaux catalogues et les configurations complètes reconstruites ;
- intégrité ZIP verte ;
- présence et cohérence des trois programmes CMD ;
- absence de cache, log, secret, rapport, smoke ou temporaire dans le ZIP.

## Gates owner obligatoires

Après exécution de `INSTALL_HF7R1.cmd` :

1. audit tokenizer P117M complet ;
2. lint PHP complet de l’arbre modifié ;
3. parsing JSON complet ;
4. backend sur `127.0.0.1:8792`, puis frontend sur `127.0.0.1:8000` ;
5. tests frontend/backend/fullstack ;
6. Registry select puis Build ;
7. corrélation Logger/Profiler ;
8. no-JavaScript, Auth0, HTTPS, bastion et parité Windows/Linux.

## Interdictions

- aucun push direct de code OPUS/OWASYS par l’assistant ;
- aucun hotfix local contournant OPUS ;
- aucune suppression de `sites/owasys_old` dans ce jalon ;
- aucun secret dans Git, argv, logs, profiler ou artefact.