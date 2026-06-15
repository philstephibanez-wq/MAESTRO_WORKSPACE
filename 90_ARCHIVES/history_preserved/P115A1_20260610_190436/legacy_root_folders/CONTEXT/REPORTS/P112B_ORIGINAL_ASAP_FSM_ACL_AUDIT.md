# P112B — ORIGINAL ASAP / FSM / ACL — AUDIT & SOCLE MODERNE

Statut: AUDIT CONTRACTUEL — AUCUN PATCH CODE  
Portée: ASAP originel PHP5, ASAP pollué actuel, futur ASAP Composer  
Date: 2026-06-05

---

## 0. Contrat appliqué

Ce document applique le contrat MAESTRO_WORKSPACE :

```text
Chaque couche métier est souveraine et précise.
La data, le traitement et la représentation sont séparés.
Les objets et contrats sont explicites.
Il n’existe aucun fallback silencieux.
Tout passe ou casse clairement.
Le workspace reste propre après chaque action.
```

Ce palier est un audit et une définition de socle.  
Il ne modifie aucun dépôt.

---

## 1. Identité ASAP

ASAP peut porter les deux sens, mais pas au même niveau.

```text
ASAP = As Simple As Possible
```

C’est le sens architectural : simple, lisible, strict, sans moteur fourre-tout.

```text
ASAP = As Soon As Possible
```

C’est le sens d’exécution : aller vite uniquement quand les contrats sont clairs.

Règle finale :

```text
As Simple As Possible first.
As Soon As Possible only after contracts.
```

---

## 2. Source analysée

Archive fournie par l’utilisateur :

```text
a25f039c-ed95-4c26-a290-68ded94c8c62.7z
```

Structure observée :

```text
demo/
  application/
  framework/
    ASAP/
    libs/
  www/
  index.php
```

L’archive contient un ASAP PHP5 historique complet avec :

```text
Application
Router
ConfigLoader
Configuration
Controller
FSM
ACL
I18N
Menu
Model
BDD
Template adapters
View Html
URL
Validator
Debug
Exception
Legacy libs
Demo application
Demo themes
Demo configs
```

---

## 3. Verdict global

L’ASAP original est très utile comme source d’intention.

Il ne doit pas être copié tel quel.

Il sert à reconstruire proprement :

```text
ASAP moderne
  framework Composer indépendant
  site resolver strict
  router strict
  FSM officielle
  ACL officielle
  controller/action contracts
  template adapters
  renderers
  no fallback silencieux
  no chemins absolus
  no configs toxiques
```

---

## 4. Socle ASAP confirmé

ASAP n’est pas seulement un routeur ou un moteur de templates.

Le vrai socle historique est :

```text
ASAP CORE
  Application / Kernel
  Router
  ConfigLoader / Configuration
  Controller / Action
  FSM
  ACL
  I18N
  Menu
  URL
  Template adapters
  View / Renderer
```

Le futur ASAP doit donc garder ce système nerveux :

```text
FSM = état souverain du site / workflow / sécurité
ACL = droits, rôles, ressources, privilèges
```

---

## 5. FSM originale — cartographie

Fichier source :

```text
demo/framework/ASAP/FSM/Fsm.class.php
```

Classes / interfaces observées :

```text
Transition
ASAP_FSM_GraphViz
iFSM
ASAP_FSM_Fsm
```

Concepts confirmés :

```text
signal
state
nextState
action
nextSignal
memory
stack
fifo
lifo
timeout
saveState
loadState
clearState
```

### 5.1 Fonctionnement original

La FSM originale fonctionne comme un microprocesseur :

```text
signal       = instruction
state        = registre d’état
transition   = microcode
nextState    = nouvel état
action       = routine exécutée
memory       = mémoire interne
stack        = pile/file de contrôle
```

Méthodes importantes observées :

```text
create()
process(signal)
addTransition(signal, state, nextState, action)
addTransitions(signals, state, nextState, action)
setDefaultTransition(action)
_getTransition(signal)
_execute(action, signal)
peek(name)
poke(name, value)
push(value)
pop()
setStackType(fifo|lifo)
saveState()
loadState()
clearState()
reset()
```

