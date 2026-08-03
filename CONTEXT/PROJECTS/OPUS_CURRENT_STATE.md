# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 7bd73ab4324cff26ebb6bee7622a8159aca787a1
Commit : opus_p117w_r46b8_profiler_structured_debug_details
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis R46

- Trace causale V2, HTTP, REST, ACL, BDD, FSM et corrélation distribuée acquis.
- Profiler SCORE dans une iframe same-origin avec 18 onglets acquis.
- Collecte détaillée et assainie des requêtes/résultats BDD et REST acquise.
- Onglet actif, détails hiérarchiques repliables, JSON brut secondaire et terme
  visible **Étape** acquis avec R46B8.
- R46C2 reste rejeté et n'a jamais été intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Défaut actif

Le panneau SCORE reste insuffisant : `OwasysFrontApplication` publie un seul
événement `score.response.rendered`, mais le moteur générique
`ScoreTemplateRenderer` ne reçoit pas le Profiler actif. Les résolutions de
template/layout, fragments, durées, sorties et échecs ne sont donc pas mesurés.

## Cible active — R46B9

R46B9 :

- injecte explicitement le Profiler et l'étape HTTP dans le renderer SCORE ;
- crée une étape `score.render` enfant de l'étape HTTP ;
- mesure résolution du template/layout et rendu des fragments ;
- mesure fin ou échec, durée et taille de sortie ;
- ne collecte que les noms de clés du view-model, jamais ses valeurs ;
- conserve SCORE uniquement et n'ajoute aucun JavaScript.

## Suite R46

1. appliquer et linter R46B9 sur le HEAD owner ;
2. exécuter les smokes OPUS/SCORE/Profiler ;
3. prouver sur `/applications?profiler=1` les étapes et événements SCORE ;
4. vérifier la causalité sous HTTP et l'absence de données sensibles ;
5. pousser uniquement après validation owner ;
6. poursuivre les autres collecteurs réellement incomplets selon le contrat.

## Invariants

- aucune correction locale de `fullstack-test` ;
- SCORE uniquement ; Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- backend sans JavaScript ; aucun `shared` ;
- frontend sans accès direct à la BDD ;
- Logger/Profiler corrélés sans secret ;
- Profiler uniquement dev/local ;
- aucune affirmation sans événement collecté ;
- assistant : ZIP différentiel seulement pour OPUS/OWASYS ;
- owner : validation et push.

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO FALLBACK SILENCIEUX.
