# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF9R1

Date : 2026-07-25  
Statut : régression `/applications` corrigée par ZIP différentiel ; décision front/back générique en attente

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
head            : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Régression

Après installation HF9 :

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HS
```

Le layout SCORE commun testait `assets.creation_css`, mais cette clé n’existait que dans les données du contrôleur Creation.

## Correctif HF9R1

```text
ZIP     : opus_owasys_p117u_hf9r1_creation_asset_scope_fix.zip
SHA-256 : 301f461443ec934ddab06ef9883e48a827534a9acc5d8cc235434c1f84e5440e
PATHS   : 2
```

Contenu :

```text
sites/owasys/application/default/layouts/layout.score
sites/owasys/application/creation/templates/index.score
```

Le layout commun ne dépend plus d’un asset spécifique à Creation. Le template Creation charge sa propre feuille CSS.

Aucune classe PHP, commande métier, route REST, commande Composer, FSM, ACL, SSO, Logger ou Profiler n’est modifié.

## Architecture front/back

Le contrat OPUS actuel impose les fonctionnalités directement sous `application/` et interdit une structure improvisée.

Recommandation actuelle :

```text
application/default
application/registry
application/creation
application/structure
application/data
application/workflows
application/security
application/source
application/build
application/api
```

La séparation logique reste :

```text
UI SCORE -> REST sécurisé -> FSM backend -> Composer -> service/provider
```

Une arborescence physique `application/front` / `application/back` exige une évolution générique du contrat et du scaffold OPUS. Elle ne doit pas être appliquée localement dans OWASYS.

## Validation owner

1. extraire HF9R1 à la racine de `H:\OPUS` ;
2. forcer le rechargement de `/fr-FR/applications` ;
3. vérifier `/fr-FR/applications/new` ;
4. vérifier Annuler ;
5. ne lancer aucune création avant validation des deux routes.

Aucun nettoyage préalable n’est requis.
