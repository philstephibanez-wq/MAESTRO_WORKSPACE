# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117V_HF10B_OWASYS_PHYSICAL_FRONT_BACK_RUNTIME_BOOTSTRAP_SPEC_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117V_HF10B_OWASYS_PHYSICAL_FRONT_BACK_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
remote head     : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
owner local     : H:\OPUS
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Preuve runtime owner

```text
route        : /fr-FR/applications
runtime_mode : front
error_code   : OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
REST backend : non émis
log backend  : aucun événement possible avant HF10B
```

HF10A est committé mais rejeté fonctionnellement : il ne livre ni la migration physique OWASYS ni l'amorçage automatique commun des secrets front/back.

## Architecture validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

Structure OWASYS cible :

```text
application/shared
application/shared/i18n/default
application/shared/i18n/modules/<module>
application/front/default
application/front/modules/<module>
application/back/modules/<module>
application/back/api
```

`application/full` est interdit.

## Différentiel actif

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
FILES   : 19
```

Mode de livraison : ZIP différentiel direct superposable à `H:\OPUS`, fichiers complets à leurs chemins finaux, sans installateur, payload, patch, staging, rapport ou log.

HF10A n'est plus le livrable actif.

## HF10B

HF10B fournit :

- migration physique vers `shared`, `front/default`, `front/modules`, `back/modules`, `back/api` ;
- bootstraps front et back distincts ;
- Singleton partagé ;
- frontend sans contrôleur API ;
- backend sans renderer, template ou contrôleur frontend ;
- modules UI sous `application/front/modules` ;
- I18n commune sous `application/shared/i18n` ;
- refus croisé des routes ;
- rendu d'erreur frontend via SCORE ;
- Logger et Profiler corrélés ;
- store secret runtime commun créé automatiquement sous verrou ;
- aucun secret dans Git, argv, Logger, Profiler ou ZIP.

## Démarrage direct

Terminal back :

```text
cd /d H:\OPUS
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
```

Terminal front :

```text
cd /d H:\OPUS
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

Aucune commande manuelle de génération ou de définition des secrets.

Le premier processus crée ou charge :

```text
sites/owasys/var/runtime/rcp-secrets.json
```

Le second processus réutilise exactement la même paire token/HMAC.

## Journaux attendus immédiatement

```text
back  : sites/owasys/var/logs/rcp-backend.log
front : sites/owasys/var/logs/owasys-frontend.log
```

Chaque journal reçoit `process.starting` avant le démarrage du serveur PHP. Après `/fr-FR/applications`, `rcp-backend.log` doit recevoir les événements REST, Composer et FSM.

## Installation owner

```text
tar -xf <ZIP> -C H:\OPUS
call sites\owasys\tools\cmd\MIGRATE_OWASYS_LAYOUT_HF10B.cmd
composer dump-autoload -o
php sites\owasys\tools\smoke\smoke_p117v_hf10b_owasys_physical_split.php
```

Résultat attendu :

```text
P117V_HF10B_OWASYS_PHYSICAL_SPLIT_SMOKE_OK
```

## Validations effectuées

```text
lint PHP                         : OK
JSON                             : OK
ZIP réouvert et relinté          : OK
secret store création/réemploi   : OK
logs process.starting front/back : OK
migration simulée                : OK
smoke séparation physique        : OK
fichiers interdits dans ZIP      : 0
```

## Nettoyage

Aucune suppression avant validation owner des deux processus, des deux routes Applications/Creation, d'une exécution REST -> Composer et des traces Profiler.

Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys/var/runtime
```

Après validation, fournir les commandes CMD de suppression des anciens chemins devenus inactifs.

## Contrats permanents

- toute classe concrète sous `Opus/**/*.php` implémente son interface homonyme ;
- chaque interface homonyme étend les quatre marqueurs standards ;
- Singleton ;
- FSM + I18n + ACL deny-by-default + SSO/Auth0-proxy + bastion ;
- locale initiale depuis le navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- SCORE uniquement pour l'interface ;
- aucun echo UI ni mélange HTML/PHP ;
- toute mutation OWASYS via REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
