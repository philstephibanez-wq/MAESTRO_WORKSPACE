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
- État courant : ODBC-only + Model core validés ; ODBC Explorer contract core validé.
- Dernier commit fonctionnel OPUS : e12b1dd.
- Dernier tag validé : OPUS_P7_ODBC_EXPLORER_CONTRACT_CORE.
- Prochain palier actif : P7_ODBC_EXPLORER_READONLY_CORE.
- Palier site ensuite : P7_ODBC_EXPLORER_SITE_APP_CORE.
- Palier LSTSAR final ensuite : P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE.
- ScoreTemplate : composant OPUS.
- Extension template : .score.
- Règle : ne pas documenter, nommer ou implémenter ScoreTemplate comme composant ASAP.
- Règle OPUS/ASAP : OPUS doit faire évoluer ASAP, pas le dégrader.
- Règle REST : REST est une brique générique OPUS.
- Règle BDD : OPUS ne connaît officiellement que ODBC pour les accès BDD.
- Règle Model : Opus\Model représente les tables, lignes, champs, types, longueurs et métadonnées ODBC.
- Règle ODBC Explorer : futur site OPUS de type Adminer/phpMyAdmin pour ODBC + Model + LSTSAR.
- Règle LSTSAR : cible finale Model-driven + ODBC-driven.
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
- Correction importante : OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Priorité de reprise

1. Lire CONTEXT/HANDOFFS/CURRENT_HANDOFF.md.
2. Lire CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md.
3. Lire CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md.
4. Lancer P7_ODBC_EXPLORER_READONLY_CORE.
5. Reprendre ensuite P7_ODBC_EXPLORER_SITE_APP_CORE.
6. Reprendre ensuite P7_LSTSAR_MODEL_DRIVEN_ODBC_CORE.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/DECISIONS/DECISION_20260629_OPUS_ODBC_ONLY_MODEL_EXPLORER_SITE.md
- CONTEXT/HANDOFFS/P7C1_20260629_OPUS_ODBC_MODEL_EXPLORER.md
- CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
