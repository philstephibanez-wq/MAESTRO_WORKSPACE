# HANDOFF — OPUS P117W R45D2A4 GENERATED PROFILER LINK DEV POLICY

Date : 2026-08-10  
Statut : LIVRABLE OWNER À VALIDER

## Base

```text
OPUS/master = dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
R45D2A3 publié
```

## Preuve owner conservée

La déclaration précédente selon laquelle « Prévisualiser casse OWASYS » est explicitement retirée et ne doit pas être utilisée comme défaut.

Restent confirmés :

- connexion navigateur à `essai2` encore refusée ;
- page `/fr/login` sans lien Profiler visible ;
- l'identité cible `steve` existe dans `runtime.local-password` avec rôle `admin` ;
- les `.lock` Profiler persistants restent normaux et ne doivent pas être purgés.

## Cause Profiler visible

`sites/essai2/config/environment.yaml` contient `environment: dev`, `collect: true`, `web.enabled: true`, mais `web.links: false`.

La valeur provient de `ProfilerEnvironmentScaffoldPolicy::environmentYaml()`. `GeneratedSiteRuntime` respecte ce contrat et n'injecte donc pas de lien.

## R45D2A4

```text
ZIP     : opus_p117w_r45d2a4_generated_profiler_link_dev_policy.zip
SHA-256 : f503525aff801b664a3e3441fb250b202c0839cc1bb4da9a1eb0dc6107b00acb
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 2
```

Fichiers :

```text
Opus/Profiler/ProfilerConfiguration.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
```

Le scaffold produit désormais `links: true` en dev. Pour les sites existants générés avec l'ancienne valeur, le runtime lancé par le serveur de développement OPUS utilise `OPUS_ENV=dev` déjà fourni par `SiteCommandService` pour rendre le lien actif sans modifier `sites/essai2`.

La garde production reste inchangée.

## Login essai2

R45D2A3 est publié et journalise maintenant `security.sso/authentication.failed` avec un code d'erreur normalisé, sans credential. Tant que ce code runtime n'est pas fourni après une tentative `steve`, aucune correction supplémentaire du login ne doit être inventée.

## Gate owner

- appliquer R45D2A4 sur `dfab7d0...` ;
- relancer preview/dev-server de `essai2` ;
- vérifier `OPUS Profiler` visible et ouvrable sur `/fr/login` ;
- tenter login `steve` avec le password provisionné pour `essai2` ;
- si échec, relever les dernières lignes de `sites/essai2/var/logs/essai2.log` afin d'obtenir le code `authentication.failed` ;
- corriger ensuite uniquement cette cause.

NO SITE-SPECIFIC PATCH.  
NO PROFILER LOCK PURGE.  
NO ACL/SSO RELAXATION.  
NO SECRET IN LOGS/PROFILER.  
NO PUSH OPUS BY ASSISTANT.
