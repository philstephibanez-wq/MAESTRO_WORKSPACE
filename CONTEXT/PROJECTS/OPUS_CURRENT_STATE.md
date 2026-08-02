# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 6bee0bde41fa1bfb7a933c5b667da40fdb2d47d7
Commit : opus_p117w_r46b5b_fsm_started_deduplication
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46B2 : span HTTP racine validé et poussé.
- R46B3 : collecteur ACL validé sur autorisation et refus, puis poussé.
- R46B4 : collecteur BDD poussé.
- R46B5 : interface Profiler SCORE par 18 onglets poussée.
- R46B5A : collecteur FSM générique poussé.
- R46B5B : déduplication de `fsm.transition.started` poussée au HEAD.
- R46B6 : corrélation distribuée REST→Composer→BDD et état visuel de l'onglet actif livrés ; validation owner requise.
- R46C1 : iframe/SCORE poussé.
- R46C3 : session centralisée, iframe HTTP 200, ACL et SCORE validés puis poussés.
- R46C2 : diagnostic rejeté, jamais intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Preuves acquises

- HTTP : requête GET 200, span racine et événements corrélés.
- ACL : autorisation et refus deny-by-default réellement mesurés.
- FSM : transition `change_app` réellement mesurée, enfant du span HTTP, puis événement de début dédupliqué.
- SCORE : Profiler rendu dans l'iframe same-origin avec 18 onglets fonctionnels.

## Défaut observé après R46B5B

La capture runtime affiche `Database 0` alors que `/applications` obtient son registre via REST, Composer et SQLite. La cause n'est pas le collecteur SQLite R46B4 : le frontend n'injectait pas son Profiler dans `RestClient` et ne fusionnait pas les enregistrements backend portant le même `trace_id`.

## Cible active — R46B6

R46B6 :

- injecte le Profiler actif dans le client REST du registre ;
- demande la télémétrie distante uniquement en environnement développeur ;
- retourne les enregistrements V2 déjà assainis du même `trace_id` ;
- fusionne les spans Composer/BDD sous le span REST frontend ;
- conserve les deux applications autonomes et interdit tout accès SQLite direct depuis le frontend ;
- ne transporte ni SQL brut, ni paramètres, ni secret ;
- marque visuellement l'onglet SCORE sélectionné sans JavaScript.

## Suite R46

1. appliquer et linter R46B6 sur le HEAD owner ;
2. exécuter les smokes OPUS/REST/Profiler/FSM ;
3. prouver sur `/applications?profiler=1` les compteurs REST, Composer et Database non nuls ;
4. vérifier le même `trace_id`, les liens parents et l'absence de données sensibles ;
5. vérifier l'état actif de chaque onglet ;
6. pousser uniquement après validation owner ;
7. poursuivre les collecteurs R46B manquants et l'agrégation distribuée R46D.

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
