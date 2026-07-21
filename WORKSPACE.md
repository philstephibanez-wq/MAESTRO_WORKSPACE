# MAESTRO WORKSPACE

## OPUS / OWASYS — cadre impératif

OPUS est un framework. OWASYS est une application autonome du framework OPUS.

```text
OWASYS -> OPUS Framework
```

La direction inverse est interdite. OPUS ne possède pas, ne lance pas et ne centralise pas les applications.

Dépôts concernés :

- code du framework et de l’application : `philstephibanez-wq/OPUS` ;
- gouvernance, handoffs et spécifications : `philstephibanez-wq/MAESTRO_WORKSPACE`.

## Sources de vérité relues

État courant de `OPUS/master` relu le 2026-07-21 :

```text
30fc88a89d180186d6364a0ab2ae05179b93bca3
p117c
```

Référence fonctionnelle et visuelle historique à préserver lors des remédiations :

```text
371c3757e8e80a62a198bc44a9f1b03d42a0ddec
branche owasys-backend-first-remediation
```

Le comportement observé dans le navigateur prime sur une affirmation de conformité ou sur une validation isolée.

## Contrat d’arborescence OPUS

Chaque application possède son propre arbre :

```text
sites/<application>/
  application/
    default/
    <module>/
  config/
  var/
  www/
    index.php
```

Règles non négociables :

1. `sites/<application>/www/index.php` est l’unique point d’entrée public de l’application.
2. `OPUS/www` est interdit.
3. `application/default` est exclusivement la couche commune héritée par toutes les pages et tous les modules.
4. `application/default` n’est jamais une page d’accueil, un état `home` ou un module fonctionnel.
5. Une éventuelle page d’accueil appartient à `application/home` uniquement si la FSM contient un état ciblant explicitement le module `home`.
6. Les modules fonctionnels sont directement sous `application/<module>`.
7. `application/states` est interdit.
8. Les templates applicatifs utilisent l’extension `.score` et le moteur natif OPUS ScoreTemplate.
9. Les contrôleurs construisent des données de vue ; ils ne construisent pas le document HTML.
10. `www` ne contient que le front controller et les ressources publiques.

Frontend/backend et frontoffice/backoffice sont deux axes indépendants.

## Répartition des sources de vérité

`site.json` décrit exclusivement l’identité et l’infrastructure globale du site :

- identifiant et rôle ;
- locales et thème ;
- racines publique, applicative, commune et assets ;
- modèle de dispatch ;
- pointeur vers la FSM ;
- configuration d’authentification.

`site.json` ne constitue pas un registre fonctionnel des modules.

La FSM est la source de vérité pour :

- les états ;
- les modules ciblés par les états ;
- les routes ;
- les événements ;
- les transitions ;
- les gardes ;
- les actions ;
- les exigences d’authentification et de contexte applicatif.

Le framework dérive les modules requis depuis `states[].module`, avec repli contrôlé sur `states[].id` lorsque `module` est absent. Il vérifie ensuite l’existence de chaque répertoire `application/<module>`.

Une entrée `modules` dans `site.json` est une duplication interdite pour OWASYS et ne doit plus piloter le runtime.

## Rendu SCORE

```text
application/default/templates/       composants communs
application/<module>/templates/      templates fonctionnels du module
```

Sont interdits :

- `application/default/views/layout.php` ;
- les vues PHP qui produisent l’interface ;
- la concaténation HTML dans le contrôleur runtime ;
- un moteur de template de secours silencieux.

`application/default/templates/layout.score` assemble le header, le sélecteur de langue, le menu horizontal, le contexte utilisateur et le contenu du module. Il ne représente aucune page fonctionnelle.

Le ViewModel commun doit fournir toutes les clés strictement référencées par les templates SCORE. Une clé absente constitue une erreur de contrat explicite.

## Pilotage FSM intégral

