# OPUS P117W R45D2A13 — GENERATED LOGIN ALERT PROPAGATION

Date : 2026-08-11
Statut : livrable owner à valider
Base OPUS : `186517fd37c14047e33308500d0699b8ac36ab44`

## Constat owner

Après R45D2A11, le reset administrateur local-password fonctionne et `essai2/steve` peut se connecter. Cependant le template généré `sites/essai2/application/login/templates/index.score` contient encore l'ancien rendu :

```score
<p role="alert">[[ i18n: auth.error ]]</p>
```

Le CSS généré `sites/essai2/www/asset/css/default.css` ne contient pas non plus de composant `opus-alert`.

## Cause exacte

Le commit R45D2A11 publié a intégré le reset credential mais n'a pas propagé le composant visuel d'alerte dans le scaffold canonique ni dans les sites déjà générés.

Le master courant confirme en outre que `Opus/Scaffold/SiteScaffoldPlan.php` génère toujours l'ancien `<p role="alert">`.

R45D2A12 a ensuite été publié sous `186517fd...` et contient également une modification de mise en forme du template login `essai2` : retour à la ligne avant le `<p role="alert">`. Le nouvel applicateur doit donc reconnaître les variantes legacy réelles sans dépendre d'une chaîne unique fragile.

## Correction contractuelle

R45D2A13 :

1. remplace dans `SiteScaffoldPlan` l'ancien paragraphe d'erreur par un composant SCORE :
   - `opus-alert opus-alert-error` ;
   - `role="alert"` ;
   - `aria-live="assertive"` ;
   - icône décorative masquée aux technologies d'assistance ;
   - message I18n inchangé ;
2. ajoute les styles du composant dans le CSS canonique généré ;
3. migre génériquement tous les sites Composer `generated-opus-application` possédant un module login ;
4. accepte les formes legacy compacte, LF indentée et CRLF indentée ;
5. smoke fail-fast : aucun `<p role="alert">` legacy ne doit subsister dans un login généré contrôlé.

## Invariants

- aucune cause technique SSO exposée à l'utilisateur ;
- le message reste I18n et non discriminant ;
- aucun secret ;
- aucun patch spécifique à `essai2` ;
- nouveaux sites et sites existants convergent vers le même contrat ;
- SCORE uniquement pour l'UI ;
- aucune modification owasys-back ;
- aucune modification ACL/SSO.

## Livrable

```text
ZIP     : opus_p117w_r45d2a13_generated_login_alert_propagation.zip
SHA-256 : f66e6b4614f4326e8b9ba6e14ad698b6443607b253b0f21e9921ac079c96855c
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 2
```

Le ZIP contient un applicateur générique et un smoke de propagation.

## Gate owner

1. extraire le ZIP dans `H:\OPUS` ;
2. exécuter `php tools\r45d2a13_apply_generated_login_alert_propagation.php` ;
3. exécuter `php tools\smoke_r45d2a13_generated_login_alert_propagation.php` ;
4. lint `Opus\Scaffold\SiteScaffoldPlan.php` ;
5. `composer dump-autoload -o` ;
6. `git status --short` doit montrer le scaffold et les templates/CSS des sites générés concernés ;
7. relancer `essai2` ;
8. soumettre un mauvais mot de passe : alerte visuelle standard OPUS attendue, message I18n conservé, Profiler corrélé inchangé.