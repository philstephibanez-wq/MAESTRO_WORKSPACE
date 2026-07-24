# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_2026-07-24.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité active

```text
OPUS repository : philstephibanez-wq/OPUS
Branch          : master
Current head    : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
Milestone       : P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8
Workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

HF7 et HF8 sont committés sur `OPUS/master`. HF9 est un différentiel OWASYS construit sur ce HEAD.

OWASYS reste l’application SCORE `sites/owasys/`. Toute mutation métier traverse REST sécurisé puis Composer.

## Checkpoint runtime reçu

Les quatre captures valident :

- surface Applications active ;
- diagramme FSM principal visible ;
- bouton `Créer une nouvelle application` visible ;
- 1 candidat, 1 application canonique ;
- 0 identifiant dupliqué, 0 racine ignorée ;
- 1 Singleton conforme, 0 non conforme ;
- OWASYS découvert comme `fullstack`, `standard-opus-application`, racine `sites/owasys` ;
- route `/fr-FR/applications/new` accessible ;
- champ identifiant, profils frontend/backend/fullstack et boutons Créer/Annuler présents.

Le défaut visible est limité à la présentation du sélecteur de profils : cartes superposées et descriptions illisibles.

## Journal backend

```text
événements                  : 35
traces complètes            : 7
operation                   : registry.sync
commande Composer           : owasys:registry-sync
exit_code=0                 : 7/7
stderr_bytes=0              : 7/7
FSM succeeded               : 7/7
erreurs                     : 0
site.create                 : 0
```

Aucune création d’application n’a encore été soumise.

## Cause HF9

Le template Creation utilise :

```text
ow-creation-form
ow-form-field
ow-profile-selector
ow-profile-option
```

Aucune règle dédiée n’existe au HEAD dans `owasys.css` ou le thème OWASYS. Les labels héritent seulement de `.ow-card` tout en restant inline, ce qui produit le chevauchement.

## Différentiel HF9

```text
ZIP     : opus_owasys_p117u_hf9_creation_form_layout.zip
SHA-256 : 1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0
PATHS   : 3
BASE    : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
```

Contenu :

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

HF9 ajoute une feuille dédiée chargée uniquement par Creation. Il ne modifie aucune commande métier, aucune route REST, aucune commande Composer, aucune transition FSM et aucune classe sous `Opus/`.

## Validations HF9

```text
PHP lint CreationController.php      : OK
Conditionnels SCORE                  : équilibrés
Chromium 1716 px                     : 0 chevauchement, 0 overflow
Chromium 1100 px                     : 0 chevauchement, 0 overflow
Chromium 760 px                      : 0 chevauchement, 0 overflow
Chromium 420 px                      : 0 chevauchement, 0 overflow
Nouvelle classe concrète OPUS        : aucune
Echo UI ajouté                       : aucun
Backend métier modifié               : non
Contenu parasite ZIP                 : aucun
```

## Contrats obligatoires

- toute classe concrète sous `Opus/` implémente directement son interface homonyme ;
- l’interface homonyme étend `OpusFrameworkComponentInterface`, `OpusExceptionAwareInterface`, `OpusProfilerAwareInterface` et `OpusSelfDocumentingInterface` ;
- applications Singleton, FSM, I18n, ACL deny-by-default et SSO/Auth0-proxy compatibles bastion ;
- rendu SCORE uniquement ;
- aucun echo UI, aucun mélange HTML/PHP ;
- locale initiale depuis le navigateur avec fallback explicite ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- besoin générique proposé comme évolution OPUS avant solution locale ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Installation owner HF9

1. vérifier `git status` propre dans `H:\OPUS` ;
2. vérifier le HEAD `f9d01dca6644f41c10b85fd6da47eb8c21bf15b6` ;
3. extraire HF9 à la racine de `H:\OPUS` ;
4. exécuter le PHP lint ;
5. lancer backend et frontend ;
6. forcer le rechargement de `/fr-FR/applications/new` ;
7. vérifier le formulaire à largeur desktop et mobile ;
8. tester Annuler ;
9. effectuer ensuite une création contrôlée ;
10. vérifier REST sécurisé, Composer, Logger, Profiler, Registry select et Build ;
11. exécuter l’audit tokenizer P117M avant commit ;
12. committer et pousser OPUS après acceptation owner.

## Lancement

```text
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
```

Les secrets backend viennent uniquement de l’environnement sécurisé.

## Nettoyage

Aucun nettoyage n’est requis. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
