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
af99d2037d8750b772f576dfd72f6a20f5da973b
p117d
```

Référence fonctionnelle et visuelle historique à préserver lors des remédiations :

```text
371c3757e8e80a62a198bc44a9f1b03d42a0ddec
branche owasys-backend-first-remediation
```

Référence historique du schéma FSM Mermaid :

```text
cc955e8f9e9c09fd30da59f9f639d1b6136bcffa
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
- les exigences d’authentification et de contexte applicatif ;
- la projection visuelle Mermaid du workflow.

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

`application/default/templates/layout.score` assemble le header, le sélecteur de langue, le menu horizontal, le contexte utilisateur, le schéma FSM commun et le contenu du module. Il ne représente aucune page fonctionnelle.

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

## Visualisation FSM Mermaid

Le schéma Mermaid OWASYS est une projection de la FSM canonique, jamais une seconde définition du workflow.

Règles :

1. Les nœuds proviennent des états FSM visibles et autorisés par l’ACL.
2. Les liens proviennent des routes FSM déjà construites par la navigation commune.
3. Les arêtes proviennent exclusivement des transitions portant `visual: true`.
4. `visual_from` peut préciser la source d’affichage d’une transition runtime générique `from: "*"` ; cette métadonnée n’altère pas l’exécution de la FSM.
5. L’état courant est mis en évidence.
6. Le contexte applicatif courant peut enrichir le libellé d’un nœud sans modifier la FSM.
7. Le schéma est commun aux pages authentifiées, hors login et compte.
8. Le rendu utilise le composant OPUS `MermaidDiagram` et le bundle local du framework.
9. Aucun CDN Mermaid et aucune copie applicative de Mermaid ne sont autorisés.
10. Mermaid est initialisé avec `securityLevel: strict`.
11. La navigation clavier et souris est branchée après le rendu sur la table de routes ACL filtrée.

Implantation :

```text
Opus/Assets/dist/mermaid/opus-mermaid.js
Opus/Assets/FrameworkAssetResponder.php
sites/owasys/application/default/services/FsmMermaidBuilder.php
sites/owasys/application/default/templates/partials/fsm-mermaid.score
sites/owasys/www/asset/js/fsm-mermaid.js
sites/owasys/www/asset/css/fsm-mermaid.css
```

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

Le filtrage du menu et du schéma Mermaid utilise les mêmes décisions que les contrôles serveur. Masquer un lien ou un nœud ne remplace jamais l’autorisation serveur.

## i18n

OWASYS propose les 24 langues officielles de l’Union européenne plus l’ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Le sélecteur affiche le nom natif et le drapeau. Toutes les chaînes visibles et accessibles passent par les catalogues i18n.

## État P117D relu

P117D est appliqué sur `OPUS/master` :

- `site.json.modules` ne pilote plus le runtime ;
- les modules sont dérivés des états FSM ;
- `default` est refusé comme module d’état ;
- le répertoire `application/home` inutilisé a été supprimé.

## Jalon actif — P117E

Objectif : réintégrer le schéma FSM Mermaid historique dans l’architecture OPUS actuelle.

1. Générer le schéma depuis `config/owasys-navigation.fsm.json`.
2. Conserver la FSM comme source de vérité unique.
3. Afficher uniquement les états de navigation autorisés par l’ACL.
4. Mettre en évidence l’état courant et le contexte applicatif.
5. Restaurer les transitions visuelles historiques par métadonnées `visual` et `visual_from`.
6. Rendre le schéma dans le layout commun SCORE.
7. Utiliser exclusivement le bundle Mermaid local du framework OPUS.
8. Préserver SSO, ACL, Registry, navigation horizontale, i18n et contrôle de mot de passe.
9. Ne réintroduire ni monolithe, ni CDN, ni copie vendor applicative, ni HTML construit dans le contrôleur.

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
- le schéma FSM Mermaid dérivé de la FSM ;
- ACL et SSO ;
- les routes et actions ;
- les 25 locales avec drapeaux ;
- le contrôle de visibilité des mots de passe ;
- la page Code source lorsqu’elle est présente dans la référence ;
- `sites/owasys/www/index.php` comme front controller unique ;
- le fonctionnement sous Windows et sur un système sensible à la casse.

## Règle de décision

En cas de doute, relire le framework et l’application, identifier la source de vérité unique, puis produire le plus petit correctif conforme et vérifiable.
