# MAESTRO_WORKSPACE — Handoff OPUS P117W R46B11

Date : 2026-08-03  
Statut : cadrage actif — R46B10 annulé

## Base exacte

- OPUS owner : `bf190ab7afecc09493d2d5c98513420613f45fbc`
- Commit acquis : `opus_p117w_r46b9_score_render_profiler_collector`
- R46B10 est annulé et ne doit pas être appliqué.
- Le prochain ZIP repart exclusivement de R46B9.

## Cause

Le moteur FSM, ses configurations et plusieurs consommateurs emploient encore
`event`, `from_state` et `to_state`. Le Profiler ne peut pas corriger ce
défaut par de simples libellés : `next_state` est connu dès que la transition
candidate est sélectionnée, mais il est absent de l'étape initiale et du
diagnostic lorsqu'une garde refuse la transition.

## Contrat cible strict

```text
table_fsm + current_state + signal -> next_state
```

- `signal` est le seul terme FSM autorisé ; jamais `event`.
- `current_state` et `next_state` remplacent `from_state` et `to_state`.
- le nom fonctionnel réel de la table est obligatoire et affiché systématiquement ;
- une transition acceptée sans l'un des quatre champs est invalide ;
- une garde refusée conserve la transition candidate complète et son `next_state` ;
- un signal inconnu produit `transition_not_found` sans cible inventée ;
- aucun alias ancien, fallback ou double schéma silencieux.

## Portée du prochain différentiel

Migration atomique des contrats, processeur, dispatcher, configurations FSM,
générateurs/consommateurs OWASYS et smokes directement dépendants. Le Profiler
résume systématiquement :

```text
<table_fsm> · <current_state> + <signal> → <next_state>
```

`fsm_contract` reste interne au snapshot runtime mais disparaît de la vue
développeur.

## Livraison

Assistant : ZIP différentiel OPUS/OWASYS uniquement, sans commit/push.  
Owner : application, validation runtime, commit et push.  
Assistant : mise à jour directe de MAESTRO_WORKSPACE.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
