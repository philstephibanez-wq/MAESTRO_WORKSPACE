# OPUS P117W R45B2A1R6 — INSTRUMENTATION FSM DU RUNTIME GÉNÉRÉ

Date : 2026-08-05  
Statut : livrable owner actif  
Base OPUS : `d18badad99298376a25d388bb0a76e25efc14d98`

## Preuve d'acquisition précédente

R45B2A1R5 est acquis. Le site `test5` charge ses assets, applique le thème SCORE et affiche son nom public dans le footer. Sa page d'accueil franchit la FSM, mais le Profiler affiche `FSM 0`.

## Cause

L'application générée ouvre bien une trace avec son instance `Profiler`, puis construit `GeneratedSiteRuntime` sans lui transmettre cette instance. Le runtime charge et exécute donc la FSM sans Profiler actif.

`FsmProcessor` sait déjà produire des spans et événements réels lorsqu'un Profiler lui est fourni. Ses noms d'événements ajoutent cependant un second préfixe `fsm` à la catégorie, produisant des types non canoniques `fsm.fsm.*`.

## Correction générique

R45B2A1R6 :

- injecte le Profiler actif de l'application dans `GeneratedSiteRuntime` ;
- transmet ce Profiler à `FsmSiteLoader`, puis à `FsmProcessor` ;
- mesure `fsm.loaded` et `fsm.state.resolved` ;
- mesure `fsm.transition.skipped` lorsque l'état courant est déjà l'état cible ;
- conserve les spans et mesures réelles de transition du moteur ;
- canonicalise leurs types en `fsm.transition`, `fsm.transition.completed`, `fsm.transition.failed` et `fsm.guard.evaluated` ;
- n'enregistre aucune identité, rôle, secret ou donnée de formulaire dans les nouveaux contextes.

La vue Profiler n'invente aucun compteur et n'est pas modifiée.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r6_generated_runtime_fsm_profiler.zip
SHA-256 : b5937135d47dbfbec62bafd40a7754423c8db5caf1e11b9cc6c113b197a56d1d
FILES   : 3
BASE    : d18badad99298376a25d388bb0a76e25efc14d98
```

Chemins :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php` ;
- `Opus/Fsm/FsmProcessor.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Gates owner

- lint PHP des trois sources ;
- autoload Composer optimisé ;
- validation d'`owasys-front` et d'`owasys-back` ;
- audit des interfaces homonymes ;
- `git diff --check` ;
- suppression contractuelle puis recréation de `test5` ;
- validation et démarrage du site recréé ;
- panneau FSM strictement supérieur à zéro sur l'accueil ;
- événement `fsm.transition.skipped` sur l'accueil initial ;
- span et événement `fsm.transition.completed` lors d'une navigation changeant réellement d'état.

## Suite séparée

Après acquisition : R45B2A2 pour la rétention bornée et la rotation JSONL configurable, puis E1/E2/E3 pour Sources/Git.

NO LOCAL SITE FIX.  
NO PROFILER DATA INVENTION.  
NO FALLBACK SILENCIEUX.
