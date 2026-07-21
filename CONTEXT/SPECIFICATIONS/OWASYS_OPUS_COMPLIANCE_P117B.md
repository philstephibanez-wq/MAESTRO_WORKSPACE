# Spécification OWASYS — conformité OPUS P117B

## 1. Objet

Cette spécification définit la cible de conformité de l’application autonome OWASYS avec le framework OPUS.

Elle couvre :

- arborescence applicative ;
- rendu ScoreTemplate ;
- FSM ;
- ACL ;
- SSO ;
- session ;
- i18n ;
- contrôle de visibilité des mots de passe ;
- critères de validation.

## 2. Direction de dépendance

```text
OWASYS -> OPUS Framework
```

OWASYS consomme les contrats publics du framework. Le framework ne connaît pas le cycle de vie particulier d’OWASYS et ne lance pas l’application.

## 3. Arborescence canonique

```text
sites/owasys/
  application/
    default/
      controllers/
      models/
      services/
      templates/
      local/
    login/
      controllers/
      models/
      templates/
    account/
      controllers/
      models/
      templates/
    registry/
      controllers/
      models/
      templates/
    structure/
    data/
    workflows/
    security/
    source/
    build/
    home/                  optionnel, uniquement si un état home existe
  config/
  var/
  www/
    index.php
    asset/
```

### 3.1 `application/default`

`application/default` est la couche commune à toutes les pages et à tous les modules.

Elle peut contenir :

- layout SCORE commun ;
- partiels SCORE communs ;
- registre de locales ;
- navigation commune ;
- services runtime partagés ;
- modèles de session partagés ;
- helpers de construction de ViewModel.

Elle ne peut pas contenir :

- une page d’accueil implicite ;
- un état fonctionnel `default` ;
- des actions métier propres à un module ;
- une substitution au module `home`.

### 3.2 Interdiction de `application/states`

Le répertoire suivant est interdit :

```text
sites/owasys/application/states
```

Les états FSM ciblent directement les modules sous `application/<module>`.

## 4. Point d’entrée public

Le seul front controller est :

```text
sites/owasys/www/index.php
```

Il doit :

1. laisser servir les assets publics existants sous le serveur PHP intégré ;
2. charger l’autoload Composer ;
3. charger et valider `site.json` ;
4. construire le runtime OWASYS ;
5. déléguer la requête au runtime.

Il ne doit pas contenir le rendu des pages ni la logique métier des modules.

## 5. ScoreTemplate

### 5.1 Moteur

Le moteur obligatoire est :

```text
Opus\Template\ScoreTemplateRenderer
```

Aucun fallback vers un layout PHP ou un autre moteur n’est autorisé.

### 5.2 Emplacements

```text
application/default/templates/layout.score
application/default/templates/partials/*.score
application/<module>/templates/index.score
```

### 5.3 Contrôleur

Le contrôleur fournit un tableau de données de vue. Il n’émet pas de balisage HTML.

Le document final est assemblé ainsi :

```text
ViewModel du module
  -> template application/<module>/templates/index.score
  -> body.html
  -> application/default/templates/layout.score
```

### 5.4 Suppressions finales

Après validation d’équivalence, les chemins suivants doivent disparaître :

```text
application/default/views/layout.php
application/login/views/index.php
application/account/views/index.php
application/registry/views/index.php
```

## 6. FSM

### 6.1 Source de vérité

```text
sites/owasys/config/owasys-navigation.fsm.json
```

### 6.2 Pipeline

```text
Request
  -> RouteResolver
  -> EventResolver
  -> SSO identity resolution
  -> FSM guard evaluation
  -> ACL decision
  -> FsmProcessor::transition
  -> FsmActionDispatcher::dispatch
  -> target module
  -> module ViewModel
  -> SCORE render
```

### 6.3 Exigences

- Toute navigation privée correspond à un événement FSM.
- Toute action de formulaire correspond à un événement FSM.
- Les transitions déclarent les actions à exécuter.
- Une action déclarée sans handler provoque une erreur explicite.
- Aucun état cible n’est inventé par le contrôleur.
- Aucun événement inconnu n’est ignoré.
- Les accès directs aux routes doivent être prévus par la FSM, sans contournement PHP.

## 7. Actions FSM

Les actions initiales comprennent :

```text
start_session
clear_session
set_current_app
clear_current_app
start_creation_flow
update_runtime_password_hash
clear_must_change_password
redirect_password_change
```

