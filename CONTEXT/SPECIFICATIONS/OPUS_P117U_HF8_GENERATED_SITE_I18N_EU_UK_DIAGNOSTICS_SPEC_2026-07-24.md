# OPUS P117U HF8 — I18N UE + UKRAINIEN ET DIAGNOSTICS DES APPLICATIONS GÉNÉRÉES

Date : 2026-07-24  
Statut : évolution OPUS approuvée par le propriétaire ; ZIP différentiel produit  
Portée : générateur générique des applications OPUS `frontend`, `backend` et `fullstack`

## 1. Décision owner

Le propriétaire a répondu `OUI` à l’évolution générique du framework OPUS.

Toute application générée doit donc recevoir :

- les 24 langues officielles de l’Union européenne ;
- l’ukrainien ;
- la négociation initiale depuis `Accept-Language` ;
- un fallback explicite et diagnostiqué ;
- Logger et Profiler obligatoires.

Aucune solution locale OWASYS n’est introduite.

## 2. Sources de vérité

```text
OPUS distant canonique : philstephibanez-wq/OPUS
Branche                 : master
Head distant HF6        : 79f261854ee06a9f828fec389adca77d57323d00
État owner              : HF7R1 appliqué localement, non encore committé
Fichier de base HF7R1   : Opus/Scaffold/SiteScaffoldPlan.php
SHA-256 fichier de base : a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74
```

Le correctif est fondé sur le fichier réel extrait du différentiel HF7 profile-aware, pas sur la version HF6 distante ni sur une reconstitution descriptive.

## 3. Périmètre différentiel

Un seul chemin cible est modifié :

```text
Opus/Scaffold/SiteScaffoldPlan.php
```

Aucune nouvelle classe concrète OPUS n’est ajoutée.

La classe existante reste :

```php
final class SiteScaffoldPlan implements
    ScaffoldPlanInterface,
    SiteScaffoldPlanInterface
```

`SiteScaffoldPlanInterface` demeure l’interface homonyme étendant directement :

- `OpusFrameworkComponentInterface` ;
- `OpusExceptionAwareInterface` ;
- `OpusProfilerAwareInterface` ;
- `OpusSelfDocumentingInterface`.

## 4. Registre linguistique généré

Le scaffold génère désormais exactement les 25 locales de base suivantes :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Les catalogues sont créés pour :

```text
application/default/local/<locale>.json
application/<module>/local/<locale>.json
```

Chaque profil conserve ses propres modules :

```text
frontend
backend
fullstack
```

Aucun fallback silencieux de catalogue n’est ajouté. Une locale ou une traduction de module absente provoque une erreur explicite.

## 5. Négociation navigateur

Le `config/site.json` généré déclare :

```text
contract              : OPUS_BROWSER_LOCALE_NEGOTIATION_V1
strategy              : accept-language
explicit_route_locale : true
fallback_locale       : fr
fallback_diagnostic   : true
```

`fr` est uniquement le fallback explicite. La locale primaire reste négociée depuis `Accept-Language` par `BrowserLocaleNegotiator`, sauf locale explicite valide dans la route.

Les variantes régionales comme `fr-FR`, `de-DE` et `uk-UA` sont ramenées à leur locale de base supportée par le négociateur OPUS existant.

## 6. Logger et Profiler

Le scaffold crée désormais :

```text
var/logs
var/profiler
```

Le `config/site.json` généré déclare les diagnostics obligatoires :

```text
logger.required   : true
logger.file       : var/logs/application.log
profiler.required : true
profiler.storage  : var/profiler
```

La classe Singleton générée `application/default/Application.php` utilise exclusivement les services OPUS :

```text
Opus\Log\Logger
Opus\Profiler\Profiler
```

Événements corrélés par `trace_id` :

```text
request.received
request.completed
request.failed
```

Le contexte journalisé est limité à la méthode HTTP, la durée et un code d’erreur assaini. Aucun mot de passe, token, secret, HMAC, corps de formulaire ou ligne de commande n’est journalisé.

## 7. Contrats applicatifs préservés

HF8 ne modifie pas :

- l’architecture Singleton ;
- le pilotage FSM-module-first ;
- l’ACL deny-by-default ;
- le SSO session et Auth0-proxy compatible bastion ;
- le rendu SCORE ;
- l’absence d’`echo` UI ;
- l’absence de HTML/PHP mélangé ;
- la lecture de configuration via `File` et `StructuredFileLoader` ;
- la frontière OWASYS REST sécurisé puis Composer ;
- les profils `frontend`, `backend` et `fullstack` de HF7R1.

## 8. Validations exécutées

```text
PHP lint SiteScaffoldPlan.php                  : OK
PHP lint Application.php généré                : OK
Profils frontend/backend/fullstack             : OK
Locales déclarées                              : 25
Catalogues default générés                     : 25
Catalogues modules fullstack générés           : 200
Parsing JSON des 225 catalogues                : OK
Contrat Accept-Language                        : présent
Fallback explicite                             : présent
Logger généré                                  : présent
Profiler généré                                : présent
Interface homonyme de SiteScaffoldPlan         : préservée
Nouvelle classe concrète OPUS                   : aucune
file_get_contents/json_decode config ajoutés   : aucun
Echo UI ajouté                                 : aucun
Contenu parasite dans le ZIP                   : aucun
```

L’audit tokenizer P117M exhaustif du dépôt owner complet reste un gate owner avant commit, car le dépôt live local n’est pas monté dans le runtime de livraison.

## 9. Artefact différentiel

```text
ZIP     : opus_p117u_hf8_generated_site_i18n_eu_uk_diagnostics.zip
SHA-256 : 6f5d68f23d94d048a0fc43b696397dfe643dd8dc1510cfc33147152ceda7a9f6
PATHS   : 1
```

Contenu exact :

```text
Opus/Scaffold/SiteScaffoldPlan.php
```

Le ZIP ne contient ni installateur, ni rapport, ni test, ni cache, ni log, ni profiler, ni secret, ni dépendance.

## 10. Gates owner après extraction

1. vérifier le SHA-256 du fichier HF7R1 local avant écrasement ;
2. extraire le ZIP à la racine de `H:\OPUS` ;
3. exécuter `composer dump-autoload -o` ;
4. exécuter le PHP lint ;
5. exécuter l’audit tokenizer P117M exhaustif ;
6. générer une application de chaque profil ;
7. vérifier 25 catalogues default et 25 catalogues par module ;
8. tester `fr-FR`, `de-DE`, `uk-UA` et une locale non supportée ;
9. vérifier `var/logs/application.log` et `var/profiler/<trace_id>.json` ;
10. valider SCORE, FSM, ACL, SSO, Auth0, HTTPS, bastion, no-JavaScript et Windows/Linux ;
11. committer OPUS uniquement après acceptation owner.

## 11. Nettoyage

Aucun nettoyage préalable n’est requis.

Ne pas supprimer :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```
