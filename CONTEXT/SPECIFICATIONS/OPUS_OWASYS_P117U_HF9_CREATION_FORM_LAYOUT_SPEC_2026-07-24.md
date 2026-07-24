# OPUS / OWASYS P117U HF9 — MISE EN PAGE DU FORMULAIRE CREATION

Date : 2026-07-24  
Statut : correctif OWASYS produit sous forme de ZIP différentiel  
Portée : présentation SCORE du formulaire de création d’application OWASYS

## 1. Sources de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
Branch          : master
Base commit     : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
Base milestone  : P117U + HF1 + HF2 + HF3 + HF4 + HF6 + HF7 + HF8
Workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

HF8 est désormais committé sur `OPUS/master`. HF9 est construit sur ce HEAD exact.

## 2. Preuves runtime reçues

Les quatre captures valident :

1. la surface Applications et le diagramme FSM principal ;
2. le bouton `Créer une nouvelle application` ;
3. l’intégrité de découverte : 1 candidat, 1 application canonique, 0 identifiant dupliqué, 0 racine ignorée ;
4. le contrat Singleton : 1 conforme, 0 non conforme ;
5. OWASYS découvert comme application OPUS `fullstack`, `standard-opus-application`, racine `sites/owasys` ;
6. l’ouverture effective de `/fr-FR/applications/new` ;
7. la présence du champ identifiant, des profils frontend/backend/fullstack et des actions Créer/Annuler.

La dernière capture démontre un défaut de présentation : les cartes des trois profils se chevauchent, leurs descriptions sont tronquées ou superposées et le fieldset n’organise pas les options de manière stable.

## 3. Journal backend

Le journal fourni contient 35 événements répartis sur 7 traces complètes.

```text
operation       : registry.sync
composer script : owasys:registry-sync
traces          : 7
exit_code       : 0 pour les 7 commandes
stderr_bytes    : 0 pour les 7 commandes
FSM final       : succeeded pour les 7 exécutions
erreurs         : 0
```

Durées Composer observées :

```text
minimum : 3603.440 ms
moyenne : 4919.592 ms
maximum : 10261.340 ms
```

Aucune opération `site.create` n’est présente. Le formulaire a été ouvert mais aucune création métier n’a encore été soumise.

## 4. Cause racine

Le template réel :

```text
sites/owasys/application/creation/templates/index.score
```

utilise les classes :

```text
ow-creation-form
ow-form-field
ow-profile-selector
ow-profile-option
```

Le HEAD OPUS ne fournit aucune règle dédiée à ces classes dans :

```text
sites/owasys/www/asset/css/owasys.css
sites/owasys/www/asset/themes/owasys/css/theme.css
```

Les labels de profils héritent donc seulement de `.ow-card`. Comme un élément `label` reste inline sans règle `display`, les marges, paddings et contenus se composent en lignes et provoquent le chevauchement visible.

## 5. Nature du correctif

Le besoin est strictement applicatif à la présentation OWASYS Creation. Il ne nécessite aucune évolution générique supplémentaire du framework OPUS.

HF9 :

- ajoute une feuille CSS dédiée à Creation ;
- la charge uniquement lorsque le contrôleur Creation fournit l’asset ;
- conserve le template SCORE existant ;
- ne modifie aucune commande métier ;
- ne modifie ni REST, ni Composer, ni Registry ;
- ne modifie pas le pilotage FSM ;
- ne modifie pas I18n, ACL, SSO, Auth0 ou bastion ;
- ne modifie pas Logger ou Profiler.

## 6. Périmètre différentiel

```text
sites/owasys/application/creation/controllers/CreationController.php
sites/owasys/application/default/layouts/layout.score
sites/owasys/www/asset/css/creation.css
```

### CreationController.php

Ajoute uniquement :

```text
assets.creation_css = <base>/asset/css/creation.css?v=p117u-hf9
```

### layout.score

Charge conditionnellement la feuille Creation :

```score
[[ if: assets.creation_css ]]
  <link rel="stylesheet" href="{{ assets.creation_css }}">
[[ endif ]]
```

### creation.css

Fournit :

- grille stable du champ identifiant ;
- fieldset à trois colonnes sur grand écran ;
- passage à une colonne sous 1120 px ;
- cartes de profils en grille interne radio/titre/description ;
- absence de chevauchement ;
- focus clavier visible ;
- indication visuelle du profil sélectionné ;
- boutons adaptatifs ;
- fonctionnement sans JavaScript.

## 7. Contrats préservés

- rendu exclusivement SCORE ;
- aucun `echo` UI ajouté ;
- aucun mélange HTML/PHP ;
- architecture Singleton inchangée ;
- FSM, I18n, ACL et SSO inchangés ;
- détection de langue navigateur inchangée ;
- configuration File + StructuredFileLoader inchangée ;
- frontière OWASYS REST sécurisé puis Composer inchangée ;
- Logger et Profiler inchangés ;
- aucun secret livré.

HF9 n’ajoute aucune classe concrète sous `Opus/`. Le contrat des interfaces homonymes à quatre marqueurs n’est donc pas étendu ni contourné.

## 8. Validations exécutées

```text
Base CreationController blob GitHub vérifiée : 0ac0f17476f2b1f082e11b0f83582e52ba23b0e3
Base layout.score blob GitHub vérifiée       : 62bd352c110073d60798626c0b1596062fee3035
PHP lint CreationController.php              : OK
Syntaxe conditionnelle SCORE                 : équilibrée
Asset Creation déclaré et référencé          : OK
CSS chargé dans Chromium headless            : OK
Largeur 1716 px                               : 3 colonnes, 0 chevauchement, 0 overflow
Largeur 1100 px                               : 1 colonne, 0 chevauchement, 0 overflow
Largeur 760 px                                : 1 colonne, 0 chevauchement, 0 overflow
Largeur 420 px                                : 1 colonne, 0 chevauchement, 0 overflow
Nouvelle classe concrète OPUS                 : aucune
Commande métier modifiée                      : aucune
Echo UI ajouté                                : aucun
Contenu parasite ZIP                          : aucun
```

## 9. Artefact

```text
ZIP     : opus_owasys_p117u_hf9_creation_form_layout.zip
SHA-256 : 1db0628b87961e098df9500924a496548ea2029702628eb8012c9313636505f0
PATHS   : 3
```

Le ZIP contient uniquement les trois chemins cibles.

## 10. Installation owner

Base requise :

```text
f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
```

Après extraction à la racine de `H:\OPUS` :

1. exécuter le PHP lint du contrôleur ;
2. lancer backend et frontend OWASYS ;
3. rafraîchir `/fr-FR/applications/new` avec cache navigateur forcé ;
4. vérifier les trois profils à largeur desktop et mobile ;
5. tester Annuler ;
6. tester ensuite une création contrôlée ;
7. vérifier Logger/Profiler et la chaîne REST sécurisé puis Composer ;
8. committer OPUS après acceptation owner.

## 11. Nettoyage

Aucun nettoyage préalable n’est requis.

Ne pas supprimer :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```
