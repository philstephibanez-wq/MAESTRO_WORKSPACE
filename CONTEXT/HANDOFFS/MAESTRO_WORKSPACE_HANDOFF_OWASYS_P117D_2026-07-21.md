# Handoff OWASYS / OPUS — P117D

**Date :** 2026-07-21  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit relu :** `30fc88a89d180186d6364a0ab2ae05179b93bca3` — `p117c`

## Demande active

1. Relire les dépôts GitHub.
2. Mettre à jour les handoffs et spécifications dans `MAESTRO_WORKSPACE`.
3. Livrer les correctifs OPUS/OWASYS sous forme de ZIP local uniquement.
4. Maintenir OWASYS sous pilotage FSM + ACL + SSO.
5. Maintenir OWASYS conforme au framework OPUS.
6. Fournir les commandes de nettoyage nécessaires.
7. Fournir la commande canonique de lancement.

## Diagnostic

`sites/owasys/config/site.json` déclare une liste `modules` contenant notamment `home`.

La FSM OWASYS ne contient aucun état ciblant `home`. Elle cible seulement :

```text
login account registry structure data workflows security source build
```

`Opus/Fsm/FsmSiteLoader.php` utilisait pourtant `site.json.modules` pour imposer l’existence physique de chaque répertoire. Cette seconde source de vérité explique pourquoi la suppression de `application/home` cassait le chargement du site.

## Décision architecturale

La FSM devient l’unique source fonctionnelle des modules.

```text
site.json = identité et infrastructure du site
FSM       = états, modules, routes, événements, gardes et actions
default   = couche commune hors des états fonctionnels
```

Le framework doit :

1. valider les racines `application` et `application/default` ;
2. résoudre le fichier FSM ;
3. dériver les modules depuis `states[].module` ;
4. utiliser `states[].id` comme repli contrôlé si `module` est absent ;
5. refuser `default` comme module d’état ;
6. vérifier `application/<module>` uniquement pour les modules dérivés ;
7. ignorer toute ancienne liste `site.json.modules` au runtime.

## Correctif P117D

Fichiers remplacés :

```text
Opus/Fsm/FsmSiteLoader.php
sites/owasys/config/site.json
```

Modification OWASYS : suppression de la propriété `modules` de `site.json`.

Modification framework : validation des répertoires dérivée de la FSM.

## Nettoyage

Le répertoire suivant peut être supprimé après extraction du ZIP :

```text
sites/owasys/application/home
```

Il n’est ciblé par aucun état FSM.

Aucun autre fichier ne doit être supprimé dans ce jalon.

## Packaging

Le ZIP P117D contient exactement les deux fichiers runtime remplacés.

Il ne contient aucun smoke, Markdown, manifeste, script d’installation, script de rollback ou document de gouvernance.

## Validation attendue

- syntaxe PHP de `FsmSiteLoader.php` valide ;
- JSON de `site.json` valide ;
- absence de propriété `modules` dans `site.json` ;
- démarrage OWASYS après suppression de `application/home` ;
- login, Registry, ACL, SSO, navigation et SCORE inchangés ;
- absence de `OPUS_FSM_SITE_MODULE_DIRECTORY_MISSING: owasys:home`.

## Commande de lancement canonique

Depuis `H:\OPUS\sites\owasys\www` :

```text
php -S localhost:8000 index.php
```

Le point d’entrée reste exclusivement `sites/owasys/www/index.php`.