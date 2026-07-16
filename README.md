# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est pas le workspace.

## Reprise immédiate

Lire :

1. `README.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/HANDOFFS/OWASYS_20260716_DELIVERY_CLOSURE.md`
4. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

## Vue rapide

| Projet | État |
|---|---|
| OWASYS | Priorité absolue ; Build, Source editor et Git stage/commit visuel validés ; HTTP/runtime et recette visuelle finale à fermer |
| OPUS Demo | À générer après fermeture OWASYS |
| User Book | Après la démo |
| Reference Book | Après le User Book |
| LSTSAR | Après la documentation |
| KB | Après LSTSAR |

## État OPUS / OWASYS

- dépôt : `philstephibanez-wq/OPUS`
- branche : `master`
- dernier commit localement validé : `cb2971f6abe3221a91a327fadbbd74366f641a3a`
- environnement owner actuel : `H:/OPUS`, sans valeur contractuelle pour la distribution

OWASYS est un livrable portable Windows/Linux pour les utilisateurs d'OPUS. Dev/prod dépend de `OPUS_ENV`, pas de la machine.

## Capacités validées

- Build preview/build/build-and-export ;
- génération, validation et ZIP ;
- état Source state-first et endpoint authentifié ;
- arbre et édition sécurisée des fichiers applicatifs ;
- aperçu diff obligatoire, validation PHP/JSON, verrou SHA-256, écriture atomique ;
- inspection Git ;
- staging et commit limités à l'application sélectionnée ;
- contrôles visuels de staging et commit ;
- aucune commande Git libre, aucun pull/push/reset/changement de branche ;
- suite globale `OPUS_SMOKE_ALL_OK`.

## Priorité active

1. compléter le smoke HTTP/runtime Source & Git ;
2. vérifier la session authentifiée et les gardes réelles ;
3. retirer les derniers placeholders essentiels ;
4. exécuter la recette fonctionnelle et visuelle finale.

## Feuille de route verrouillée

1. OWASYS.
2. Démo officielle.
3. User Book.
4. Reference Book.
5. LSTSAR.
6. KB.

## Règles

- NO CONTRACT, NO PATCH.
- NO SOURCE OF TRUTH, NO PATCH.
- NO BRICOLAGE DELIVERY.
- NO FALLBACK SILENCIEUX.
- WORKSPACE HANDOFF UPDATED AT EVERY STATE CHANGE.
- SCORETEMPLATE BELONGS TO OPUS, NOT ASAP.