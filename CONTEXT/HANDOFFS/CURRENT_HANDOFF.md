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

Prochaine priorité : collecte BDD générique au point central d'exécution SQL, puis corrélation distribuée :

```text
owasys-front → span REST → owasys-back → spans BDD/Composer → réponse → owasys-front
```

La collecte BDD doit couvrir connexion, opération normalisée, transaction, durée, succès/échec, lignes affectées et origine applicative, sans SQL brut, paramètres sensibles ni secrets. Aucun panneau SCORE ne doit être enrichi avant que les événements réels correspondants existent.

## Ordre de travail

1. Auditer tous les points d'exécution BDD du framework et des applications publiées.
2. Définir ou compléter les événements et spans BDD génériques.
3. Instrumenter le point central OPUS, pas un dépôt OWASYS isolé.
4. Tester succès, erreur et transaction avec événements réels.
5. Livrer OPUS/OWASYS uniquement par ZIP différentiel owner-validé.
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
