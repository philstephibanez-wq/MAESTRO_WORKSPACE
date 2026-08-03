# OPUS P117W R46B9 — Instrumentation Profiler du rendu SCORE

Date : 2026-08-03  
Statut : ZIP différentiel livré, validation owner requise

## Base

- OPUS : `7bd73ab4324cff26ebb6bee7622a8159aca787a1`
- Commit owner : `opus_p117w_r46b8_profiler_structured_debug_details`

## Cause

R46B8 rend les détails du Profiler lisibles, mais le moteur
`ScoreTemplateRenderer` ne reçoit aucun Profiler. L'onglet SCORE ne peut donc
pas expliquer le rendu réel et ne contient qu'un événement périphérique publié
après la réponse.

## Contenu R46B9

- injection explicite du Profiler dans `ScoreTemplateRenderer` ;
- étape `score.render` enfant de l'étape HTTP ;
- événements de résolution du template ou layout ;
- événements pour les fragments SCORE réellement rendus ;
- événement de fin ou d'échec et fermeture de l'étape ;
- durée calculée par la trace et taille de sortie ;
- noms des clés du view-model uniquement, sans leurs valeurs ;
- raccordement dans `OwasysFrontApplication` et `OwasysScorePageRenderer` ;
- aucun JavaScript et aucun changement métier.

## ZIP

```text
opus_p117w_r46b9_score_render_profiler_collector.zip
SHA-256: 47f8401a9aefea820b26efca80ab67bc45bead076b8e4a4111ce67bca904e3de
```

Fichiers complets :

```text
Opus/Score/ScoreTemplateRenderer.php
sites/owasys-front/application/default/Application.php
sites/owasys-front/application/default/services/ScorePageRenderer.php
```

## Validation owner

1. Appliquer le ZIP sur le HEAD OPUS indiqué.
2. Linter les trois fichiers PHP.
3. Exécuter les smokes SCORE, Profiler et OPUS.
4. Ouvrir `/applications?profiler=1` puis l'onglet SCORE.
5. Vérifier une étape `score.render` enfant de l'étape HTTP.
6. Vérifier les résolutions template/layout, fragments, fin et taille.
7. Vérifier l'absence de valeur métier ou de secret dans `view_model_keys`.
8. Vérifier le comportement métier et le rendu inchangés.
9. Ne commit/push OPUS qu'après validation owner.
