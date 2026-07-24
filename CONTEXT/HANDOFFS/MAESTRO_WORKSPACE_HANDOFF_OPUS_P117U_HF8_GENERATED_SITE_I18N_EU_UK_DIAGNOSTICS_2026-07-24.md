# MAESTRO_WORKSPACE HANDOFF — OPUS P117U HF8 I18N UE + UKRAINIEN

Date : 2026-07-24  
Statut : ZIP différentiel HF8 produit ; installation et recette owner requises

## Décision

Le propriétaire a approuvé l’évolution générique OPUS.

Les applications générées doivent recevoir les 24 langues officielles de l’Union européenne plus l’ukrainien. La locale initiale est négociée depuis le navigateur ; `fr` reste uniquement le fallback explicite.

## Source de vérité

```text
OPUS distant : philstephibanez-wq/OPUS master
Head distant : 79f261854ee06a9f828fec389adca77d57323d00
Owner local  : HF7R1 appliqué, non committé
Base HF8     : Opus/Scaffold/SiteScaffoldPlan.php post-HF7R1
Base SHA256  : a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74
```

## Différentiel HF8

```text
ZIP     : opus_p117u_hf8_generated_site_i18n_eu_uk_diagnostics.zip
SHA-256 : 6f5d68f23d94d048a0fc43b696397dfe643dd8dc1510cfc33147152ceda7a9f6
PATHS   : 1
```

Contenu :

```text
Opus/Scaffold/SiteScaffoldPlan.php
```

## Évolution produite

Le scaffold profile-aware génère désormais :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

pour `application/default/local/` et chaque module du profil `frontend`, `backend` ou `fullstack`.

Le `config/site.json` généré déclare :

```text
Accept-Language
locale explicite dans la route
fallback fr explicite et diagnostiqué
Logger obligatoire
Profiler obligatoire
```

La classe Singleton générée utilise `Opus\Log\Logger` et `Opus\Profiler\Profiler`. Les événements `request.received`, `request.completed` et `request.failed` partagent le même `trace_id`.

## Contrat des classes OPUS

Aucune nouvelle classe concrète sous `Opus/` n’est introduite.

`SiteScaffoldPlan` conserve son interface homonyme `SiteScaffoldPlanInterface`, laquelle étend les quatre marqueurs contractuels.

## Validations de livraison

```text
SiteScaffoldPlan PHP lint            : OK
Application.php généré PHP lint      : OK
25 locales                           : OK
25 catalogues default                : OK
200 catalogues modules fullstack     : OK
Parsing JSON                         : OK
Trois profils                        : OK
SCORE                                : préservé
FSM/ACL/SSO/Singleton                : préservés
Logger/Profiler                      : générés
Aucun echo UI ajouté                 : OK
Aucun parser local ajouté            : OK
ZIP sans parasite                    : OK
```

## Installation owner

Avant extraction, le SHA-256 du fichier local `Opus\Scaffold\SiteScaffoldPlan.php` doit être :

```text
a68f57c7de7f934363cd76ba8c726f732bf83c9a8575fcf88cdb2d8f68877a74
```

Si le SHA diffère, ne pas écraser le fichier : fournir le fichier local réel pour reconstruction du différentiel.

Après extraction :

1. Composer autoload optimisé ;
2. PHP lint ;
3. audit tokenizer P117M exhaustif ;
4. génération et recette des trois profils ;
5. contrôle des locales navigateur ;
6. contrôle Logger et Profiler ;
7. commit OPUS uniquement après acceptation.

## Nettoyage

Aucun nettoyage n’est requis. Préserver `sites/owasys_old`, les logs, le profiler et le Registry.
