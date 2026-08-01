# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-02.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : f01f891a24dffd00daba4bf230ca3a771165efea
Commit : opus_p117w_r46b2_http_root_span
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46B2 : span HTTP racine validé sur le parcours nominal et poussé.
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

## Livraison active — R46B3

ZIP : `opus_p117w_r46b3_acl_decision_collector.zip`  
SHA-256 : `b21c39e009c09a0601d4a9d7b110475195713ec7f658120afcd8eb3927b2ccde`

Base : OPUS `f01f891a24dffd00daba4bf230ca3a771165efea`.

Fichiers complets :

```text
Opus/Security/Acl/AclPolicy.php
sites/owasys-front/application/default/Application.php
sites/owasys-front/application/default/services/RuntimeSecurity.php
```

R46B3 ajoute les événements contractuels `acl.decision.evaluated` et `acl.decision.denied` au point générique réel d'évaluation. Les rôles effectifs, la ressource, l'action, le scope, la décision, le code et la règle décisive sont collectés sans secret et rattachés au span HTTP. Aucune permission ni règle deny-by-default n'est modifiée.

Statut : archive validée structurellement ; lint et recette owner requis ; non accepté et non poussé dans OPUS.

## Suite R46

1. valider et pousser R46B3 ;
2. compléter les collecteurs R46B manquants à partir des événements réellement observables ;
3. compléter la barre compacte et les douze rubriques SCORE R46C ;
4. réaliser la corrélation distribuée R46D ;
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