```text
requête/action
  -> résolution de l’événement
  -> identité SSO
  -> décision ACL
  -> transition FSM
  -> FsmActionDispatcher
  -> état et module cibles
  -> ViewModel
  -> template SCORE
```

Aucun contrôleur ne doit inventer un état cible ou contourner une transition déclarée.

## SSO

Toute authentification OWASYS passe par l’abstraction SSO OPUS. Le fournisseur `local-password` est le fournisseur local de développement.

Le store runtime non versionné reste sous :

```text
sites/owasys/var/auth/local-users.json
```

Aucun mot de passe ou hash n’est versionné.

## ACL

L’ACL OPUS fonctionne en `deny-by-default` sur un couple :

```text
resource:action
```

Le filtrage du menu utilise les mêmes décisions que les contrôles serveur. Masquer un lien ne remplace jamais l’autorisation serveur.

## i18n

OWASYS propose les 24 langues officielles de l’Union européenne plus l’ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Le sélecteur affiche le nom natif et le drapeau. Toutes les chaînes visibles et accessibles passent par les catalogues i18n.

## État P117C relu

Le runtime courant utilise :

- ScoreTemplate pour le document et les pages fonctionnelles migrées ;
- la FSM pour les événements, transitions, gardes et actions ;
- `FsmActionDispatcher` pour les actions déclarées ;
- SSO pour l’identité et le changement de mot de passe ;
- ACL pour les accès serveur et la navigation ;
- un ViewModel strict pour les templates SCORE.

Le défaut P117C de clés `labels.language_selector` et `labels.none_selected_short` a été corrigé.

## Jalon actif — P117D

Objectif : supprimer la double déclaration des modules.

1. Retirer `modules` de `sites/owasys/config/site.json`.
2. Faire dériver les modules requis de la FSM dans `Opus/Fsm/FsmSiteLoader.php`.
3. Conserver `application/default` comme couche commune obligatoire hors des états fonctionnels.
4. Refuser explicitement un état FSM ciblant le module `default`.
5. Vérifier l’existence des seuls modules réellement ciblés par la FSM.
6. Supprimer le répertoire OWASYS `application/home` puisqu’aucun état FSM ne le cible.
7. Ne modifier ni le rendu, ni l’ACL, ni le SSO, ni les transitions fonctionnelles existantes.

## Politique d’écriture GitHub

ChatGPT ne doit effectuer aucune écriture directe dans :

```text
philstephibanez-wq/OPUS
```

Les correctifs OPUS/OWASYS sont fournis sous forme de ZIP local contrôlé.

Le dépôt suivant peut être mis à jour directement à la demande de l’utilisateur :

```text
philstephibanez-wq/MAESTRO_WORKSPACE
```

## Politique de livraison ZIP

Les ZIP OPUS/OWASYS contiennent uniquement les fichiers runtime à ajouter ou remplacer.

Ils ne contiennent pas :

- de Markdown à la racine OPUS ;
- de manifeste à la racine OPUS ;
- de script d’application ou de rollback à la racine OPUS ;
- de smoke dans l’arbre `sites/owasys` ;
- de document de handoff ou de spécification.

Les suppressions sont communiquées sous forme de commandes `cmd` séparées. Les validations utilisées pour construire le ZIP restent hors du patch, sauf demande explicite.

## Garanties de non-régression

Doivent rester présents et fonctionnels :

- le header séparé du menu horizontal ;
- le Registry et la sélection d’application ;
- le contexte applicatif courant ;
- la FSM complète ;
- ACL et SSO ;
- les routes et actions ;
- les 25 locales avec drapeaux ;
- le contrôle de visibilité des mots de passe ;
- la page Code source lorsqu’elle est présente dans la référence ;
- `sites/owasys/www/index.php` comme front controller unique ;
- le fonctionnement sous Windows et sur un système sensible à la casse.

## Règle de décision

En cas de doute, relire le framework et l’application, identifier la source de vérité unique, puis produire le plus petit correctif conforme et vérifiable.