# Handoff OWASYS / OPUS — P117B

**Date :** 2026-07-21  
**Dépôt code lu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit courant relu :** `0a6041426c0dacec57fec490fd6750510d00ded8` — `step7 login password`

## Demande active

1. Ajouter un contrôle œil dans les champs mot de passe.
2. Verrouiller la sémantique de `application/default` : couche commune à toutes les pages, jamais page `home`.
3. Continuer la mise en conformité OWASYS avec le framework OPUS.
4. Faire de la FSM, de l’ACL et du SSO le chemin runtime unique.
5. Fournir les changements OPUS/OWASYS uniquement sous forme de ZIP local.
6. Mettre à jour le workspace directement sur GitHub.

## Architecture confirmée par le framework

`Opus/Fsm/FsmSiteLoader.php` impose :

```text
application/default
application/<module>
```

et interdit :

```text
application/states
```

`application/default` contient uniquement les composants partagés : services, modèles communs, templates communs, i18n, navigation commune et helpers. Il ne représente aucun état fonctionnel.

Une page d’accueil éventuelle doit être un module distinct :

```text
application/home
```

avec un état et des transitions FSM explicites.

## État runtime observé

Le navigateur affiche correctement la page de connexion, le header, le sélecteur des 25 langues avec drapeaux et le formulaire.

Le contrôle œil du mot de passe est absent.

Le runtime GitHub courant n’est pas encore intégralement conforme :

- `sites/owasys/application/default/controllers/RuntimeController.php` charge encore des vues PHP ;
- `sites/owasys/application/default/views/layout.php` produit encore le document HTML live ;
- `login/views/index.php`, `account/views/index.php` et `registry/views/index.php` restent utilisés ;
- le runtime contient des branches dédiées à `login`, `account/password` et `applications` ;
- `OwasysScorePageRenderer` et `OwasysRuntimeSecurity` existent mais ne sont pas branchés dans le contrôleur live ;
- les classes ACL et SSO du framework sont présentes ;
- `config/acl.json` est deny-by-default ;
- `config/sso.json` déclare `local-password` ;
- la FSM OWASYS existe, mais ses actions ne sont pas encore exécutées systématiquement par `FsmActionDispatcher`.

## Cause du précédent problème de connexion

Le fournisseur local dépend du fichier runtime non versionné :

```text
sites/owasys/var/auth/local-users.json
```

Un store absent, vide ou incompatible rend toute authentification impossible. Le bootstrap doit créer ou réparer l’utilisateur sans versionner de secret.

## Jalon P117B

Le ZIP P117B doit rester conservateur et vérifiable.

### Partie visible

- œil d’affichage/masquage dans le login ;
- même contrôle dans les trois champs de changement de mot de passe ;
- bouton accessible au clavier ;
- état `aria-pressed` ;
- libellés afficher/masquer issus de l’i18n ;
- aucune modification visuelle globale.

### Partie architecture

- `default/templates/layout.score` reste le layout commun ;
- les templates fonctionnels restent sous `application/<module>/templates` ;
- aucune page fonctionnelle sous `default` ;
- ScoreTemplate devient le rendu runtime unique ;
- l’identité est produite par SSO ;
- chaque état privé est contrôlé par ACL ;
- routes et actions deviennent des événements FSM ;
- les actions de transition passent par `FsmActionDispatcher` ;
- les vues PHP ne sont supprimées qu’après validation d’équivalence.

## Recette obligatoire

1. Login valide.
2. Login invalide refusé.
3. Route privée anonyme redirigée vers login.
4. Rôle non autorisé refusé côté serveur.
5. Œil fonctionnel sur login.
6. Œil fonctionnel sur changement de mot de passe.
7. Sélecteur des 25 langues intact.
8. Registry intact.
9. Sélection et effacement du contexte applicatif intacts.
10. Transitions FSM et actions exécutées.
11. Aucun `application/states`.
12. Aucun `OPUS/www`.
13. Aucun push direct d’OPUS par ChatGPT.

## Fichiers prioritaires à comparer après extraction

```text
sites/owasys/www/index.php
sites/owasys/application/default/controllers/RuntimeController.php
sites/owasys/application/default/services/ScorePageRenderer.php
sites/owasys/application/default/services/RuntimeSecurity.php
sites/owasys/application/default/templates/layout.score
sites/owasys/application/login/templates/index.score
sites/owasys/application/account/templates/index.score
sites/owasys/application/registry/templates/index.score
sites/owasys/www/asset/css/owasys.css
sites/owasys/config/owasys-navigation.fsm.json
sites/owasys/config/acl.json
sites/owasys/config/sso.json
```

## Interdictions

- Ne pas transformer `default` en `home`.
- Ne pas créer `application/states`.
- Ne pas remettre un routeur public parallèle.
- Ne pas construire du HTML dans le contrôleur.
- Ne pas contourner l’ACL par un simple masquage de menu.
- Ne pas contourner le SSO avec un login parallèle.
- Ne pas déclarer la conformité tant que le runtime live utilise encore le layout PHP.
