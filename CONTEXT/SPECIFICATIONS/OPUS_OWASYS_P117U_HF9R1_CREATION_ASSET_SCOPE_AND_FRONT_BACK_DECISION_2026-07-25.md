# OPUS / OWASYS P117U HF9R1 — ASSET CREATION ET DÉCISION FRONT/BACK

Date : 2026-07-25  
Statut : correctif différentiel produit ; décision d’architecture générique non encore approuvée

## 1. Régression reproduite

Après HF9 :

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HS
```

Cause confirmée dans le différentiel HF9 :

- le layout SCORE commun référence `assets.creation_css` ;
- `OwasysCreationController` fournit cette clé ;
- `OwasysRuntimeController`, qui rend `/applications`, ne la fournit pas ;
- la vue Creation fonctionne, tandis que les autres vues utilisant le layout commun échouent.

Cette régression concerne exclusivement la portée d’un asset frontend OWASYS. Elle ne concerne ni REST, ni Composer, ni la FSM backend.

## 2. Correctif HF9R1

Le layout commun ne référence plus l’asset spécifique Creation.

Le template SCORE du module Creation charge lui-même :

```text
assets.creation_css
```

Périmètre :

```text
sites/owasys/application/default/layouts/layout.score
sites/owasys/application/creation/templates/index.score
```

Aucune classe PHP n’est ajoutée ou modifiée. Aucun contrat classe/interface OPUS n’est affecté.

## 3. Architecture front/back proposée

Le contrat actuel `OPUS_SITE_STANDARD_CONTRACT_CORE` impose :

```text
sites/<site>/application/default/
sites/<site>/application/<controller-or-feature>/
```

Il interdit les structures applicatives improvisées et prévoit chaque controller ou fonctionnalité directement sous `application`.

Par conséquent, la structure suivante n’est pas autorisée sans évolution générique du contrat OPUS :

```text
sites/owasys/application/front/...
sites/owasys/application/back/...
```

## 4. Recommandation

Conserver la structure canonique directe et séparer les responsabilités par modules :

```text
application/default/     commun, bootstrap, layout SCORE, services partagés
application/registry/    UI Registry
application/creation/    UI Creation
application/structure/   UI Structure
application/data/        UI Données
application/workflows/   UI Workflows
application/security/    UI Sécurité
application/source/      UI Sources et Git
application/build/       UI Construction et validation
application/api/         frontière REST sécurisée
```

Le backend métier reste derrière :

```text
SCORE UI -> REST sécurisé -> FSM backend -> Composer allow-listé -> service/provider
```

La séparation logique front/back existe donc sans ajouter une couche de répertoires contraire au contrat.

## 5. Décision owner requise pour une séparation physique

Une séparation physique `application/front` / `application/back` nécessiterait une évolution générique de :

- `OPUS_SITE_STANDARD_CONTRACT_CORE` ;
- le scaffold OPUS ;
- le bootstrap et la découverte des modules ;
- les conventions I18n, ACL, FSM, SCORE, Logger et Profiler ;
- les applications OPUS existantes ou leur compatibilité de migration.

Cette évolution ne doit pas être introduite localement dans OWASYS.

## 6. Artefact

```text
ZIP     : opus_owasys_p117u_hf9r1_creation_asset_scope_fix.zip
SHA-256 : 301f461443ec934ddab06ef9883e48a827534a9acc5d8cc235434c1f84e5440e
PATHS   : 2
```

## 7. Validation attendue

Après extraction et rechargement forcé :

```text
/fr-FR/applications     : OK
/fr-FR/applications/new : OK
```

Aucun nettoyage préalable n’est requis.
