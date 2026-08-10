# HANDOFF — OPUS P117W R45D2A13 GENERATED LOGIN ALERT PROPAGATION

Date : 2026-08-11

## Base canonique

`philstephibanez-wq/OPUS` master : `186517fd37c14047e33308500d0699b8ac36ab44` (`opus_p117w_r45d2a12_source_acl_ui_truth`).

## États acquis owner

- `essai2/steve` : connexion réussie ;
- reset local-password administrateur : acquis ;
- message utilisateur login I18n : acquis ;
- Profiler login PRG/corrélation : acquis ;
- R45D2A12 : correction du faux bandeau lecture seule publiée.

## Défaut courant

Le template login réellement versionné dans `essai2` contient encore l'ancien rendu d'erreur :

```score
<p role="alert">[[ i18n: auth.error ]]</p>
```

Le scaffold canonique `SiteScaffoldPlan` génère lui aussi encore cette ancienne forme. Le CSS de `essai2` n'a aucun composant `opus-alert`.

## Cause

La partie « alerte login standardisée » annoncée avec R45D2A11 n'a pas été propagée dans le scaffold ni dans les sites Composer déjà générés.

La base R45D2A12 contient en plus une variante indentée du bloc legacy dans `essai2`. Le nouvel applicateur ne doit pas dépendre d'une seule représentation textuelle.

## Livrable actif — R45D2A13

```text
ZIP     : opus_p117w_r45d2a13_generated_login_alert_propagation.zip
SHA-256 : f66e6b4614f4326e8b9ba6e14ad698b6443607b253b0f21e9921ac079c96855c
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 2
```

Correction :

- scaffold login futur -> composant `opus-alert opus-alert-error` ;
- CSS canonique -> styles alert ;
- migration de tous les sites `generated-opus-application` avec login ;
- compatibilité legacy compact/LF/CRLF ;
- smoke global de convergence.

## Gate immédiat

```text
php tools/r45d2a13_apply_generated_login_alert_propagation.php
php tools/smoke_r45d2a13_generated_login_alert_propagation.php
php -l Opus/Scaffold/SiteScaffoldPlan.php
composer dump-autoload -o
git status --short
composer opus:dev-server -- essai2
```

Validation UI : mauvais mot de passe => composant visuel OPUS standard, texte I18n non discriminant, aucune cause technique exposée, Profiler conservé.

NO SITE-SPECIFIC PATCH.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.