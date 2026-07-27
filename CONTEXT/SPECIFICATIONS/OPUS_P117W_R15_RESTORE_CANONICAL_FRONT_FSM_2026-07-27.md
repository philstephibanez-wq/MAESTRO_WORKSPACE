# OPUS P117W R15 — RESTAURER LA FSM CANONIQUE DU FRONTEND

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver uniquement deux applications OPUS autonomes actives :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Cause

Après P117W R14, le frontend atteint le backend REST et la commande Composer ciblée peut progresser. Le rendu frontend échoue ensuite avec :

```text
OWASYS_FRONT_RUNTIME_FAILED
```

Le fichier :

```text
sites/owasys-front/config/fsm.json
```

contient une FSM réduite qui a perdu les métadonnées contractuelles nécessaires au rendu SCORE et à I18n, notamment pour l’état `registry` :

```text
title_key
summary_key
navigation
requires_current_app
```

Sans `title_key`, le renderer construit implicitement :

```text
menu.registry
```

Cette clé n’existe pas. La clé canonique est :

```text
menu.applications
```

La description canonique est :

```text
registry.description
```

## Corriger la source de vérité

Restaurer dans :

```text
sites/owasys-front/config/fsm.json
```

la FSM canonique complète `OWASYS_NAVIGATION_FSM_V1`, comprenant :

```text
diagram
states
events
transitions
guards
actions
```

Restaurer pour l’état `registry` :

```text
module = registry
route = applications
title_key = menu.applications
summary_key = registry.description
navigation.visible = true
navigation.order = 10
navigation.label = menu.applications
```

Restaurer également les états et transitions nécessaires à `login`, `account`, `creation`, `structure`, `data`, `workflows`, `security`, `source` et `build`.

Ne pas ajouter un fallback I18n. Ne pas modifier le renderer. Traiter la FSM dégradée, qui constitue la cause.

## Livrer

```text
ZIP : opus_p117w_r15_restore_canonical_front_fsm.zip
SHA-256 : 1a39348365bfe5dbb3a286519b93bb50ccd60a5a09d642f111cf0836224ae575
Fichiers : 1
Octets non compressés : 7206
```

Inclure uniquement :

```text
sites/owasys-front/config/fsm.json
```

## Valider avant livraison

```text
Contrat FSM canonique                         : OK
État registry et clés I18n                    : OK
États, événements et transitions              : OK
Gardes et actions contractuelles               : OK
Chemins interdits dans le ZIP                  : 0
ZIP directement superposable                   : OK
```

Marqueurs :

```text
P117W_R15_FSM_CONTRACT_OK
P117W_R15_REGISTRY_I18N_BINDING_OK
P117W_R15_TRANSITIONS_OK
```

Ne pas présenter cette validation structurelle comme une validation runtime Windows owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
