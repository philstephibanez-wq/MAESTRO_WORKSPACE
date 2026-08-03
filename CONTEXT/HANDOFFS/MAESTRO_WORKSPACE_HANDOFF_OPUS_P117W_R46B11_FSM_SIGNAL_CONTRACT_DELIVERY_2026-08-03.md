# MAESTRO WORKSPACE — Handoff OPUS P117W R46B11

Date : 2026-08-03

## Base owner

- Dépôt : `philstephibanez-wq/OPUS`
- Branche : `master`
- Base exacte : `bf190ab7afecc09493d2d5c98513420613f45fbc`
- R46B9 acquis.
- R46B10 annulé et interdit.
- Archive : `opus_p117w_r46b11_fsm_signal_contract.zip`
- SHA-256 : `7c78b527357f5adc37d87109b94c06eec2a1be454eee5a3744e4732dc5a3fcd0`
- Fichiers complets : 17.

## Objet

R46B11 migre atomiquement le domaine FSM actif vers le vocabulaire strict :

```text
table_fsm + current_state + signal -> next_state
```

Aucun alias silencieux `event/from_state/to_state` n'est accepté par le contrat de résultat V2 ni par les quatre définitions FSM actives.

## Comportement contractuel

- le nom réel de table FSM est obligatoire et toujours visible ;
- une transition acceptée publie `current_state`, `signal` et `next_state` ;
- une garde refusée publie la transition candidate complète et `failure_reason=guard_refused` ;
- un signal inconnu publie `failure_reason=transition_not_found` sans cible inventée ;
- `fsm_contract` reste uniquement dans le snapshot runtime et disparaît de la vue Profiler ;
- le résumé Profiler est `table · current state + signal → next state`.

## Portée du ZIP

Le ZIP contient le processeur et son interface, le dispatcher, les consommateurs génériques OPUS, le Profiler, les consommateurs OWASYS front, le générateur Mermaid, les quatre tables FSM actives et la règle de routage.

Aucune classe concrète nouvelle n'est ajoutée. `FsmProcessor` continue d'implémenter son interface homonyme à quatre marqueurs ; l'interface expose maintenant `name()`.

## Contrôles assistant

- archive ZIP intègre ;
- 12 fichiers PHP validés avec un parseur PHP indépendant ;
- 5 JSON validés ;
- 70 transitions contrôlées : `from`, `signal`, `next_state`, sans `event/to` ;
- `git diff --check` propre.

PHP n'est pas installé dans l'environnement assistant. Les smokes PHP et la validation runtime sont donc obligatoires côté owner avant commit.

## Autorité et suite

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : applique, valide, committe et pousse OPUS/OWASYS
```

Après validation owner, publier le nouveau HEAD OPUS puis fournir les captures du panneau FSM. Le workspace sera alors réaligné sur ce HEAD acquis.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
