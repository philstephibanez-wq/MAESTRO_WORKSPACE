# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : bf190ab7afecc09493d2d5c98513420613f45fbc
Commit : opus_p117w_r46b9_score_render_profiler_collector
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46B9 est poussé et acquis.
- R46B10 est annulé et ne doit pas être appliqué.
- Les détails structurés REST/BDD, l'onglet actif, le terme visible Étape et
  l'instrumentation réelle SCORE restent acquis.
- R46C2 reste rejeté.
- `fullstack-test` est un témoin, jamais une cible de correction locale.

## Défaut actif

Le schéma FSM emploie encore `event/from_state/to_state`. `next_state` est
connu après sélection de la transition mais n'est pas conservé dans tous les
diagnostics, notamment lors d'un refus de garde. Une correction limitée aux
libellés du Profiler serait incohérente avec le contrat runtime.

## Cible active — R46B11

Migration contractuelle atomique vers :

```text
table_fsm + current_state + signal -> next_state
```

Portée : contrats et API FSM, processeur, dispatcher, configurations front/back,
générateurs et consommateurs OWASYS, télémétrie, Profiler et smokes concernés.

Règles :

- nom réel de table systématiquement visible ;
- `signal` uniquement dans le domaine FSM ;
- transition candidate complète lors d'un refus de garde ;
- `transition_not_found` sans cible inventée pour un signal inconnu ;
- aucun alias ancien ni fallback silencieux ;
- `fsm_contract` interne au snapshot seulement, absent de la vue.

## Invariants

- ZIP différentiel seulement pour OPUS/OWASYS ;
- validation et push par l'owner ;
- aucune correction locale du site témoin ;
- SCORE, Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- aucune donnée inventée dans le Profiler.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
