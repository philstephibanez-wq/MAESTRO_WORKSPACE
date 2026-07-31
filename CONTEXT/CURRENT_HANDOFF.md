# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source canonique

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner de base : 08e42ae9
Commit : opus_p117w_r46a1_profiler_causal_trace_v2
Racine owner : H:\OPUS
```

## État acquis

- R46A1 est appliqué, validé, committé et poussé par l'owner.
- Le modèle `OPUS_PROFILER_TRACE_V2` fournit traces, spans causaux, statuts typés, masquage récursif et lecture V1/V2.
- Le smoke owner `P117W_R46A1_PROFILER_CAUSAL_TRACE_V2_SMOKE_OK` est vert.
- La recette OWASYS a confirmé que le bandeau actuel reste statique et pauvre.
- La décision d'architecture est acquise : le site est le domaine observé ; OPUS collecte les preuves et sert la représentation développeur.
- R46C utilisera une barre compacte hors iframe et un panneau SCORE OPUS dans une iframe same-origin hébergée par un `aside`.

## Action active — R46B1

Instrumenter génériquement le transport REST OPUS avant toute évolution d'interface :

- injection explicite de `ProfilerInterface` dans `RestClient` ;
- span `rest.request.started` ;
- événement réel `rest.response.received` ou `rest.request.failed` ;
- statut final `success` ou `error` ;
- méthode, route normalisée, service logique, statut HTTP, durée et volumes filtrés ;
- aucun secret, acteur brut, corps, credential ou URL complète ;
- aucune affirmation REST lorsque le collecteur n'a observé aucun appel.

R46B1 est livré sous forme de ZIP différentiel fondé exclusivement sur OPUS `08e42ae9`. L'assistant ne committe ni ne pousse OPUS/OWASYS.

## Suite contractuelle

1. Validation owner de R46B1.
2. Collecteurs R46B suivants : HTTP/routage, FSM, SSO/ACL, Composer, SCORE, configuration/données, Logger/exceptions.
3. R46C : barre compacte + route protégée + ViewModel filtré + SCORE génériques OPUS + iframe same-origin.
4. R46D : corrélation distribuée OWASYS front/back.
5. R46E : intégration standard dans les profils générés.

Ne modifier ni `fullstack-test` ni un site généré pour corriger le Profiler.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
