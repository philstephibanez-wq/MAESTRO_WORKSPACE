# MAESTRO_WORKSPACE — GLOBAL HANDOFF

Date: 2026-06-09  
Scope: MAESTRO_WORKSPACE global — ASAP, ASAP_REF_BOOK, MO_KB, MAESTRO_V5, règles de livraison.  
Statut: point de reprise stable après validation/push ASAP P112Q3E3.

---

## 1. Résumé exécutif

Le workspace est organisé autour d’une règle centrale : **GitHub est la source de vérité du code**, et aucun patch ne doit être proposé sans source réelle, fichier réel, cible claire, test ciblé, recette globale et rollback possible.

Le travail actif récent a porté sur **ASAP** et la mise en place d’un contrat documentaire/reflection pour ASAP_REF_BOOK :

- **Reflection PHP** = vérité technique.
- **Attributes RefBook** = vérité fonctionnelle.
- **Strict domain test** = anti-dérive.
- **Global regression recipe** = anti-régression.
- **Delivery recipe** = validation complète avant commit/push.

Trois domaines critiques ASAP sont maintenant validés et poussés :

```text
P112Q3E1 FSM      ✅ validé runtime complet + poussé
P112Q3E2 ACL      ✅ validé runtime complet + poussé
P112Q3E3 Routing  ✅ validé runtime complet + poussé
```

Dernier état Git ASAP observé :

```text
e366f40..003fd1b  master -> master
Your branch is up to date with 'origin/master'.
nothing to commit, working tree clean
```

---

## 2. Règles permanentes MAESTRO_WORKSPACE

### 2.1 Source de vérité

Toujours partir de la source réelle :

```text
1. Repo GitHub réel ou ZIP/handoff complet fourni.
2. Cible live identifiée.
3. Fichier réel consulté avant modification.
4. Aucun patch depuis mémoire ou supposition.
```

### 2.2 Livraison obligatoire

Chaque livraison doit inclure :

```text
1. Test ciblé de la nouvelle fonctionnalité.
2. Test unitaire ou contrat si applicable.
3. Smoke runtime.
4. Recette globale anti-régression.
5. Recette livraison quand le palier en introduit une.
6. Rapport observable.
7. ExitCode strict.
```

Une livraison n’est pas validée si seul le test de la nouvelle fonctionnalité passe. La recette globale doit passer aussi.

### 2.3 Interdits forts

```text
- 0 fallback silencieux.
- 0 patch depuis ZIP partiel non vérifié.
- 0 scorie laissée volontairement.
- 0 var/refbook ou var/reports dans Git.
- 0 JSON brut dans UI normale.
- 0 PowerShell long si un .cmd suffit.
- 0 pause dans les wrappers automatisables.
- Ne pas toucher Apache/UwAmp/.htaccess sans demande explicite.
```

### 2.4 Commandes Windows

Les blocs `cmd` doivent contenir uniquement des commandes exécutables, sans prompt, commentaire, ni sortie attendue.

Préférence utilisateur : `.cmd`, pas `.bat`.

---

## 3. Dépôts et chemins clés

### 3.1 ASAP

Repo public :

```text
https://github.com/philstephibanez-wq/ASAP
```

Chemin local :

```text
H:\ASAP
```

Branche :

```text
master
```

Dernier commit poussé observé :

```text
003fd1b
```

Statut attendu :

```text
Your branch is up to date with 'origin/master'.
nothing to commit, working tree clean
```

### 3.2 ASAP_REF_BOOK

Repo public :

```text
https://github.com/philstephibanez-wq/ASAP_REF_BOOK
```

Chemin local probable :

```text
H:\ASAP_REF_BOOK
```

État connu :

```text
P113B4 Language Switcher UI             livré
P113B5 Header + Language + Breadcrumb   livré
P113B6 Sidebar Content Polish           livré
P113B7 Theme Selector                   livré + push indiqué
P113B8 Search                           livré, push à vérifier
```

### 3.3 MAESTRO_WORKSPACE

Repo public :

```text
https://github.com/philstephibanez-wq/MAESTRO_WORKSPACE
```

Chemin cible :

```text
H:\MAESTRO_WORKSPACE
```

Rôle :

```text
Workspace global sectorisé, contrats, contexte, source de reprise.
```

### 3.4 MO_KB / MAESTRO autres dépôts

Sources distantes de vérité déjà établies :

```text
MAESTRO_V5      -> https://github.com/philstephibanez-wq/Maestro.git
MO_KB_DAEMON    -> https://github.com/philstephibanez-wq/Maestro_KB_Engine.git
MO_KB_FRONT     -> https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git
```

Chemins clés MO_KB :

```text
APP master   H:\MO_KB_DAEMON
STORE        H:\MO_KB_STORE
VENDOR       H:\MO_KB_VENDOR
APP slave    C:\MO_KB_SLAVE_DAEMON
VENDOR slave C:\MO_KB_VENDOR
```

---

## 4. État détaillé ASAP

### 4.1 Contrat RefBook / Reflection

Architecture validée :

