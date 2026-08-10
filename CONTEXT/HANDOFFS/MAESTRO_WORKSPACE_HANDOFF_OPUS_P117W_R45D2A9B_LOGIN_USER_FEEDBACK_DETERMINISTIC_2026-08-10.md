# HANDOFF — OPUS P117W R45D2A9B LOGIN USER FEEDBACK DETERMINISTIC

Date : 2026-08-10

## Base canonique

```text
OPUS master = ce7a628ddea08334b2d4139be36d12b176396c9b
commit = opus_p117w_r45d2a8_local_password_failure_diagnostics
```

## Incident R45D2A9

L'applicateur `tools/r45d2a9_apply_login_user_feedback.php` a échoué avec :

```text
OPUS_R45D2A9_RUNTIME_FLASH_CONSUME_TARGET_INVALID
```

Cause : l'ancre textuelle `profilerLinkProvider` utilisée pour injecter la consommation du flash n'était pas unique dans `GeneratedSiteRuntime.php`. Le script s'est arrêté avant écriture ; aucun local change OPUS n'a été produit par cet applicateur.

## R45D2A9B

Livrable :

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

Le nouvel applicateur utilise des blocs complets et uniques du runtime R45D2A8 :

1. échec login -> flash session + 303 vers la route login localisée ;
2. consommation du flash après construction du ViewModel SCORE ;
3. message navigateur non discriminant et I18n pour les 24 langues UE + ukrainien ;
4. `SiteScaffoldPlan` corrigé pour les futurs sites ;
5. migration générique des catalogues login des sites Composer générés ;
6. diagnostic technique détaillé conservé exclusivement dans Logger/Profiler ;
7. aucune donnée de credential/hash ajoutée.

## Validation attendue

```text
php tools\r45d2a9b_apply_login_user_feedback.php
=> OPUS_R45D2A9B_APPLIED
```

Puis `git status --short` doit montrer des modifications au minimum sur :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Scaffold/SiteScaffoldPlan.php
sites/essai2/application/login/local/*.json
```

Aucun patch site-specific : la migration de `essai2` résulte du contrat générique des applications Composer générées.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO SECRET IN UI/LOGS/PROFILER.
NO PUSH OPUS BY ASSISTANT.
