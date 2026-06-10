# MAESTRO_WORKSPACE — CONTRAT D’ARCHITECTURE ULTIME

Version: P112A
Statut: OBLIGATOIRE
Portée: MAESTRO_WORKSPACE complet
Date: 2026-06-05

---

## 1. Principe souverain

MAESTRO_WORKSPACE applique une architecture par métiers stricts.

Chaque couche est souveraine dans son périmètre et précise dans sa responsabilité.

```text
1 couche = 1 métier
1 moteur = 1 responsabilité
1 objet = 1 contrat
1 frontière = 1 validation explicite
```

Aucune couche ne doit faire le métier d’une autre.

Si un contrat n’est pas respecté, le système doit casser clairement avec une erreur explicite.

---

## 2. Règles non négociables

```text
0 fallback silencieux
0 tolérance implicite
0 logique métier dans la représentation
0 représentation dans la data
0 moteur fourre-tout
0 helper local non contractuel
0 fichier temporaire abandonné
0 scorie après livraison
0 patch sans source de vérité
0 patch depuis ZIP partiel
0 patch sur hypothèse
```

Tout comportement de secours doit être déclaré officiellement dans un contrat ou une configuration explicite.

Un `defaultLang = fr` déclaré est une règle contractuelle.
Une langue absente remplacée silencieusement par `fr` est interdite.

---

## 3. Source de vérité et gates P111/P112

Avant toute modification, le contexte vivant doit être identifié.

```text
NO SOURCE OF TRUTH, NO PATCH
NO CONTEXT, NO PATCH
NO LIVE TARGET, NO PATCH
NO REAL FILE VISIBLE, NO PATCH
NO PARTIAL ZIP PATCH
NO HYPOTHESIS PATCH
```

Un patch n’est autorisé que si les éléments suivants sont clairs :

```text
repo cible
branche cible
état git propre ou explicitement compris
fichiers réels inspectés
contrat d’architecture applicable
effet attendu
plan de rollback
contrôle final
cleanup final
```

Pour MAESTRO_V5 spécifiquement, le contrat AGENTS/MAESTRO_DEV_CONTEXT doit être disponible avant tout patch.

```text
NO AGENTS, NO PATCH
```

---

## 4. Séparation des métiers

### 4.1 Kernel

Le Kernel orchestre.

Il ne fait pas le métier des engines.

```text
Kernel =
  boot
  orchestration
  validation des frontières
  distribution des responsabilités
  gestion des contrats globaux
```

Interdit :

```text
Kernel qui traite une logique métier d’engine
Kernel qui rend l’UI
Kernel qui corrige silencieusement une config invalide
Kernel qui compense un moteur absent
```

### 4.2 Engines

Un engine fait un métier précis.

```text
Engine =
  responsabilité unique
  contrat explicite
  entrées validées
  sorties typées
  erreurs claires
```

Interdit :

```text
engine fourre-tout
engine qui remplace le Kernel
engine qui corrige un autre engine
engine qui fait de l’UI
engine qui fallback silencieusement
```

### 4.3 Services

Un service exécute une responsabilité métier ciblée.

```text
Service =
  traitement métier précis
  objets typés
  pas de rendu
  pas de décision hors contrat
```

Interdit :

```text
service qui génère du HTML
service qui lit une config hors contrat
service qui décide des routes
service qui corrige la représentation
```

### 4.4 Modules

Un module expose une interface métier ou fonctionnelle.

Il utilise les moteurs, services et composants officiels.

```text
Module =
  coordination locale minimale
  appels aux engines/services officiels
  exposition des composants publics
  aucune logique framework réinventée
```

Interdit :

```text
module qui contourne le Kernel
module qui redessine un composant officiel
module qui réimplémente un helper UI local
module qui fait le métier d’un engine
```

### 4.5 Composants / Widgets / Fenêtres

Une représentation affiche un état validé et remonte des événements.

```text
UI / Widget / Window =
  affichage
  interaction
  événement
  représentation
```

