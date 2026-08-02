# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-02

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `b64eba112a4cdf4db1fe36f3c5ebeb3372959f96`.
- Commit owner : `opus_p117w_r46b4_database_operation_collector`.
- R46A1, R46B1, R46B2, R46B3, R46C1 et R46C3 validés et poussés.
- R46B4 est poussé ; sa preuve fonctionnelle runtime reste à acquérir avant de le déclarer validé.
- R46B5 est livré sous forme de ZIP différentiel ; validation owner requise.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuves acquises

- R46B2 : un span HTTP racine en succès, dix événements corrélés, HTTP 200, aucun faux span REST ou Composer.
- R46B3 autorisé : utilisateur `admin`, Profiler accessible, span HTTP en succès, `acl.decision.evaluated`, aucun `acl.decision.denied`.
- R46B3 refusé : `roles: []`, `profiler:view`, décision `denied`, règle `default:deny`, événements corrélés au span HTTP ; l'accès reste refusé.
- R46C3 : iframe same-origin, session OWASYS centralisée, ACL et rendu SCORE validés.

La branche `http.exception.caught` reste non prouvée tant qu'une erreur réelle n'a pas été exécutée.

## Cible active — R46B5 onglets fonctionnels

R46B5 remplace la page Profiler monolithique par 18 onglets SCORE génériques : résumé, chronologie, requête/réponse, routage/contrôleur, FSM, SCORE, sécurité, BDD, REST, Composer, session, cache, I18n, logs, exceptions, configuration, runtime et performances.

Chaque onglet affiche uniquement les événements et spans mesurés de sa famille. Une rubrique sans mesure reste visible avec un état explicite d'absence de données. Aucun JavaScript, aucune donnée inventée et aucun raccordement local OWASYS ne sont ajoutés.

R46B4 reste parallèlement à valider sur le flux réel :

```text
owasys-front → span REST → owasys-back → spans BDD/Composer → réponse → owasys-front
```

## Ordre de travail

1. Appliquer et linter le ZIP R46B5 sur le HEAD OPUS exact.
2. Ouvrir le Profiler et vérifier les 18 onglets, leur navigation et leur filtrage.
3. Vérifier qu'un onglet sans collecteur affiche l'absence de mesure sans faux compteur.
4. Ne commit/push R46B5 qu'après validation owner.
5. Acquérir séparément la preuve runtime R46B4 sur un `owasys:registry:sync` réel.
6. Poursuivre la corrélation distribuée et les collecteurs manquants.

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
