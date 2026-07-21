# Spécification OWASYS — source des modules pilotée par FSM P117D

## 1. Objet

Cette spécification supprime la duplication entre la liste de modules de `site.json` et les modules réellement ciblés par la FSM.

## 2. Sources de vérité

### 2.1 `site.json`

`site.json` contient les métadonnées globales et les pointeurs d’infrastructure :

- `site_id` ;
- `role` ;
- locales ;
- thème ;
- `public_root` ;
- `application_root` ;
- `default_root` ;
- `asset_root` ;
- `dispatch_model` ;
- pointeur `navigation.fsm` ;
- configuration SSO.

La propriété `modules` n’est pas admise comme source runtime pour OWASYS.

### 2.2 FSM

Le fichier FSM est la source de vérité pour les modules fonctionnels :

```text
states[].module
```

Lorsqu’un état ne définit pas `module`, le framework peut utiliser `states[].id` comme repli explicite et validé.

## 3. Couche commune `default`

```text
application/default
```

est obligatoire comme couche commune, mais ne constitue pas un module fonctionnel ni un état.

Une FSM ciblant :

```json
{"module":"default"}
```

doit être refusée avec une erreur explicite.

## 4. Algorithme de chargement

`FsmSiteLoader::resolve()` exécute l’ordre suivant :

1. charger et valider `config/site.json` ;
2. valider `application_root`, `default_root` et `dispatch_model` ;
3. vérifier l’existence de `application` et `application/default` ;
4. refuser `application/states` ;
5. résoudre le fichier FSM déclaré ou canonique ;
6. charger le JSON FSM ;
7. extraire les modules uniques depuis les états ;
8. valider le nom de chaque module ;
9. refuser le module fonctionnel `default` ;
10. vérifier l’existence de chaque `application/<module>` dérivé ;
11. construire le processeur FSM.

## 5. Erreurs contractuelles

Les erreurs suivantes doivent rester explicites :

```text
OPUS_FSM_SITE_STATES_MISSING
OPUS_FSM_SITE_STATE_INVALID
OPUS_FSM_SITE_STATE_ID_INVALID
OPUS_FSM_SITE_MODULE_NAME_INVALID
OPUS_FSM_SITE_DEFAULT_STATE_MODULE_FORBIDDEN
OPUS_FSM_SITE_MODULE_DIRECTORY_MISSING
```

## 6. Compatibilité

Une ancienne propriété `site.json.modules` peut encore exister temporairement dans une autre application, mais elle ne pilote plus la résolution runtime des modules.

Cette compatibilité permet une migration progressive sans conserver deux sources fonctionnelles concurrentes.

## 7. Cas `home`

Un module `application/home` n’est requis que si la FSM contient un état dont le module cible est `home`.

OWASYS P117D ne possède aucun état `home`. Le répertoire `sites/owasys/application/home` peut donc être supprimé après retrait de la liste `modules` de `site.json` et installation du nouveau `FsmSiteLoader`.

## 8. Non-régression

Le correctif ne doit modifier ni :

- les états et transitions OWASYS ;
- les gardes et actions ;
- l’ACL ;
- le SSO ;
- les templates SCORE ;
- le ViewModel ;
- les routes ;
- le Registry ;
- les 25 locales ;
- le point d’entrée public.

## 9. Packaging

Le ZIP contient uniquement :

```text
Opus/Fsm/FsmSiteLoader.php
sites/owasys/config/site.json
```

Les suppressions sont exécutées par commande locale séparée. Aucun fichier de documentation ou de validation n’est inclus dans l’arbre OPUS.

## 10. Critères d’acceptation

1. OWASYS démarre sans propriété `modules` dans `site.json`.
2. OWASYS démarre après suppression de `application/home`.
3. Un module référencé par la FSM mais physiquement absent provoque une erreur explicite.
4. Un état ciblant `default` est refusé.
5. Login, SSO, ACL, Registry, navigation, SCORE et i18n restent fonctionnels.
6. `sites/owasys/www/index.php` reste l’unique front controller.