Interdit :

```text
widget qui charge la data
fenêtre qui décide des droits
composant qui corrige un état invalide
renderer qui appelle l’API métier
template qui fait du routing
```

---

## 5. Séparation data / traitement / représentation

La séparation à respecter n’est pas seulement `data / vue`.

Elle est :

```text
DATA
TRAITEMENT
REPRÉSENTATION
THÈME
```

### 5.1 Data

```text
Data =
  faits
  contenus
  états
  configurations
  routes
  droits
  résultats API
  DTO
  ViewModels
  objets métier validés
```

La data ne connaît jamais sa représentation.

Interdit :

```text
HTML dans la data
CSS dans la data métier
Twig dans un objet métier
décision de rendu dans un DTO
fallback de rendu dans un modèle métier
```

### 5.2 Traitement

```text
Traitement =
  services
  engines
  validators
  resolvers
  registries
  orchestrateurs métier
```

Le traitement produit des objets validés.

Il ne représente pas.

### 5.3 Représentation

```text
Représentation =
  HTML / Twig
  JSON
  XML
  Markdown
  PDF
  backoffice
  widget Qt
  fenêtre Windows
  export
  API response
```

Une représentation consomme une data déjà validée.

Elle ne décide pas.

### 5.4 Thème

```text
Thème =
  CSS
  assets
  habillage
  variations visuelles
```

Le thème ne contient pas de métier.

---

## 6. Objets, typage fort et contrats

Toute donnée structurante doit être portée par des objets ou structures contractuelles.

```text
SiteContext
RouteMatch
ModuleDefinition
ActionRequest
PermissionDecision
ViewModel
RenderModel
ApiResponseModel
JobDefinition
EngineResult
```

Chaque objet doit avoir :

```text
responsabilité claire
champs explicites
validation à la construction ou à l’entrée
erreurs précises
aucun état implicite
```

Les tableaux anonymes non contractuels sont interdits aux frontières importantes.

Ils peuvent exister localement uniquement s’ils ne franchissent pas une frontière métier.

---

## 7. Erreurs explicites

Une erreur doit dire ce qui est cassé.

Exemples attendus :

```text
SITE_NOT_RESOLVED
ROUTE_NOT_FOUND
MODULE_DISABLED
CONTROLLER_NOT_FOUND
ACTION_NOT_ALLOWED
TEMPLATE_NOT_FOUND
VIEWMODEL_INVALID
CONFIG_CONTRACT_FAILED
ENGINE_CONTRACT_FAILED
SOURCE_OF_TRUTH_MISSING
LIVE_TARGET_NOT_CONFIRMED
```

Interdit :

```text
ça ne marche pas
erreur inconnue
on continue quand même
fallback silencieux
valeur par défaut non déclarée
```

---

## 8. ASAP / Front / Multisite

ASAP est un framework Composer mutualisable.

Twig est intégré à ASAP via Composer.

```text
MO_KB_FRONT
  -> logandplay/asap
      -> twig/twig
```

ASAP reste souverain et indépendant.

```text
ASAP =
  framework
  resolver
  router
  dispatcher
  template adapters
  site manager
  module/action contracts
```

ASAP ne connaît pas MO_KB.

Une application déclare ses sites.

```text
Application =
  modules
  services
  data
  sites
  themes
  configs
  representations
```

Un site configure :

```text
host/basePath
routes
modules actifs
actions autorisées
langues
thème
droits
représentations
```

La mécanique cible est :

```text
ASAP résout le site.
ASAP charge la configuration du site.
ASAP résout la route.
ASAP valide le module.
ASAP valide l’action.
ASAP appelle le controller.
Le controller appelle les services.
Les services produisent la data.
Un renderer représente la data.
```

Twig ne route pas.
Twig ne décide pas.
Twig ne charge pas la data.
Twig rend une représentation HTML.

---

## 9. MAESTRO_V5

MAESTRO_V5 applique strictement la même méthode.