```text
Reflection PHP
  -> extrait signatures, classes, méthodes, arguments, retours, fichiers/lignes.

Attributes RefBook
  -> portent le sens métier/fonctionnel :
     domain, role, responsibility, contract, examples, diagrams,
     behavior, preconditions, postconditions, side effects, errors, tests.

ASAP_REF_BOOK
  -> consomme snapshot/API sans recopier les signatures manuellement.
```

Contrat :

```text
Aucune classe publique ASAP exposée au RefBook sans contrat RefBook.
Aucune méthode publique ASAP exposée au RefBook sans description fonctionnelle.
Aucun schéma ASAP_REF_BOOK dessiné à la main quand il peut être généré depuis données réelles.
```

### 4.2 P112Q3E1 — FSM

Statut :

```text
✅ Validé runtime complet
✅ Strict FSM OK
✅ Global regression recipe OK
✅ Delivery recipe OK
✅ Poussé
```

Marqueurs validés :

```text
P112Q3E1_REFBOOK_FSM_METADATA_CONTRACT_UNIT_OK
P112Q3E1_REFBOOK_FSM_METADATA_SMOKE_OK
P112Q3E1_REFBOOK_FSM_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E1_DELIVERY_RECIPE_OK
ExitCode=0
```

### 4.3 P112Q3E2 — ACL

Statut :

```text
✅ Validé runtime complet
✅ Strict ACL OK
✅ Global regression recipe OK
✅ Delivery recipe OK
✅ Poussé
```

Dernier commit lié :

```text
e366f40 — P112Q3E2 Add RefBook ACL metadata contract baseline
```

Strict ACL validé :

```text
Classes=11
PublicMethods=30
ClassMetadataMissing=0
MethodMetadataMissing=0
Violations=0
LoadErrors=0
```

Marqueurs validés :

```text
P112Q3E2_REFBOOK_ACL_METADATA_CONTRACT_UNIT_OK
P112Q3E2_REFBOOK_ACL_METADATA_SMOKE_OK
P112Q3E2_REFBOOK_ACL_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E2_DELIVERY_RECIPE_OK
ExitCode=0
```

### 4.4 P112Q3E3 — Routing

Statut :

```text
✅ Validé runtime complet
✅ Strict Routing OK
✅ Global regression recipe OK
✅ Delivery recipe OK
✅ Poussé
```

Dernier push observé :

```text
e366f40..003fd1b  master -> master
```

Strict Routing validé :

```text
Classes=8
PublicMethods=28
ClassMetadataMissing=0
MethodMetadataMissing=0
Violations=0
LoadErrors=0
```

Marqueurs validés :

```text
P112Q3E3_REFBOOK_ROUTING_METADATA_CONTRACT_UNIT_OK
P112Q3E3_REFBOOK_ROUTING_METADATA_SMOKE_OK
P112Q3E3_REFBOOK_ROUTING_METADATA_STRICT_OK
ASAP_GLOBAL_REGRESSION_RECIPE_OK
P112Q3E3_DELIVERY_RECIPE_OK
ExitCode=0
```

Surface Routing réelle intégrée :

```text
ASAP\Routing\Router
ASAP\Routing\RouteDefinition
ASAP\Routing\RouteMatch
ASAP\Routing\AttributeRouteProvider
ASAP\Routing\ClassIndex
ASAP\Routing\Route
ASAP\Routing\RouteCompilerException
ASAP\Routing\RouteManifestCompiler
```

### 4.5 Recette globale ASAP actuelle

La recette globale inclut maintenant au minimum :

```text
P112Q3B_SMOKE
P112Q3B2_SMOKE
P112Q3B3_SMOKE
P112Q3B4_SMOKE
P112Q3C_SMOKE
P112Q3D_SMOKE
P112Q3E_UNIT
P112Q3E_SMOKE
P112Q3E1_UNIT
P112Q3E1_SMOKE
P112Q3E2_UNIT
P112Q3E2_SMOKE
P112Q3E3_UNIT
P112Q3E3_SMOKE
```

---

## 5. Commandes de reprise ASAP

### 5.1 Vérification Git

```cmd
cd /d H:\ASAP
git status
git log --oneline -5
```

Attendu :

```text
Your branch is up to date with 'origin/master'.
nothing to commit, working tree clean
```

### 5.2 Vérification rapide anti-régression

```cmd
cd /d H:\ASAP
tools\recipes\run_asap_global_regression_recipe.cmd
```

Attendu :

```text
ASAP_GLOBAL_REGRESSION_RECIPE_OK
ExitCode=0
```

---

## 6. Prochaine étape recommandée

### Option A — P112Q3E4 HTTP RefBook metadata contract

Suite logique technique :

```text
P112Q3E4 — HTTP RefBook metadata contract
```

But :

```text
- Scanner framework/Asap/Http.
- Annoter classes/méthodes publiques réelles.
- Test contract HTTP.
- Smoke HTTP.
- Strict HTTP.
- Ajout à global regression recipe.
- Delivery recipe P112Q3E4.
```

### Option B — P112Q3E4 Security / SecureDispatch

