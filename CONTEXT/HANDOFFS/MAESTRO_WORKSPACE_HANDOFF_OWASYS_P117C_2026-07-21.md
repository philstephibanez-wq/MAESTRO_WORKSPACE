# Handoff OWASYS / OPUS — P117C

**Date :** 2026-07-21  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit courant relu :** `9cb57fdbba0de07c9cefc4732a7c13482af60d51` — `p117b sans le smoke`

## Incident runtime constaté

Le lancement suivant atteint le runtime OWASYS mais retourne HTTP 500 :

```text
php -S localhost:8000 index.php
```

Erreur :

```text
OPUS_SCORE_TEMPLATE_DATA_MISSING: labels.language_selector
```

Le moteur OPUS ScoreTemplate applique correctement son contrat strict : toute donnée interpolée par un template doit exister dans le ViewModel. Aucun fallback silencieux n'est autorisé.

## Cause exacte

Les templates communs SCORE utilisent les deux chemins suivants :

```text
labels.language_selector
labels.none_selected_short
```

La méthode `OwasysRuntimeController::viewLabels()` du commit relu ne fournit pas ces deux entrées.

La première clé manquante provoque l'erreur observée. La seconde provoquerait l'erreur suivante dès que le premier défaut serait corrigé et que le layout authentifié serait rendu sans application courante.

## Correctif P117C

Le correctif différentiel modifie uniquement :

```text
sites/owasys/application/default/controllers/RuntimeController.php
```

Ajouts au registre commun des libellés :

```php
'language_selector' => 'language.selector',
'none_selected_short' => 'registry.none_selected',
```

Aucun template, contrôleur fonctionnel, fichier de configuration, moteur OPUS ou asset n'est modifié.

## Sémantique de `application/default`

`sites/owasys/application/default` est exclusivement la partie commune à toutes les pages et à tous les modules :

- runtime partagé ;
- session ;
- sécurité partagée ;
- navigation partagée ;
- i18n partagée ;
- ViewModel commun ;
- templates et partiels SCORE communs.

`application/default` n'est pas une page d'accueil et ne représente aucun état fonctionnel.

Une page d'accueil éventuelle appartient exclusivement à :

```text
sites/owasys/application/home
```

et doit être reliée à un état FSM explicite.

## Règles de packaging désormais obligatoires

Les ZIP de correctif OPUS / OWASYS contiennent uniquement les fichiers de code ou de configuration à déposer à leurs chemins canoniques.

Sont interdits dans les ZIP destinés à être extraits à la racine OPUS :

- fichiers Markdown de livraison à la racine ;
- rapports de validation à la racine ;
- README de patch à la racine ;
- scripts smoke sous `sites/owasys/application` ;
- répertoires temporaires de patch ;
- copies de sauvegarde ;
- fichiers sans rôle runtime ou framework.

Les spécifications et handoffs appartiennent au dépôt `MAESTRO_WORKSPACE`.

Les outils de validation versionnés, lorsqu'ils sont demandés, appartiennent au répertoire OPUS `tools/`, jamais dans l'arbre runtime de l'application.

## État architectural après P117B

Le commit relu comporte désormais :

- rendu SCORE comme chemin runtime ;
- résolution des requêtes et actions en événements FSM ;
- transitions OPUS FSM ;
- exécution des actions par `FsmActionDispatcher` ;
- authentification par l'abstraction SSO OPUS ;
- contrôle d'accès serveur par ACL OPUS ;
- navigation filtrée par ACL ;
- point d'entrée public unique `sites/owasys/www/index.php` ;
- contrôle œil accessible sur les champs de mot de passe.

La conformité navigateur ne peut être déclarée qu'après application de P117C et validation des parcours login, compte, Registry et navigation privée.

## Recette P117C

1. Extraire le ZIP à la racine `H:\OPUS`.
2. Vérifier la syntaxe du contrôleur.
3. Redémarrer le serveur PHP intégré.
4. Ouvrir `/` puis `/fr/login`.
5. Vérifier le sélecteur des 25 langues.
6. Vérifier l'œil du mot de passe.
7. Se connecter.
8. Vérifier le header sans application courante.
9. Vérifier le Registry et la sélection d'application.
10. Vérifier qu'aucune erreur `OPUS_SCORE_TEMPLATE_DATA_MISSING` ne subsiste.

## Interdictions maintenues

- Aucun push direct dans GitHub OPUS par ChatGPT.
- Aucun `OPUS/www`.
- Aucun `application/states`.
- Aucun layout PHP.
- Aucune vue PHP produisant le document final.
- Aucun contournement de FSM, ACL ou SSO.
- Aucun amalgame entre `default` et `home`.
