# HANDOFF — OPUS P117W R45A3 REST / Profiler transaction boundary

Date : 2026-08-03

## Base exacte

- dépôt : `philstephibanez-wq/OPUS`
- branche : `master`
- HEAD owner : `ad33c64cb091711bcf98e7a1c9307cb4029e0ca6`
- R45A2 : acquis
- R46B15 : acquis

## Défaut traité

`RestServer` lisait la trace avant son `stop()`. L'exception `OPUS_PROFILER_TRACE_NOT_FOUND` pouvait donc convertir un `site.create` réussi en échec REST. Les erreurs de scaffold avec détails étaient en plus masquées par `OPUS_REST_API_REQUEST_FAILED`.

## Livrable owner

```text
ZIP     : opus_p117w_r45a3_rest_profiler_transaction_boundary.zip
SHA-256 : 6ceb5e5a55ca0b501dffc9748190fdc62b4a862ca8767df48fc278843e57b96d
FILES   : 1
BASE    : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
STATUS  : livré, validation et push owner requis
```

Chemin :

- `Opus/Api/Rest/RestServer.php`

## Résultat attendu

- la trace REST est finalisée avant lecture ;
- un échec de télémétrie est journalisé sans annuler le résultat métier ;
- `OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS:sites/test` devient le code REST `OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS` ;
- aucune cible existante n'est écrasée.

## Suite

Après validation et push de R45A3, reprendre R45B : profils `frontend`, `backend` et `fullstack` réellement distincts.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.
