# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : ce7a628ddea08334b2d4139be36d12b176396c9b
Commit : opus_p117w_r45d2a8_local_password_failure_diagnostics
```

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée.
- R45D2A5 : iframe Profiler publiée.
- R45D2A6 : Profiler repliable validé owner.
- R45D2A7 : projection hiérarchique Profiler publiée.
- R45D2A8 : diagnostic local-password détaillé publié sous `ce7a628d...`.

## Site essai2 — preuve owner courante

La capture owner prouve :

```text
page /fr/login conservée
Profiler intégré et repliable
Security / ACL / SSO = 1
type = security.sso.authentication.failed
provider = local-password
locale = fr
error_code = OPUS_SSO_LOCAL_PASSWORD_INVALID
```

Le subject est trouvé et possède un hash ; `password_verify()` échoue pour le mot de passe soumis. Cette cause technique reste réservée au Logger/Profiler.

## Exigence UI login

Après un POST refusé :

1. flash session ;
2. réponse 303 vers la route login localisée ;
3. message SCORE/I18n utilisateur non discriminant ;
4. consommation du flash après le GET suivant ;
5. aucune cause technique, credential ou hash dans l'UI.

## Incident R45D2A9

Le premier applicateur R45D2A9 a échoué avant toute écriture :

```text
OPUS_R45D2A9_RUNTIME_FLASH_CONSUME_TARGET_INVALID
```

Cause : ancre textuelle `profilerLinkProvider` non unique dans `GeneratedSiteRuntime.php`. Le constat owner « pas de local changes » est cohérent avec cet arrêt fail-fast.

## Livrable actif — R45D2A9B

```text
ZIP     : opus_p117w_r45d2a9b_login_user_feedback_deterministic.zip
SHA-256 : 86bfddcda0b5ddde9f7c6f6a0778e5e86cc893b238e437c050aca852fddf4036
BASE    : ce7a628ddea08334b2d4139be36d12b176396c9b
FILES   : 1
```

Fichier :

```text
tools/r45d2a9b_apply_login_user_feedback.php
```

L'applicateur cible des blocs complets et uniques du runtime canonique, corrige `GeneratedSiteRuntime`, `SiteScaffoldPlan`, puis migre génériquement les catalogues login des applications Composer générées conformes.

## Validation attendue

```text
php tools\r45d2a9b_apply_login_user_feedback.php
OPUS_R45D2A9B_APPLIED
```

Ensuite `git status --short` doit montrer des local changes sur le runtime, le scaffold et les catalogues login générés concernés. Un mauvais password doit produire le message utilisateur I18n ; le Profiler doit continuer à afficher `OPUS_SSO_LOCAL_PASSWORD_INVALID`.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO SECRET IN UI/LOGS/PROFILER.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