Chaque action possède un handler explicite enregistré dans `FsmActionDispatcher`.

Les mutations de session, contexte applicatif et credentials ne doivent pas être exécutées avant la validation de la transition correspondante.

## 8. SSO

### 8.1 Contrat

Toute authentification passe par :

```text
Opus\Security\Sso\SsoManager
Opus\Security\Sso\SsoProviderInterface
```

### 8.2 Fournisseur local

Le fournisseur local de développement est :

```text
local-password
```

Configuration :

```text
sites/owasys/config/sso.json
```

Store runtime :

```text
sites/owasys/var/auth/local-users.json
```

### 8.3 Identité normalisée

```text
subject
label
roles[]
provider
authenticated_at
must_change_password
```

### 8.4 Changement de mot de passe

Le changement de mot de passe doit être exposé par une capacité du fournisseur SSO. Le contrôleur de compte ne doit pas modifier directement un store dont il connaît le format.

## 9. ACL

### 9.1 Politique

```text
sites/owasys/config/acl.json
```

Le mode est obligatoirement :

```text
deny-by-default
```

### 9.2 Décision

```text
roles[] + resource + action -> AclDecision
```

### 9.3 Contrôles

L’ACL est évaluée :

- avant l’exécution du contrôleur du module ;
- avant toute action d’écriture ;
- lors de la construction de la navigation ;
- indépendamment de la visibilité du lien dans l’interface.

## 10. Session

La session conserve l’identité SSO normalisée et le contexte applicatif OWASYS.

Clés conceptuelles :

```text
owasys_sso_identity
owasys_current_app
opus_fsm_state_owasys
```

Une déconnexion :

- exécute la transition FSM `logout` ;
- appelle les actions `clear_session` et `clear_current_app` ;
- régénère l’identifiant de session ;
- redirige vers l’état login.

## 11. Contrôle œil des mots de passe

### 11.1 Champs concernés

- mot de passe de connexion ;
- mot de passe actuel ;
- nouveau mot de passe ;
- confirmation du nouveau mot de passe.

### 11.2 Structure

Chaque champ mot de passe est enveloppé dans un composant commun :

```html
<div class="ow-password-field">
  <input type="password" ...>
  <button type="button" class="ow-password-toggle" ...></button>
</div>
```

### 11.3 Accessibilité

Le bouton :

- est accessible au clavier ;
- possède `aria-controls` ;
- possède `aria-pressed` ;
- utilise un libellé i18n pour afficher ou masquer ;
- ne modifie jamais la valeur du champ ;
- conserve le focus et la position du curseur lorsque le navigateur le permet.

### 11.4 JavaScript

Le script commun est public et propre à l’application :

```text
sites/owasys/www/asset/js/password-visibility.js
```

Il utilise la délégation ou initialise tous les éléments `[data-ow-password-toggle]`.

Aucune dépendance distante n’est autorisée.

## 12. i18n

Les clés minimales ajoutées aux 25 catalogues sont :

```text
auth.password.show
auth.password.hide
```

Le libellé visible du formulaire et le libellé accessible du bouton sont toujours issus du catalogue actif.

## 13. Critères de conformité

OWASYS n’est déclaré 100 % compliant que si :

1. aucun rendu live ne charge `layout.php` ;
2. toutes les pages sont rendues par `.score` ;
3. toutes les routes et actions sont pilotées par la FSM ;
4. toutes les actions FSM déclarées sont dispatchées ;
5. toute authentification passe par SSO ;
6. toute route privée passe par ACL ;
7. la navigation est filtrée par ACL ;
8. les contrôles serveur restent actifs même sans navigation visible ;
9. `default` reste exclusivement commun ;
10. aucun `application/states` n’existe ;
11. aucun `OPUS/www` n’existe ;
12. le login, le compte et le Registry conservent leur comportement ;
13. les 25 langues et drapeaux restent fonctionnels ;
14. le contrôle œil fonctionne sur tous les mots de passe ;
15. les tests Windows et système sensible à la casse passent ;
16. le navigateur confirme l’absence de régression.

## 14. Livraison

Les modifications du dépôt OPUS sont fournies sous forme de ZIP comprenant :

- les fichiers à ajouter ou remplacer ;
- un manifeste de source GitHub ;
- un manifeste de suppression ;
- les SHA-256 ;
- un smoke ciblé ;
- les instructions d’application et de rollback.

Aucune écriture GitHub directe dans OPUS n’est effectuée par ChatGPT.
