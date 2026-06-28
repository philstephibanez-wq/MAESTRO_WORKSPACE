# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace.

## Règles permanentes

NO CONTRACT, NO PATCH.
NO DOC CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO BRICOLAGE DELIVERY.
WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
ASAP BEHAVIOR MUST BE EVOLVED, NOT DEGRADED.
SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.

## OPUS

- Rôle : framework PHP principal.
- Dépôt cible : philstephibanez-wq/OPUS.
- État courant : P7B4 ACL smoke repair poussé sur master, commit c402bd9.
- Prochain palier actif : P7_ACL_ASAP_PARITY_AUDIT.
- Palier LSTSAR ensuite : P7_LSTSAR_CONTRACT_VALIDATION_CORE.
- ScoreTemplate : composant OPUS.
- Extension template : .score.
- Règle : ne pas documenter, nommer ou implémenter ScoreTemplate comme composant ASAP.
- P7B1 : REST API SSO Security Core, commit 73f1deb.
- P7B2 : LSTSAR contract core, commit af2576f.
- P7B3 : LSTSAR contract engine skeleton, commit ec2cb0c.
- P7B4 : ACL smoke repair, commit c402bd9.
- Règle OPUS/ASAP : OPUS doit faire évoluer ASAP, pas le dégrader.
- Règle REST : REST est une brique générique OPUS.
- Règle LSTSAR : LSTSAR signifie Load, Secure, Transform, Store, Audit, Report.
- Cache Windows dev : H:/OPUS/var/cache uniquement.
- Logs Windows dev : H:/OPUS/var/logs uniquement.

## OPUS RefBook

- Rôle : site officiel de documentation OPUS.
- Cible : package optionnel officiel livré avec OPUS.
- Règle : rendu .score OPUS.

## LOGANDPLAY

- Rôle : identité publique et carte d'entrée logandplay.org.
- Dépôt source actuel : philstephibanez-wq/OPUS.

## MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs et contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.

## Priorité de reprise

1. Lire CONTEXT/DECISIONS/DECISION_20260628_OPUS_SCORETEMPLATE_OWNERSHIP.md.
2. Lire CONTEXT/HANDOFFS/CURRENT_HANDOFF.md.
3. Lire CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md.
4. Lancer P7_ACL_ASAP_PARITY_AUDIT.
5. Reprendre ensuite P7_LSTSAR_CONTRACT_VALIDATION_CORE.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/DECISION_20260628_OPUS_SCORETEMPLATE_OWNERSHIP.md
- CONTEXT/HANDOFFS/P7B4_20260628_OPUS_ACL_ASAP_COMPAT_REPAIR.md
- CONTEXT/HANDOFFS/P7B3_20260628_OPUS_LSTSAR_CONTRACT_ENGINE_SKELETON.md
- CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
