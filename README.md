# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et LOGANDPLAY.

Ce dépôt garde les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. README.md
2. CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
3. CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
4. CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
5. CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
6. CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
7. CONTEXT/PROJECTS/PROJECT_INDEX.md
8. les ADRs liées

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| LOGANDPLAY | Identité publique et carte d'entrée logandplay.org | Projet workspace/site OPUS à aligner contractuellement ; aucune exposition publique active |
| OPUS | Framework PHP OPUS 8.1.0 Lysenko | P7B4 ACL ASAP-compatible repair validé et poussé, commit OPUS c402bd9 ; prochaine étape P7_LSTSAR_CONTRACT_VALIDATION_CORE |
| OPUS RefBook | Site officiel de documentation OPUS | Intégré sous OPUS comme site optionnel ; doit rester .score, sans polluer le core |
| OPUS_USER_GUIDE | Guide utilisateur optionnel futur | À cadrer |
| OPUS_REF_BOOK | Ancien dépôt transitoire RefBook | Ne plus utiliser comme source long terme |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif, non exposé publiquement |
| MO_KB_DAEMON | Backend KB musicale | Actif privé, non exposé publiquement |
| MO_KB_FRONT | Front/backoffice KB historique | À réévaluer vers KB_FRONT_OFFICE / KB_BACK_OFFICE OPUS |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte, handoffs et TODOs |

## OPUS état immédiat

- OPUS root : H:\OPUS
- OPUS GitHub : philstephibanez-wq/OPUS
- Workspace root : H:\MAESTRO_WORKSPACE
- Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
- OPUS branch : master
- OPUS commit : c402bd9
- OPUS message : P7 repair ACL with ASAP-compatible engine

P7B4 a réparé la régression ACL. OPUS doit faire évoluer ASAP, pas le dégrader.

ACL actuelle : default deny, rôles, héritage de rôles, ressources, héritage de ressources, privilèges, allow, deny, all roles, all resources, all privileges, conditions, trace de décision, aucun fallback silencieux.

Endpoints smoke validés :

- GET /api/v1/status
- GET /api/v1/me
- GET /api/v1/security/policies
- GET /api/v1/lstsar/contracts
- GET /api/v1/lstsar/pipelines/default
- GET /api/v1/lstsar/engine/skeleton

Validation P7B4 : lint PHP OK, JSON ACL OK, autoload OK, matrice ACL OK, smoke REST OK, profiler temp nettoyé, commit et push OK.

## Handoff obligatoire à chaque livraison

À chaque livraison qui change l'état projet, mettre à jour le workspace, notamment CURRENT_HANDOFF.md, PROJECT_INDEX.md, les décisions si nécessaire, et README.md si la vue 10 secondes change.

## Raccourcis

- Handoff courant : CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- Handoff OPUS P7B4 : CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- Handoff OPUS P7B3 : CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- Handoff OPUS P7B2 : CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- Handoff OPUS P7B1 : CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- OPUS current state : CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Projet LOGANDPLAY : CONTEXT/PROJECTS/LOGANDPLAY.md

## Règles immédiates

- OPUS P7B4 : ACL ASAP-compatible repair validé et poussé.
- OPUS REST : générique, data-driven, contractuel, sans hardcode LSTSAR.
- OPUS ACL : faire évoluer ASAP, ne pas le dégrader.
- OPUS LSTSAR : contrats et skeleton moteur séparés sous Opus\Lstsar, pas de vraie persistance à ce stade.
- Prochaine étape : P7_LSTSAR_CONTRACT_VALIDATION_CORE.
- Opus/Legacy ne doit pas réapparaître.
- Pas de fallback silencieux.
- Les caches vont dans OPUS/var/cache.
- Les logs vont dans OPUS/var/logs.
