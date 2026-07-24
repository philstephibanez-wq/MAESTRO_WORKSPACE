# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF9 CREATION FORM LAYOUT

Date : 2026-07-24  
Statut : défaut de mise en page reproduit ; ZIP différentiel HF9 produit ; installation owner en attente

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
Branch          : master
Base commit     : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
Workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

HF7 et HF8 sont désormais committés sur `OPUS/master`.

## Preuves reçues

Les quatre captures valident :

- Applications accessible ;
- navigation FSM visible ;
- bouton de création visible ;
- découverte canonique verte ;
- Singleton vert ;
- OWASYS projeté comme application standard fullstack ;
- route `/fr-FR/applications/new` accessible ;
- champ identifiant, profils frontend/backend/fullstack et boutons Créer/Annuler présents.

La dernière capture montre le défaut HF9 : les trois cartes de profils se chevauchent et leurs descriptions sont illisibles.

Le journal backend contient 7 synchronisations Registry complètes. Toutes traversent REST sécurisé puis `owasys:registry-sync`, terminent avec `exit_code=0`, `stderr_bytes=0` et FSM `succeeded`. Aucune opération `site.create` n’a encore été lancée.

## Cause racine

Le template Creation utilise quatre classes CSS dédiées qui ne sont définies ni dans `owasys.css`, ni dans le thème OWASYS.

```text
ow-creation-form
ow-form-field
ow-profile-selector
ow-profile-option
```

Les labels héritent seulement de `.ow-card` et conservent leur comportement inline, ce qui provoque le chevauchement.

## Correctif HF9

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

Le nouveau CSS est chargé conditionnellement uniquement lorsque l’asset Creation est fourni.

HF9 ne modifie aucun service métier, aucune route REST, aucune commande Composer, aucune transition FSM et aucun composant OPUS générique.

## Artefact

```text
ZIP     : opus_owasys_p117u_hf9_creation_form_layout.zip
SHA-256 : 1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0
PATHS   : 3
```

## Validations de livraison

```text
PHP lint contrôleur                      : OK
Conditionnels SCORE équilibrés           : OK
Chromium 1716 px                         : 0 chevauchement, 0 overflow
Chromium 1100 px                         : 0 chevauchement, 0 overflow
Chromium 760 px                          : 0 chevauchement, 0 overflow
Chromium 420 px                          : 0 chevauchement, 0 overflow
Nouvelle classe concrète sous Opus/      : aucune
Echo UI ajouté                           : aucun
Backend métier modifié                   : non
Secret ou diagnostic livré               : aucun
```

## Prochaine séquence owner

1. vérifier que `H:\OPUS` est propre et au commit `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6` ;
2. extraire HF9 à la racine ;
3. exécuter le PHP lint ;
4. lancer backend et frontend ;
5. forcer le rechargement navigateur de `/fr-FR/applications/new` ;
6. vérifier les trois cartes de profils ;
7. tester Annuler ;
8. revenir dans Creation et effectuer une création contrôlée ;
9. vérifier REST sécurisé, Composer, Logger, Profiler, Registry select et Build ;
10. committer et pousser OPUS après acceptation owner.

## Nettoyage

Aucun nettoyage requis. Préserver `sites/owasys_old`, les logs, le profiler et le Registry.
