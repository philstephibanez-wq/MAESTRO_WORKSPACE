# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et LOGANDPLAY.

Ce dépôt garde les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. README.md
2. CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
3. CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
4. CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
5. CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
6. CONTEXT/PROJECTS/PROJECT_INDEX.md
7. les ADRs liées

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| LOGANDPLAY | Identité publique et carte d'entrée logandplay.org | Projet workspace/site OPUS à aligner contractuellement ; aucune exposition publique active |
| OPUS | Framework PHP OPUS 8.1.0 Lysenko | P7B3 LSTSAR Contract Engine Skeleton validé et poussé, commit OPUS ec2cb0c ; prochaine étape P7_LSTSAR_CONTRACT_VALIDATION_CORE |
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
- OPUS commit : ec2cb0c
- OPUS message : P7 add LSTSAR contract engine skeleton

P7B3 a ajouté le skeleton moteur contractuel LSTSAR sous Opus\Lstsar.

LSTSAR signifie Load / Secure / Transform / Store / Audit / Report.

REST reste généraliste : les endpoints LSTSAR exposent et déclenchent seulement des services et contrats framework via ApiEndpointInterface, sans logique métier LSTSAR dans le core REST.

Endpoints smoke validés :

- GET /api/v1/status
- GET /api/v1/me
- GET /api/v1/security/policies
- GET /api/v1/lstsar/contracts
- GET /api/v1/lstsar/pipelines/default
- GET /api/v1/lstsar/engine/skeleton

Validation P7B3 : lint PHP OK, JSON configs OK, autoload OK, smoke API LSTSAR engine OK, profiler temp nettoyé, commit et push OK.

## OPUS contrats immédiats

REST / Security : ApiEndpointInterface, ApiDispatcher, ApiRouteRegistry, ApiErrorResponseFactory, SsoAuthenticatorInterface, IdentityContextInterface, AclPolicyInterface, AccessDecisionInterface, FsmGuardInterface.

LSTSAR : LstsarPipelineInterface, LstsarJobInterface, LstsarReportInterface, LstsarStageInterface, LoadStageInterface, SecureStageInterface, TransformStageInterface, StoreStageInterface, AuditStageInterface, ReportStageInterface, LstsarConstraintSet, LstsarJobDescriptor, LstsarSourceContract, LstsarTargetContract, LstsarPipelineRunner, LstsarPipelineRunReport, DeclaredLstsarPipeline, LstsarStageResult.

## Handoff obligatoire à chaque livraison

À chaque livraison qui change l'état projet, mettre à jour le workspace, notamment CURRENT_HANDOFF.md, PROJECT_INDEX.md, les décisions si nécessaire, et README.md si la vue 10 secondes change.

## Raccourcis

- Handoff courant : CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- Handoff OPUS P7B3 : CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- Handoff OPUS P7B2 : CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- Handoff OPUS P7B1 : CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- ADR OPUS REST Security Core : CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
- OPUS current state : CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Projet LOGANDPLAY : CONTEXT/PROJECTS/LOGANDPLAY.md

## Règles immédiates

- OPUS P7B3 : LSTSAR Contract Engine Skeleton validé et poussé.
- OPUS REST : générique, data-driven, contractuel, sans hardcode LSTSAR.
- OPUS LSTSAR : contrats et skeleton moteur séparés sous Opus\Lstsar, pas de vraie persistance à ce stade.
- OPUS Security : SSO / Identity / ACL / FSM sous interfaces.
- Prochaine étape : P7_LSTSAR_CONTRACT_VALIDATION_CORE.
- Profiler dev : i18n fr/en/es à reprendre ensuite.
- Opus/Legacy ne doit pas réapparaître.
- Pas de fallback silencieux.
- Les caches vont dans OPUS/var/cache.
- Les logs vont dans OPUS/var/logs.
