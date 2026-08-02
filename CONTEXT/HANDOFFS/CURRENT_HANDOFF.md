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

- OPUS GitHub : `039ec38fade806778a6c948289aa2886f048605f`.
- Commit owner : `opus_p117w_r46b3_acl_decision_collector`.
- R46A1, R46B1, R46B2, R46B3, R46C1 et R46C3 validés et poussés.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuves acquises

- R46B2 : un span HTTP racine en succès, dix événements corrélés, HTTP 200, aucun faux span REST ou Composer.
- R46B3 autorisé : utilisateur `admin`, Profiler accessible, span HTTP en succès, `acl.decision.evaluated`, aucun `acl.decision.denied`.
- R46B3 refusé : `roles: []`, `profiler:view`, décision `denied`, règle `default:deny`, événements corrélés au span HTTP ; l'accès reste refusé.
- R46C3 : iframe same-origin, session OWASYS centralisée, ACL et rendu SCORE validés.

La branche `http.exception.caught` reste non prouvée tant qu'une erreur réelle n'a pas été exécutée.

## Cible active — Profiler OPUS complet

Le Profiler doit fournir une couverture développeur comparable à Symfony, complétée par les domaines propres à OPUS : FSM, SCORE, REST distribué, ACL/SSO, I18n et Composer.

R46B4 est livré sur le HEAD OPUS `039ec38fade806778a6c948289aa2886f048605f` et attend la validation owner. Il ajoute un observateur BDD générique OPUS puis raccorde les opérations SQLite réelles du backend au cycle Composer corrélé.

```text
owasys-front → span REST → owasys-back → spans BDD/Composer → réponse → owasys-front
```

R46B4 mesure connexion, préparation/exécution, schéma et transactions avec durée, succès/échec et origine applicative, sans SQL brut, paramètres sensibles ni secrets. Les lignes lues/affectées et l'agrégation frontend restent des incréments ultérieurs. Aucun panneau SCORE ne doit être enrichi avant que les événements réels correspondants existent.

## Ordre de travail

1. Appliquer puis linter le ZIP R46B4 sur le HEAD exact.
2. Exécuter un `owasys:registry:sync` réel via le flux REST/Composer.
3. Vérifier les spans Composer → BDD, les événements contractuels, les transactions et l'absence de SQL/paramètres.
4. Ne commit/push OPUS qu'après validation owner.
5. Compléter lignes lues/affectées puis l'agrégation distribuée frontend.
6. Poursuivre les collecteurs session, cache, I18n, logs, exceptions, runtime et performances, puis les panneaux SCORE.

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
