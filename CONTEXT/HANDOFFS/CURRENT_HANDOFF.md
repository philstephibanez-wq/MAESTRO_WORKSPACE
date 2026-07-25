# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-25

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117V_HF10A_REJECTION_AND_HF10B_CORRECTION_GATE_2026-07-25.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117V_HF10A_REJECTED_HF10B_REQUIRED_2026-07-25.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
remote head     : 41f77ad7187c0facb125a5737b62d10928809e66
owner local     : H:\OPUS + HF10A overlay
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Décision architecture validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

`application/full` est interdit.

## Preuve runtime owner

Le journal frontend fourni établit :

```text
GET /fr-FR/applications     -> HTTP 500
runtime_mode                -> front
error_code                  -> OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
appel REST backend          -> non émis
journal backend             -> aucun événement possible
GET /fr-FR/applications/new -> completed
```

Le HTTP 500 courant n'est donc pas une erreur Composer/backend. Le frontend s'arrête avant l'envoi REST parce que le token RCP n'est pas présent dans son environnement.

## Statut HF10A

```text
opus_p117v_hf10a_shared_front_back_direct_differential.zip
STATUS : REJECTED / WITHDRAWN
```

Motifs :

1. le mode `front|back` existe au niveau processus, mais la migration physique OWASYS vers `application/shared`, `application/front`, `application/back` n'a pas été livrée ;
2. aucun lanceur contractuel ne transmet la même paire token/HMAC aux deux processus ;
3. le frontend échoue donc avant REST et aucun log backend ne peut être produit.

HF10A ne doit pas être considéré comme milestone accepté ni committé comme correction validée.

## Gate HF10B

HF10B doit être un ZIP différentiel direct, superposable à `H:\OPUS`, sans installateur, payload, patch, staging, rapport ou log.

Périmètre obligatoire :

- migration physique réelle OWASYS vers `application/shared`, `application/front`, `application/back` ;
- bootstraps front et back distincts ;
- fullstack par composition uniquement ;
- lanceur local corrélé générant ou chargeant une seule paire token/HMAC et la transmettant aux deux processus sans l'écrire dans Git, les logs, le profiler ou les argv ;
- journal frontend distinct ;
- journal backend REST/Composer distinct ;
- traces Profiler corrélées ;
- refus croisé des routes selon le mode ;
- SCORE-only côté interface ;
- toute mutation via REST sécurisé puis Composer ;
- nettoyage uniquement après validation des nouveaux chemins.

## Contrats permanents

- toute classe concrète sous `Opus/**/*.php` implémente directement son interface homonyme ;
- chaque interface homonyme étend les quatre marqueurs standards ;
- Singleton ;
- FSM + I18n + ACL deny-by-default + SSO/Auth0-proxy + bastion ;
- locale initiale depuis le navigateur ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- SCORE uniquement pour l'interface ;
- aucun echo UI ni mélange HTML/PHP ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Mesure locale immédiate

Les processus front et back doivent hériter de la même paire :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Cette mesure permet de confirmer REST/backend, mais elle ne remplace pas la migration physique HF10B.

## Nettoyage

Aucun nettoyage autorisé avant validation HF10B. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
