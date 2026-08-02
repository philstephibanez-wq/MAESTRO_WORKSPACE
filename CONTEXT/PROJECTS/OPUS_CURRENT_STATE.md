# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-02.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : b64eba112a4cdf4db1fe36f3c5ebeb3372959f96
Commit : opus_p117w_r46b4_database_operation_collector
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46B2 : span HTTP racine validé sur le parcours nominal et poussé.
- R46B3 : collecteur ACL validé sur autorisation et refus, puis poussé.
- R46B4 : collecteur BDD poussé ; recette runtime encore requise.
- R46B5 : interface Profiler SCORE par 18 onglets invalidée par `FSM 0` ; ne pas pousser seule.
- R46B5A : collecteur FSM générique livré ; validation owner requise.
- R46C1 : iframe/SCORE poussé.
- R46C3 : session centralisée, iframe HTTP 200, ACL et SCORE validés puis poussés.
- R46C2 : diagnostic rejeté, jamais intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Preuves R46B2 et R46B3

- R46B2 : requête GET HTTP 200, span `http.http.request` en succès, dix événements rattachés et aucun faux span REST/Composer.
- R46B3 autorisé : `acl.decision.evaluated` en succès sans `acl.decision.denied`.
- R46B3 refusé : `roles: []`, `profiler:view`, décision `denied`, règle `default:deny`, ACL inchangée.

La branche `http.exception.caught` reste à tester sur une erreur réelle.

## Cible active

R46B5A traite la cause de `FSM 0` en injectant le Profiler actif jusqu'au `FsmProcessor`. Les transitions et gardes réelles alimentent désormais le panneau FSM avec des spans enfants du span HTTP ; SCORE ne fabrique aucun compteur.

R46B4 doit encore être prouvé sur un parcours REST/Composer/SQLite réel. La corrélation complète `front → REST → back → BDD/Composer → front` reste à poursuivre, sans SQL brut, paramètres sensibles ni secret.

## Suite R46

1. appliquer R46B5A par-dessus R46B5 non poussé et valider les événements FSM réels ;
2. pousser R46B5 + R46B5A seulement après validation owner ;
3. valider R46B4 sur un parcours REST/Composer/SQLite réel ;
4. compléter les métriques et collecteurs R46B manquants ;
5. réaliser la corrélation et l'agrégation distribuées R46D.

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
