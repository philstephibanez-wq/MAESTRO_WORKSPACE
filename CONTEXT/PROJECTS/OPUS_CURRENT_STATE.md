# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-02.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 039ec38fade806778a6c948289aa2886f048605f
Commit : opus_p117w_r46b3_acl_decision_collector
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46B2 : span HTTP racine validé sur le parcours nominal et poussé.
- R46B3 : collecteur ACL validé sur autorisation et refus, puis poussé.
- R46C1 : iframe/SCORE poussé.
- R46C3 : session centralisée, iframe HTTP 200, ACL et SCORE validés puis poussés.
- R46C2 : diagnostic rejeté, jamais intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Preuve R46B2

La preuve owner montre une requête GET HTTP 200 avec :

- un span `http.http.request` terminé en `success` ;
- dix événements rattachés ;
- zéro erreur, alerte ou indisponibilité ;
- aucun span REST ou Composer fabriqué.

La branche `http.exception.caught` et la fermeture du span en `error` restent à tester séparément sur une erreur réelle.

## Preuve R46B3

- parcours autorisé : `acl.decision.evaluated` en succès, sans `acl.decision.denied` ;
- parcours refusé : `roles: []`, ressource `profiler`, action `view`, décision `denied`, règle `default:deny` ;
- événements rattachés au span HTTP ;
- ACL deny-by-default inchangée ;
- validation owner acquise et commit poussé.

## Cible active

Profiler OPUS complet, comparable à Symfony et adapté aux domaines OPUS. R46B4, collecteur d'opérations BDD générique raccordé au backend Composer, est livré mais non validé. La corrélation complète `front → REST → back → BDD/Composer → front` reste à poursuivre après validation, sans SQL brut, paramètres sensibles ni secret.

## Suite R46

1. valider R46B4 sur un parcours REST/Composer/SQLite réel ;
2. compléter les métriques de lignes lues/affectées et les collecteurs R46B manquants ;
3. réaliser la corrélation et l'agrégation distribuées R46D ;
4. compléter la barre et les panneaux SCORE R46C à partir des collecteurs disponibles ;
5. intégrer les profils générés en R46E.

## Invariants

- aucune correction locale de `fullstack-test` ;
- SCORE uniquement ; Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- backend sans JavaScript ; aucun `shared` ;
- Logger/Profiler corrélés sans secret ;
- Profiler uniquement dev/local via `?profiler=1` ;
- aucune affirmation sans événement collecté ;
- assistant : ZIP différentiel seulement pour OPUS/OWASYS ;
- owner : validation et push.

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO FALLBACK SILENCIEUX.
