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
- R46B5A collecteur FSM a corrigé `FSM 0`, mais la preuve runtime a révélé une double émission de `fsm.transition.started` pour le même span.
- R46B5B déduplication FSM est livré sous forme de ZIP différentiel ; validation owner requise.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuves acquises

- R46B2 : un span HTTP racine en succès, dix événements corrélés, HTTP 200, aucun faux span REST ou Composer.
- R46B3 autorisé : utilisateur `admin`, Profiler accessible, span HTTP en succès, `acl.decision.evaluated`, aucun `acl.decision.denied`.
- R46B3 refusé : `roles: []`, `profiler:view`, décision `denied`, règle `default:deny`, événements corrélés au span HTTP ; l'accès reste refusé.
- R46C3 : iframe same-origin, session OWASYS centralisée, ACL et rendu SCORE validés.

La branche `http.exception.caught` reste non prouvée tant qu'une erreur réelle n'a pas été exécutée.

## Cible active — R46B5B déduplication de l’événement FSM

R46B5A raccorde correctement la chaîne générique `Application → RuntimeController → FsmSiteLoader → FsmProcessor` au Profiler actif et la preuve runtime confirme un span FSM enfant du span HTTP. Elle a toutefois publié deux fois `fsm.transition.started` pour ce même span : une fois automatiquement par `Trace::beginSpan()` et une fois explicitement dans `FsmProcessor`.

R46B5B traite la cause en supprimant uniquement l’émission explicite redondante. `Trace::beginSpan()` reste l’unique propriétaire de l’événement de début ; gardes, succès, échec, fin de span, contexte et durée restent mesurés. Aucun compteur n’est fabriqué dans SCORE.

R46B4 reste parallèlement à valider sur le flux réel :

```text
owasys-front → span REST → owasys-back → spans BDD/Composer → réponse → owasys-front
```

## Ordre de travail

1. Appliquer R46B5B par-dessus R46B5 + R46B5A non poussés.
2. Linter `Opus/Fsm/FsmProcessor.php` et exécuter les smokes OPUS/FSM.
3. Parcourir `/applications?profiler=1` et vérifier exactement un `fsm.transition.started` par span FSM.
4. Vérifier le même `trace_id`, le span FSM enfant du span HTTP, gardes, succès/échec, états, actions et durée.
5. Ne commit/push l’ensemble R46B5 + R46B5A + R46B5B qu’après validation owner.
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