```text
Kernel souverain
Engines à responsabilité unique
Modules petits et contractuels
Composants publics réutilisables
Data/ViewModels séparés de l’UI
0 fallback silencieux
0 tolérance implicite
```

Exemples :

```text
FSM engine = FSM uniquement
SQL engine = SQL uniquement
CSS engine = CSS uniquement
I18N engine = I18N uniquement
UI Factory = création/assemblage UI uniquement
Module = exposition métier minimale
Component = affichage/interaction uniquement
```

Un module ne redessine pas un composant.
Un composant ne décide pas du métier.
Un renderer ne corrige pas la data.
Un engine ne compense pas un autre engine.

---

## 10. MO_KB_DAEMON

MO_KB_DAEMON suit les mêmes règles.

```text
Master = coordination
Scheduler = planification
Worker = exécution
Job Queue = état des jobs
REST API = exposition contrôlée
Store = persistance
Dashboard = représentation
Widget = contrôle local minimal
```

Interdit :

```text
dashboard qui décide des jobs
worker qui écrit directement dans la KB canonique
scheduler qui rend l’UI
API qui corrige une data invalide
slave qui prend une décision souveraine du master
```

Les slaves peuvent être autonomes dans l’exécution autorisée, mais jamais souverains sur la KB canonique.

---

## 11. Git et organisation

Chaque dépôt a un métier.

```text
ASAP.git
= framework mutualisable

MO_KB_FRONT.git
= application front/backoffice KB

MAESTRO.git
= code Maestro V5

MO_KB_DAEMON.git
= moteur KB

DOC_*.git
= documentation/site dédié
```

Interdit :

```text
framework copié dans chaque site
repo applicatif qui embarque des scories vendor/cache
dépôt qui mélange plusieurs métiers non liés
dossier temporaire committé
cache suivi par Git
secret suivi par Git
```

---

## 12. Hygiène et autonettoyage

Chaque installation, audit, livraison ou patch doit se terminer par un contrôle de propreté.

### 12.1 À supprimer automatiquement après usage

```text
*_EXTRACT
*_TMP
tmp
cache temporaire généré
dossier d’installation transitoire
fichier debug ponctuel
fichier brouillon
export intermédiaire non utile
```

### 12.2 À ne jamais versionner

```text
vendor/
var/cache/
var/logs/
.env
*.local.php
*.secret.php
*.tmp
*.bak
templates_c/
__pycache__/
node_modules/
logs runtime
exports temporaires
```

### 12.3 À garder uniquement si utile

```text
rapport final
handoff final
ZIP de livraison final
manifest de livraison
audit final
```

Tout artefact conservé doit avoir une raison explicite.

---

## 13. Livraison propre

Une livraison doit inclure :

```text
but du palier
fichiers modifiés
contrats respectés
instructions d’installation
instructions de vérification
instructions de cleanup
contrôle git final
rollback si nécessaire
```

Pour MAESTRO_V5, les livraisons doivent être des ZIP `*_full_files.zip` contenant les fichiers complets avec chemins relatifs, sauf demande explicite contraire.

---

## 14. Checklist obligatoire avant patch

Avant patch :

```text
[ ] repo cible identifié
[ ] branche cible identifiée
[ ] git status lu
[ ] contexte projet relu
[ ] fichier réel inspecté
[ ] source de vérité confirmée
[ ] responsabilité de chaque couche respectée
[ ] pas de fallback ajouté
[ ] pas de mélange data/représentation
[ ] pas de scorie prévue
[ ] plan de vérification défini
[ ] cleanup défini
```

Si une case critique manque :

```text
PAS DE PATCH
```

---

## 15. Checklist obligatoire après patch

Après patch :

```text
[ ] fichiers attendus présents
[ ] tests/smoke checks exécutés ou explicitement demandés
[ ] git status contrôlé
[ ] scories supprimées
[ ] dossiers d’extraction supprimés
[ ] caches inutiles supprimés
[ ] artefacts utiles rangés dans OUTBOX / CONTEXT / DOC
[ ] aucune clé/secrets exposés
[ ] handoff proposé si palier stable
```

