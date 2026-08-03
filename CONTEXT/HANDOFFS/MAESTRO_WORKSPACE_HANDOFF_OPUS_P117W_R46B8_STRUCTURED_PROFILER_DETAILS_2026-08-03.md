# OPUS P117W R46B8 — Détails Profiler structurés

Date : 2026-08-03  
Statut : ZIP différentiel livré, validation owner requise

## Base

- OPUS : `97034ed93de2909afffcef2c7b48942da9a29e7a`
- Commit owner : `opus_p117w_r46b7_profiler_debug_payloads`

## Cause

R46B7 collecte les données de débogage nécessaires, mais `WebProfilerView`
sérialise chaque contexte dans une chaîne JSON unique. `layout.score` place
ensuite cette chaîne dans une colonne de tableau. Le résultat conserve la vérité
technique, mais reste difficile à lire et produit une page démesurément large.

## Contenu R46B8

- ligne compacte par événement ou étape mesurée ;
- terminologie UI `Étape`, `ID d’étape` et `Étape parente` ;
- détails natifs repliables sans JavaScript ;
- représentation récursive `chemin / type / valeur` ;
- résumé borné aux trois premiers champs ;
- JSON brut intégral conservé dans un volet secondaire ;
- aucune modification de collecteur, de trace ou de comportement métier.

Le protocole interne conserve les noms `span`, `span_id` et
`parent_span_id`. Seule la terminologie visible est adaptée.

## Validation owner

1. Appliquer le ZIP sur le HEAD OPUS indiqué.
2. Linter `Opus/Profiler/WebProfilerView.php`.
3. Exécuter les smokes Profiler et OPUS.
4. Ouvrir `/applications?profiler=1`.
5. Vérifier les onglets Database et REST avec des contextes imbriqués.
6. Vérifier l’ouverture/fermeture des détails et du JSON brut.
7. Vérifier l’absence de débordement horizontal dû au contexte.
8. Vérifier que l’onglet actif reste allumé et que toutes les données R46B7
   restent disponibles.
9. Ne commit/push OPUS qu’après validation owner.
