# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OWASYS, documentation OPUS, LSTSAR, KB et LOGANDPLAY.

Ce dépôt garde les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

Correction importante : OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. `README.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| OWASYS | Livrable OPUS de création/inspection/génération pour les utilisateurs d’OPUS | Priorité absolue ; moteurs et recette globale verts ; écran Build à brancher au pipeline |
| OPUS Demo | Démonstration officielle générée par OWASYS | À générer après fermeture OWASYS |
| OPUS User Book | Documentation utilisateur | Après la démo |
| OPUS Reference Book | Documentation technique officielle | Après le User Book |
| LSTSAR | Load / Secure / Transform / Store / Audit / Restore | Après la documentation ; cible Model-driven + ODBC-driven |
| KB | Connaissance musicale et services | Reprise après LSTSAR |
| LOGANDPLAY | Identité publique et carte d'entrée logandplay.org | À aligner contractuellement |
| OPUS | Framework PHP principal | Supporte OWASYS ; décisions ODBC/Model conservées |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte, handoffs et TODOs |

## État immédiat OPUS / OWASYS

- OPUS local dev actuel : `H:/OPUS`
- OPUS GitHub : `philstephibanez-wq/OPUS`
- Workspace local : `H:/MAESTRO_WORKSPACE`
- Workspace GitHub : `philstephibanez-wq/MAESTRO_WORKSPACE`
- Branche OPUS : `master`
- Dernier commit OPUS validé enregistré : `4082f3c3ff57c57b560c371b2b01ff1b728cffc2`

Le chemin Windows, UwAmp et la machine actuelle sont des détails de développement, pas des exigences de distribution.

OWASYS est un livrable portable pour les utilisateurs d’OPUS : Windows/Linux supportés, racine résolue à l’exécution, séparation dev/prod par `OPUS_ENV`.

## Validation OWASYS confirmée

Après le commit OPUS `4082f3c`, les validations locales incluent :

- `OWASYS_DISTRIBUTION_PORTABILITY_SMOKE_OK`
- `OWASYS_BUILD_PIPELINE_SMOKE_OK`
- `OWASYS_GENERATED_PROFILER_SMOKE_OK`
- `OWASYS_APPLICATION_CREATOR_SMOKE_OK`
- `OWASYS_APPLICATION_EXPORTER_SMOKE_OK`
- `OPUS_VALIDATE_SITE_OK: owasys`
- `OPUS_SMOKE_ALL_OK`

Les smokes HTTP runtime restent exécutés séparément du runner global non serveur.

## Priorité active

Terminer OWASYS sans dérive périphérique :

1. brancher l’écran Build au pipeline validé ;
2. finaliser create -> preview -> generate -> validate -> export depuis l’interface ;
3. compléter les smokes UI/HTTP ;
4. retirer les comportements essentiels encore purement descriptifs ;
5. effectuer la recette fonctionnelle et visuelle finale.

## Feuille de route verrouillée

1. OWASYS terminé.
2. Démo officielle générée par OWASYS.
3. User Book.
4. Reference Book.
5. LSTSAR.
6. Retour sur KB.

## Contrats majeurs

- OWASYS distribution : `sites/owasys/config/distribution.json` dans le dépôt OPUS, contrat `OWASYS_DISTRIBUTION_V1`.
- Profiler généré : obligatoire dans toutes les applications OWASYS, dev/local/development uniquement, indisponible en production.
- Build pipeline : `OWASYS_BUILD_PIPELINE_RESULT_V1`, modes `preview`, `build`, `build-and-export`.
- OPUS database : ODBC-only.
- OPUS Model : représentation officielle des tables/lignes/champs ODBC.
- LSTSAR final : Model-driven + ODBC-driven, avec validation séparée source/cible et contraintes de tailles/longueurs.

## Handoff obligatoire à chaque livraison

À chaque livraison qui change l'état projet, mettre à jour au minimum :

- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md` tant qu’OWASYS reste actif
- `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
- `CONTEXT/PROJECTS/PROJECT_INDEX.md`
- `README.md` si la vue 10 secondes change

## Règles immédiates

- OPUS est un sous-projet du MAESTRO_WORKSPACE ; OPUS n'est pas le workspace.
- OWASYS est un livrable OPUS pour les utilisateurs, pas un outil propre à une machine.
- ScoreTemplate et `.score` : OPUS uniquement, pas ASAP.
- OPUS REST : générique, data-driven, contractuel.
- OPUS database : ODBC-only, via `Opus\\Database\\Odbc`.
- OPUS Model : représentation officielle des tables/lignes/champs ODBC.
- OPUS LSTSAR final : Model-driven + ODBC-driven.
- Pas de fallback silencieux.
- Les caches vont dans `OPUS/var/cache`.
- Les logs vont dans `OPUS/var/logs`.
