# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B9_SCORE_RENDER_PROFILER_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `7bd73ab4324cff26ebb6bee7622a8159aca787a1`.
- Commit owner : `opus_p117w_r46b8_profiler_structured_debug_details`.
- R46B8 est poussé et acquis.
- La capture runtime valide les détails structurés, la terminologie **Étape** et
  l'onglet actif.
- R46B9 est le livrable actif : instrumentation du moteur SCORE réel.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Cause R46B9

L'onglet SCORE ne contient qu'un événement périphérique
`score.response.rendered`. `ScoreTemplateRenderer` exécute réellement le
template, le layout et les fragments, mais ne reçoit pas le Profiler actif et
ne mesure aucune de ces phases.

R46B9 traite la chaîne réelle :

```text
Étape HTTP
-> OwasysScorePageRenderer
-> ScoreTemplateRenderer
-> template/layout/fragments SCORE
-> sortie ou échec
```

## Ordre de travail

1. Appliquer R46B9 sur OPUS `7bd73ab4324cff26ebb6bee7622a8159aca787a1`.
2. Linter les trois fichiers PHP du ZIP.
3. Exécuter les smokes Profiler, SCORE et OPUS, puis `git diff --check`.
4. Parcourir `/applications?profiler=1`.
5. Vérifier plusieurs événements SCORE réels et une étape `score.render`.
6. Vérifier template/layout/fragments, durées, tailles et causalité HTTP.
7. Vérifier qu'aucune donnée de view-model sensible n'est stockée.
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
