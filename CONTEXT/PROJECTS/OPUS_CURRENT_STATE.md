# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 62ed6c6b7440034c5855e310899fb11d605fdf00
Commit : opus_p117w_r45d2a5_generated_profiler_iframe_integration
```

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée.
- R45D2A5 : iframe Profiler publiée.
- R45D2A7 : projection hiérarchique Profiler validée localement owner.
- R45D2A8 : diagnostic local-password détaillé validé localement owner.

## Site essai2 — preuve owner courante

La capture owner du 2026-08-10 prouve :

```text
page /fr/login conservée
Profiler intégré et repliable
Security / ACL / SSO = 1
type = security.sso.authentication.failed
provider = local-password
locale = fr
error_code = OPUS_SSO_LOCAL_PASSWORD_INVALID
```

La cause technique du refus est donc précise : le subject est trouvé et possède un hash, mais `password_verify()` échoue pour le mot de passe soumis.

Cette cause reste réservée au Logger/Profiler. Elle ne doit pas être affichée telle quelle au navigateur afin de ne pas exposer l'existence d'un compte.

## Nouvelle exigence UI login

Après un POST refusé :

1. retour 303 vers la route login localisée ;
2. message I18n utilisateur générique : identifiant ou mot de passe incorrect ;
3. flash consommé après le GET suivant ;
4. cause technique détaillée conservée dans Logger/Profiler ;
5. aucun secret ou hash dans l'UI.

## Livrable actif — R45D2A9

```text
ZIP     : opus_p117w_r45d2a9_login_user_feedback.zip
SHA-256 : 776dde0bd303d5110804a14212d31786acd945dbe9c55ddaef39dd8281eb4a0f
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00 + R45D2A8 local
FILES   : 4
```

R45D2A9 est cumulatif avec R45D2A8 :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/WebProfilerView.php
Opus/Security/Sso/LocalPasswordSsoProvider.php
tools/r45d2a9_apply_login_user_feedback.php
```

L'applicateur est fail-fast. Il met à jour le runtime générique, le scaffold canonique et migre les catalogues login de toutes les applications Composer générées conformes au contrat. Aucun identifiant, password ou hash n'est introduit.

## Suite

1. owner applique R45D2A9 ;
2. exécute `php tools/r45d2a9_apply_login_user_feedback.php` ;
3. lint `GeneratedSiteRuntime.php`, `SiteScaffoldPlan.php`, `LocalPasswordSsoProvider.php`, `WebProfilerView.php` ;
4. `composer dump-autoload -o` ;
5. relance `essai2` ;
6. teste un mauvais password : message utilisateur I18n attendu ;
7. recharge : le flash doit disparaître ;
8. vérifie que Profiler conserve `OPUS_SSO_LOCAL_PASSWORD_INVALID` ;
9. provisionne/corrige ensuite le vrai password `steve` et reprend R45D2 preview/commit.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO SECRET IN UI/LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
