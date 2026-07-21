# Spécification OWASYS — contrat ViewModel SCORE et packaging P117C

## 1. Objet

Cette spécification complète la cible OWASYS 100 % conforme au framework OPUS.

Elle définit :

- le contrat de complétude des données SCORE ;
- la responsabilité de `application/default` ;
- le placement des composants fonctionnels ;
- les règles de packaging des correctifs ZIP ;
- les critères de conformité FSM, ACL et SSO.

## 2. Contrat strict ScoreTemplate

Le moteur obligatoire est :

```text
Opus\Template\ScoreTemplateRenderer
```

Pour chaque interpolation, condition ou boucle présente dans un template `.score`, le chemin de données doit exister dans le ViewModel transmis au renderer.

Exemples :

```text
{{ labels.language_selector }}
[[ if: current_app.present ]]
[[ foreach: navigation as item ]]
```

Les chemins suivants doivent donc être définis avant le rendu :

```text
labels.language_selector
current_app.present
navigation
```

Le moteur ne doit pas :

- inventer une valeur vide ;
- remplacer silencieusement une clé absente ;
- masquer une erreur de contrat ;
- basculer sur un autre moteur de template.

Une erreur `OPUS_SCORE_TEMPLATE_DATA_MISSING` indique un ViewModel incomplet et doit être corrigée dans le producteur de données, pas neutralisée dans le renderer.

## 3. Registre des libellés communs

Les libellés utilisés par `application/default/templates` sont produits par le ViewModel commun.

Le registre commun doit couvrir au minimum :

```text
account
login
logout
navigation
language_selector
pending
password_auth
sign_in
sign_in_description
username
password
password_show
password_hide
change_password
change_password_description
current_password
new_password
confirm_password
current_application
change_application
none_selected_short
```

Les clés applicatives i18n correspondantes restent dans :

```text
sites/owasys/application/default/local/<locale>.php
```

Les 25 locales restent obligatoires : 24 langues officielles de l'Union européenne plus l'ukrainien.

## 4. Responsabilité de `application/default`

`sites/owasys/application/default` est la couche commune héritée par toutes les pages et tous les modules.

Elle contient uniquement des responsabilités partagées :

- contrôleur runtime partagé ;
- modèles de session partagés ;
- sécurité partagée ;
- résolution de locale ;
- navigation commune ;
- construction du ViewModel commun ;
- layout SCORE commun ;
- partiels SCORE communs ;
- catalogues i18n communs.

Elle ne représente jamais :

- une page d'accueil ;
- un état FSM `default` ;
- un module fonctionnel ;
- une substitution à `application/home`.

## 5. Modules fonctionnels

Chaque état fonctionnel cible directement un module :

```text
sites/owasys/application/<module>
```

Exemples :

```text
application/login
application/account
application/registry
application/structure
application/data
application/workflows
application/security
application/source
application/build
```

Une page d'accueil ne peut exister que sous :

```text
application/home
```

avec un état, une route et des transitions FSM explicitement configurés.

Le répertoire `application/states` est interdit.

## 6. Pipeline runtime obligatoire

```text
requête HTTP
  -> résolution locale et route
  -> résolution événement FSM
  -> identité SSO
  -> gardes FSM
  -> décision ACL serveur
  -> FsmProcessor::transition
  -> FsmActionDispatcher::dispatch
  -> module cible
  -> ViewModel commun + ViewModel module
  -> template module .score
  -> layout commun .score
```

Aucun traitement fonctionnel ne doit contourner ce pipeline.

## 7. SSO

Toute authentification passe par l'abstraction SSO OPUS.

Le fournisseur local `local-password` est le fournisseur de développement et respecte le même contrat que les futurs fournisseurs externes.

Le store utilisateur est runtime et non versionné :

```text
sites/owasys/var/auth/local-users.json
```

## 8. ACL

L'ACL est appliquée côté serveur en `deny-by-default`.

Le masquage d'un lien dans la navigation n'est jamais une autorisation.

Chaque accès est décidé sur :

```text
resource:action
```

Les décisions utilisées pour la navigation et pour le contrôleur doivent provenir de la même politique.

## 9. Règles de packaging ZIP

Un ZIP de correctif destiné à être extrait à la racine OPUS doit contenir uniquement les fichiers à écrire dans le dépôt OPUS à leurs chemins canoniques.

### 9.1 Autorisé

```text
Opus/<domaine>/<fichier>
sites/<application>/application/<chemin>
sites/<application>/config/<fichier>
sites/<application>/www/asset/<fichier>
sites/<application>/www/index.php
tools/<validation>              uniquement si explicitement demandé
```

### 9.2 Interdit

```text
README_PATCH.md à la racine
VALIDATION_REPORT.md à la racine
HANDOFF.md à la racine
application/default/smokes/
répertoires backup dans le ZIP
fichiers temporaires
artefacts de génération
copies de fichiers supprimés
```

Les handoffs et spécifications sont écrits dans `MAESTRO_WORKSPACE`, pas dans OPUS.

Les scripts de validation versionnés, lorsqu'ils sont requis, appartiennent à `tools/`. Ils ne font pas partie du runtime applicatif.

### 9.3 Correctif différentiel

Le ZIP doit être aussi petit que possible.

Pour P117C, le correctif porte uniquement sur :

```text
sites/owasys/application/default/controllers/RuntimeController.php
```

## 10. Validation P117C

La validation minimale est :

```text
php -l sites/owasys/application/default/controllers/RuntimeController.php
php -S localhost:8000 index.php
```

Parcours navigateur :

1. `/` redirige ou rend la connexion sans HTTP 500.
2. `/fr/login` affiche le sélecteur de langue.
3. Le sélecteur contient 25 langues avec drapeaux.
4. Le bouton œil affiche et masque le mot de passe.
5. La connexion SSO fonctionne.
6. Le header authentifié sans application courante se rend sans clé manquante.
7. Le Registry fonctionne.
8. Les accès privés sont filtrés par ACL.
9. Les transitions et actions passent par la FSM.
10. Aucune erreur `OPUS_SCORE_TEMPLATE_DATA_MISSING` n'apparaît.

## 11. Critère de conformité

OWASYS ne peut être déclaré 100 % conforme que si :

- le navigateur valide les parcours ;
- tous les rendus passent par SCORE ;
- toutes les routes et actions passent par FSM ;
- toute identité passe par SSO ;
- tout accès privé passe par ACL ;
- `default` reste exclusivement commun ;
- aucun fichier de patch parasite n'est ajouté à la racine OPUS ou dans l'arbre runtime.
