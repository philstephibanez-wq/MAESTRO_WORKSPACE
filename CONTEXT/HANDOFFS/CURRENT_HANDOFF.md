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
- R46B5 onglets est invalidé : l’affichage `FSM 0` a prouvé l’absence d’instrumentation réelle du moteur FSM. Ne pas le pousser seul.
- R46B5A collecteur FSM est livré sous forme de ZIP différentiel ; validation owner requise.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuves acquises

- R46B2 : un span HTTP racine en succès, dix événements corrélés, HTTP 200, aucun faux span REST ou Composer.
- R46B3 autorisé : utilisateur `admin`, Profiler accessible, span HTTP en succès, `acl.decision.evaluated`, aucun `acl.decision.denied`.
- R46B3 refusé : `roles: []`, `profiler:view`, décision `denied`, règle `default:deny`, événements corrélés au span HTTP ; l'accès reste refusé.
- R46C3 : iframe same-origin, session OWASYS centralisée, ACL et rendu SCORE validés.

La branche `http.exception.caught` reste non prouvée tant qu'une erreur réelle n'a pas été exécutée.

## Cible active — R46B5A instrumentation FSM réelle

R46B5A raccorde la chaîne générique `Application → RuntimeController → FsmSiteLoader → FsmProcessor` au Profiler actif. Chaque transition réelle produit un span `fsm.transition`, enfant du span HTTP, et les événements `fsm.transition.started`, `fsm.guard.evaluated`, `fsm.transition.completed` ou `fsm.transition.failed`.

Le contexte mesuré contient le contrat FSM, les états source/cible, l'événement, l'identifiant de transition, les gardes, les actions et la durée. Aucun compteur n'est fabriqué dans SCORE. R46B5 onglets ne pourra être validé qu'avec ces événements réels.

R46B4 reste parallèlement à valider sur le flux réel :

```text
owasys-front → span REST → owasys-back → spans BDD/Composer → réponse → owasys-front
```

## Ordre de travail

1. Conserver R46B5 onglets non poussé et appliquer R46B5A par-dessus sur le HEAD OPUS exact.
2. Linter les quatre fichiers R46B5A et exécuter les smokes OPUS/FSM.
3. Parcourir `/applications?profiler=1` et vérifier les événements FSM réels dans l'onglet FSM.
4. Vérifier le même `trace_id`, un span FSM enfant du span HTTP, les états source/cible, gardes, actions et durée.
5. Ne commit/push l'ensemble R46B5 + R46B5A qu'après validation owner.
6. Acquérir séparément la preuve runtime R46B4 sur un `owasys:registry:sync` réel.

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
