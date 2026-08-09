# OPUS P117W R45D2A1 — CANONICAL CREATION SECURITY INPUTS

Date : 2026-08-09  
Statut : LIVRABLE OWNER À VALIDER

## Base canonique relue

```text
OPUS/master
4be105ebbc81b3164d7dcc26aa69ddd7400d2dd2
site: essai pour analyser la génération
```

Le parent `e822848896734f92eb2fd631449e625a55aa8e08` est le commit publié de R45D2. Le commit `4be105...` ajoute uniquement le site généré `sites/essai` fourni par l'owner pour analyse.

## Preuve owner

Le screenshot de création montre l'échec :

```text
OWASYS_CREATION_LOGIN_PROVIDER_INVALID
```

avec la combinaison saisie :

```text
authentication_required = true
login_page = true
provider = session
```

Le site `essai` poussé sur GitHub confirme par ailleurs une génération publique valide :

```text
authentication_required = false
login_page = false
provider = session
home roles = everyone
initial identity = steve
```

## Cause

La cause n'est ni REST, ni Composer, ni le scaffold OPUS.

Le formulaire OWASYS exposait quatre paramètres interdépendants comme s'ils étaient indépendants :

```text
authentication_required
login_page
provider
home_roles
```

Or `SiteScaffoldPlan` protège volontairement les invariants suivants :

```text
login_page => authentication_required
local-password => login_page
login_page => provider local-password
public => provider session
application authentifiée => home_roles ne contient pas everyone
```

Le formulaire permettait donc de construire directement des combinaisons que le contrat canonique devait ensuite refuser. Avec les valeurs initiales `provider=session` et `home_roles=everyone`, cocher l'authentification et/ou la page de connexion menait mécaniquement à une erreur supplémentaire si l'utilisateur ne corrigeait pas manuellement plusieurs champs liés.

## Correction R45D2A1

Le validateur générique OPUS reste strict et n'est pas relâché.

OWASYS projette désormais des entrées compatibles avec ce contrat :

```text
Public + session
  authentication_required = false
  login_page = false
  home_roles = everyone

Authentifié + session
  authentication_required = true
  login_page = false
  home_roles = tous les rôles déclarés

Authentifié + local-password
  authentication_required = true
  login_page = true
  home_roles = tous les rôles déclarés

Authentifié + auth0-proxy
  authentication_required = true
  login_page = false
  home_roles = tous les rôles déclarés
```

Une application publique avec `local-password` ou `auth0-proxy` reste refusée explicitement : aucun fallback silencieux vers `session`.

## UI

La case indépendante « Créer une page de connexion » est supprimée.

La page de connexion est une conséquence contractuelle explicite du choix `Mot de passe local` lorsque l'authentification est requise. Le libellé de ce choix rappelle la création de la page de connexion.

Le champ libre `home_roles` est supprimé de l'étape initiale. Sa valeur est déterminée par le mode d'exposition afin d'éviter une ACL initiale contradictoire :

```text
public -> everyone
authenticated -> rôles déclarés
```

La valeur calculée reste visible dans le récapitulatif avant confirmation et pourra ensuite être affinée dans l'espace Sécurité.

## Séparation des responsabilités

Aucune classe `Opus/**/*.php` n'est modifiée.

`SiteScaffoldPlan` conserve ses gardes génériques. R45D2A1 corrige uniquement la projection métier du wizard OWASYS vers le blueprint OPUS.

Flux de création inchangé :

```text
SCORE
-> FSM/ACL/SSO OWASYS
-> REST sécurisé
-> owasys-back
-> Composer allow-listé
-> SiteScaffoldPlan
-> validation
-> écriture
```

## Livrable

Le ZIP différentiel contient uniquement :

```text
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/creation/templates/index.score
```

Aucun apply script, smoke, rapport, log, cache, temporaire, vendor ou fichier du site `essai` n'est livré.

## Validation statique

Matrice contrôlée sur `securityDraft` :

```text
public + session       -> OK / login=false / home=everyone
public + auth0-proxy   -> rejet explicite PUBLIC_PROVIDER_INVALID
auth + session         -> OK / login=false / home=roles
auth + local-password  -> OK / login=true  / home=roles
auth + auth0-proxy     -> OK / login=false / home=roles
```

PHP lint du contrôleur : OK.

Le template SCORE ne contient plus les entrées `owasys_login_page` ni `owasys_home_roles`; les balises conditionnelles sont équilibrées et aucune nouvelle clé I18n n'est introduite.

## Gate owner

1. HEAD exact `4be105eb...` ou descendant sans modification des deux fichiers cibles ;
2. extraction directe du ZIP ;
3. lint PHP ;
4. `composer dump-autoload -o` ;
5. lancement back puis front ;
6. création fullstack publique + session : doit atteindre le récapitulatif ;
7. création fullstack authentifiée + session : doit atteindre le récapitulatif sans page login ;
8. création fullstack authentifiée + local-password : doit atteindre le récapitulatif avec `login_page=true` ;
9. création fullstack authentifiée + auth0-proxy : doit atteindre le récapitulatif avec `login_page=false` ;
10. confirmer une création de test et vérifier le site généré ;
11. owner commit/push uniquement après succès.

NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO REST BYPASS.
NO SITE-SPECIFIC PATCH.
NO PUSH OPUS BY ASSISTANT.