### 5.2 Atouts à conserver

```text
modèle signal/state/action clair
mémoire interne via peek/poke
pile FIFO/LIFO
persistance d’état
transitions chaînées par signal retourné
export GraphViz
séparation entre programme FSM et runtime
```

### 5.3 Points à moderniser

```text
PHP5 -> PHP moderne strict
classes globales -> namespace ASAP\FSM
Transition typée
State typé
Signal typé
ActionHandler explicite
MemoryStore contractuel
PersistenceStore contractuel
aucun serialize/unserialize non contrôlé
aucun ROOT/tmp implicite
aucun __default__ silencieux non déclaré
aucun echo dans default_proc
aucun save automatique destructeur non maîtrisé
verrouillage fichiers propre ou stockage configurable
```

### 5.4 Contrat FSM moderne cible

Objets recommandés :

```text
ASAP\FSM\Signal
ASAP\FSM\State
ASAP\FSM\Transition
ASAP\FSM\TransitionTable
ASAP\FSM\ActionHandlerInterface
ASAP\FSM\FsmProgram
ASAP\FSM\FsmRuntime
ASAP\FSM\FsmMemory
ASAP\FSM\FsmStack
ASAP\FSM\FsmPersistenceStoreInterface
ASAP\FSM\FsmDecision
ASAP\FSM\FsmException
```

Règle de traitement :

```text
Input: Signal + CurrentState + Context
Resolve: Transition explicite
Execute: ActionHandler optionnel
Output: FsmDecision + NewState + OptionalNextSignal
```

Erreur obligatoire si transition absente :

```text
FSM_TRANSITION_NOT_FOUND
```

Exception uniquement si un `defaultTransition` est explicitement déclaré dans le programme FSM.

---

## 6. ACL originale — cartographie

Fichiers sources :

```text
demo/framework/ASAP/ACL/ASAP_Acl.class.php
demo/framework/ASAP/ACL/ASAP_Acl_Role.class.php
demo/framework/ASAP/ACL/ASAP_Acl_Resource.class.php
demo/framework/ASAP/ACL/ASAP_Roles.class.php
demo/framework/ASAP/ACL/ASAP_Acl_conditions.php
```

Classes observées :

```text
ASAP_Acl
ASAP_ACL_Role
ASAP_ACL_Resource
ASAP_ACL_roles
```

Méthodes importantes observées :

```text
addRole(role, parents)
getRole(role)
hasRole(role)
inheritsRole(role, inherit)
removeRole(role)
addResource(resource, parent)
getResource(resource)
has(resource)
inherits(resource, inherit)
allow(roles, resources, privileges, conditions)
deny(roles, resources, privileges, conditions)
setRule(operation, type, roles, resources, privileges, conditions)
isAllowed(role, resource, privilege)
```

### 6.1 Atouts à conserver

```text
rôles hiérarchiques
ressources hiérarchiques
privilèges
allow / deny
conditions
isAllowed centralisé
logique de décision séparée du controller
```

### 6.2 Points à moderniser

```text
PHP5 -> PHP moderne strict
singleton global -> service injectable ou registry contrôlé
namespace ASAP\ACL
Role typé
Resource typée
Privilege typé
Rule typée
AccessContext typé
AccessDecision typée
conditions sous forme d’objets/callables contractuels
deny explicite par défaut pour zones protégées
aucun accès direct depuis templates
aucun controller qui contourne ACL
```

### 6.3 Contrat ACL moderne cible

Objets recommandés :

```text
ASAP\ACL\Role
ASAP\ACL\Resource
ASAP\ACL\Privilege
ASAP\ACL\Rule
ASAP\ACL\RuleSet
ASAP\ACL\ConditionInterface
ASAP\ACL\AccessContext
ASAP\ACL\AccessDecision
ASAP\ACL\AclEngine
ASAP\ACL\AclException
```

Décision :

```text
Input: Role + Resource + Privilege + AccessContext
Output: AccessDecision(ALLOW|DENY, reason)
```

