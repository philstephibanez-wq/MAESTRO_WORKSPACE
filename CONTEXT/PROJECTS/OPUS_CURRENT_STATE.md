# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
Commit : opus_p117w_r45d2a3_generated_login_observability
```

Historique immédiat :

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
```

## États acquis / publiés

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée sous `dfab7d0...`.

## Site essai2

Le store runtime local-password contient désormais :

```text
subject  = steve
provider = local-password
status   = active
roles    = admin
source   = runtime.local-password
```

Le login navigateur échoue encore. R45D2A3 fournit maintenant le code corrélé `security.sso/authentication.failed`; aucune nouvelle correction SSO ne doit être inventée avant lecture de ce code.

La déclaration owner « Prévisualiser casse OWASYS » a été retirée explicitement et n'est pas un défaut courant.

## Profiler

Les `.lock` persistants sont des sidecars de synchronisation et restent normaux.

Le lien Profiler absent de `/fr/login` a une cause source confirmée :

`sites/essai2/config/environment.yaml` est en `dev`, avec collecte et Web Profiler actifs, mais `profiler.web.links=false`.

Cette valeur vient de `Opus\Scaffold\ProfilerEnvironmentScaffoldPolicy::environmentYaml()`.

## Livrable actif — R45D2A4

```text
ZIP     : opus_p117w_r45d2a4_generated_profiler_link_dev_policy.zip
SHA-256 : f503525aff801b664a3e3441fb250b202c0839cc1bb4da9a1eb0dc6107b00acb
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 2
```

Fichiers :

```text
Opus/Profiler/ProfilerConfiguration.php
Opus/Scaffold/ProfilerEnvironmentScaffoldPolicy.php
```

Fonctions :

1. futurs sites générés en dev : lien Web Profiler visible par défaut ;
2. compatibilité des sites existants lancés par le serveur dev OPUS via `OPUS_ENV=dev` ;
3. prérequis `collect=true` et `web.enabled=true` conservés ;
4. garde production conservée ;
5. aucun patch spécifique `essai2` ;
6. aucun changement SSO/ACL/FSM.

Validation assistant : PHP lint OK sur les deux fichiers ; ZIP direct 2 fichiers.

## Suite

1. owner applique R45D2A4 ;
2. relance `essai2` et valide le lien Profiler sur `/fr/login` ;
3. retente login `steve` ;
4. si échec, relève `security.sso/authentication.failed` dans le log `essai2` ;
5. corriger uniquement la cause prouvée ;
6. reprendre ensuite la validation R45D2 preview/commit avec la fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
