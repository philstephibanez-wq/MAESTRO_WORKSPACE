# MAESTRO WORKSPACE

## OPUS / OWASYS — cadre impératif

OPUS est un framework. OWASYS est une application autonome du framework OPUS.

Direction de dépendance obligatoire :

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
0a6041426c0dacec57fec490fd6750510d00ded8
step7 login password
```

Référence fonctionnelle et visuelle historique à préserver lors des remédiations :

```text
371c3757e8e80a62a198bc44a9f1b03d42a0ddec
branche owasys-backend-first-remediation
```

Le comportement observé dans le navigateur prime sur une affirmation de conformité ou sur un smoke isolé.

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
5. Une éventuelle page d’accueil appartient à un module séparé `application/home` et à un état FSM explicite.
6. Les modules fonctionnels sont directement sous `application/<module>`.
7. `application/states` est interdit par le contrat du framework.
8. Les templates applicatifs utilisent l’extension `.score` et le moteur natif OPUS ScoreTemplate.
9. Les contrôleurs construisent des données de vue ; ils ne construisent pas le document HTML.
10. `www` ne contient que le front controller et les ressources publiques.

Frontend/backend et frontoffice/backoffice sont deux axes indépendants. Aucune déduction automatique entre ces notions n’est autorisée.

## Rendu SCORE

Le rendu cible est :

```text
application/default/templates/       composants communs
application/<module>/templates/      templates fonctionnels du module
```

Sont interdits dans la cible conforme :

- `application/default/views/layout.php` ;
- les vues PHP qui produisent l’interface ;
- la concaténation HTML dans le contrôleur runtime ;
- un moteur de template de secours silencieux.

Le fichier commun `layout.score` assemble le header, le sélecteur de langue, le menu horizontal, le contexte utilisateur et le contenu du module. Il ne représente aucune page fonctionnelle.

## Pilotage FSM intégral

Toute route et toute action utilisateur doivent être résolues en événement FSM :

```text
requête/action
  -> résolution de l’événement
  -> authentification SSO
  -> autorisation ACL
  -> transition FSM
  -> exécution des actions FSM
  -> état cible
  -> contrôleur / ViewModel du module
  -> template SCORE
```

Les branches de navigation codées en dur dans le contrôleur runtime sont interdites dans la cible finale.

La FSM est la source de vérité pour :

- l’état courant ;
- les transitions ;
- les gardes ;
- les actions ;
- les modules cibles ;
- les besoins d’authentification et de contexte applicatif.

## SSO

Toute authentification OWASYS passe par l’abstraction SSO OPUS.

Le fournisseur `local-password` est le fournisseur local de développement. Il ne constitue pas une exception au contrat SSO.

Une identité de session normalisée contient au minimum :

- `subject` ;
- `label` ;
- `roles` ;
- `provider` ;
- `authenticated_at` ;
- `must_change_password` si applicable.

Aucun mot de passe ou hash n’est versionné. Le store local reste sous :

```text
sites/owasys/var/auth/local-users.json
```

## ACL

L’ACL OPUS fonctionne en `deny-by-default`.

Chaque accès serveur est contrôlé sur un couple :

```text
resource:action
```

Le filtrage du menu utilise les mêmes décisions ACL, mais masquer un lien ne remplace jamais le contrôle serveur.

Rôles de base :

- `admin` ;
- `developer` ;
- `viewer`.

## i18n

OWASYS propose les 24 langues officielles de l’Union européenne plus l’ukrainien :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Le sélecteur unique affiche le nom natif et le drapeau. Aucun choix limité à français/anglais n’est acceptable. Toutes les chaînes visibles, y compris les libellés accessibles des contrôles de mot de passe, passent par les catalogues i18n.

## État réel du step 7

Le step 7 a ajouté :

- les fondations `Opus/Security/Acl` ;
- les fondations `Opus/Security/Sso` ;
- `config/acl.json` ;
- `config/sso.json` ;
- les premiers templates `.score` ;
- `OwasysScorePageRenderer` ;
- `OwasysRuntimeSecurity`.

Cependant, la conformité n’est pas encore atteinte :

- le runtime live charge toujours `application/default/views/layout.php` ;
- les pages login, compte et Registry utilisent encore des vues PHP ;
- le contrôleur contient encore des branches spéciales par route ;
- les services SCORE, ACL et SSO ajoutés ne sont pas encore le chemin runtime unique ;
- l’action de changement de mot de passe n’est pas encore totalement abstraite par le fournisseur SSO ;
- le contrôle d’affichage du mot de passe manque dans les formulaires.

## Jalon actif — P117B

Objectif du prochain ZIP local :

1. ajouter un contrôle œil accessible sur tous les champs de mot de passe ;
2. conserver `default` comme couche commune uniquement ;
3. brancher réellement ScoreTemplate dans le runtime ;
4. brancher réellement SSO et ACL ;
5. exécuter les actions déclarées par la FSM via `FsmActionDispatcher` ;
6. supprimer les chemins de rendu PHP seulement après équivalence démontrée ;
7. conserver l’interface, le Registry, les 25 langues et les routes existantes.

P117B n’est pas terminé tant que la recette navigateur et les contrôles serveur ne sont pas verts.

## Politique d’écriture GitHub

ChatGPT ne doit effectuer aucune écriture directe dans :

```text
philstephibanez-wq/OPUS
```

Les correctifs OPUS/OWASYS sont fournis sous forme de ZIP local contrôlé.

Le dépôt suivant peut être mis à jour directement lorsque l’utilisateur le demande :

```text
philstephibanez-wq/MAESTRO_WORKSPACE
```

## Méthode obligatoire

1. Relire `OPUS/master` et `MAESTRO_WORKSPACE/master`.
2. Identifier les fichiers réellement servis.
3. Préparer un ZIP local limité au jalon annoncé.
4. Inclure un manifeste des remplacements et suppressions.
5. Valider les syntaxes PHP et JSON.
6. Exécuter les smokes ciblés.
7. Tester dans le navigateur.
8. Vérifier les refus anonymes et ACL.
9. Vérifier les transitions et actions FSM.
10. Pousser OPUS uniquement depuis le dépôt local de l’utilisateur après validation.

## Garanties de non-régression

Doivent rester présents et fonctionnels :

- le header séparé du menu horizontal ;
- le Registry et la sélection d’application ;
- le contexte applicatif courant ;
- la FSM complète ;
- les routes et actions ;
- les 25 locales avec drapeaux ;
- les catalogues i18n complets ;
- la page Code source et sa coloration locale lorsqu’elle est présente dans la référence ;
- `sites/owasys/www/index.php` comme front controller unique ;
- le fonctionnement sous Windows et sur un système sensible à la casse.

## Règle de décision

En cas de doute, ne pas inventer un autre arbre, un autre lanceur, un autre routeur, un autre layout ou un autre moteur de rendu. Relire le framework et l’application, puis produire le plus petit correctif conforme et vérifiable.
