# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B10_FSM_DEBUG_TRANSITION_SUMMARY_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `bf190ab7afecc09493d2d5c98513420613f45fbc`.
- Commit owner : `opus_p117w_r46b9_score_render_profiler_collector`.
- R46B9 est poussé et acquis.
- Les captures runtime valident les détails structurés REST/BDD et l'onglet actif.
- R46B10 est le livrable actif : résumé FSM utile au débogage.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Cause R46B10

Le collecteur FSM transporte les états et le signal, mais le résumé générique
affiche d'abord `fsm_contract`. Le nom fonctionnel de la table n'est pas
transporté et la transition n'est pas lisible directement.

R46B10 traite :

```text
nom réel de table FSM
+ état courant
+ signal
+ état suivant
-> résumé développeur lisible
```

## Ordre de travail

1. Appliquer R46B10 sur OPUS `bf190ab7afecc09493d2d5c98513420613f45fbc`.
2. Linter les deux fichiers PHP du ZIP.
3. Exécuter les smokes FSM, Profiler et OPUS, puis `git diff --check`.
4. Parcourir `/applications?profiler=1`.
5. Vérifier le nom de table sur chaque ligne FSM.
6. Vérifier `état courant → signal → état suivant`.
7. Vérifier l'absence visible de `fsm_contract`, JSON brut compris.
8. Vérifier les gardes et transitions refusées.
9. Ne commit/push OPUS qu'après validation owner.

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