Erreur ou refus explicite :

```text
ACL_ROLE_NOT_FOUND
ACL_RESOURCE_NOT_FOUND
ACL_PRIVILEGE_NOT_ALLOWED
ACL_CONDITION_FAILED
ACL_DENIED_BY_RULE
```

---

## 7. Pipeline ASAP moderne avec FSM + ACL

Le pipeline cible devient :

```text
REQUEST
  -> Application / Kernel
  -> SiteResolver
  -> SiteState FSM Guard
  -> ACL Guard
  -> Router
  -> Dispatcher
  -> Controller
  -> Service
  -> ViewModel
  -> Renderer
  -> RESPONSE
```

Rôles précis :

```text
SiteResolver
= identifie le site, rien d’autre

SiteState FSM Guard
= vérifie l’état souverain du site

ACL Guard
= vérifie les droits sur ressource/privilège

Router
= résout la route, rien d’autre

Dispatcher
= appelle le controller/action autorisé

Controller
= orchestre les services applicatifs

Service
= traite le métier

ViewModel
= porte la data validée

Renderer
= représente la data
```

Interdits :

```text
Router qui décide des droits
ACL qui décide l’état global du site
FSM qui gère les rôles
Controller qui contourne FSM/ACL
Template qui appelle ACL/FSM
Renderer qui charge la data
```

---

## 8. FSM appliquée aux états de site

Nouveau moteur recommandé :

```text
ASAP\SITE\SiteStateEngine
```

Il s’appuie sur :

```text
ASAP\FSM\FsmRuntime
```

États de site possibles :

```text
SITE_OPEN
SITE_READ_ONLY
SITE_MAINTENANCE
SITE_ATTACK_SUSPECTED
SITE_LOCKDOWN
SITE_RECOVERY
SITE_BLOCKED
```

Signaux possibles :

```text
REQUEST_OK
TOO_MANY_ERRORS
AUTH_FAIL_BURST
AUTH_ATTACK_DETECTED
ADMIN_LOCK
ADMIN_UNLOCK
MAINTENANCE_ON
MAINTENANCE_OFF
RECOVERY_OK
```

Actions possibles :

```text
allow_request
force_read_only
deny_public_access
notify_admin
log_security_event
require_admin_unlock
```

Exemple :

```text
SITE_OPEN
  AUTH_FAIL_BURST
  -> SITE_ATTACK_SUSPECTED
  -> log_security_event

SITE_ATTACK_SUSPECTED
  AUTH_ATTACK_DETECTED
  -> SITE_LOCKDOWN
  -> deny_public_access

SITE_LOCKDOWN
  ADMIN_UNLOCK
  -> SITE_RECOVERY
  -> require_admin_unlock

SITE_RECOVERY
  RECOVERY_OK
  -> SITE_OPEN
  -> allow_request
```

---

## 9. ACL appliquée aux sites front/backoffice

Ressources possibles :

```text
site:kb-front
site:kb-backoffice
module:musicien
module:k2000
module:technique
module:security
module:backoffice
route:admin.dashboard
job:ingestion
worker:control
kb:write
```

Privilèges possibles :

```text
read
write
execute
admin
unlock
start
stop
approve
```

Rôles possibles :

```text
public
user
editor
admin
superadmin
system
```

Exemple :

```text
SITE_OPEN:
  public -> read site:kb-front
  admin  -> admin site:kb-backoffice

SITE_LOCKDOWN:
  public -> denied
  user   -> denied
  admin  -> limited read
  superadmin -> unlock
```

La FSM donne l’état.
L’ACL décide les droits dans cet état.

---

## 10. Configs historiques toxiques

L’ASAP original contient des fichiers de démo utiles pour comprendre les conventions, mais toxiques pour une migration brute.

À ne pas reprendre tel quel :

```text
demo/application/config/config.xml
demo/application/config/config.xml.php
demo/logs/
demo/tmp/
demo/www/assets/
demo/www/themes démo
jQuery ancien embarqué
Smarty cache/templates_c
adodb tests/docs
PHPMailer tests/docs
_dummy/
```

Raisons :

