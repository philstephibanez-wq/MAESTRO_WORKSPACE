# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B8_STRUCTURED_PROFILER_DETAILS_2026-08-03.md
```

## Base exacte

- OPUS GitHub : `97034ed93de2909afffcef2c7b48942da9a29e7a`.
- Commit owner : `opus_p117w_r46b7_profiler_debug_payloads`.
- R46A1, R46B1, R46B2, R46B3, R46B4, R46B5, R46B5A, R46B5B,
  R46B6, R46B7, R46C1 et R46C3 sont poussés.
- R46C2 est rejeté et n’a jamais été intégré.
- La collecte détaillée Database et REST est acquise.
- Les captures runtime montrent que les contextes sont encore affichés comme
  JSON monolithique, avec colonnes très larges et hiérarchie illisible.
- R46B8 est le livrable actif : présentation SCORE structurée et repliable.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Cause R46B8

Le collecteur R46B7 fournit les entrées et sorties utiles. Le défaut restant est
dans le renderer générique :

1. `WebProfilerView` convertit tout contexte en une seule chaîne JSON ;
2. `layout.score` l’insère dans une colonne unique ;
3. la page devient large et la structure des données disparaît visuellement.

R46B8 traite cette cause sans modifier les collecteurs :

```text
contexte assaini → view-model récursif → résumé compact
                                  ↘ détail chemin/type/valeur
                                  ↘ JSON brut secondaire
```

Dans l’interface, le terme `span` devient **Étape**. Le protocole interne et
ses clés `span_id` restent inchangés.

## Ordre de travail

1. Appliquer R46B8 sur OPUS `97034ed93de2909afffcef2c7b48942da9a29e7a`.
2. Linter `Opus/Profiler/WebProfilerView.php`.
3. Exécuter les smokes Profiler et OPUS, puis `git diff --check`.
4. Parcourir `/applications?profiler=1`.
5. Vérifier les détails structurés dans Database et REST.
6. Vérifier le résumé compact, les volets repliables et le JSON brut.
7. Vérifier l’absence de débordement horizontal dû aux contextes.
8. Vérifier que toutes les données R46B7 et l’onglet actif sont conservés.
9. Ne commit/push OPUS qu’après validation owner.

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