Suite logique sécurité runtime :

```text
P112Q3E4 — Security / SecureDispatch RefBook metadata contract
```

But :

```text
- Documenter le cœur sécurité autour SecureDispatchGate.
- Aligner ACL + FSM + Routing dans la documentation générée.
- Préparer les schémas RefBook security sequence.
```

Recommandation : continuer **HTTP d’abord** si l’objectif est de couvrir les briques de base dans l’ordre technique ; continuer **Security/SecureDispatch** si l’objectif est de verrouiller la documentation sécurité end-to-end.

---

## 7. ASAP_REF_BOOK — état et suite

### 7.1 État UI / UX

Livraisons récentes :

```text
P113B4 Language Switcher UI
P113B5 Header + Language + Breadcrumb
P113B6 Sidebar Content Polish
P113B7 Theme Selector
P113B8 Search
```

État important :

```text
- P113B7 push confirmé par l’utilisateur.
- P113B8 livré et jugé bon, push à vérifier.
```

### 7.2 Suite ASAP_REF_BOOK

Objectif suivant :

```text
Consommer les snapshots ASAP produits par les domaines RefBook :
- snapshot.fsm.latest.json
- snapshot.acl.latest.json
- snapshot.routing.latest.json
```

Règle :

```text
ASAP_REF_BOOK doit afficher les vraies classes, méthodes, signatures, rôles,
contrats et schémas depuis snapshot/API, pas depuis une doc manuelle recopiée.
```

Schémas à générer :

```text
- FSM Mermaid
- Router graph
- ACL matrix
- Security dispatch sequence
- Domain class maps
- Public API coverage view
```

---

## 8. MO_KB_DAEMON / MO_KB_FRONT — état mémoire

### 8.1 MO_KB_DAEMON

État de référence :

```text
APP master: H:\MO_KB_DAEMON
STORE:      H:\MO_KB_STORE
VENDOR:     H:\MO_KB_VENDOR
Log unique: H:\MO_KB_STORE\logs\master_slave_session.log
```

Principes :

```text
- Backend Python REST headless.
- Widget Qt minimal Start/Stop/diagnostic.
- Dashboard/front officiel à terme côté PHP/ASAP/UwAmp, pas HTML Python.
- Slaves workers LAN pour load balancing.
- Master seul écrit/merge la KB canonique.
- Slaves prennent jobs via leases, spool/outbox, heartbeat.
- LOCALHOST_SLAVE possible, priorité la plus faible.
```

### 8.2 MO_KB_FRONT

Décision :

```text
Front/backoffice officiel = PHP/ASAP/UwAmp.
Le PHP consomme API REST Python.
Le PHP ne doit pas écrire directement la BDD KB canonique.
```

Chemins :

```text
H:\UwAmp\www
H:\MO_KB_FRONT_ASAP ou H:\MO_KB_FRONT selon branche de travail
```

---

## 9. MAESTRO_V5 — état mémoire

Projet REAPER Lua / Maestro V5.

Règles fortes :

```text
- Framework existant obligatoire.
- Modules petits.
- UI via composants publics, CSS/I18N/ranges.
- Pas de helper UI sauvage dans modules métier.
- 0 fallback silencieux.
- SQL manuel possible si demandé, mais pas de patch BDD automatique.
- Ne jamais oublier handoff après palier runtime validé.
```

État fonctionnel mémoire :

```text
- Workflow Project Guard/RPP certifié avancé.
- P85E Session Map validé.
- P91D MIDI Integrity Review Gate validé.
- P92L Intention musicale confirmée validée.
- P92Q3 Input Manager baseline provisoirement validé.
```

Priorités futures possibles :

```text
- Séparation Session Map hardware / analyse artistique.
- Musical Role Analyzer.
- Intention musicale genre/sous-genre + UI accordéon officielle.
- KB musicale / rendering library / VSTi futur.
```

---

## 10. Nettoyage / Git / generated files

Ne pas versionner :

```text
var/refbook/
var/reports/
cd
type
fichiers temporaires d’extraction
caches générés
logs runtime
```

Avant commit :

```cmd
cd /d H:\ASAP
git status
```

Vérifier que rien sous `var/refbook` ou `var/reports` n’est staged.

---

## 11. Checkpoint stable

Ce handoff doit être considéré comme stable si les commandes suivantes restent vraies :

```cmd
cd /d H:\ASAP
git status
tools\recipes\run_asap_global_regression_recipe.cmd
```

Attendu :

```text
nothing to commit, working tree clean
ASAP_GLOBAL_REGRESSION_RECIPE_OK
ExitCode=0
```

---

## 12. Reprise conseillée

Prochaine réponse recommandée au prochain chat :

```text
On reprend MAESTRO_WORKSPACE depuis le handoff global 2026-06-09.
ASAP est clean sur origin/master commit 003fd1b.
FSM, ACL et Routing sont validés RefBook Reflection/Attributes + strict + global recipe.
Prochaine cible proposée : P112Q3E4 HTTP ou Security/SecureDispatch.
```