```text
PHP5 ancien
chemins absolus historiques
identifiants MySQL historiques
mots de passe historiques
site demo spécifique
logs runtime
cache runtime
assets de démo
libs vendorisées sans stratégie Composer
```

Règle :

```text
Les configs historiques servent à comprendre.
Elles ne sont pas migrées.
```

---

## 11. Comparaison avec ASAP actuel pollué

L’audit P112B précédent a montré que l’ASAP actuel dans `MO_KB_FRONT_ASAP` est plus récent mais pollué.

Pollutions connues :

```text
fallback logandplay dans SiteResolver
host logandplay.localhost dans framework
pathPrefix spécial logandplay
message MO_KB dans Smarty adapter
chemin H:\MO_KB_FRONT_ASAP dans Twig adapter
vendor Twig intégré localement
caches/tests à exclure
```

Conclusion :

```text
ASAP original = intention souveraine
ASAP actuel = source technique partielle
Contrat MAESTRO_WORKSPACE = arbitre final
```

---

## 12. Architecture cible du dépôt ASAP

```text
ASAP
  composer.json
  README.md
  CHANGELOG.md
  LICENSE

  framework
    ASAP
      Application.php
      Kernel.php
      Exception
      Config
      Site
      Routing
      Controller
      FSM
      ACL
      Security
      Template
      Renderer
      I18N
      Menu
      Url
      Validation

  skeleton
    public
    application
    sites
    themes

  examples
    basic
    multisite
    fsm-acl-lockdown

  DOC
    ARCHITECTURE.md
    FSM.md
    ACL.md
    REQUEST_PIPELINE.md
    TEMPLATE_ADAPTERS.md
    SECURITY_LOCKDOWN.md
```

---

## 13. Composer cible ASAP

```json
{
  "name": "logandplay/asap",
  "description": "ASAP — As Simple As Possible PHP framework",
  "type": "library",
  "require": {
    "php": ">=8.2",
    "twig/twig": "^3.0"
  },
  "autoload": {
    "psr-4": {
      "ASAP\\": "framework/ASAP/"
    }
  }
}
```

Note : la version PHP minimale pourra être adaptée à UwAmp réel, mais la cible doit rester moderne et typée.

---

## 14. Paliers recommandés

### P112B1 — Audit original ASAP FSM/ACL

```text
Créer ce document.
Aucun patch code.
```

### P112B2 — Repo ASAP skeleton

```text
Créer H:\UwAmp\www\_packages\ASAP.
Créer composer.json.
Créer README.md.
Créer DOC/FSM.md.
Créer DOC/ACL.md.
Aucun portage complet encore.
```

### P112B3 — Portage minimal Core

```text
Application / Kernel
Config
Exception
SiteResolver strict
Router strict
Controller base
```

### P112B4 — Portage FSM moderne

```text
Signal
State
Transition
FsmProgram
FsmRuntime
Memory
Stack
Persistence
```

### P112B5 — Portage ACL moderne

```text
Role
Resource
Privilege
Rule
AccessContext
AccessDecision
AclEngine
```

### P112B6 — Exemple sécurité

```text
example fsm-acl-lockdown
site ouvert -> attaque suspectée -> lockdown -> unlock admin
```

### P112C — KB_FRONT consomme ASAP

```text
KB_FRONT dépend de logandplay/asap via Composer path repository.
```

---

## 15. Critères de validation ASAP moderne

ASAP est validé seulement si :

```text
framework indépendant
Composer OK
Twig via Composer
FSM conservée et modernisée
ACL conservée et modernisée
pas de fallback silencieux
pas de chemin absolu projet
pas de config toxique
pas de secret
pas de vendor committé
pas de cache/log/tmp
front/backoffice gérés par sites
routing strict
site state guard avant router métier
ACL guard avant controller
```

---

## 16. Phrase canonique ASAP

```text
ASAP is As Simple As Possible by architecture,
and As Soon As Possible only after contracts.

FSM controls the site state.
ACL controls the access rights.
Router routes.
Controller orchestrates.
Renderer represents.
No layer steals another layer’s job.
```
