# OPUS P117W R36 — Profiler corrélé piloté par FSM et URL canonique

Date : 2026-07-29

## Cause

La syntaxe `/<script>/profiler=1` mélangeait un paramètre de diagnostic et
le chemin de la ressource Source. OWASYS ne disposait d'aucun constructeur
d'URL générique chargé de séparer segments, query string et encodage.

## Contrat

- `profiler=1` est exclusivement un paramètre de requête.
- `/profiler=1` est refusé explicitement.
- la page courante, la locale et le script restent pilotés par la FSM R34 ;
- `open_profiler` empile l'URL de retour puis mémorise l'ouverture et le
  `trace_id` avec `push` et `poke` ;
- `close_profiler` utilise `pop` et désactive l'affichage ;
- le panneau est rendu côté serveur exclusivement par SCORE ;
- l'accès `profiler:view` reste deny-by-default et est accordé à
  l'administrateur par la règle `admin = *:*` ;
- le même `trace_id` continue de relier front, REST, back et Composer ;
- le schéma de trace `OPUS_PROFILER_TRACE_V1` reste inchangé.

## Évolution générique OPUS

`Opus\Http\UrlBuilder` est l'unique constructeur introduit. Il :

- encode chaque segment séparément ;
- refuse segment vide, traversée, slash embarqué et pseudo-segment
  `profiler=...` ;
- trie et encode la query string selon RFC 3986 ;
- ne normalise jamais silencieusement une syntaxe invalide.

La classe implémente son interface homonyme. Cette interface étend directement
les quatre marqueurs OPUS obligatoires.

## Panneau SCORE

Le layout reçoit un ViewModel Profiler contenant :

- visibilité ;
- URL canonique d'ouverture et de fermeture ;
- `trace_id` courant ;
- état FSM ;
- chaîne de corrélation `front → REST → back → Composer`.

Aucune mutation DOM ni JavaScript n'est nécessaire.

## Base et livraison

Base OPUS : `90db4b0943507c54215ce199b21207748cc9a6d8`.

R36 est cumulatif après R34 et R35-R2. Il ne modifie ni le backend, ni le
dispatch Composer in-process, ni l'I18n, ni la remise à zéro des diagnostics.

## Gates

- syntaxe PHP des cinq fichiers PHP ;
- parsing JSON de `fsm.json` ;
- autoload Composer optimisé ;
- validation des deux sites ;
- interface homonyme et quatre marqueurs ;
- `git diff --check` ;
- ouvrir un script puis `?profiler=1` ;
- vérifier conservation du script et de la locale ;
- fermer le panneau et vérifier le retour FSM ;
- vérifier le même `trace_id` front/back et `execution_mode: in_process`.