---

## 16. Règle assistant

L’assistant doit appliquer ce contrat systématiquement.

Il doit refuser ou différer toute action qui violerait le contrat.

Il doit signaler explicitement :

```text
ce qui est source de vérité
ce qui est temporaire
ce qui est à garder
ce qui est à supprimer
ce qui est hors Git
ce qui doit être committé
ce qui ne doit jamais être committé
```

Il doit privilégier :

```text
audit avant patch
plan avant migration
fichiers complets plutôt que bricolage
cleanup final
erreurs claires
contrats explicites
```

---

## 17. Phrase canonique

```text
Chaque couche métier est souveraine et précise.
La data, le traitement et la représentation sont séparés.
Les objets et contrats sont explicites.
Il n’existe aucun fallback silencieux.
Tout passe ou casse clairement.
Le workspace reste propre après chaque action.
```

---

## 18. Documentation contractuelle obligatoire et Reference Books

Tout fichier maintenu dans MAESTRO_WORKSPACE doit être documenté par des commentaires clairs, structurés et exploitables pour générer des Reference Books.

Cette règle s’applique aux scripts PHP, Lua, Python, JavaScript, PowerShell, CSS, configurations actives, engines, services, modules, composants, renderers, widgets et utilitaires.

La documentation doit être conçue dans l’esprit de Doxygen, phpDocumentor, JSDoc, LuaDoc ou PowerShell comment-based help.

### 18.1 Règle obligatoire

NO DOC CONTRACT, NO PATCH.

Aucune fonction publique, classe publique, API publique, composant public, section CSS publique ou script maintenu ne doit être ajouté sans documentation contractuelle.

### 18.2 Informations minimales à documenter

Chaque bloc public doit préciser :

- visibilité : PUBLIC, INTERNAL ou PRIVATE
- rôle
- responsabilité métier
- arguments ou paramètres
- retours
- erreurs ou exceptions possibles
- effets de bord
- contrat métier
- invariants si applicables
- version ou palier d’introduction si utile

### 18.3 CSS

Chaque section CSS publique ou structurante doit préciser :

- rôle visuel
- portée : PUBLIC, INTERNAL ou PRIVATE
- classes publiques utilisables
- classes internes réservées au composant
- dépendances éventuelles
- règles d’override
- interdictions métier

Le CSS représente. Il ne décide jamais un droit, une route, un état métier ou une action.

### 18.4 Scripts d’audit, installation, migration et cleanup

Chaque script maintenu doit préciser :

- ce qu’il lit
- ce qu’il écrit
- ce qu’il supprime
- ce qui est temporaire
- ce qui est conservé
- comment vérifier
- comment rollback si applicable

### 18.5 Reference Books

Chaque dépôt doit pouvoir produire à terme un Reference Book :

- ASAP Reference Book
- MAESTRO_V5 Reference Book
- MO_KB_DAEMON Reference Book
- MO_KB_FRONT Reference Book

Les commentaires publics doivent donc être structurés, stables et exploitables par un générateur documentaire.

### 18.6 Phrase canonique

Tout code maintenu doit être lisible par contrat.
Le commentaire ne décore pas : il déclare la responsabilité, la frontière et l’usage.
Les Reference Books doivent pouvoir être générés depuis le code documenté.


---

## 19. Reference Books HTML

Les Reference Books générés doivent avoir une sortie officielle HTML.

Les commentaires structurés et les fichiers Markdown restent les sources documentaires, mais la documentation consultable doit être générée en HTML.

Cible standard : DOC/reference/generated/html/

Pour ASAP, MO_KB_FRONT et les documentations web, la génération HTML doit pouvoir être rendue ou hébergée par ASAP.

NO HTML REFERENCE OUTPUT, NO DOC GENERATION VALIDATION.
