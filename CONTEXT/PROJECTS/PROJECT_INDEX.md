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
- Dépôt cible : `philstephibanez-wq/OPUS`.
- Branche : `master`.
- Dernier commit OPUS validé enregistré : `4082f3c3ff57c57b560c371b2b01ff1b728cffc2`.
- Priorité active : terminer OWASYS.
- ScoreTemplate : composant OPUS, extension `.score`.
- REST : brique générique OPUS.
- Accès BDD officiel : ODBC.
- `Opus\\Model` : représentation officielle des tables, lignes, champs, types, tailles et métadonnées ODBC.

## OWASYS

- Rôle : livrable OPUS destiné aux utilisateurs d’OPUS.
- Source : dépôt OPUS, sous `sites/owasys` et `Opus/Owasys`.
- Portabilité : environnements OPUS Windows et Linux supportés.
- Interdiction : aucune dépendance contractuelle à `H:/OPUS`, UwAmp, un PC HP ou un serveur particulier.
- Séparation dev/prod : basée sur `OPUS_ENV`, pas sur la machine.
- Contrat de distribution : `OWASYS_DISTRIBUTION_V1`.
- Architecture : state-first, sans racines générées `src`, `public` ou `resources`.
- Profiler : obligatoire dans chaque application générée, disponible seulement en dev/local/development et indisponible en production.
- Build pipeline : `OWASYS_BUILD_PIPELINE_RESULT_V1`, modes preview/build/build-and-export.
- État : moteur et recette globale verts ; écran Build encore à brancher au pipeline.
- Prochain travail : rendre utilisable depuis l’UI create -> preview -> generate -> validate -> export.
- Handoff : `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`.

## OPUS Demo

- Rôle : démonstration officielle générée par OWASYS.
- État : à générer après fermeture d’OWASYS.

## OPUS User Book

- Rôle : documentation utilisateur d’OPUS et d’OWASYS.
- État : à produire après la démo.

## OPUS Reference Book

- Rôle : documentation technique officielle OPUS.
- Cible : package/site optionnel officiel livré avec OPUS.
- Rendu : ScoreTemplate `.score` OPUS.
- État : à produire après le User Book.

## LSTSAR

- Rôle : Load / Secure / Transform / Store / Audit / Restore.
- Priorité : après OWASYS, Demo, User Book et Reference Book.
- Cible finale : Model-driven + ODBC-driven.
- Validation : source reçue et cible transformée contrôlées séparément.
- Contraintes : type, `min_length`, `max_length`, `exact_length`, `max_bytes`, précision et échelle numériques.

## KB

- Rôle : connaissance musicale et services associés.
- Priorité : reprise après finalisation LSTSAR.

## LOGANDPLAY

- Rôle : identité publique et carte d’entrée `logandplay.org`.
- Dépôt source actuel : `philstephibanez-wq/OPUS`.

## MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs et contrats transverses.
- Règle : documenter et cadrer, sans remplacer les dépôts sources.
- Correction importante : OPUS fait partie du workspace ; OPUS n’est pas le workspace.

## Priorité de reprise

1. Lire `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
2. Lire `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`.
3. Terminer l’écran Build et le parcours complet OWASYS.
4. Générer la démo officielle.
5. Produire User Book puis Reference Book.
6. Finaliser LSTSAR.
7. Revenir à KB.

## Contrats associés

- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
- `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
- `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
- Les décisions ODBC/Model/LSTSAR restent applicables lors de la reprise de ce chantier.
