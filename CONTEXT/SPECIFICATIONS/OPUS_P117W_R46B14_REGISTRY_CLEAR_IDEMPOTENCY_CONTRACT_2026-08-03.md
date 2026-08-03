# OPUS P117W R46B14 — Contrat d'idempotence de Registry Clear

Date : 2026-08-03  
Statut : contractuel

## Règle

`registry.clear` est une mutation idempotente du contexte courant OWASYS.

- contexte présent : le contexte est supprimé, `cleared=true`, `already_empty=false` ;
- contexte absent : aucune écriture artificielle n'est produite, `cleared=false`, `already_empty=true` ;
- aucun identifiant applicatif historique `owasys` n'est inventé pour enregistrer un événement ;
- un événement technique du backend est rattaché à l'application autonome réelle `owasys-back` ;
- une erreur non-FSM conserve son identité et ne reçoit pas le préfixe `OWASYS_FSM_RUNTIME_REJECTED` ;
- seuls les diagnostics contractuels `OPUS_FSM_*` peuvent être qualifiés de refus runtime FSM.

## Flux obligatoire

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer -> RegistryRepository
```

Le frontend ne modifie jamais directement le Registry. L'absence de contexte est un résultat mesuré, pas une erreur et pas un événement inventé.

## Résultat Composer

```text
contract      : OWASYS_REGISTRY_CLEAR_COMMAND_RESULT_V2
cleared       : bool
already_empty : bool
```

Les deux booléens sont strictement complémentaires.

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO FALLBACK SILENCIEUX.
