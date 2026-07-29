# MAESTRO WORKSPACE handoff — OPUS P117W R36

Date : 2026-07-29

## Décision

R36 traite la cause de l'URL Profiler incorrecte par une évolution générique
OPUS : construction canonique des URL, signaux FSM `open_profiler` et
`close_profiler`, pile/mémoire ASAP, ACL deny-by-default et panneau SCORE.

## Source

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD/base : 90db4b0943507c54215ce199b21207748cc9a6d8
Prérequis : R34 puis R35-R2
```

## Invariants conservés

- FSM R34 propriétaire de la navigation ;
- `push/pop/peek/poke` et wildcards ASAP inchangés ;
- dispatch Composer R35-R2 in-process ;
- remise à zéro ciblée des diagnostics à chaque dev-server ;
- 24 langues officielles UE plus ukrainien ;
- SCORE exclusif, ACL, SSO, Logger et Profiler.

## Livraison

ZIP différentiel direct contenant sept fichiers complets. Aucun log, profiler,
cache, outil, smoke, dépendance ou secret.

## Validation owner

L'URL valide est :

```text
/<locale>/source/<script>?profiler=1
```

La forme suivante doit échouer explicitement :

```text
/<locale>/source/<script>/profiler=1
```

Le panneau doit conserver la locale et le script courant. Son `trace_id` doit
être identique dans les traces frontend, REST, backend et Composer.

NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
TOUJOURS TRAITER LA CAUSE.
NO FALLBACK SILENCIEUX.
NO DELIVERY ROOT POLLUTION.

