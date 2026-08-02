# OPUS P117W R46B7 — Profiler de débogage détaillé

Date : 2026-08-03  
Statut : ZIP différentiel livré, validation owner requise

## Base

- OPUS : `c9f46233f0cc567943b0d6f668ff4896d99b2600`
- Commit owner : `opus_p117w_r46b6_distributed_database_profiler_and_active_tabs`

## Décision contractuelle

Le Profiler OPUS est un outil de débogage. Un panneau alimenté uniquement par
des compteurs, types d'événements, tailles ou statuts ne suffit pas.

Chaque panneau doit exposer, selon son domaine, les entrées, décisions,
transformations et sorties réellement nécessaires pour expliquer et reproduire
l'exécution. Les données sont assainies avant stockage, limitées en taille et en
profondeur, et toute troncature est signalée. Secrets, credentials, cookies,
signatures, nonces et jetons restent interdits.

## Contenu R46B7

- assainisseur transversal `ProfilerContextSanitizer` avec interface homonyme
  étendant directement les quatre marqueurs OPUS ;
- assainissement central des événements, spans et résumés ;
- requêtes SQL visibles dans Database ;
- aperçu borné à 50 lignes des résultats SQLite réellement consommés ;
- requête et réponse REST visibles sous forme assainie ;
- en-têtes REST limités à une allow-list sans authentification ;
- réponse REST d'erreur conservée lorsqu'elle a réellement été reçue.

## Validation owner

1. Linter les sept fichiers PHP du ZIP.
2. Exécuter les smokes Profiler, REST, SQLite et OWASYS.
3. Ouvrir `/applications?profiler=1`.
4. Vérifier SQL et résultats dans Database.
5. Vérifier requête et réponse dans REST.
6. Tester une valeur nommée `password`, `token`, `authorization`, `cookie`,
   `signature` ou `nonce` et confirmer `[REDACTED]`.
7. Tester un résultat de plus de 50 lignes et confirmer l'indication de
   troncature sans altération du résultat métier.

Ne commit/push OPUS qu'après cette validation.
