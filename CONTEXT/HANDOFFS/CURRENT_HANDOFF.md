# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `c9f46233f0cc567943b0d6f668ff4896d99b2600`.
- Commit owner : `opus_p117w_r46b6_distributed_database_profiler_and_active_tabs`.
- R46A1, R46B1, R46B2, R46B3, R46B4, R46B5, R46B5A, R46B5B, R46C1 et R46C3 sont poussés.
- La preuve runtime confirme la collecte FSM et sa déduplication.
- La capture suivante révèle `Database 0` et l'absence de marquage visuel de l'onglet actif.
- R46B6 est poussé et la preuve runtime confirme Database non nul.
- La preuve runtime montre cependant que Database n'affiche ni requêtes ni
  résultats ; la même insuffisance existe pour les requêtes/réponses REST.
- R46B7 est le livrable actif : assainissement transversal du contexte Profiler,
  détails de débogage BDD et REST, puis généralisation contractuelle à tous les
  panneaux.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Cause R46B7

R46B6 corrèle correctement le chemin distribué, mais les collecteurs ont été
conçus comme de la télémétrie minimale plutôt que comme des outils de débogage :

1. `DatabaseOperationProfiler` supprimait explicitement SQL et résultats ;
2. `RestClient` ne conservait que route, statut et tailles ;
3. aucun assainissement transversal ne permettait de collecter des valeurs
   utiles avec une politique homogène ;
4. les onglets étaient alimentés, mais ne répondaient pas suffisamment à la
   question développeur « pourquoi et avec quelles entrées/sorties ? ».

R46B7 traite la cause avec un contrat commun :

```text
collecteur → contexte détaillé → assainissement central → stockage borné → SCORE
```

Les secrets restent interdits. Les requêtes et résultats nécessaires au
débogage ne sont plus supprimés : ils sont assainis, limités et leur troncature
est explicite. Ce principe est transversal à tous les panneaux.

## Ordre de travail

1. Appliquer R46B7 sur OPUS `c9f46233f0cc567943b0d6f668ff4896d99b2600`.
2. Linter les sept fichiers PHP, exécuter les smokes OPUS/REST/Profiler/BDD et `git diff --check`.
3. Parcourir `/applications?profiler=1`.
4. Vérifier que Database montre le SQL et l'aperçu borné des lignes réellement lues.
5. Vérifier que REST montre requête et réponse, y compris une réponse d'erreur.
6. Vérifier le masquage des secrets et l'indication des troncatures.
7. Vérifier la corrélation causale et l'onglet courant actif.
8. Ne commit/push OPUS qu'après validation owner.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
